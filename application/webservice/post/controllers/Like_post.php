<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Like Post Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Like Post
 *
 * @class Like_post.php
 *
 * @path application\webservice\post\controllers\Like_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Like_post extends Cit_Controller
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
            "check_post_exist_for_like",
            "check_like_record_exists",
            "insert_like",
            "update_post_date",
            "get_posted_user_details",
            "get_liked_user_details",
            "insert_liked_notification",
            "delete_like",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('like_post_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_like_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_like_post method is used to validate api input params.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 25.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_like_post($request_arr = array())
    {
        $valid_arr = array(
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "like_post");

        return $valid_res;
    }

    /**
     * start_like_post method is used to initiate api execution flow.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 25.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_like_post($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_like_post($request_arr);
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

                $input_params = $this->check_post_exist_for_like($input_params);

                $condition_res = $this->condition_2($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_finish_success_1($input_params);
                    return $output_response;
                }

                else
                {

                    $condition_res = $this->cond_post_exists($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->check_like_record_exists($input_params);

                        $condition_res = $this->cond_check_exists($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->insert_like($input_params);

                            $condition_res = $this->condition($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->update_post_date($input_params);

                                $condition_res = $this->cond_posted_user_check($input_params);
                                if ($condition_res["success"])
                                {

                                    $input_params = $this->get_posted_user_details($input_params);

                                    $input_params = $this->get_liked_user_details($input_params);

                                    $input_params = $this->insert_liked_notification($input_params);

                                    $condition_res = $this->check_posted_user_notify_pref($input_params);
                                    if ($condition_res["success"])
                                    {

                                        $input_params = $this->push_notify_posted_user($input_params);
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

                        $output_response = $this->post_finish_success($input_params);
                        return $output_response;
                    }
                }
            }

            else
            {

                $input_params = $this->delete_like($input_params);

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
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
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
     * check_post_exist_for_like method is used to process query block.
     * @created Vamsi Ippe | 22.10.2018
     * @modified Jay Rajput | 25.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_exist_for_like($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_model->check_post_exist_for_like($post_id, $user_id);
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
        $input_params["check_post_exist_for_like"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["m_status"];
            $cc_ro_0 = "Inactive";

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
     * post_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * cond_post_exists method is used to process conditions.
     * @created Vamsi Ippe | 22.10.2018
     * @modified Vamsi Ippe | 22.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_exist_for_like"]) ? 0 : 1);
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
     * check_like_record_exists method is used to process query block.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 22.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_like_record_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_like_model->check_like_record_exists($post_id, $user_id);
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
        $input_params["check_like_record_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_exists method is used to process conditions.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_like_record_exists"]) ? 0 : 1);
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
     * insert_like method is used to process query block.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_like($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $this->block_result = $this->post_like_model->insert_like($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_like"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_like"]) ? 0 : 1);
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
     * update_post_date method is used to process query block.
     * @created Rohit Patidar | 14.10.2021
     * @modified Rohit Patidar | 14.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_date($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["post_id"]))
            {
                $where_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_dmodifieddate"] = "now()";
            $this->block_result = $this->post_model->update_post_date($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_date"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_posted_user_check method is used to process conditions.
     * @created Vamsi Ippe | 22.10.2018
     * @modified Vamsi Ippe | 22.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_posted_user_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["posted_user_id"];
            $cc_ro_0 = $input_params["user_id"];

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
     * get_posted_user_details method is used to process query block.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_posted_user_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->get_posted_user_details($post_id);
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
        $input_params["get_posted_user_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_liked_user_details method is used to process query block.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_liked_user_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_liked_user_details($user_id);
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
        $input_params["get_liked_user_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * insert_liked_notification method is used to process query block.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_liked_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["posted_users_id"]))
            {
                $params_arr["posted_users_id"] = $input_params["posted_users_id"];
            }
            $params_arr["liked_name"] = "CONCAT('".$input_params["liked_name"]."',\" liked your post\")";
            $params_arr["_dtaddeddate"] = "NOW()";
            $params_arr["_etype"] = "Post";
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "'LOP'";
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["liked_users_id"]))
            {
                $params_arr["liked_users_id"] = $input_params["liked_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_liked_notification($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_liked_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_posted_user_notify_pref method is used to process conditions.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_posted_user_notify_pref($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["posted_notification_pref"];
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
     * push_notify_posted_user method is used to process mobile push notification.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notify_posted_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["posted_device_token"];
            $code = "LOP";
            $sound = "";
            $badge = $input_params["post_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#liked_name# liked your post";
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
        $input_params["push_notify_posted_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * post_like_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 25.07.2022
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
            'posted_user_id',
            'pl_post_like_id',
            'insert_id',
        );
        $output_keys = array(
            'check_like_record_exists',
            'insert_like',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_like_finish_failure method is used to process finish flow.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
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

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_like_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
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

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 22.10.2018
     * @modified Vamsi Ippe | 22.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * delete_like method is used to process query block.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_like($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_like_model->delete_like($post_id, $user_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_like"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["delete_like"]) ? 0 : 1);
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
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
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
            'delete_like',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_like_finish_delete_failure method is used to process finish flow.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
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

        $func_array["function"]["name"] = "like_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
