<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Like Comment Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Like Comment
 *
 * @class Like_comment.php
 *
 * @path application\webservice\post\controllers\Like_comment.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Like_comment extends Cit_Controller
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
            "check_record_exists",
            "insert_comment_like",
            "get_commented_user_data",
            "get_commet_liked_user_data",
            "insert_commented_notification",
            "delete_like_v1",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('like_comment_model');
        $this->load->model("post/post_comment_like_model");
        $this->load->model("post/post_comment_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_like_comment method is used to validate api input params.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_like_comment($request_arr = array())
    {
        $valid_arr = array(
            "post_comment_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_comment_id_required",
                )
            ),
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "status" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "status_required",
                ),
                array(
                    "rule" => "digits",
                    "value" => TRUE,
                    "message" => "status_digits",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "like_comment");

        return $valid_res;
    }

    /**
     * start_like_comment method is used to initiate api execution flow.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_like_comment($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_like_comment($request_arr);
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

            $condition_res = $this->check_status($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->check_record_exists($input_params);

                $condition_res = $this->cond_check_exists($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->insert_comment_like($input_params);

                    $condition_res = $this->condition_for_insert_comment($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->get_commented_user_data($input_params);

                        $input_params = $this->get_commet_liked_user_data($input_params);

                        $condition_res = $this->cond_commented_user_id_check($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->insert_commented_notification($input_params);

                            $condition_res = $this->check_commented_user_notify_pref($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->push_notify_commented_user($input_params);
                            }
                        }

                        $output_response = $this->post_like_finish_success($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->post_like_finish_failure($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->post_like_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $input_params = $this->delete_like_v1($input_params);

                $condition_res = $this->condition_1($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_like_finish_delete_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->post_like_finish_delete_failure($input_params);
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
     * check_status method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["status"];
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
     * check_record_exists method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_record_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_comment_like_model->check_record_exists($user_id, $post_comment_id, $post_id);
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
        $input_params["check_record_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_exists method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_record_exists"]) ? 0 : 1);
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
     * insert_comment_like method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_comment_like($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_comment_id"]))
            {
                $params_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $this->block_result = $this->post_comment_like_model->insert_comment_like($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_comment_like"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_insert_comment method is used to process conditions.
     * @created CIT Dev Team
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_insert_comment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_comment_like"]) ? 0 : 1);
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
     * get_commented_user_data method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_commented_user_data($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $this->block_result = $this->post_comment_model->get_commented_user_data($post_comment_id);
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
        $input_params["get_commented_user_data"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_commet_liked_user_data method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_commet_liked_user_data($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_commet_liked_user_data($user_id);
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
        $input_params["get_commet_liked_user_data"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_commented_user_id_check method is used to process conditions.
     * @created Vamsi Ippe | 23.10.2018
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_commented_user_id_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["commented_users_id"];
            $cc_ro_0 = $input_params["liked_users_id"];

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
     * insert_commented_notification method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_commented_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["commented_users_id"]))
            {
                $params_arr["commented_users_id"] = $input_params["commented_users_id"];
            }
            $params_arr["liked_name"] = "CONCAT('".$input_params["liked_name"]."',\" liked your comment\")";
            $params_arr["_dtaddeddate"] = "NOW()";
            $params_arr["_etype"] = "Post";
            $params_arr["_eisread"] = "No";
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["post_comment_id"]))
            {
                $params_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            $params_arr["_vcode"] = "'LOC'";
            if (isset($input_params["liked_users_id"]))
            {
                $params_arr["liked_users_id"] = $input_params["liked_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_commented_notification($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_commented_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_commented_user_notify_pref method is used to process conditions.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_commented_user_notify_pref($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["commented_notification_pref"];
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
     * push_notify_commented_user method is used to process mobile push notification.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notify_commented_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["commented_device_token"];
            $code = "LOC";
            $sound = "";
            $badge = $input_params["insert_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "post_comment_id",
                    "value" => $input_params["post_comment_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#liked_name# liked your comment";
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
        $input_params["push_notify_commented_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * post_like_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_like_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_like_finish_success",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_comment_like',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_comment";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_like_finish_failure method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_like_finish_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_like_finish_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_like_finish_success_1 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_like_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_like_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * delete_like_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_like_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_comment_like_model->delete_like_v1($post_comment_id, $post_id, $user_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_like_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["delete_like_v1"]) ? 0 : 1);
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
     * post_like_finish_delete_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_like_finish_delete_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_like_finish_delete_success",
        );
        $output_fields = array(
            'affected_rows',
        );
        $output_keys = array(
            'delete_like_v1',
        );
        $ouput_aliases = array(
            "delete_like_v1" => "delete_like",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_comment";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_like_finish_delete_failure method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_like_finish_delete_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_like_finish_delete_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
