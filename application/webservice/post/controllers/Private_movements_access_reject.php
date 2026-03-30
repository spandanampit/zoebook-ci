<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of private movements access reject Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module private movements access reject
 *
 * @class Private_movements_access_reject.php
 *
 * @path application\webservice\post\controllers\Private_movements_access_reject.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 16.08.2022
 */

class Private_movements_access_reject extends Cit_Controller
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
            "get_movements_user",
            "private_movement_active",
            "insert_user_notifications",
            "get_activet_record",
            "update_user_notification_read_status",
            "private_movements_inactive",
            "update_user_notification",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('private_movements_access_reject_model');
        $this->load->model("misc/movement_users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_private_movements_access_reject method is used to validate api input params.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_private_movements_access_reject($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "private_movements_access_reject");

        return $valid_res;
    }

    /**
     * start_private_movements_access_reject method is used to initiate api execution flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_private_movements_access_reject($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_private_movements_access_reject($request_arr);
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

            $input_params = $this->get_movements_user($input_params);

            $condition_res = $this->condition_for_get_moment_user($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_for_status($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->private_movement_active($input_params);

                    $condition_res = $this->condition_for_device_token_and_notification($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->push_notification($input_params);
                    }

                    $input_params = $this->insert_user_notifications($input_params);

                    $input_params = $this->get_activet_record($input_params);

                    $input_params = $this->update_user_notification_read_status($input_params);

                    $output_response = $this->movement_users_finish_success_2($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->private_movements_inactive($input_params);

                    $input_params = $this->update_user_notification($input_params);

                    $output_response = $this->movement_users_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

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
     * get_movements_user method is used to process query block.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 19.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movements_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->get_movements_user($movement_id, $user_id);
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
        $input_params["get_movements_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_get_moment_user method is used to process conditions.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_moment_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_movements_user"]) ? 0 : 1);
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
     * condition_for_status method is used to process conditions.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_status($input_params = array())
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
     * private_movement_active method is used to process query block.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 20.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function private_movement_active($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["mu_movement_users_id"]))
            {
                $where_arr["mu_movement_users_id"] = $input_params["mu_movement_users_id"];
            }
            $params_arr["status"] = "Active";
            $params_arr["_dupdateddate"] = "now()";
            $this->block_result = $this->movement_users_model->private_movement_active($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["private_movement_active"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_device_token_and_notification method is used to process conditions.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_device_token_and_notification($input_params = array())
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
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 19.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u_device_token"];
            $code = "MRA";
            $sound = "";
            $badge = $input_params["affected_rows"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                ),
                array(
                    "key" => "movement_id",
                    "value" => $input_params["mu_movement_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "m_device_group_token",
                    "value" => $input_params["m_device_group_token"],
                    "send" => "Yes",
                )
            );
            $push_msg = "#u2_name# has accepted your movements join  request";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "default";

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
     * insert_user_notifications method is used to process query block.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_user_notifications($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["mu_user_id"]))
            {
                $params_arr["mu_user_id"] = $input_params["mu_user_id"];
            }
            if (isset($input_params["u2_name"]))
            {
                $params_arr["u2_name"] = $input_params["u2_name"];
            }
            if (method_exists($this, "getNotificationText"))
            {
                $params_arr["u2_name"] = $this->getNotificationText($params_arr["u2_name"], $input_params);
            }
            $params_arr["_etype"] = "Normal";
            if (isset($input_params["movement_id"]))
            {
                $params_arr["movement_id"] = $input_params["movement_id"];
            }
            if (isset($input_params["u2_users_id"]))
            {
                $params_arr["u2_users_id"] = $input_params["u2_users_id"];
            }
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "MRA";
            $params_arr["_dtaddeddate"] = "now()";
            $this->block_result = $this->user_notifications_model->insert_user_notifications($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_user_notifications"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_activet_record method is used to process query block.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 20.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_activet_record($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $mu_movement_users_id = isset($input_params["mu_movement_users_id"]) ? $input_params["mu_movement_users_id"] : "";
            $this->block_result = $this->movement_users_model->get_activet_record($mu_movement_users_id);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
        }
        catch(Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_activet_record"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_user_notification_read_status method is used to process query block.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_notification_read_status($input_params = array())
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
            $this->block_result = $this->user_notifications_model->update_user_notification_read_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_notification_read_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 22.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_2",
        );
        $output_fields = array(
            'mu_movement_id_1',
            'mu_user_id_1',
            'mu_status_1',
        );
        $output_keys = array(
            'get_activet_record',
        );
        $ouput_aliases = array(
            "mu_movement_id_1" => "movement_id",
            "mu_user_id_1" => "user_id",
            "mu_status_1" => "status",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "private_movements_access_reject";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * private_movements_inactive method is used to process query block.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function private_movements_inactive($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $mu_movement_users_id = isset($input_params["mu_movement_users_id"]) ? $input_params["mu_movement_users_id"] : "";
            $this->block_result = $this->movement_users_model->private_movements_inactive($mu_movement_users_id);
        } catch(Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["private_movements_inactive"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_user_notification method is used to process query block.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_notification($input_params = array())
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
            $this->block_result = $this->user_notifications_model->update_user_notification($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 21.09.2021
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

        $func_array["function"]["name"] = "private_movements_access_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Alpesh Patel | 24.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "private_movements_access_reject";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
