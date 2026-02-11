<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Follow Accept Reject Cancel Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Follow Accept Reject Cancel
 *
 * @class Follow_accept_reject_cancel.php
 *
 * @path application\webservice\user\controllers\Follow_accept_reject_cancel.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 05.10.2021
 */

class Follow_accept_reject_cancel extends Cit_Controller
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
            "check_status",
            "update_follow_status",
            "insert_user_notify",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('follow_accept_reject_cancel_model');
        $this->load->model("user/user_followers_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_follow_accept_reject_cancel method is used to validate api input params.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Rohit Patidar | 05.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_follow_accept_reject_cancel($request_arr = array())
    {
        $valid_arr = array(
            "status" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "status_required",
                )
            ),
            "user_follow_request_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_follow_request_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "follow_accept_reject_cancel");

        return $valid_res;
    }

    /**
     * start_follow_accept_reject_cancel method is used to initiate api execution flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Rohit Patidar | 05.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_follow_accept_reject_cancel($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_follow_accept_reject_cancel($request_arr);
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

            $input_params = $this->check_status($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_2($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->user_followers_finish_success_2($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->update_follow_status($input_params);

                    $condition_res = $this->condition_1($input_params);
                    if ($condition_res["success"])
                    {

                        $condition_res = $this->condition_check_accept($input_params);
                        if ($condition_res["success"])
                        {

                            $condition_res = $this->cond_check_notification_pref($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->push_notification($input_params);
                            }

                            $input_params = $this->insert_user_notify($input_params);

                            $condition_res = $this->condition_4($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->email_notification($input_params);
                            }

                            $output_response = $this->user_followers_finish_success($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $condition_res = $this->condition_3($input_params);
                            if ($condition_res["success"])
                            {

                                $output_response = $this->user_followers_finish_success_3($input_params);
                                return $output_response;
                            }

                            else
                            {

                                $output_response = $this->user_followers_finish_success_5($input_params);
                                return $output_response;
                            }
                        }
                    }

                    else
                    {

                        $output_response = $this->user_followers_finish_success_1($input_params);
                        return $output_response;
                    }
                }
            }

            else
            {

                $output_response = $this->user_followers_finish_success_4($input_params);
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
     * check_status method is used to process query block.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Rohit Patidar | 05.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_follow_request_id = isset($input_params["user_follow_request_id"]) ? $input_params["user_follow_request_id"] : "";
            $status = isset($input_params["status"]) ? $input_params["status"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->user_followers_model->check_status($user_follow_request_id, $status, $user_id);
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
        $input_params["check_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_status"]) ? 0 : 1);
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
     * condition_2 method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["uf_status"];
            $cc_ro_0 = $input_params["status"];

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
     * user_followers_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_followers_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "follow_accept_reject_cancel";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * update_follow_status method is used to process query block.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_follow_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_follow_request_id"]))
            {
                $where_arr["user_follow_request_id"] = $input_params["user_follow_request_id"];
            }
            if (isset($input_params["status"]))
            {
                $params_arr["status"] = $input_params["status"];
            }
            $params_arr["_dmodifieddate"] = "NOW()";
            $this->block_result = $this->user_followers_model->update_follow_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_follow_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["update_follow_status"]) ? 0 : 1);
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
     * condition_check_accept method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_check_accept($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["status"];
            $cc_ro_0 = "Accepted";

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
     * cond_check_notification_pref method is used to process conditions.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Nandini Santoki | 05.09.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_notification_pref($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u1_notification_pref"];
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["u1_device_token"];

            $cc_fr_1 = (!is_null($cc_lo_1) && !empty($cc_lo_1) && trim($cc_lo_1) != "") ? TRUE : FALSE;
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
     * push_notification method is used to process mobile push notification.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u1_device_token"];
            $code = "FRA";
            $sound = "";
            $badge = $input_params["affected_rows"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "pending_request_id",
                    "value" => $input_params["uf_user_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#u_name# has accepted your follow request";
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
     * insert_user_notify method is used to process query block.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 20.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_user_notify($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["u1_users_id"]))
            {
                $params_arr["u1_users_id"] = $input_params["u1_users_id"];
            }
            $params_arr["u_name"] = "".$input_params["u_name"]."";
            if (method_exists($this, "getNotificationText"))
            {
                $params_arr["u_name"] = $this->getNotificationText($params_arr["u_name"], $input_params);
            }
            $params_arr["_etype"] = "Normal";
            $params_arr["_eisread"] = "No";
            $params_arr["_dtaddeddate"] = "NOW()";
            $params_arr["_vcode"] = "'FRA'";
            if (isset($input_params["uf_user_id"]))
            {
                $params_arr["uf_user_id"] = $input_params["uf_user_id"];
            }
            if (isset($input_params["u_users_id"]))
            {
                $params_arr["u_users_id"] = $input_params["u_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_user_notify($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_user_notify"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_4 method is used to process conditions.
     * @created Rohit Patidar | 29.09.2021
     * @modified Rohit Patidar | 05.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_4($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u1_subscribe_email"];
            $cc_ro_0 = "Yes";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["u1_facebook_id"];

            $cc_fr_1 = (is_null($cc_lo_1) || empty($cc_lo_1) || trim($cc_lo_1) == "") ? TRUE : FALSE;
            if (!$cc_fr_1)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_2 = $input_params["u1_apple_id"];

            $cc_fr_2 = (is_null($cc_lo_2) || empty($cc_lo_2) || trim($cc_lo_2) == "") ? TRUE : FALSE;
            if (!$cc_fr_2)
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
     * email_notification method is used to process email notification.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Rohit Patidar | 05.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function email_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $email_arr["vEmail"] = $input_params["u1_email"];

            $email_arr["follower_name"] = $input_params["u1_name"];
            $email_arr["u_name"] = $input_params["u_name"];

            $success = $this->general->sendMail($email_arr, "USER_FOLLOW_ACCEPT", $input_params);

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
     * user_followers_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "user_followers_finish_success",
        );
        $output_fields = array(
            'uf_status',
            'affected_rows',
        );
        $output_keys = array(
            'check_status',
            'update_follow_status',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "follow_accept_reject_cancel";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * condition_3 method is used to process conditions.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_3($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["status"];
            $cc_ro_0 = "Deleted";

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
     * user_followers_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "user_followers_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "follow_accept_reject_cancel";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_followers_finish_success_5 method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_5($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "user_followers_finish_success_5",
        );
        $output_fields = array(
            'uf_status',
            'uf_user_follower_id',
            'uf_user_id',
            'uf_follower_id',
            'u_name',
            'u1_device_type',
            'u1_device_name',
            'u1_device_token',
            'u1_name',
            'u1_email',
            'u1_users_id',
            'u1_notification_pref',
        );
        $output_keys = array(
            'check_status',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "follow_accept_reject_cancel";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_followers_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_followers_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "follow_accept_reject_cancel";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_followers_finish_success_4 method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_followers_finish_success_4",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "follow_accept_reject_cancel";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
