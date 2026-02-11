<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update Live Video Post Status Controller
 *
 * @category notification
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Update Live Video Post Status
 *
 * @class Update_live_video_post_status.php
 *
 * @path application\notifications\tokbox\controllers\Update_live_video_post_status.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 31.12.2018
 */

class Update_live_video_post_status extends Cit_Controller
{
    public $settings_params;
    public $output_params;
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
        $this->multiple_keys = array(
            "get_live_tokbox_session",
        );
        $this->block_result = array();

        $this->load->library('notifyresponse');
        $this->load->model('update_live_video_post_status_model');
        $this->load->model("tokbox/tokbox_session_model");
        $this->load->model("post/post_media_model");
        $this->load->model("post/post_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * start_update_live_video_post_status method is used to initiate api execution flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 31.12.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $output_response returns output response of API.
     */
    public function start_update_live_video_post_status($request_arr = array())
    {
        try
        {
            $output_response = array();
            $input_params = $request_arr;
            $output_array = array();

            $input_params = $this->get_live_tokbox_session($input_params);

            $condition_res = $this->condi_post_exists($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->start_loop($input_params);

                $output_response = $this->tokbox_session_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->tokbox_session_finish_success_1($input_params);
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
     * get_live_tokbox_session method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_live_tokbox_session($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $archive_url = isset($input_params["archive_url"]) ? $input_params["archive_url"] : "";
            $this->block_result = $this->tokbox_session_model->get_live_tokbox_session($archive_url);
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
        $input_params["get_live_tokbox_session"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condi_post_exists method is used to process conditions.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condi_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_live_tokbox_session"]) ? 0 : 1);
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
     * start_loop method is used to process loop flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop($input_params = array())
    {
        $this->iterate_start_loop($input_params["get_live_tokbox_session"], $input_params);
        return $input_params;
    }

    /**
     * func_get_archive_status method is used to process custom function.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 18.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_get_archive_status($input_params = array())
    {
        if (!method_exists($this, "get_archive_status"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->get_archive_status($input_params);
        }
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $result_arr["data"]);

        $input_params["func_get_archive_status"] = $this->notifyresponse->assignFunctionResponse($result_arr);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 31.12.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["final_archive_status"];
            $cc_ro_0 = "uploaded";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["archive_url"];

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
     * update_tokbox_status method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_tokbox_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_tokbox_session_id"]))
            {
                $where_arr["ts_tokbox_session_id"] = $input_params["ts_tokbox_session_id"];
            }
            if (isset($input_params["final_archive_status"]))
            {
                $params_arr["final_archive_status"] = $input_params["final_archive_status"];
            }
            if (isset($input_params["archive_url"]))
            {
                $params_arr["archive_url"] = $input_params["archive_url"];
            }
            $params_arr["ts_archive_status"] = "Published";
            $this->block_result = $this->tokbox_session_model->update_tokbox_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_tokbox_status"] = $this->block_result["data"];
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * insert_live_media method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 18.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_live_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["ts_post_id"]))
            {
                $params_arr["ts_post_id"] = $input_params["ts_post_id"];
            }
            $params_arr["_emediatype"] = "Video";
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["archive_file_name"]))
            {
                $params_arr["archive_file_name"] = $input_params["archive_file_name"];
            }
            if (isset($input_params["live_video_thumb"]))
            {
                $params_arr["live_video_thumb"] = $input_params["live_video_thumb"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            $this->block_result = $this->post_media_model->insert_live_media($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_live_media"] = $this->block_result["data"];
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_post_status method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 03.12.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_post_id"]))
            {
                $where_arr["ts_post_id"] = $input_params["ts_post_id"];
            }
            $params_arr["final_archive_status"] = "Active";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_eposttype"] = "Live";
            $this->block_result = $this->post_model->update_post_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_status"] = $this->block_result["data"];
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * insert_post_notification method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 05.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_post_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["notify_text"]))
            {
                $params_arr["notify_text"] = $input_params["notify_text"];
            }
            $params_arr["_etype"] = "Post";
            $params_arr["_eisread"] = "No";
            $params_arr["_dtaddeddate"] = "NOW()";
            $params_arr["_vcode"] = "'LVPT'";
            if (isset($input_params["ts_post_id"]))
            {
                $params_arr["ts_post_id"] = $input_params["ts_post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_post_notification($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_post_notification"] = $this->block_result["data"];
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_notify_pref_check method is used to process conditions.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 02.11.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_notify_pref_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_notification_pref"];
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
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u_device_token"];
            $code = "LVPT";
            $sound = "";
            $badge = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["ts_post_id"],
                    "send" => "Yes",
                )
            );
            $push_msg = "#notify_text# ";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "runtime";

            $send_arr = array();
            $send_arr['device_id'] = $device_id;
            $send_arr['code'] = $code;
            $send_arr['sound'] = $sound;
            $send_arr['badge'] = intval($badge);
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
     * exist_api_send_post_notification method is used to process custom function.
     * Send post notification to followers
     * @created Vamsi Ippe | 02.11.2018
     * @modified Vamsi Ippe | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function exist_api_send_post_notification($input_params = array())
    {
        if (!method_exists($this, "send_post_notify_to_follower"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->send_post_notify_to_follower($input_params);
        }
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $result_arr["data"]);

        $input_params["exist_api_send_post_notification"] = $this->notifyresponse->assignFunctionResponse($result_arr);

        return $input_params;
    }

    /**
     * update_tokbox_latest_status method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_tokbox_latest_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_tokbox_session_id"]))
            {
                $where_arr["ts_tokbox_session_id"] = $input_params["ts_tokbox_session_id"];
            }
            if (isset($input_params["final_archive_status"]))
            {
                $params_arr["final_archive_status"] = $input_params["final_archive_status"];
            }
            if (isset($input_params["archive_url"]))
            {
                $params_arr["archive_url"] = $input_params["archive_url"];
            }
            $this->block_result = $this->tokbox_session_model->update_tokbox_latest_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_tokbox_latest_status"] = $this->block_result["data"];
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * tokbox_session_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "Data saved successfully.",
        );
        $output_fields = array(
            'ts_tokbox_session_id',
            'ts_post_id',
            'ts_archive_id',
            'ts_archive_status',
            'ts_status',
            'ts_user_id',
            'u_notification_pref',
            'u_device_token',
            'func_get_archive_status',
            'archive_url',
            'final_archive_status',
            'notify_text',
            'update_tokbox_status',
            'affected_rows',
            'insert_live_media',
            'insert_id',
            'update_post_status',
            'affected_rows1',
            'insert_post_notification',
            'insert_id1',
        );
        $output_keys = array(
            'get_live_tokbox_session',
        );
        $ouput_aliases = array(
            "insert_id" => "media_id",
            "insert_id1" => "notify_id",
        );
        $inner_keys = array(
            'func_get_archive_status',
            'update_tokbox_status',
            'insert_live_media',
            'update_post_status',
            'insert_post_notification',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_live_video_post_status";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["inner_keys"] = $inner_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $responce_arr = $this->notifyresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "No Pending live posts",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_live_video_post_status";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $responce_arr = $this->notifyresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * iterate_start_loop method is used to iterate loop.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $get_live_tokbox_session_lp_arr get_live_tokbox_session_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop(&$get_live_tokbox_session_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $get_live_tokbox_session_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $get_live_tokbox_session_lp_pms = $input_params_loc;

            unset($get_live_tokbox_session_lp_pms["get_live_tokbox_session"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $get_live_tokbox_session_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $get_live_tokbox_session_lp_pms["get_live_tokbox_session"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["get_live_tokbox_session"] = $get_live_tokbox_session_lp_pms["get_live_tokbox_session"];
            }

            $get_live_tokbox_session_lp_pms["i"] = $i;
            $input_params = $get_live_tokbox_session_lp_pms;

            $input_params = $this->func_get_archive_status($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->update_tokbox_status($input_params);

                $input_params = $this->insert_live_media($input_params);

                $input_params = $this->update_post_status($input_params);

                $input_params = $this->insert_post_notification($input_params);

                $condition_res = $this->cond_notify_pref_check($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->push_notification($input_params);
                }

                $input_params = $this->exist_api_send_post_notification($input_params);
            }

            else
            {

                $input_params = $this->update_tokbox_latest_status($input_params);
            }

            $get_live_tokbox_session_lp_arr[$i] = $this->notifyresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $get_live_tokbox_session_lp_pms);
        }
    }
}
