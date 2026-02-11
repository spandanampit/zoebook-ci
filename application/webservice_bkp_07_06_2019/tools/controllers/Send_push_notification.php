<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Send Push Notification Controller
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage controllers
 *
 * @module Send Push Notification
 *
 * @class Send_push_notification.php
 *
 * @path application\webservice\tools\controllers\Send_push_notification.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 11.01.2019
 */

class Send_push_notification extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $block_result;

    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->settings_params = array();
        $this->output_params = array();
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('send_push_notification_model');
    }

    /**
     * rules_send_push_notification method is used to validate api input params.
     * @created Vamsi Ippe | 26.12.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_send_push_notification($request_arr = array())
    {
        $valid_arr = array(
            "device_token" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "device_token_required",
                )
            ),
            "message" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "message_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "send_push_notification");

        return $valid_res;
    }

    /**
     * start_send_push_notification method is used to initiate api execution flow.
     * @created Vamsi Ippe | 26.12.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_send_push_notification($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_send_push_notification($request_arr);
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
            $output_array = $func_array = array();

            $input_params = $this->push_notification($input_params);

            $output_response = $this->finish_success($input_params);
            return $output_response;
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * push_notification method is used to process mobile push notification.
     * @created Vamsi Ippe | 26.12.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["device_token"];
            $code = "CHAT";
            $sound = "";
            $badge = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "senderId",
                    "value" => $input_params["sender_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "receiverId",
                    "value" => $input_params["receiver_id"],
                    "send" => "Yes",
                )
            );
            $push_msg = "#message# ";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "runtime";

            $send_arr = array();
            $send_arr['device_id'] = $device_id;
            $send_arr['code'] = $code;
            $send_arr['sound'] = $sound;
            $send_arr['badge'] = intval($badge);
            $send_arr['title'] = $title;
            $send_arr['message'] = "You Have New Message: ".$push_msg;
            $send_arr['variables'] = json_encode($send_vars);
            $send_arr['send_mode'] = $send_mode;
            $uni_id = $this->general->insertPushNotification($send_arr);
            if (!$uni_id)
            {
                throw new Exception('Failure in insertion of push notification batch entry.');
            }

            $success = 1;
            $message = "Push notification send succesfully.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        $input_params["push_notification"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 26.12.2018
     * @modified Vamsi Ippe | 26.12.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "send_push_notification";

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
