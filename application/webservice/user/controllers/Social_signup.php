<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Social Signup Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Social Signup
 *
 * @class Social_signup.php
 *
 * @path application\webservice\user\controllers\Social_signup.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 12.10.2021
 */

class Social_signup extends Cit_Controller
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
            "update_fb_google_id",
            "check_dup_fbid_google",
            "func_fetch_social_image",
            "insert_social_user",
            "exist_login",
        );
        $this->multiple_keys = array(
            "login_facebook_id",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('social_signup_model');
        $this->load->model("user/users_model");
    }

    /**
     * rules_social_signup method is used to validate api input params.
     * @created Vamsi Ippe | 10.09.2018
     * @modified Rohit Patidar | 12.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_social_signup($request_arr = array())
    {
        $valid_arr = array(
            "device_type" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "device_type_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "social_signup");

        return $valid_res;
    }

    /**
     * start_social_signup method is used to initiate api execution flow.
     * @created Vamsi Ippe | 10.09.2018
     * @modified Rohit Patidar | 12.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_social_signup($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_social_signup($request_arr);
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

            $condition_res = $this->facebook_google_empty($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_1($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->condition_2($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->update_fb_google_id($input_params);
                    }
                }

                $input_params = $this->check_dup_fbid_google($input_params);

                $condition_res = $this->dup_fb_found($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->login_facebook_id($input_params);

                    $output_response = $this->users_finish_success_2($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->func_fetch_social_image($input_params);

                    $input_params = $this->insert_social_user($input_params);

                    $condition_res = $this->condition($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->exist_login($input_params);

                        $output_response = $this->users_finish_success_1($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->users_finish_success_3($input_params);
                        return $output_response;
                    }
                }
            }

            else
            {

                $output_response = $this->users_finish_success($input_params);
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
     * facebook_google_empty method is used to process conditions.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 11.11.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function facebook_google_empty($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["facebook_id"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;

            $cc_lo_1 = $input_params["google_id"];

            $cc_fr_1 = (!is_null($cc_lo_1) && !empty($cc_lo_1) && trim($cc_lo_1) != "") ? TRUE : FALSE;

            $cc_lo_2 = $input_params["user_email"];

            $cc_fr_2 = (!is_null($cc_lo_2) && !empty($cc_lo_2) && trim($cc_lo_2) != "") ? TRUE : FALSE;

            $cc_lo_3 = $input_params["apple_id"];

            $cc_fr_3 = (!is_null($cc_lo_3) && !empty($cc_lo_3) && trim($cc_lo_3) != "") ? TRUE : FALSE;
            if (!($cc_fr_0 || $cc_fr_1 || $cc_fr_2 || $cc_fr_3))
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
     * @created Rohit Patidar | 12.10.2021
     * @modified Rohit Patidar | 12.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["facebook_id"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;

            $cc_lo_1 = $input_params["google_id"];

            $cc_fr_1 = (!is_null($cc_lo_1) && !empty($cc_lo_1) && trim($cc_lo_1) != "") ? TRUE : FALSE;

            $cc_lo_2 = $input_params["apple_id"];

            $cc_fr_2 = (!is_null($cc_lo_2) && !empty($cc_lo_2) && trim($cc_lo_2) != "") ? TRUE : FALSE;
            if (!($cc_fr_0 || $cc_fr_1 || $cc_fr_2))
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
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 12.10.2021
     * @modified Rohit Patidar | 12.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_email"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;
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
     * update_fb_google_id method is used to process query block.
     * @created Rohit Patidar | 12.10.2021
     * @modified Rohit Patidar | 12.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_fb_google_id($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_email"]))
            {
                $where_arr["user_email"] = $input_params["user_email"];
            }
            if (isset($input_params["facebook_id"]))
            {
                $params_arr["facebook_id"] = $input_params["facebook_id"];
            }
            if (isset($input_params["google_id"]))
            {
                $params_arr["google_id"] = $input_params["google_id"];
            }
            if (isset($input_params["apple_id"]))
            {
                $params_arr["apple_id"] = $input_params["apple_id"];
            }
            $this->block_result = $this->users_model->update_fb_google_id($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_fb_google_id"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_dup_fbid_google method is used to process query block.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 12.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_dup_fbid_google($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["user_email"]))
            {
                $params_arr["user_email"] = $input_params["user_email"];
            }
            if (isset($input_params["facebook_id"]))
            {
                $params_arr["facebook_id"] = $input_params["facebook_id"];
            }
            if (isset($input_params["google_id"]))
            {
                $params_arr["google_id"] = $input_params["google_id"];
            }
            if (isset($input_params["apple_id"]))
            {
                $params_arr["apple_id"] = $input_params["apple_id"];
            }
            $this->block_result = $this->users_model->check_dup_fbid_google($params_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["check_dup_fbid_google"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * dup_fb_found method is used to process conditions.
     * @created CIT Dev Team
     * @modified Bhargav Narkedamilli | 14.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function dup_fb_found($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_users_id_1"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;
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
     * login_facebook_id method is used to process custom function.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 12.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function login_facebook_id($input_params = array())
    {

        $this->load->module("user/login");
        $api_params = array();
        if (array_key_exists("user_email", $input_params))
        {
            $api_params["user_email"] = $input_params["user_email"];
        }
        if (array_key_exists("u_password", $input_params))
        {
            $api_params["password"] = $input_params["u_password"];
        }
        if (array_key_exists("facebook_id", $input_params))
        {
            $api_params["facebook_id"] = $input_params["facebook_id"];
        }
        if (array_key_exists("google_id", $input_params))
        {
            $api_params["google_id"] = $input_params["google_id"];
        }
        if (array_key_exists("lattitude", $input_params))
        {
            $api_params["latitude"] = $input_params["lattitude"];
        }
        if (array_key_exists("longitude", $input_params))
        {
            $api_params["longitude"] = $input_params["longitude"];
        }
        if (array_key_exists("device_token", $input_params))
        {
            $api_params["device_token"] = $input_params["device_token"];
        }
        if (array_key_exists("device_type", $input_params))
        {
            $api_params["device_type"] = $input_params["device_type"];
        }
        if (array_key_exists("device_os", $input_params))
        {
            $api_params["device_os"] = $input_params["device_os"];
        }
        if (array_key_exists("device_name", $input_params))
        {
            $api_params["device_name"] = $input_params["device_name"];
        }
        if (array_key_exists("app_version", $input_params))
        {
            $api_params["app_version"] = $input_params["app_version"];
        }
        if (array_key_exists("apple_id", $input_params))
        {
            $api_params["apple_id"] = $input_params["apple_id"];
        }
        $maping_arr = array(
            "select_user" => "select_user_1",
            "u_user_id" => "u_user_id_1",
            "u_status" => "u_status_1",
            "u_email_verified" => "u_email_verified_1",
            "u_name" => "u_name_1",
            "u_email" => "u_email_1",
            "u_phone" => "u_phone_1",
            "u_profile_image" => "u_profile_image_1",
            "u_notification_pref" => "u_notification_pref_1",
        );
        $result_arr = $this->login->start_login($api_params, TRUE);
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
        $input_params["login_facebook_id"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * users_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Nandini Santoki | 10.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => $input_params["custom_function_success"],
            "message" => "users_finish_success_2",
        );
        $output_fields = array(
            'u_user_id_1',
            'u_status_1',
            'u_email_verified_1',
            'u_name_1',
            'u_email_1',
            'u_phone_1',
            'u_profile_image_1',
            'u_notification_pref_1',
        );
        $output_keys = array(
            'login_facebook_id',
        );
        $ouput_aliases = array(
            "u_user_id_1" => "u_user_id",
            "u_status_1" => "u_status",
            "u_email_verified_1" => "u_email_verified",
            "u_name_1" => "u_name",
            "u_email_1" => "u_email",
            "u_phone_1" => "u_phone",
            "u_profile_image_1" => "u_profile_image",
            "u_notification_pref_1" => "u_notification_pref",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "social_signup";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * func_fetch_social_image method is used to process custom function.
     * @created Vara  Prasad | 14.09.2018
     * @modified Vara  Prasad | 14.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_fetch_social_image($input_params = array())
    {
        if (!method_exists($this->general, "fetchn_upload_social_image"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->fetchn_upload_social_image($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_fetch_social_image"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * insert_social_user method is used to process query block.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 11.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_social_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["user_name"]))
            {
                $params_arr["user_name"] = $input_params["user_name"];
            }
            if (isset($input_params["user_email"]))
            {
                $params_arr["user_email"] = $input_params["user_email"];
            }
            if (isset($input_params["password"]))
            {
                $params_arr["password"] = $input_params["password"];
            }
            if (isset($input_params["lattitude"]))
            {
                $params_arr["lattitude"] = $input_params["lattitude"];
            }
            if (isset($input_params["longitude"]))
            {
                $params_arr["longitude"] = $input_params["longitude"];
            }
            if (isset($input_params["facebook_id"]))
            {
                $params_arr["facebook_id"] = $input_params["facebook_id"];
            }
            if (isset($input_params["google_id"]))
            {
                $params_arr["google_id"] = $input_params["google_id"];
            }
            $params_arr["_estatus"] = "Active";
            $params_arr["_daddeddate"] = "NOW()";
            if (isset($input_params["app_version"]))
            {
                $params_arr["app_version"] = $input_params["app_version"];
            }
            if (isset($input_params["device_os"]))
            {
                $params_arr["device_os"] = $input_params["device_os"];
            }
            if (isset($input_params["device_name"]))
            {
                $params_arr["device_name"] = $input_params["device_name"];
            }
            if (isset($input_params["device_type"]))
            {
                $params_arr["device_type"] = $input_params["device_type"];
            }
            $params_arr["_eemailverified"] = "1";
            if (isset($input_params["profile_image_social"]))
            {
                $params_arr["profile_image_social"] = $input_params["profile_image_social"];
            }
            if (isset($input_params["mobile_num"]))
            {
                $params_arr["mobile_num"] = $input_params["mobile_num"];
            }
            $params_arr["_enotificationpref"] = "1";
            if (isset($input_params["apple_id"]))
            {
                $params_arr["apple_id"] = $input_params["apple_id"];
            }
            $this->block_result = $this->users_model->insert_social_user($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_social_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Alpesh Patel | 11.10.2021
     * @modified Alpesh Patel | 11.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_social_user"]) ? 0 : 1);
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
     * exist_login method is used to process custom function.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 12.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function exist_login($input_params = array())
    {

        $this->load->module("user/login");
        $api_params = array();
        if (array_key_exists("facebook_id", $input_params))
        {
            $api_params["facebook_id"] = $input_params["facebook_id"];
        }
        if (array_key_exists("google_id", $input_params))
        {
            $api_params["google_id"] = $input_params["google_id"];
        }
        if (array_key_exists("lattitude", $input_params))
        {
            $api_params["latitude"] = $input_params["lattitude"];
        }
        if (array_key_exists("longitude", $input_params))
        {
            $api_params["longitude"] = $input_params["longitude"];
        }
        if (array_key_exists("device_token", $input_params))
        {
            $api_params["device_token"] = $input_params["device_token"];
        }
        if (array_key_exists("device_type", $input_params))
        {
            $api_params["device_type"] = $input_params["device_type"];
        }
        if (array_key_exists("device_os", $input_params))
        {
            $api_params["device_os"] = $input_params["device_os"];
        }
        if (array_key_exists("device_name", $input_params))
        {
            $api_params["device_name"] = $input_params["device_name"];
        }
        if (array_key_exists("app_version", $input_params))
        {
            $api_params["app_version"] = $input_params["app_version"];
        }
        if (array_key_exists("apple_id", $input_params))
        {
            $api_params["apple_id"] = $input_params["apple_id"];
        }
        $maping_arr = array();
        $result_arr = $this->login->start_login($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["exist_login_success"] = $result_arr["success"];
            $input_params["exist_login_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["exist_login_success"] = $result_arr["settings"]["success"];
            $input_params["exist_login_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["exist_login"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * users_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => $input_params["exist_login_success"],
            "message" => "users_finish_success_1",
        );
        $output_fields = array(
            'u_user_id',
            'u_status',
            'u_email_verified',
            'u_name',
            'u_email',
            'u_phone',
            'u_profile_image',
            'u_notification_pref',
        );
        $output_keys = array(
            'exist_login',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "social_signup";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success_3 method is used to process finish flow.
     * @created Alpesh Patel | 11.10.2021
     * @modified Alpesh Patel | 11.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success_3",
        );
        $output_fields = array(
            'u_users_id_1',
            'u_password',
        );
        $output_keys = array(
            'check_dup_fbid_google',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "social_signup";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "social_signup";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
