<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Login Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Login
 *
 * @class Login.php
 *
 * @path application\webservice\user\controllers\Login.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Login extends Cit_Controller
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
            "get_fbid_google_id",
            "select_user",
            "update_user_lat_long",
            "update_dev_token",
        );
        $this->multiple_keys = array(
            "update_firebase_users_collection",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('login_model');
        $this->load->model("wscustom/wscustom_model");
        $this->load->model("user/users_model");
    }

    /**
     * rules_login method is used to validate api input params.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_login($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "login");

        return $valid_res;
    }

    /**
     * start_login method is used to initiate api execution flow.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_login($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_login($request_arr);
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

            $input_params = $this->get_fbid_google_id($input_params);

            $input_params = $this->select_user($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_email_verify_check($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->condition_1($input_params);
                    if ($condition_res["success"])
                    {

                        $condition_res = $this->check_device_token($input_params);
                        if ($condition_res["success"])
                        {


                        }

                        else
                        {

                            $input_params = $this->update_dev_token($input_params);
                        }

                        $input_params = $this->update_user_lat_long($input_params);

                        $input_params = $this->update_firebase_users_collection($input_params);

                        $output_response = $this->users_finish_success($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->users_finish_success_1($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->finish_success($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->users_finish_success_2($input_params);
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
     * get_fbid_google_id method is used to process query block.
     * @created CIT Dev Team
     * @modified Alpesh Patel | 26.08.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_fbid_google_id($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $facebook_id = isset($input_params["facebook_id"]) ? $input_params["facebook_id"] : "";
            $google_id = isset($input_params["google_id"]) ? $input_params["google_id"] : "";
            $apple_id = isset($input_params["apple_id"]) ? $input_params["apple_id"] : "";
            $this->block_result = $this->wscustom_model->get_fbid_google_id($facebook_id, $google_id, $apple_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_fbid_google_id"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * select_user method is used to process query block.
     * @created CIT Dev Team
     * @modified Alpesh Patel | 26.08.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function select_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["fb_id"]))
            {
                $params_arr["fb_id"] = $input_params["fb_id"];
            }
            if (isset($input_params["g_id"]))
            {
                $params_arr["g_id"] = $input_params["g_id"];
            }
            if (isset($input_params["a_id"]))
            {
                $params_arr["a_id"] = $input_params["a_id"];
            }
            if (isset($input_params["user_email"]))
            {
                $params_arr["user_email"] = $input_params["user_email"];
            }
            if (isset($input_params["password"]))
            {
                $params_arr["password"] = $input_params["password"];
            }
            $this->block_result = $this->users_model->select_user($params_arr);
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
                    $image_arr["width"] = "500";
                    $image_arr["height"] = "500";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "profile_image";
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
        $input_params["select_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["select_user"]) ? 0 : 1);
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
     * condition_email_verify_check method is used to process conditions.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_email_verify_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_email_verified"];
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
     * condition_1 method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_status"];
            $cc_ro_0 = "Active";

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
     * check_device_token method is used to process conditions.
     * @created Nandini Santoki | 02.11.2020
     * @modified Rohit Patidar | 30.04.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_device_token($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["device_type"];
            $cc_ro_0 = "WebSite";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["device_token"];

            $cc_fr_1 = (is_null($cc_lo_1) || empty($cc_lo_1) || trim($cc_lo_1) == "") ? TRUE : FALSE;
            if (!$cc_fr_1)
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
     * update_dev_token method is used to process custom function.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_dev_token($input_params = array())
    {

        $this->load->module("user/device_token_update");
        $api_params = array();
        if (array_key_exists("u_users_id", $input_params))
        {
            $api_params["user_id"] = $input_params["u_users_id"];
        }
        if (array_key_exists("device_token", $input_params))
        {
            $api_params["device_token"] = $input_params["device_token"];
        }
        if (array_key_exists("device_type", $input_params))
        {
            $api_params["device_type"] = $input_params["device_type"];
        }
        $maping_arr = array();
        $result_arr = $this->device_token_update->start_device_token_update($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["custom_function_success"] = $result_arr["success"];
            $input_params["custom_function_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["custom_function_success"] = $result_arr["settings"]["success"];
            $input_params["custom_function_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["update_dev_token"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * update_user_lat_long method is used to process query block.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 02.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_lat_long($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["u_users_id"]))
            {
                $where_arr["u_users_id"] = $input_params["u_users_id"];
            }
            if (isset($input_params["latitude"]))
            {
                $params_arr["latitude"] = $input_params["latitude"];
            }
            if (isset($input_params["longitude"]))
            {
                $params_arr["longitude"] = $input_params["longitude"];
            }
            if (isset($input_params["device_name"]))
            {
                $params_arr["device_name"] = $input_params["device_name"];
            }
            if (isset($input_params["app_version"]))
            {
                $params_arr["app_version"] = $input_params["app_version"];
            }
            if (isset($input_params["device_os"]))
            {
                $params_arr["device_os"] = $input_params["device_os"];
            }
            $params_arr["_dlastlogin"] = "NOW()";
            $this->block_result = $this->users_model->update_user_lat_long($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_lat_long"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_firebase_users_collection method is used to process custom function.
     * @created Vamsi Ippe | 01.04.2020
     * @modified Vamsi Ippe | 01.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_firebase_users_collection($input_params = array())
    {
        if (!method_exists($this, "update_firebase_users"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->update_firebase_users($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["update_firebase_users_collection"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Alpesh Patel | 19.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_finish_success",
        );
        $output_fields = array(
            'u_users_id',
            'u_status',
            'u_email_verified',
            'u_name',
            'u_email',
            'u_phone',
            'u_profile_image',
            'u_notification_pref',
            'u_privacy_pref',
        );
        $output_keys = array(
            'select_user',
        );
        $ouput_aliases = array(
            "u_users_id" => "u_user_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "login";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success_1 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "login";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Pavan  | 22.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "2",
            "message" => "finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "login";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success_2 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "login";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
