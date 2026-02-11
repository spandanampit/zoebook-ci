<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movements follower Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Movements follower
 *
 * @class Movements_follower.php
 *
 * @path application\webservice\user\controllers\Movements_follower.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Movements_follower extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
    public $multiple_keys;
    public $block_result;

    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->settings_params = array();
        $this->output_params = array();
        $this->single_keys = array(
            "movements",
        );
        $this->multiple_keys = array(
            "get_follower_users",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('movements_follower_model');
        $this->load->model("wscustom/wscustom_model");
        $this->load->model("misc/movement_users_model");
    }

    /**
     * rules_movements_follower method is used to validate api input params.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_movements_follower($request_arr = array())
    {
        $valid_arr = array(
            "movements_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movements_id_required",
                )
            ),
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "movements_follower");

        return $valid_res;
    }

    /**
     * start_movements_follower method is used to initiate api execution flow.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_movements_follower($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_movements_follower($request_arr);
            if ($validation_res["success"] == "-5")
            {
                if ($inner_api === TRUE)
                {
                    return $validation_res;
                }
                else
                {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];

            $input_params = $this->movements($input_params);

            $input_params = $this->get_follower_users($input_params);

            $condition_res = $this->condition_for_get_follower($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->movement_users_finish_success($input_params);
                return $output_response;
            }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * movements method is used to process query block.
     * @created Rohit Patidar | 23.09.2021
     * @modified Rohit Patidar | 28.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function movements($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $this->block_result = $this->wscustom_model->movements($movements_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["movements"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_follower_users method is used to process query block.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_follower_users($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $search_text = isset($input_params["search_text"]) ? $input_params["search_text"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->movement_users_model->get_follower_users($user_id, $movements_id, $search_text, $page_index, $this->settings_params);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if (is_array($result_arr) && count($result_arr) > 0)
            {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr)
                {

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_follower_users"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_get_follower method is used to process conditions.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_follower($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_follower_users"]) ? 0 : 1);
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $success = 1;
            $message = "Conditions matched.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        return $this->block_result;
    }

    /**
     * finish_success method is used to process finish flow.
     * @created Rohit Patidar | 22.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "finish_success",
        );
        $output_fields = array(
            'total_members',
            'u_users_id',
            'u_name',
            'u_email',
            'u_profile_image',
            'uf_user_id',
            'mu_admin_status',
        );
        $output_keys = array(
            'movements',
            'get_follower_users',
        );
        $ouput_aliases = array(
            "u_users_id" => "f_users_id",
            "u_name" => "f_name",
            "u_email" => "f_email",
            "u_profile_image" => "f_profile_image",
            "uf_user_id" => "f_friend_is",
            "mu_admin_status" => "f_is_leader",
        );
        $output_objects = array(
            "movements",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movements_follower";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["output_objects"] = $output_objects;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 22.09.2021
     * @modified Rohit Patidar | 22.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movements_follower";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
