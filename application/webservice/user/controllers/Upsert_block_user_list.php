<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of upsert_block_user_list Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module upsert_block_user_list
 *
 * @class Upsert_block_user_list.php
 *
 * @path application\webservice\user\controllers\Upsert_block_user_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Upsert_block_user_list extends Cit_Controller
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
            "user_query_block",
            "block_user_query_block",
            "unblock_user",
            "block_update_query",
            "unfollow_query_1",
            "block_user_condition_block_only",
            "unfollow_query",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('upsert_block_user_list_model');
        $this->load->model("user/users_model");
        $this->load->model("user/block_user_list_model");
        $this->load->model("user/user_followers_model");
    }

    /**
     * rules_upsert_block_user_list method is used to validate api input params.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_upsert_block_user_list($request_arr = array())
    {
        $valid_arr = array(
            "blocked_user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "blocked_user_id_required",
                )
            ),
            "block_by_user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "block_by_user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "upsert_block_user_list");

        return $valid_res;
    }

    /**
     * start_upsert_block_user_list method is used to initiate api execution flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_upsert_block_user_list($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_upsert_block_user_list($request_arr);
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

            $input_params = $this->user_query_block($input_params);

            $input_params = $this->block_user_query_block($input_params);

            $condition_res = $this->block_user_condition($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->block_status_condition($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->unblock_user($input_params);

                    $condition_res = $this->condition_unblock_user($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->block_user_list_finish_success_5($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->block_user_list_finish_success_4($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $input_params = $this->block_update_query($input_params);

                    $condition_res = $this->condition_block_update($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->unfollow_query_1($input_params);

                        $condition_res = $this->check_device_token_again($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->push_notification_1($input_params);
                        }

                        $output_response = $this->block_user_list_finish_success_3($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->block_user_list_finish_success_2($input_params);
                        return $output_response;
                    }
                }
            }

            else
            {

                $input_params = $this->block_user_condition_block_only($input_params);

                $condition_res = $this->block_user_condition_block_only_in_condition($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->unfollow_query($input_params);

                    $condition_res = $this->device_token_condition($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->push_notification($input_params);
                    }

                    $output_response = $this->block_user_list_finish_success_1($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->block_user_list_finish_success($input_params);
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
     * user_query_block method is used to process query block.
     * @created Rohit Patidar | 31.08.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function user_query_block($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $blocked_user_id = isset($input_params["blocked_user_id"]) ? $input_params["blocked_user_id"] : "";
            $this->block_result = $this->users_model->user_query_block($blocked_user_id);
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
        $input_params["user_query_block"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * block_user_query_block method is used to process query block.
     * if record exist
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function block_user_query_block($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $blocked_user_id = isset($input_params["blocked_user_id"]) ? $input_params["blocked_user_id"] : "";
            $block_by_user_id = isset($input_params["block_by_user_id"]) ? $input_params["block_by_user_id"] : "";
            $this->block_result = $this->block_user_list_model->block_user_query_block($blocked_user_id, $block_by_user_id);
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
        $input_params["block_user_query_block"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * block_user_condition method is used to process conditions.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function block_user_condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["block_user_query_block"]) ? 0 : 1);
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
     * block_status_condition method is used to process conditions.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function block_status_condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["bc_eStatus"];
            $cc_ro_0 = "block";

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
     * unblock_user method is used to process query block.
     * if block then unblock
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function unblock_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["bc_block_list_user_id"]))
            {
                $where_arr["bc_block_list_user_id"] = $input_params["bc_block_list_user_id"];
            }
            $params_arr["_estatus"] = "unblock";
            $this->block_result = $this->block_user_list_model->unblock_user($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["unblock_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_unblock_user method is used to process conditions.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_unblock_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["unblock_user"]) ? 0 : 1);
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
     * block_user_list_finish_success_5 method is used to process finish flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 06.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function block_user_list_finish_success_5($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "block_user_list_finish_success_5",
        );
        $output_fields = array(
            'bc_block_list_user_id',
            'bc_eStatus',
            'affected_rows1',
        );
        $output_keys = array(
            'block_user_query_block',
            'block_update_query',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "upsert_block_user_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * block_user_list_finish_success_4 method is used to process finish flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function block_user_list_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "block_user_list_finish_success_4",
        );
        $output_fields = array(
            'bc_block_list_user_id',
            'bc_eStatus',
        );
        $output_keys = array(
            'block_user_query_block',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "upsert_block_user_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * block_update_query method is used to process query block.
     * if unblock then block
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function block_update_query($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["bc_block_list_user_id"]))
            {
                $where_arr["bc_block_list_user_id"] = $input_params["bc_block_list_user_id"];
            }
            $params_arr["_estatus"] = "block";
            $this->block_result = $this->block_user_list_model->block_update_query($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["block_update_query"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_block_update method is used to process conditions.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_block_update($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["block_update_query"]) ? 0 : 1);
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
     * unfollow_query_1 method is used to process query block.
     * @created Alpesh Patel | 03.09.2021
     * @modified Alpesh Patel | 03.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function unfollow_query_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["block_by_user_id"]))
            {
                $where_arr["block_by_user_id"] = $input_params["block_by_user_id"];
            }
            if (isset($input_params["blocked_user_id"]))
            {
                $where_arr["blocked_user_id"] = $input_params["blocked_user_id"];
            }
            $params_arr["_estatus"] = "Deleted";
            $params_arr["_dmodifieddate"] = "NOW()";
            $this->block_result = $this->user_followers_model->unfollow_query_1($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["unfollow_query_1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_device_token_again method is used to process conditions.
     * @created Alpesh Patel | 03.09.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_device_token_again($input_params = array())
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
     * push_notification_1 method is used to process mobile push notification.
     * @created Rohit Patidar | 31.08.2021
     * @modified Rohit Patidar | 02.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u_device_token"];
            $code = "BLOCKED";
            $sound = "";
            $badge = $input_params["u_users_id"];
            $silent = "";
            $title = "Block ";
            $send_vars = array(
                array(
                    "key" => "bloked_by_user_id",
                    "value" => $input_params["block_by_user_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "bloked_user",
                    "value" => $input_params["blocked_user_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "1",
                    "send" => "Yes",
                )
            );
            $push_msg = "You are blocked by another user";
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
        $input_params["push_notification_1"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * block_user_list_finish_success_3 method is used to process finish flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 06.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function block_user_list_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "block_user_list_finish_success_3",
        );
        $output_fields = array(
            'bc_eStatus',
            'affected_rows1',
        );
        $output_keys = array(
            'block_user_query_block',
            'block_update_query',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "upsert_block_user_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * block_user_list_finish_success_2 method is used to process finish flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function block_user_list_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "block_user_list_finish_success_2",
        );
        $output_fields = array(
            'bc_block_list_user_id',
            'bc_eStatus',
        );
        $output_keys = array(
            'block_user_query_block',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "upsert_block_user_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * block_user_condition_block_only method is used to process query block.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function block_user_condition_block_only($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            $params_arr["_estatus"] = "block";
            if (isset($input_params["blocked_user_id"]))
            {
                $params_arr["blocked_user_id"] = $input_params["blocked_user_id"];
            }
            if (isset($input_params["block_by_user_id"]))
            {
                $params_arr["block_by_user_id"] = $input_params["block_by_user_id"];
            }
            $this->block_result = $this->block_user_list_model->block_user_condition_block_only($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["block_user_condition_block_only"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * block_user_condition_block_only_in_condition method is used to process conditions.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function block_user_condition_block_only_in_condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["block_user_condition_block_only"]) ? 0 : 1);
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
     * unfollow_query method is used to process query block.
     * @created Alpesh Patel | 03.09.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function unfollow_query($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["block_by_user_id"]))
            {
                $where_arr["block_by_user_id"] = $input_params["block_by_user_id"];
            }
            if (isset($input_params["blocked_user_id"]))
            {
                $where_arr["blocked_user_id"] = $input_params["blocked_user_id"];
            }
            $params_arr["_estatus"] = "Deleted";
            $params_arr["_dmodifieddate"] = "NOW()";
            $this->block_result = $this->user_followers_model->unfollow_query($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["unfollow_query"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * device_token_condition method is used to process conditions.
     * @created Alpesh Patel | 03.09.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function device_token_condition($input_params = array())
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
     * @created Rohit Patidar | 31.08.2021
     * @modified Rohit Patidar | 02.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u_device_token"];
            $code = "BLOCKED";
            $sound = "default";
            $badge = $input_params["u_users_id"];
            $silent = "";
            $title = "Block ";
            $send_vars = array(
                array(
                    "key" => "bloked_by_user_id",
                    "value" => $input_params["block_by_user_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "bloked_user",
                    "value" => $input_params["blocked_user_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "1",
                    "send" => "Yes",
                )
            );
            $push_msg = "You are blocked by another user";
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
     * block_user_list_finish_success_1 method is used to process finish flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 06.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function block_user_list_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "block_user_list_finish_success_1",
        );
        $output_fields = array(
            'bc_block_list_user_id',
            'bc_eStatus',
            'insert_id',
        );
        $output_keys = array(
            'block_user_query_block',
            'block_user_condition_block_only',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "upsert_block_user_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * block_user_list_finish_success method is used to process finish flow.
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function block_user_list_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "block_user_list_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "upsert_block_user_list";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
