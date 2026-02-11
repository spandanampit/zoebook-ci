<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of send_bulk_mail Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module send_bulk_mail
 *
 * @class Send_bulk_mail.php
 *
 * @path application\webservice\misc\controllers\Send_bulk_mail.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Send_bulk_mail extends Cit_Controller
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
            "get_bulk_mail",
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('send_bulk_mail_model');
        $this->load->model("user/mailer_log_history_model");
    }

    /**
     * rules_send_bulk_mail method is used to validate api input params.
     * @created Rohit Patidar | 24.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_send_bulk_mail($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "send_bulk_mail");

        return $valid_res;
    }

    /**
     * start_send_bulk_mail method is used to initiate api execution flow.
     * @created Rohit Patidar | 24.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_send_bulk_mail($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_send_bulk_mail($request_arr);
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

            $input_params = $this->get_bulk_mail($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->custom_function($input_params);

                $output_response = $this->success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->success1($input_params);
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
     * get_bulk_mail method is used to process query block.
     * @created Rohit Patidar | 24.06.2021
     * @modified Rohit Patidar | 24.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_bulk_mail($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->mailer_log_history_model->get_bulk_mail();
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

                    $data = $data_arr["mlh_mail_send_status"];
                    if (method_exists($this, "setSendMailStatus"))
                    {
                        $data = $this->setSendMailStatus($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["mlh_mail_send_status"] = $data;

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
        $input_params["get_bulk_mail"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 24.06.2021
     * @modified Rohit Patidar | 24.06.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_bulk_mail"]) ? 0 : 1);
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
     * custom_function method is used to process custom function.
     * @created Rohit Patidar | 24.06.2021
     * @modified Rohit Patidar | 24.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
    {
        if (!method_exists($this, "sendMail"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->sendMail($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_function"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * success method is used to process finish flow.
     * @created Rohit Patidar | 24.06.2021
     * @modified Rohit Patidar | 24.06.2021
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
            'mlh_frome_name',
            'mlh_from_email',
            'mlh_cc_email',
            'mlh_email_formate',
            'mlh_email_subject',
            'mlh_to_email',
            'mlh_user_name',
            'mlh_email_code',
            'mlh_mail_sent_date',
            'mlh_added_date',
            'mlh_mail_send_status',
            'mlh_massage_body',
            'mlh_email_template_id',
            'mlh_userid',
            'mlh_mailer_log_history_id',
        );
        $output_keys = array(
            'get_bulk_mail',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "send_bulk_mail";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * success1 method is used to process finish flow.
     * @created Rohit Patidar | 24.06.2021
     * @modified Rohit Patidar | 24.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "success1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "send_bulk_mail";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
