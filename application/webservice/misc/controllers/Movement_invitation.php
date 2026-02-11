<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movement invitation Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Movement invitation
 *
 * @class Movement_invitation.php
 *
 * @path application\webservice\misc\controllers\Movement_invitation.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 16.12.2021
 */

class Movement_invitation extends Cit_Controller
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
            "movement_exist",
            "inviter_details",
        );
        $this->multiple_keys = array(
            "invitee_details",
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('movement_invitation_model');
        $this->load->model("post/movements_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_movement_invitation method is used to validate api input params.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 16.12.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_movement_invitation($request_arr = array())
    {
        $valid_arr = array(
            "invitee_user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "invitee_user_id_required",
                )
            ),
            "inviter_user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "inviter_user_id_required",
                )
            ),
            "movement_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movement_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "movement_invitation");
        $input_params = $valid_res['input_params'];
        if (!empty($input_params["invitee_user_id"]) && !is_array($input_params["invitee_user_id"]))
        {
            $input_params["invitee_user_id"] = explode(",", $input_params["invitee_user_id"]);
        }
        elseif (!is_array($input_params["invitee_user_id"]))
        {
            $input_params["invitee_user_id"] = array();
        }
        $valid_res['input_params'] = $input_params;
        return $valid_res;
    }

    /**
     * start_movement_invitation method is used to initiate api execution flow.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 16.12.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_movement_invitation($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_movement_invitation($request_arr);
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

            $input_params = $this->movement_exist($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->inviter_details($input_params);

                $input_params = $this->invitee_details($input_params);

                $input_params = $this->start_loop($input_params);

                $input_params = $this->custom_function($input_params);

                $condition_res = $this->condition_3($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->start_loop_1($input_params);

                    $output_response = $this->movements_finish_success_2($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->movements_finish_success_3($input_params);
                    return $output_response;
                }
            }

            else
            {

                $condition_res = $this->condition_1($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->movements_finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->movements_finish_success_1($input_params);
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
     * movement_exist method is used to process query block.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function movement_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $this->block_result = $this->movements_model->movement_exist($movement_id);
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
        $input_params["movement_exist"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["movement_exist"]) ? 0 : 1);
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["m_status"];
            $cc_ro_1 = "Active";

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
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
     * inviter_details method is used to process query block.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function inviter_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $inviter_user_id = isset($input_params["inviter_user_id"]) ? $input_params["inviter_user_id"] : "";
            $this->block_result = $this->users_model->inviter_details($inviter_user_id);
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
        $input_params["inviter_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * invitee_details method is used to process query block.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function invitee_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $u_name = isset($input_params["u_name"]) ? $input_params["u_name"] : "";
            $m_movement_name = isset($input_params["m_movement_name"]) ? $input_params["m_movement_name"] : "";
            $invitee_user_id = isset($input_params["invitee_user_id"]) ? $input_params["invitee_user_id"] : "";
            $this->block_result = $this->users_model->invitee_details($u_name, $m_movement_name, $invitee_user_id);
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
        $input_params["invitee_details"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * start_loop method is used to process loop flow.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop($input_params = array())
    {
        $this->iterate_start_loop($input_params["invitee_details"], $input_params);
        return $input_params;
    }

    /**
     * invitation_insert_user_notification method is used to process query block.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function invitation_insert_user_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["u_users_id_1"]))
            {
                $params_arr["u_users_id_1"] = $input_params["u_users_id_1"];
            }
            if (isset($input_params["notification_text"]))
            {
                $params_arr["notification_text"] = $input_params["notification_text"];
            }
            $params_arr["_etype"] = "MovementFRequest";
            $params_arr["_iuserfollowerid"] = "0";
            $params_arr["_ipostid"] = "0";
            $params_arr["_ipostcommentid"] = "0";
            $params_arr["_itokboxsessionid"] = "0";
            if (isset($input_params["u_users_id"]))
            {
                $params_arr["u_users_id"] = $input_params["u_users_id"];
            }
            if (isset($input_params["m_movements_id"]))
            {
                $params_arr["m_movements_id"] = $input_params["m_movements_id"];
            }
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "IMR";
            $params_arr["_dtaddeddate"] = "Now()";
            $params_arr["_emovementreadstatus"] = "No";
            $this->block_result = $this->user_notifications_model->invitation_insert_user_notification($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["invitation_insert_user_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * custom_function method is used to process custom function.
     * @created Alpesh Patel | 15.12.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
    {
        if (!method_exists($this, "get_device_tokens_chunks"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->get_device_tokens_chunks($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_function"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition_3 method is used to process conditions.
     * @created Alpesh Patel | 15.12.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_3($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["invitee_device_tokens"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0)) ? TRUE : FALSE;
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
     * start_loop_1 method is used to process loop flow.
     * @created Alpesh Patel | 15.12.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop_1($input_params = array())
    {
        $this->iterate_start_loop_1($input_params["custom_function"], $input_params);
        return $input_params;
    }

    /**
     * push_notification method is used to process mobile push notification.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["invitee_device_tokens"];
            $code = "IMR";
            $sound = "";
            $badge = $input_params["insert_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#notification_text# ";
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
        $input_params["push_notification"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * movements_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success_2",
        );
        $output_fields = array(
            'm_movements_id',
            'm_movement_name',
            'm_description',
            'm_visibility',
            'm_status',
            'm_user_id',
            'u_users_id',
            'u_name',
            'u_email',
            'u_subscribe_email',
            'u_notification_pref',
            'u_device_token',
            'u_device_type',
            'u_users_id_1',
            'u_name_1',
            'u_email_1',
            'u_notification_pref_1',
            'u_device_token_1',
            'notification_text',
            'invitation_insert_user_notification',
            'insert_id',
            'invitee_device_tokens',
        );
        $output_keys = array(
            'movement_exist',
            'inviter_details',
            'invitee_details',
            'custom_function',
        );
        $inner_keys = array(
            'invitation_insert_user_notification',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["inner_keys"] = $inner_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success_3 method is used to process finish flow.
     * @created Alpesh Patel | 15.12.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success_3",
        );
        $output_fields = array(
            'm_movements_id',
            'm_movement_name',
            'm_description',
            'm_visibility',
            'm_status',
            'm_user_id',
            'u_users_id',
            'u_name',
            'u_email',
            'u_subscribe_email',
            'u_notification_pref',
            'u_device_token',
            'u_device_type',
            'u_users_id_1',
            'u_name_1',
            'u_email_1',
            'u_notification_pref_1',
            'u_device_token_1',
            'notification_text',
            'invitation_insert_user_notification',
            'insert_id',
            'invitee_device_tokens',
        );
        $output_keys = array(
            'movement_exist',
            'inviter_details',
            'invitee_details',
            'custom_function',
        );
        $inner_keys = array(
            'invitation_insert_user_notification',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["inner_keys"] = $inner_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["movement_exist"]) ? 0 : 1);
            $cc_ro_0 = 0;

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
     * movements_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 08.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * iterate_start_loop method is used to iterate loop.
     * @created Rohit Patidar | 06.10.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $invitee_details_lp_arr invitee_details_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop(&$invitee_details_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $invitee_details_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $invitee_details_lp_pms = $input_params_loc;

            unset($invitee_details_lp_pms["invitee_details"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $invitee_details_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $invitee_details_lp_pms["invitee_details"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["invitee_details"] = $invitee_details_lp_pms["invitee_details"];
            }

            $invitee_details_lp_pms["i"] = $i;
            $input_params = $invitee_details_lp_pms;

            $input_params = $this->invitation_insert_user_notification($input_params);

            $invitee_details_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $invitee_details_lp_pms);
        }
    }

    /**
     * iterate_start_loop_1 method is used to iterate loop.
     * @created Alpesh Patel | 15.12.2021
     * @modified Alpesh Patel | 15.12.2021
     * @param array $custom_function_lp_arr custom_function_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop_1(&$custom_function_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $custom_function_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $custom_function_lp_pms = $input_params_loc;

            unset($custom_function_lp_pms["custom_function"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $custom_function_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $custom_function_lp_pms["custom_function"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["custom_function"] = $custom_function_lp_pms["custom_function"];
            }

            $custom_function_lp_pms["i"] = $i;
            $input_params = $custom_function_lp_pms;

            $input_params = $this->push_notification($input_params);

            $custom_function_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $custom_function_lp_pms);
        }
    }
}
