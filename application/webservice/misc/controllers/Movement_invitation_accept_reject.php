<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movement invitation accept reject Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Movement invitation accept reject
 *
 * @class Movement_invitation_accept_reject.php
 *
 * @path application\webservice\misc\controllers\Movement_invitation_accept_reject.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Movement_invitation_accept_reject extends Cit_Controller
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
            "user_exists_this_movement",
            "update_read_status_request",
            "get_send_movement_details",
            "join_public_movement",
            "get_request_user_detail",
            "send_private_movement_join_request",
            "request_notification",
            "update_cancel_read_status",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('movement_invitation_accept_reject_model');
        $this->load->model("misc/movement_users_model");
        $this->load->model("user/user_notifications_model");
        $this->load->model("post/movements_model");
        $this->load->model("user/users_model");
    }

    /**
     * rules_movement_invitation_accept_reject method is used to validate api input params.
     * @created Rohit Patidar | 07.10.2021
     * @modified Jay Rajput | 25.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_movement_invitation_accept_reject($request_arr = array())
    {
        $valid_arr = array(
            "movement_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movement_id_required",
                )
            ),
            "status" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "status_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "movement_invitation_accept_reject");

        return $valid_res;
    }

    /**
     * start_movement_invitation_accept_reject method is used to initiate api execution flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Jay Rajput | 25.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_movement_invitation_accept_reject($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_movement_invitation_accept_reject($request_arr);
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

            $condition_res = $this->condition_for_accept($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->user_exists_this_movement($input_params);

                $input_params = $this->update_read_status_request($input_params);

                $condition_res = $this->condition_2($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->active_pending($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->movement_users_finish_success_1($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->movement_users_finish_success_2($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $input_params = $this->get_send_movement_details($input_params);

                    $condition_res = $this->condition_3($input_params);
                    if ($condition_res["success"])
                    {

                        $condition_res = $this->condition_1($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->join_public_movement($input_params);

                            $output_response = $this->movement_users_finish_success_3($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $input_params = $this->get_request_user_detail($input_params);

                            $input_params = $this->send_private_movement_join_request($input_params);

                            $input_params = $this->request_notification($input_params);

                            $condition_res = $this->condition_5($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->push_notification($input_params);
                            }

                            $output_response = $this->movement_users_finish_success_4($input_params);
                            return $output_response;
                        }
                    }

                    else
                    {

                        $condition_res = $this->condition_4($input_params);
                        if ($condition_res["success"])
                        {

                            $output_response = $this->movement_users_finish_success_5($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $output_response = $this->movement_users_finish_success_6($input_params);
                            return $output_response;
                        }
                    }
                }
            }

            else
            {

                $input_params = $this->update_cancel_read_status($input_params);

                $output_response = $this->movement_users_finish_success($input_params);
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
     * condition_for_accept method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Jay Rajput | 25.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_accept($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["status"];
            $cc_ro_0 = "Accept";

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
     * user_exists_this_movement method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function user_exists_this_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->user_exists_this_movement($movement_id, $user_id);
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
        $input_params["user_exists_this_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_read_status_request method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_read_status_request($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["movement_id"]))
            {
                $where_arr["movement_id"] = $input_params["movement_id"];
            }
            $params_arr["_emovementreadstatus"] = "Yes";
            $this->block_result = $this->user_notifications_model->update_read_status_request($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_read_status_request"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["user_exists_this_movement"]) ? 0 : 1);
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
     * active_pending method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function active_pending($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["mu_status"];
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
     * movement_users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_send_movement_details method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_send_movement_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $this->block_result = $this->movements_model->get_send_movement_details($movement_id);
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
        $input_params["get_send_movement_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_3 method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_3($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_send_movement_details"]) ? 0 : 1);
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["m_status_1"];
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
     * condition_1 method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["m_visibility_1"];
            $cc_ro_0 = "Public";

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
     * join_public_movement method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function join_public_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["movement_id"]))
            {
                $params_arr["movement_id"] = $input_params["movement_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["status"] = "Active";
            $params_arr["_daddeddate"] = "now()";
            $params_arr["_dupdateddate"] = "now()";
            $params_arr["_eadminstatus"] = "No";
            $this->block_result = $this->movement_users_model->join_public_movement($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["join_public_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_request_user_detail method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 08.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_request_user_detail($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $m_movement_name_1 = isset($input_params["m_movement_name_1"]) ? $input_params["m_movement_name_1"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_request_user_detail($m_movement_name_1, $user_id);
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
        $input_params["get_request_user_detail"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * send_private_movement_join_request method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function send_private_movement_join_request($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["movement_id"]))
            {
                $params_arr["movement_id"] = $input_params["movement_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_estatus"] = "Pending";
            $params_arr["_eadminstatus"] = "No";
            $params_arr["_daddeddate"] = "now()";
            $params_arr["_dupdateddate"] = "now()";
            $this->block_result = $this->movement_users_model->send_private_movement_join_request($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["send_private_movement_join_request"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * request_notification method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function request_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["u_users_id"]))
            {
                $params_arr["u_users_id"] = $input_params["u_users_id"];
            }
            if (isset($input_params["notification_text"]))
            {
                $params_arr["notification_text"] = $input_params["notification_text"];
            }
            $params_arr["_etype"] = "MovementFollower";
            $params_arr["_iuserfollowerid"] = "0";
            $params_arr["_ipostid"] = "0";
            $params_arr["movement_id"] = "".$input_params["movement_id"]."";
            $params_arr["_ipostcommentid"] = "0";
            $params_arr["_itokboxsessionid"] = "0";
            if (isset($input_params["u_users_id_1"]))
            {
                $params_arr["u_users_id_1"] = $input_params["u_users_id_1"];
            }
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "MR";
            $params_arr["_dtaddeddate"] = "now()";
            $params_arr["_emovementreadstatus"] = "No";
            $this->block_result = $this->user_notifications_model->request_notification($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["request_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_5 method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_5($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_device_token"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["u_notification_pref"];
            $cc_ro_1 = 1;

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
     * push_notification method is used to process mobile push notification.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 08.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u_device_token"];
            $code = "MR";
            $sound = "";
            $badge = $input_params["insert_id2"];
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
     * movement_users_finish_success_4 method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_4",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * condition_4 method is used to process conditions.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_4($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_send_movement_details"]) ? 0 : 1);
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
     * movement_users_finish_success_5 method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_5($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success_5",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success_6 method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_6($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success_6",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * update_cancel_read_status method is used to process query block.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_cancel_read_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["movement_id"]))
            {
                $where_arr["movement_id"] = $input_params["movement_id"];
            }
            $params_arr["_emovementreadstatus"] = "Yes";
            $this->block_result = $this->user_notifications_model->update_cancel_read_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_cancel_read_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "movement_invitation_accept_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
