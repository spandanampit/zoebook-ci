<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of My Movements Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module My Movements
 *
 * @class My_movements.php
 *
 * @path application\webservice\user\controllers\My_movements.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 18.04.2023
 */

class My_movements extends Cit_Controller
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
            "get_my_movement",
            "custom_get_moments_ids",
            "follower_users_details",
            "get_my_movement_file",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('my_movements_model');
        $this->load->model("post/movements_model");
        $this->load->model("misc/movement_users_model");
        $this->load->model("post/movement_images_model");
    }

    /**
     * rules_my_movements method is used to validate api input params.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 17.04.2023
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_my_movements($request_arr = array())
    {
        $valid_arr = array(
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "my_movements");

        return $valid_res;
    }

    /**
     * start_my_movements method is used to initiate api execution flow.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 17.04.2023
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_my_movements($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_my_movements($request_arr);
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

            $input_params = $this->get_my_movement($input_params);

            $condition_res = $this->condition_for_get_my_moments($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->custom_get_moments_ids($input_params);

                $input_params = $this->follower_users_details($input_params);

                $input_params = $this->get_my_movement_file($input_params);

                $output_response = $this->movements_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->movements_false($input_params);
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
     * get_my_movement method is used to process query block.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_my_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->movements_model->get_my_movement($user_id, $page_index, $this->settings_params);
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
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $data = $data_arr["m_added_date"];
                    if (method_exists($this->general, "dateTimeSystemFormat"))
                    {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["m_added_date"] = $data;

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
        $input_params["get_my_movement"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_get_my_moments method is used to process conditions.
     * @created Rohit Patidar | 13.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_my_moments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_my_movement"]) ? 0 : 1);
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
     * custom_get_moments_ids method is used to process custom function.
     * @created Jay Rajput | 16.08.2022
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_get_moments_ids($input_params = array())
    {
        if (!method_exists($this, "get_moments_ids"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->get_moments_ids($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_get_moments_ids"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * follower_users_details method is used to process query block.
     * @created Rohit Patidar | 15.09.2021
     * @modified Jay Rajput | 17.04.2023
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function follower_users_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $mm_ids = isset($input_params["mm_ids"]) ? $input_params["mm_ids"] : "";
            $this->block_result = $this->movement_users_model->follower_users_details($user_id, $mm_ids);
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
        $input_params["follower_users_details"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_my_movement_file method is used to process query block.
     * @created Rohit Patidar | 13.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_my_movement_file($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $mm_ids = isset($input_params["mm_ids"]) ? $input_params["mm_ids"] : "";
            $this->block_result = $this->movement_images_model->get_my_movement_file($mm_ids);
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
        $input_params["get_my_movement_file"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * movements_finish_success method is used to process finish flow.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 16.08.2022
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
            'm_device_group_token',
            'u_name',
            'u_users_id',
            'u_profile_image',
            'total_members',
            'm_added_date',
            'join_status',
            'm_status',
            'is_movement_active',
            'u_users_id_1',
            'u_name_1',
            'u_email',
            'u_profile_image_1',
            'mu_movement_id',
            'mi_movement_images_id',
            'mi_movements_id',
            'mi_media_type',
            'mi_upload_file',
            'mi_mheight',
            'mi_mwidth',
        );
        $output_keys = array(
            'get_my_movement',
            'follower_users_details',
            'get_my_movement_file',
        );
        $ouput_aliases = array(
            "get_my_movement" => "get_movement",
            "m_movements_id" => "movements_id",
            "m_movement_name" => "movement_name",
            "m_description" => "description",
            "m_theme" => "theme",
            "m_visibility" => "visibility",
            "m_device_group_token" => "device_group_token",
            "u_name" => "users_name",
            "u_users_id" => "users_id",
            "u_profile_image" => "users_profile_image",
            "m_added_date" => "added_date",
            "m_status" => "status",
            "follower_users_details" => "get_movement_followers",
            "u_users_id_1" => "f_users_id",
            "u_name_1" => "f_name",
            "u_email" => "f_email",
            "u_profile_image_1" => "f_profile_image",
            "get_my_movement_file" => "get_movement_file",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "my_movements";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_false method is used to process finish flow.
     * @created Rohit Patidar | 13.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_false($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_false",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "my_movements";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
