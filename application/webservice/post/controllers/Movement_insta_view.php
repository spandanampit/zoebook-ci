<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movement insta view Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Movement insta view
 *
 * @class Movement_insta_view.php
 *
 * @path application\webservice\post\controllers\Movement_insta_view.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Movement_insta_view extends Cit_Controller
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
            "get_movement_instaviews",
            "get_insta_movements",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('movement_insta_view_model');
        $this->load->model("post/movements_model");
        $this->load->model("post/movement_images_model");
    }

    /**
     * rules_movement_insta_view method is used to validate api input params.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_movement_insta_view($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "movement_insta_view");

        return $valid_res;
    }

    /**
     * start_movement_insta_view method is used to initiate api execution flow.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_movement_insta_view($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_movement_insta_view($request_arr);
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

            $condition_res = $this->condition_static($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->get_movement_instaviews($input_params);

                $condition_res = $this->condition_get_moment_success($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->movements_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $input_params = $this->get_insta_movements($input_params);

                $condition_res = $this->condition_for_get_insta_moments($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->start_loop($input_params);

                    $output_response = $this->movement_users_finish_success_1($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->movement_users_finish_success_2($input_params);
                    return $output_response;
                }
            }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * condition_static method is used to process conditions.
     * @created Rohit Patidar | 14.04.2022
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_static($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = 1;
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
     * get_movement_instaviews method is used to process query block.
     * @created Rohit Patidar | 14.04.2022
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_instaviews($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->movements_model->get_movement_instaviews($user_id, $page_index, $this->settings_params);
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
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_1"] = $data;

                    $data = $data_arr["join_status_1"];
                    if (method_exists($this->general, "getInactiveStatus"))
                    {
                        $data = $this->general->getInactiveStatus($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["join_status_1"] = $data;

                    $data = $data_arr["mi_upload_file_2"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["mi_movements_id_2"] != "") ? $data_arr["mi_movements_id_2"] : $input_params["mi_movements_id_2"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_movements_files";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["mi_upload_file_2"] = $data;

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
        $input_params["get_movement_instaviews"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_get_moment_success method is used to process conditions.
     * @created Rohit Patidar | 14.04.2022
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_get_moment_success($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_movement_instaviews"]) ? 0 : 1);
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
     * @created Rohit Patidar | 14.04.2022
     * @modified Rohit Patidar | 25.04.2022
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
            'm_movements_id_1',
            'm_movement_name_1',
            'm_description_1',
            'm_theme_1',
            'm_visibility_1',
            'm_status_1',
            'm_device_group_token_1',
            'm_added_date_1',
            'm_user_id',
            'u_name_1',
            'u_email_1',
            'u_profile_image_1',
            'join_status_1',
            'self_movements_1',
            'is_movement_active_1',
            'follower_count_1',
            'mi_movement_images_id_2',
            'mi_movements_id_2',
            'mi_media_type_2',
            'mi_upload_file_2',
            'mi_mheight_2',
            'mi_mwidth_2',
            'total_members_1',
        );
        $output_keys = array(
            'get_movement_instaviews',
        );
        $ouput_aliases = array(
            "get_movement_instaviews" => "get_insta_movements",
            "m_movements_id_1" => "movements_id",
            "m_movement_name_1" => "movement_name",
            "m_description_1" => "description",
            "m_theme_1" => "theme",
            "m_visibility_1" => "visibility",
            "m_status_1" => "status",
            "m_device_group_token_1" => "device_group_token",
            "m_added_date_1" => "added_date",
            "m_user_id" => "users_id",
            "u_name_1" => "users_name",
            "u_email_1" => "users_email",
            "u_profile_image_1" => "users_profile_image",
            "join_status_1" => "join_status",
            "is_movement_active_1" => "is_movement_active",
            "mi_movement_images_id_2" => "mi_movement_images_id",
            "mi_movements_id_2" => "mi_movements_id",
            "mi_media_type_2" => "mi_media_type",
            "mi_upload_file_2" => "mi_upload_file",
            "mi_mheight_2" => "mi_mheight",
            "mi_mwidth_2" => "mi_mwidth",
            "total_members_1" => "total_members",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_insta_view";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 14.04.2022
     * @modified Rohit Patidar | 14.04.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success_1",
        );
        $output_fields = array(
            'm_movements_id_1',
            'm_movement_name_1',
            'm_description_1',
            'm_theme_1',
            'm_visibility_1',
            'm_status_1',
            'm_device_group_token_1',
            'm_added_date_1',
            'u_users_id_1',
            'u_name_1',
            'u_email_1',
            'u_profile_image_1',
            'join_status_1',
            'self_movements_2',
            'is_movement_active_1',
            'self_movements_1',
            'total_members_1',
        );
        $output_keys = array(
            'get_movement_instaviews',
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_insta_view";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_insta_movements method is used to process query block.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_insta_movements($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->movements_model->get_insta_movements($user_id, $page_index, $this->settings_params);
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

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $data = $data_arr["join_status"];
                    if (method_exists($this->general, "getInactiveStatus"))
                    {
                        $data = $this->general->getInactiveStatus($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["join_status"] = $data;

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
        $input_params["get_insta_movements"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_get_insta_moments method is used to process conditions.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_insta_moments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_insta_movements"]) ? 0 : 1);
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
     * start_loop method is used to process loop flow.
     * @created Rohit Patidar | 27.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop($input_params = array())
    {
        $this->iterate_start_loop($input_params["get_insta_movements"], $input_params);
        return $input_params;
    }

    /**
     * get_insta_movements_file method is used to process query block.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_insta_movements_file($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $m_movements_id = isset($input_params["m_movements_id"]) ? $input_params["m_movements_id"] : "";
            $this->block_result = $this->movement_images_model->get_insta_movements_file($m_movements_id);
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
        $input_params["get_insta_movements_file"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 27.09.2021
     * @modified Rohit Patidar | 11.11.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_1",
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
            'u_users_id',
            'u_name',
            'u_email',
            'u_profile_image',
            'total_members',
            'join_status',
            'is_movement_active',
            'get_insta_movements_file',
            'mi_movement_images_id',
            'mi_movements_id',
            'mi_media_type',
            'mi_upload_file',
            'mi_mheight',
            'mi_mwidth',
        );
        $output_keys = array(
            'get_insta_movements',
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
            "get_insta_movements_file" => "get_movements_file",
        );
        $output_objects = array(
            "get_insta_movements_file",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_insta_view";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["output_objects"] = $output_objects;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 27.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_insta_view";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * iterate_start_loop method is used to iterate loop.
     * @created Rohit Patidar | 27.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $get_insta_movements_lp_arr get_insta_movements_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop(&$get_insta_movements_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $get_insta_movements_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $get_insta_movements_lp_pms = $input_params_loc;

            unset($get_insta_movements_lp_pms["get_insta_movements"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $get_insta_movements_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $get_insta_movements_lp_pms["get_insta_movements"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["get_insta_movements"] = $get_insta_movements_lp_pms["get_insta_movements"];
            }

            $get_insta_movements_lp_pms["i"] = $i;
            $input_params = $get_insta_movements_lp_pms;

            $input_params = $this->get_insta_movements_file($input_params);

            $get_insta_movements_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $get_insta_movements_lp_pms);
        }
    }
}
