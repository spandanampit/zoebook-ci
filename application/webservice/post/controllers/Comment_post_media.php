<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Comment Post Media Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Comment Post Media
 *
 * @class Comment_post_media.php
 *
 * @path application\webservice\post\controllers\Comment_post_media.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Comment_post_media extends Cit_Controller
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
            "check_post_media_id_v1",
            "insert_post_media_comments",
            "update_post_modifydate",
            "sender_details",
            "insert_notification",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('comment_post_media_model');
        $this->load->model("post/post_media_model");
        $this->load->model("post/post_comment_model");
        $this->load->model("post/post_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_comment_post_media method is used to validate api input params.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_comment_post_media($request_arr = array())
    {
        $valid_arr = array(
            "comment_text" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "comment_text_required",
                )
            ),
            "media_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "media_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "comment_post_media");

        return $valid_res;
    }

    /**
     * start_comment_post_media method is used to initiate api execution flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_comment_post_media($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_comment_post_media($request_arr);
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

            $input_params = $this->check_post_media_id_v1($input_params);

            $condition_res = $this->condition_for_post_media($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->insert_post_media_comments($input_params);

                $input_params = $this->update_post_modifydate($input_params);

                $condition_res = $this->is_not_same_user($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->sender_details($input_params);

                    $input_params = $this->insert_notification($input_params);

                    $condition_res = $this->should_user_notify($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->push_notification($input_params);

                        $output_response = $this->success_with_noti($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->success_without_noti($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->success_same_user($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->failed($input_params);
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
     * check_post_media_id_v1 method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_media_id_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $media_id = isset($input_params["media_id"]) ? $input_params["media_id"] : "";
            $this->block_result = $this->post_media_model->check_post_media_id_v1($media_id);
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
        $input_params["check_post_media_id_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_post_media method is used to process conditions.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_media_id_v1"]) ? 0 : 1);
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
     * insert_post_media_comments method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_post_media_comments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["media_id"]))
            {
                $params_arr["media_id"] = $input_params["media_id"];
            }
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["comment_text"]))
            {
                $params_arr["comment_text"] = $input_params["comment_text"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            $this->block_result = $this->post_comment_model->insert_post_media_comments($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_post_media_comments"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_post_modifydate method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_modifydate($input_params = array())
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
            $this->block_result = $this->post_model->update_post_modifydate($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_modifydate"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * is_not_same_user method is used to process conditions.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_not_same_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["post_owner_id"];

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
     * sender_details method is used to process query block.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function sender_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->sender_details($user_id);
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
        $input_params["sender_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * insert_notification method is used to process query block.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_owner_id"]))
            {
                $params_arr["post_owner_id"] = $input_params["post_owner_id"];
            }
            $params_arr["_vnotificationtext"] = "CONCAT('".$input_params["sender_name"]."',' has commented on your post')";
            $params_arr["_etype"] = "Comment";
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "'COP'";
            $params_arr["_dtaddeddate"] = "NOW()";
            $this->block_result = $this->user_notifications_model->insert_notification($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * should_user_notify method is used to process conditions.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function should_user_notify($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["should_notify"];
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
     * push_notification method is used to process mobile push notification.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["post_owner_device_token"];
            $code = "COP";
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
                    "value" => $input_params["insert_id"],
                    "send" => "Yes",
                )
            );
            $push_msg = "#sender_name# has commented on your post";
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
     * success_with_noti method is used to process finish flow.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success_with_noti($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success_with_noti",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_post_media_comments',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * success_without_noti method is used to process finish flow.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success_without_noti($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success_without_noti",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_post_media_comments',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * success_same_user method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success_same_user($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success_same_user",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_post_media_comments',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * failed method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failed($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "failed",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
