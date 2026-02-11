<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Search movements Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Search movements
 *
 * @class Search_movements.php
 *
 * @path application\webservice\post\controllers\Search_movements.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 12.12.2022
 */

class Search_movements extends Cit_Controller
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
            "moment_images",
        );
        $this->multiple_keys = array(
            "check_search_key",
            "search_new_moments",
            "custom_mm_ids",
            "get_moment_users",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('search_movements_model');
        $this->load->model("post/movements_model");
        $this->load->model("misc/movement_users_model");
        $this->load->model("post/movement_images_model");
    }

    /**
     * rules_search_movements method is used to validate api input params.
     * @created Rohit Patidar | 23.09.2021
     * @modified Jay Rajput | 12.12.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_search_movements($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "search_movements");

        return $valid_res;
    }

    /**
     * start_search_movements method is used to initiate api execution flow.
     * @created Rohit Patidar | 23.09.2021
     * @modified Jay Rajput | 12.12.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_search_movements($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_search_movements($request_arr);
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

            $input_params = $this->check_search_key($input_params);

            $condition_res = $this->condition_for_valid($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->search_new_moments($input_params);

                $condition_res = $this->condition_for_new_moment($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->custom_mm_ids($input_params);

                    $input_params = $this->get_moment_users($input_params);

                    $input_params = $this->moment_images($input_params);

                    $output_response = $this->movement_users_finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->movement_users_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->movement_users_finish_success_2($input_params);
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
     * check_search_key method is used to process custom function.
     * @created Rohit Patidar | 21.01.2022
     * @modified Ravi Chauhan | 06.04.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_search_key($input_params = array())
    {
        if (!method_exists($this, "checkSerachKeyword"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->checkSerachKeyword($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["check_search_key"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition_for_valid method is used to process conditions.
     * @created Ravi Chauhan | 06.04.2022
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_valid($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["is_valid"];
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
     * search_new_moments method is used to process query block.
     * @created Ravi Chauhan | 06.04.2022
     * @modified Jay Rajput | 12.12.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function search_new_moments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $search_key = isset($input_params["search_key"]) ? $input_params["search_key"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->movements_model->search_new_moments($user_id, $search_key, $page_index, $this->settings_params);
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

                    $data = $data_arr["u_profile_image_2"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_2"] = $data;

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
        $input_params["search_new_moments"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_new_moment method is used to process conditions.
     * @created Rohit Patidar | 24.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_new_moment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["search_new_moments"]) ? 0 : 1);
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
     * custom_mm_ids method is used to process custom function.
     * @created Jay Rajput | 16.08.2022
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_mm_ids($input_params = array())
    {
        if (!method_exists($this, "fetch_mm_ids"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->fetch_mm_ids($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_mm_ids"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_moment_users method is used to process query block.
     * @created Rohit Patidar | 24.09.2021
     * @modified Jay Rajput | 17.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_moment_users($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $mm_ids = isset($input_params["mm_ids"]) ? $input_params["mm_ids"] : "";
            $this->block_result = $this->movement_users_model->get_moment_users($user_id, $mm_ids);
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
        $input_params["get_moment_users"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * moment_images method is used to process query block.
     * @created Rohit Patidar | 24.09.2021
     * @modified Jay Rajput | 17.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function moment_images($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $mm_ids = isset($input_params["mm_ids"]) ? $input_params["mm_ids"] : "";
            $this->block_result = $this->movement_images_model->moment_images($mm_ids);
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
                    $image_arr["def_img"] = "Yes";
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
        $input_params["moment_images"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 24.09.2021
     * @modified Jay Rajput | 22.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success",
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
            'u_users_id_2',
            'u_name_2',
            'u_email_2',
            'u_profile_image_2',
            'follower_count_1',
            'join_status_1',
            'self_movements_1',
            'total_members_1',
            'u_users_id_1',
            'u_name_1',
            'u_email_1',
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
            'search_new_moments',
            'get_moment_users',
            'moment_images',
        );
        $ouput_aliases = array(
            "m_movements_id_1" => "movements_id",
            "m_movement_name_1" => "movement_name",
            "m_description_1" => "description",
            "m_theme_1" => "theme",
            "m_visibility_1" => "visibility",
            "m_status_1" => "m_status",
            "m_device_group_token_1" => "device_group_token",
            "m_added_date_1" => "added_date",
            "u_users_id_2" => "users_id",
            "u_name_2" => "users_name",
            "u_email_2" => "users_email",
            "u_profile_image_2" => "users_profile_image",
            "follower_count_1" => "follower_count",
            "join_status_1" => "join_status",
            "self_movements_1" => "self_movements",
            "total_members_1" => "total_members",
            "u_users_id_1" => "f_users_id",
            "u_name_1" => "f_name",
            "u_email_1" => "f_email",
            "u_profile_image_1" => "f_profile_image",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "search_movements";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 24.09.2021
     * @modified Ravi Chauhan | 07.04.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "search_movements";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success_2 method is used to process finish flow.
     * @created Ravi Chauhan | 06.04.2022
     * @modified Ravi Chauhan | 06.04.2022
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

        $func_array["function"]["name"] = "search_movements";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
