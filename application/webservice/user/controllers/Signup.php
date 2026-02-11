<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Signup Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Signup
 *
 * @class Signup.php
 *
 * @path application\webservice\user\controllers\Signup.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Signup extends Cit_Controller
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
            "email_duplicate_v1",
            "insert_user",
            "get_activate_url",
        );
        $this->multiple_keys = array(
            "check_data_curl_call",
            "update_devic_token",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('signup_model');
        $this->load->model("user/users_model");
    }

    /**
     * rules_signup method is used to validate api input params.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 19.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_signup($request_arr = array())
    {
        $valid_arr = array(
            "password" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "password_required",
                )
            ),
            "user_email" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_email_required",
                )
            ),
            "user_name" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_name_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "signup");

        return $valid_res;
    }

    /**
     * start_signup method is used to initiate api execution flow.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 19.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_signup($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_signup($request_arr);
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

            $input_params = $this->email_duplicate_v1($input_params);

            $condition_res = $this->email_exist($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->email_dup_success($input_params);
                return $output_response;
            }

            else
            {

                $input_params = $this->check_data_curl_call($input_params);
               
                $condition_res = $this->condition($input_params);
               
                if ($condition_res["success"])
                { 
                    
                    $input_params = $this->insert_user($input_params);
                   
                    $input_params = $this->update_devic_token($input_params);

                    $input_params = $this->get_activate_url($input_params);
                      
                    $input_params = $this->email_notification($input_params);

                    $output_response = $this->users_finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->users_finish_success_1($input_params);
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
     * email_duplicate_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function email_duplicate_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_email = isset($input_params["user_email"]) ? $input_params["user_email"] : "";
            $this->block_result = $this->users_model->email_duplicate_v1($user_email);
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
        $input_params["email_duplicate_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * email_exist method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function email_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["email_duplicate_v1"]) ? 0 : 1);
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
     * email_dup_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function email_dup_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "email_dup_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "signup";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * check_data_curl_call method is used to process custom function.
     * @created Rohit Patidar | 18.10.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_data_curl_call($input_params = array())
    {
        if (!method_exists($this->general, "valid_email"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->valid_email($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["check_data_curl_call"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 19.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["API_status"];
            $cc_ro_0 = "success";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["status"];
            $cc_ro_1 = "valid";

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
            if (!$cc_fr_1)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_2 = $input_params["code"];
            $cc_ro_2 = 200;

            $cc_fr_2 = ($cc_lo_2 == $cc_ro_2) ? TRUE : FALSE;
            if (!$cc_fr_2)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_3 = $input_params["safe_to_send"];
            $cc_ro_3 = "yes";

            $cc_fr_3 = ($cc_lo_3 == $cc_ro_3) ? TRUE : FALSE;
            if (!$cc_fr_3)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_4 = $input_params["bounce_type"];

            $cc_fr_4 = (is_null($cc_lo_4) || empty($cc_lo_4) || trim($cc_lo_4) == "") ? TRUE : FALSE;
            if (!$cc_fr_4)
            {
                throw new Exception("Some conditions does not match.");
            }
            // $cc_lo_5 = $input_params["score"];
            // $cc_ro_5 = 0.25;

            // $cc_fr_5 = ($cc_lo_5 > $cc_ro_5) ? TRUE : FALSE;
            // if (!$cc_fr_5)
            // {
            //     throw new Exception("Some conditions does not match.");
            // }
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
     * insert_user method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 19.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($_FILES["profile_image"]["name"]) && isset($_FILES["profile_image"]["tmp_name"]))
            {
                $sent_file = $_FILES["profile_image"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["profile_image"]["ext"] = " jpg,jpeg,png";
                $images_arr["profile_image"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["profile_image"]["ext"], $_FILES["profile_image"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["profile_image"]["size"], $_FILES["profile_image"]["size"]))
                    {
                        $images_arr["profile_image"]["name"] = $file_name;
                    }
                }
            }
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
            $params_arr["_estatus"] = "Inactive";
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
            $params_arr["_eemailverified"] = "0";
            if (isset($input_params["mobile_num"]))
            {
                $params_arr["mobile_num"] = $input_params["mobile_num"];
            }
            if (isset($images_arr["profile_image"]["name"]))
            {
                $params_arr["profile_image"] = $images_arr["profile_image"]["name"];
            }
            $params_arr["_enotificationpref"] = "1";
            if (isset($input_params["ddob"]))
            {
                $params_arr["ddob"] = $input_params["ddob"];
            }
            if (isset($input_params["gender"]))
            {
                $params_arr["gender"] = $input_params["gender"];
            }
            
            $this->block_result = $this->users_model->insert_user($params_arr);
            
            if (!$this->block_result["success"])
            {
                throw new Exception("Insertion failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["profile_image"]["name"]))
            {

                $file_path = "compress_profile_image";
                $file_name = $images_arr["profile_image"]["name"];
                $file_tmp_path = $_FILES["profile_image"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_devic_token method is used to process custom function.
     * @created CIT Dev Team
     * @modified Jay Rajput | 19.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_devic_token($input_params = array())
    {

        $this->load->module("user/device_token_update");
        $api_params = array();
        if (array_key_exists("insert_id", $input_params))
        {
            $api_params["user_id"] = $input_params["insert_id"];
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
            $input_params["update_devic_token_success"] = $result_arr["success"];
            $input_params["update_devic_token_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["update_devic_token_success"] = $result_arr["settings"]["success"];
            $input_params["update_devic_token_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["update_devic_token"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_activate_url method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 19.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_activate_url($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $insert_id = isset($input_params["insert_id"]) ? $input_params["insert_id"] : "";
            $this->block_result = $this->users_model->get_activate_url($insert_id);
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
                    $image_arr["width"] = "50";
                    $image_arr["height"] = "50";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $data = $data_arr["activation_url_new"];
                    if (method_exists($this->general, "generateactivation_url"))
                    {
                        $data = $this->general->generateactivation_url($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["activation_url_new"] = $data;
                     
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
        $input_params["get_activate_url"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * email_notification method is used to process email notification.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function email_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $email_arr["vEmail"] = $input_params["user_email"];

            $email_arr["vName"] = $input_params["user_name"];
            $email_arr["vUserEmail"] = $input_params["user_email"];
            $email_arr["vUsername"] = $input_params["user_name"];
            $email_arr["vPassword"] = $input_params["password"];
            $email_arr["ACTIVATION_URL"] = $input_params["activation_url"];

            $success = $this->general->sendMail($email_arr, "USER_REGISTER", $input_params);
            
            $log_arr = array();
            $log_arr['eEntityType'] = 'General';
            $log_arr['vReceiver'] = is_array($email_arr["vEmail"]) ? implode(",", $email_arr["vEmail"]) : $email_arr["vEmail"];
            $log_arr['eNotificationType'] = "EmailNotify";
            $log_arr['vSubject'] = $this->general->getEmailOutput("subject");
            $log_arr['tContent'] = $this->general->getEmailOutput("content");
            if (!$success)
            {
                $log_arr['tError'] = $this->general->getNotifyErrorOutput();
            }
            $log_arr['dtSendDateTime'] = date('Y-m-d H:i:s');
            $log_arr['eStatus'] = ($success) ? "Executed" : "Failed";
            $this->general->insertExecutedNotify($log_arr);
            if (!$success)
            {
                throw new Exception("Failure in sending mail.");
            }
            $success = 1;
            $message = "Email notification send successfully.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        $input_params["email_notification"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.10.2018
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
            'insert_id',
            'u_users_id_1',
            'u_name',
            'u_email',
            'u_phone',
            'u_profile_image',
            'u_notification_pref',
            'u_email_verified',
            'u_status',
        );
        $output_keys = array(
            'insert_user',
            'get_activate_url',
        );
        $ouput_aliases = array(
            "insert_id" => "user_id",
            "u_users_id_1" => "u_users_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "signup";
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
     * @created Rohit Patidar | 18.10.2021
     * @modified Rohit Patidar | 25.10.2021
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

        $func_array["function"]["name"] = "signup";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
