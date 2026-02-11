<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movements Details Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Movements Details
 *
 * @class Movements_details.php
 *
 * @path application\webservice\misc\controllers\Movements_details.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Movements_details extends Cit_Controller
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
            "get_movements",
        );
        $this->multiple_keys = array(
            "follower_details",
            "get_movements_file",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('movements_details_model');
        $this->load->model("post/movements_model");
        $this->load->model("misc/movement_users_model");
        $this->load->model("post/movement_images_model");
    }

    /**
     * rules_movements_details method is used to validate api input params.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_movements_details($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "movements_details");

        return $valid_res;
    }

    /**
     * start_movements_details method is used to initiate api execution flow.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_movements_details($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_movements_details($request_arr);
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

            $input_params = $this->get_movements($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->follower_details($input_params);

                $input_params = $this->get_movements_file($input_params);

                $output_response = $this->movements_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->movements_finish_success_1($input_params);
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
     * get_movements method is used to process query block.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movements($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $this->block_result = $this->movements_model->get_movements($user_id, $movements_id);
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

                    $data = $data_arr["m_added_date"];
                    if (method_exists($this->general, "dateTimeSystemFormat"))
                    {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["m_added_date"] = $data;

                    $data = $data_arr["join_status"];
                    if (method_exists($this->general, "getInactiveStatus"))
                    {
                        $data = $this->general->getInactiveStatus($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["join_status"] = $data;

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["color"] = "FFFFFF";
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
        $input_params["get_movements"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 22.09.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_movements"]) ? 0 : 1);
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
     * follower_details method is used to process query block.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function follower_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $m_movements_id = isset($input_params["m_movements_id"]) ? $input_params["m_movements_id"] : "";
            $this->block_result = $this->movement_users_model->follower_details($user_id, $m_movements_id);
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
        $input_params["follower_details"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_movements_file method is used to process query block.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movements_file($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $m_movements_id = isset($input_params["m_movements_id"]) ? $input_params["m_movements_id"] : "";
            $this->block_result = $this->movement_images_model->get_movements_file($m_movements_id);
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

                    $data = $data_arr["mi_upload_file"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["mi_movements_id"] != "") ? $data_arr["mi_movements_id"] : $input_params["mi_movements_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_movements_files";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["mi_upload_file"] = $data;

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
        $input_params["get_movements_file"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * movements_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 01.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success",
        );
        $output_fields = array(
            'm_movements_id',
            'm_movement_name',
            'm_description',
            'm_theme',
            'm_visibility',
            'm_status',
            'm_device_group_token',
            'm_added_date',
            'total_members',
            'join_status',
            'u_users_id',
            'u_name',
            'u_email',
            'u_profile_image',
            'is_movement_active',
            'u_users_id_1',
            'u_name_1',
            'u_email_1',
            'u_profile_image_1',
            'mi_movement_images_id',
            'mi_movements_id',
            'mi_media_type',
            'mi_upload_file',
            'mi_mheight',
            'mi_mwidth',
        );
        $output_keys = array(
            'get_movements',
            'follower_details',
            'get_movements_file',
        );
        $ouput_aliases = array(
            "m_movements_id" => "movements_id",
            "m_movement_name" => "movement_name",
            "m_description" => "description",
            "m_theme" => "theme",
            "m_visibility" => "visibility",
            "m_status" => "status",
            "m_device_group_token" => "device_group_token",
            "m_added_date" => "added_date",
            "u_users_id" => "users_id",
            "u_name" => "users_name",
            "u_email" => "users_email",
            "u_profile_image" => "users_profile_image",
            "follower_details" => "follower_users_details",
            "u_users_id_1" => "f_users_id",
            "u_name_1" => "f_name",
            "u_email_1" => "f_email",
            "u_profile_image_1" => "f_profile_image",
        );
        $output_objects = array(
            "get_movements",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movements_details";
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
     * movements_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movements_details";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
