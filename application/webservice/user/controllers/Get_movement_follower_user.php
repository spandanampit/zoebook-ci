<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Get movement followers user Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Get movement followers user
 *
 * @class Get_movement_follower_user.php
 *
 * @path application\webservice\user\controllers\Get_movement_follower_user.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Get_movement_follower_user extends Cit_Controller
{
    public $settings_params;
    public $output_params;
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
        $this->multiple_keys = array(
            "moment_users_query_block",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('get_movement_follower_user_model');
        $this->load->model("misc/movement_users_model");
    }

    /**
     * rules_get_movement_follower_user method is used to validate api input params.
     * @created Rohit Patidar | 16.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_get_movement_follower_user($request_arr = array())
    {
        $valid_arr = array(
            "follower_count" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "follower_count_required",
                )
            ),
            "movement_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movement_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "get_movement_follower_user");

        return $valid_res;
    }

    /**
     * start_get_movement_follower_user method is used to initiate api execution flow.
     * @created Rohit Patidar | 16.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_get_movement_follower_user($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_get_movement_follower_user($request_arr);
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

            $input_params = $this->moment_users_query_block($input_params);

            $condition_res = $this->condition_2($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->finish_success_2($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->finish_success_3($input_params);
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
     * moment_users_query_block method is used to process query block.
     * @created Rohit Patidar | 16.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function moment_users_query_block($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $this->block_result = $this->movement_users_model->moment_users_query_block($user_id, $movement_id);
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

                    $data = $data_arr["u_profile_image_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_1"] = $data;

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
        $input_params["moment_users_query_block"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 16.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["moment_users_query_block"]) ? 0 : 1);
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
     * finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 16.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "finish_success_2",
        );
        $output_fields = array(
            'u_users_id_1',
            'u_name_1',
            'u_email_1',
            'u_profile_image_1',
        );
        $output_keys = array(
            'moment_users_query_block',
        );
        $ouput_aliases = array(
            "u_users_id_1" => "f_users_id",
            "u_name_1" => "f_name",
            "u_email_1" => "f_email",
            "u_profile_image_1" => "f_profile_image",
            "moment_users_query_block" => "get_movement_followers",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "get_movement_follower_user";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 16.09.2021
     * @modified Rohit Patidar | 16.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "get_movement_follower_user";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
