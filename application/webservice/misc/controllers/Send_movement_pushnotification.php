<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Send_movement_pushnotification Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Send_movement_pushnotification
 *
 * @class Send_movement_pushnotification.php
 *
 * @path application\webservice\misc\controllers\Send_movement_pushnotification.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.10.2021
 */

class Send_movement_pushnotification extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
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
            "send_movement_push_notification",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('send_movement_pushnotification_model');
        $this->load->model("post/movements_model");
    }

    /**
     * rules_send_movement_pushnotification method is used to validate api input params.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_send_movement_pushnotification($request_arr = array())
    {
        $valid_arr = array(
            "movement_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movement_id_required",
                )
            ),
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "send_movement_pushnotification");

        return $valid_res;
    }

    /**
     * start_send_movement_pushnotification method is used to initiate api execution flow.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_send_movement_pushnotification($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_send_movement_pushnotification($request_arr);
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

            $input_params = $this->send_movement_push_notification($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->movement_push_notification($input_params);
            }

            $output_response = $this->movements_finish_success($input_params);
            return $output_response;
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * send_movement_push_notification method is used to process query block.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 22.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function send_movement_push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $this->block_result = $this->movements_model->send_movement_push_notification($movement_id);
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

                    $data = $data_arr["u_profile_image_3"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_3"] = $data;

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
        $input_params["send_movement_push_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 22.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_users_id_3"];
            $cc_ro_0 = $input_params["user_id"];

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
     * movement_push_notification method is used to process mobile push notification.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function movement_push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["m_device_group_token"];
            $code = "NMPA";
            $sound = "";
            $badge = $input_params["m_movements_id"];
            $silent = "";
            $title = "Movement post";
            $send_vars = array(
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                ),
                array(
                    "key" => "movement_id",
                    "value" => $input_params["m_movements_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "is_topic",
                    "value" => "1",
                    "send" => "Yes",
                )
            );
            $push_msg = "#u_name_3# added new post in \"#m_movement_name#\" Movement";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "runtime";

            $send_arr = array();
            $send_arr['device_id'] = $device_id;
            $send_arr['code'] = $code;
            $send_arr['sound'] = $sound;
            $send_arr['badge'] = intval($badge);
            $send_arr['silent'] = $silent;
            $send_arr['title'] = $title;
            $send_arr['message'] = $push_msg;
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
        $input_params["movement_push_notification"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * movements_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 22.10.2021
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
            'm_visibility',
            'm_device_group_token',
        );
        $output_keys = array(
            'send_movement_push_notification',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "send_movement_pushnotification";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
