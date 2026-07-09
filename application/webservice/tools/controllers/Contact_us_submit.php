<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Contact Us Submit Controller
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage controllers
 *
 * @module Contact Us Submit
 *
 * @class Contact_us_submit.php
 *
 * @path application\webservice\tools\controllers\Contact_us_submit.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Contact_us_submit extends Cit_Controller
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
            "insert_records",
        );
        $this->multiple_keys = array(
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('contact_us_submit_model');
        $this->load->model("tools/contact_us_model");
    }

    /**
     * rules_contact_us_submit method is used to validate api input params.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_contact_us_submit($request_arr = array())
    {
        $valid_arr = array(
            "email" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "email_required",
                )
            ),
            "message_text" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "message_text_required",
                )
            ),
            "name" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "name_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "contact_us_submit");

        return $valid_res;
    }

    /**
     * start_contact_us_submit method is used to initiate api execution flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_contact_us_submit($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_contact_us_submit($request_arr);

            $headers = getallheaders();

            $apiKey = $headers['X-API-KEY'] ?? '';

            if ($apiKey !== 'em9lYm9va0BqZWFuTHViaW4=') {

                http_response_code(401);

                echo json_encode([
                    'success' => 0,
                    'message' => 'Access Denied'
                ]);

                exit;
            }

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

            $input_params = $this->custom_function($input_params);

            $condition_res = $this->condition_for_checking_email($input_params);
            if ($condition_res["success"])
            {


            }

            else
            {

                $condition_res = $this->condition_for_api_status($input_params);
                if ($condition_res["success"])
                {


                }

                else
                {

                    $output_response = $this->contact_us_finish_success($input_params);
                    return $output_response;
                }
            }

            $input_params = $this->insert_records($input_params);

            $condition_res = $this->is_inserted($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->notification_to_admin($input_params);

                $input_params = $this->notification_to_user($input_params);

                $output_response = $this->success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->failure($input_params);
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
     * custom_function method is used to process custom function.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
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
        $input_params["custom_function"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition_for_checking_email method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_checking_email($input_params = array())
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
     * condition_for_api_status method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_api_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["API_status"];
            $cc_ro_0 = "success";

            $cc_fr_0 = ($cc_lo_0 != $cc_ro_0) ? TRUE : FALSE;
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
     * contact_us_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 25.10.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function contact_us_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "contact_us_finish_success",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_records',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "contact_us_submit";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * insert_records method is used to process query block.
     * @created Bhagya Rachana | 03.10.2018
     * @modified  | 27.03.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_records($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["name"]))
            {
                $params_arr["name"] = $input_params["name"];
            }
            if (isset($input_params["email"]))
            {
                $params_arr["email"] = $input_params["email"];
            }
            if (isset($input_params["message_text"]))
            {
                $params_arr["message_text"] = $input_params["message_text"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $this->block_result = $this->contact_us_model->insert_records($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_records"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * is_inserted method is used to process conditions.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_inserted($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["insert_id"];
            $cc_ro_0 = 0;

            $cc_fr_0 = ($cc_lo_0 > $cc_ro_0) ? TRUE : FALSE;
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
     * notification_to_admin method is used to process email notification.
     * @created Bhagya Rachana | 04.10.2018
     * @modified Vamsi Ippe | 04.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function notification_to_admin($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $email_arr["vEmail"] = "".$this->config->item("EMAIL_ADMIN")."";

            $email_arr["NAME"] = $input_params["name"];
            $email_arr["EMAIL"] = $input_params["email"];
            $email_arr["COMMENT"] = $input_params["message_text"];

            $success = $this->general->sendMail($email_arr, "CONTACT_US", $input_params);

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
        $input_params["notification_to_admin"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * notification_to_user method is used to process email notification.
     * @created Bhagya Rachana | 04.10.2018
     * @modified Bhagya Rachana | 04.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function notification_to_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $email_arr["vEmail"] = $input_params["email"];

            $email_arr["NAME"] = $input_params["name"];
            $email_arr["EMAIL"] = $input_params["email"];
            $email_arr["COMMENT"] = $input_params["message_text"];

            $success = $this->general->sendMail($email_arr, "CONTACT_US_USER", $input_params);

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
        $input_params["notification_to_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * success method is used to process finish flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_records',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "contact_us_submit";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * failure method is used to process finish flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "contact_us_submit";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
