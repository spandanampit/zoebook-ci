<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Send Post Notification Controller
 * 
 * @category webservice
 *            
 * @package post
 * 
 * @subpackage controllers 
 * 
 * @module Send Post Notification
 * 
 * @class Send_post_notification.php
 * 
 * @path application\webservice\post\controllers\Send_post_notification.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 22.07.2021
 */ 
 
class Send_post_notification extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
    public $multiple_keys;
    public $block_result;
      
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct() {
        parent::__construct();
        $this->settings_params = array();
        $this->output_params = array();
        $this->single_keys = array("get_user_name","ins_follwer_notification");
        $this->multiple_keys = array("check_user_followers","func_generate_notification_text");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('send_post_notification_model');
        $this->load->model("user/user_followers_model");
    $this->load->model("user/users_model");
    $this->load->model("user/user_notifications_model");
    }
      
    /**
     * rules_send_post_notification method is used to validate api input params.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Alpesh Patel | 22.07.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_send_post_notification($request_arr = array()){
        $valid_arr = array(
                "post_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "post_id_required"
                    )
                ),
                "user_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "user_id_required"
                    )
                )
            );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "send_post_notification");
        
        return $valid_res;
    }
    
    /**
     * start_send_post_notification method is used to initiate api execution flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Alpesh Patel | 22.07.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_send_post_notification($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_send_post_notification($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            
        
        $input_params = $this->check_user_followers($input_params);
        
    
        $condition_res = $this->is_follwers_exist($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->get_user_name($input_params);
        
    
        $input_params = $this->func_generate_notification_text($input_params);
        
    
        $input_params = $this->ins_follwer_notification($input_params);
        
    
        $input_params = $this->start_loop($input_params);
        
    
        $output_response = $this->user_followers_finish_success($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->user_followers_finish_success_1($input_params);
        return $output_response;
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    
                                
    /**
     * check_user_followers method is used to process query block.
     * @created CIT Dev Team
     * @modified Anjaneyulu Gulla | 24.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_user_followers($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->user_followers_model->check_user_followers($user_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["check_user_followers"] = $this->block_result["data"];
            
        return $input_params;
    }

    /**
     * is_follwers_exist method is used to process conditions.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_follwers_exist($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["check_user_followers"]) ? 0 : 1);
            $cc_ro_0 = 1;
            
            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;    
            
            if(!$cc_fr_0){
                throw new Exception("Some conditions does not match.");
            }
                $success = 1;
                $message = "Conditions matched.";
            } catch (Exception $e) {
                $success = 0;
                $message = $e->getMessage();
            }
            $this->block_result["success"] = $success;
            $this->block_result["message"] = $message;
            return $this->block_result;
            
    }
                                
    /**
     * get_user_name method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_name($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_user_name($user_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if(is_array($result_arr) && count($result_arr) > 0){
                $i = 0;
                foreach($result_arr as $data_key => $data_arr){
                    
                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();                        
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["height"] = "50";
                    $image_arr["width"] = "50";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["path"] = "profile_image";
                    $data = $this->general->get_image_aws($image_arr);
                    
                    $result_arr[$data_key]["u_profile_image"] = $data;
                    
                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["get_user_name"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }
                                
    /**
     * func_generate_notification_text method is used to process custom function.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_generate_notification_text($input_params = array())
    {
                    
            if (!method_exists($this, "getNotificationText")) {
                $result_arr["data"] = array();
            } else {
                $result_arr["data"] = $this->getNotificationText($input_params);
            }
            $format_arr = $result_arr;
            
            $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
            $input_params["func_generate_notification_text"] = $format_arr;
            
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }
                                
    /**
     * ins_follwer_notification method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function ins_follwer_notification($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $params_arr = array();
            $batch_params_arr = $input_params["check_user_followers"];
            if(!is_array($batch_params_arr) || count($batch_params_arr) == 0){
                throw new Exception("Batch insert data not found.");
            }
            $tmp_input_params = $input_params;
            unset($tmp_input_params["check_user_followers"]);
            
            $batch_count = count($batch_params_arr);
            for($i = 0; $i < $batch_count; $i++){
                $batch_params = is_array($batch_params_arr[$i]) ? array_merge($tmp_input_params, $batch_params_arr[$i]) : $tmp_input_params;
                $batch_params["i"] = $i;
                
                $params_arr[$i]["follower_users_id"] = $batch_params["follower_users_id"];
                $params_arr[$i]["notification_type"] = $batch_params["notification_type"];
                $params_arr[$i]["_eisread"] = "No";
                $params_arr[$i]["_dtaddeddate"] = "NOW()";
                $params_arr[$i]["notification_text"] = $batch_params["notification_text"];
                $params_arr[$i]["post_id"] = $batch_params["post_id"];
                $params_arr[$i]["notification_code"] = $batch_params["notification_code"];
                $params_arr[$i]["tokbox_session_id"] = $batch_params["tokbox_session_id"];
                $params_arr[$i]["user_id"] = $batch_params["user_id"];
            }
            $this->block_result = $this->user_notifications_model->ins_follwer_notification($params_arr);
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["ins_follwer_notification"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }
                           
    /**
     * start_loop method is used to process loop flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop($input_params = array())
    {
        $this->iterate_start_loop($input_params["check_user_followers"], $input_params);
        return $input_params;
    }
    

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Anjaneyulu Gulla | 24.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["notification_type"];
            $cc_ro_0 = "Post";
            
            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;    
            
            $cc_lo_1 = $input_params["notification_type"];
            $cc_ro_1 = "Share";
            
            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;    
            
            if(!($cc_fr_0 || $cc_fr_1)){
                throw new Exception("Some conditions does not match."); 
            }
                $success = 1;
                $message = "Conditions matched.";
            } catch (Exception $e) {
                $success = 0;
                $message = $e->getMessage();
            }
            $this->block_result["success"] = $success;
            $this->block_result["message"] = $message;
            return $this->block_result;
            
    }

    /**
     * cond_user_notifypref_check method is used to process conditions.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_user_notifypref_check($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["user_notification_pref"];
            $cc_ro_0 = 1;
            
            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;    
            
            if(!$cc_fr_0){
                throw new Exception("Some conditions does not match.");
            }
                $success = 1;
                $message = "Conditions matched.";
            } catch (Exception $e) {
                $success = 0;
                $message = $e->getMessage();
            }
            $this->block_result["success"] = $success;
            $this->block_result["message"] = $message;
            return $this->block_result;
            
    }
                                
    /**
     * push_notification_post method is used to process mobile push notification.
     * @created CIT Dev Team
     * @modified Alpesh Patel | 22.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_post($input_params = array())
    {
        
            $this->block_result = array();
            try {
                                
            $device_id = $input_params["user_device_token"];
            $code = "NPA";
            $sound = "";
            $badge = $input_params["u_profile_image"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "silent",
                    "value" => "1",
                    "send" => "Yes"
                )
                );
            $push_msg = "#notification_text# ";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "cron";
            
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

            if(!$uni_id){
                 throw new Exception('Failure in insertion of push notification batch entry.');
            }
            
                $success = 1;
                $message = "Push notification send succesfully.";
            } catch (Exception $e) {
                $success = 0;
                $message = $e->getMessage();
            }
            $this->block_result["success"] = $success;
            $this->block_result["message"] = $message;
            $input_params["push_notification_post"] = $this->block_result["success"];
            
        return $input_params;
    }

    /**
     * user_followers_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "user_followers_finish_success"
            );
            $output_fields = array('device_token','follower_users_id','insert_id1');
            $output_keys = array('check_user_followers','ins_follwer_notification');
            $ouput_aliases = array("ins_follwer_notification_v1" => "ins_follwer_notification","insert_id1" => "notification_id");
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "send_post_notification";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["output_alias"] = $ouput_aliases;
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * check_user_notify_pref method is used to process conditions.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_user_notify_pref($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["user_notification_pref"];
            $cc_ro_0 = 1;
            
            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;    
            
            if(!$cc_fr_0){
                throw new Exception("Some conditions does not match.");
            }
                $success = 1;
                $message = "Conditions matched.";
            } catch (Exception $e) {
                $success = 0;
                $message = $e->getMessage();
            }
            $this->block_result["success"] = $success;
            $this->block_result["message"] = $message;
            return $this->block_result;
            
    }
                                
    /**
     * push_notification_live_post method is used to process mobile push notification.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_live_post($input_params = array())
    {
        
            $this->block_result = array();
            try {
                                
            $device_id = $input_params["user_device_token"];
            $code = "LVP";
            $sound = "";
            $badge = $input_params["u_profile_image"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "tokbox_session_id",
                    "value" => $input_params["tokbox_session_id"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes"
                )
                );
            $push_msg = "#notification_text# ";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "cron";
            
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

            if(!$uni_id){
                 throw new Exception('Failure in insertion of push notification batch entry.');
            }
            
                $success = 1;
                $message = "Push notification send succesfully.";
            } catch (Exception $e) {
                $success = 0;
                $message = $e->getMessage();
            }
            $this->block_result["success"] = $success;
            $this->block_result["message"] = $message;
            $input_params["push_notification_live_post"] = $this->block_result["success"];
            
        return $input_params;
    }

    /**
     * user_followers_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_1($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "user_followers_finish_success_1"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "send_post_notification";
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
    /**
     * iterate_start_loop method is used to iterate loop.
     * @created CIT Dev Team
     * @modified ---
     * @param array $check_user_followers_lp_arr check_user_followers_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop(&$check_user_followers_lp_arr = array(), &$input_params_addr = array())
    {
        
         
        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $check_user_followers_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1) {
            $check_user_followers_lp_pms = $input_params_loc;
            
            unset($check_user_followers_lp_pms["check_user_followers"]);
            if(is_array($_loop_params_loc[$i])){
                $check_user_followers_lp_pms = $_loop_params_loc[$i] + $input_params_loc;
            } else {
                $check_user_followers_lp_pms["check_user_followers"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["check_user_followers"] = $check_user_followers_lp_pms["check_user_followers"];
            }
            
            $check_user_followers_lp_pms["i"] = $i;
            $input_params = $check_user_followers_lp_pms;
            
        $condition_res = $this->condition($input_params);
        
        if($condition_res["success"]) {
        
    
        $condition_res = $this->cond_user_notifypref_check($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->push_notification_post($input_params);
        
    
        }
    
        }
    
        else {
        
    
        $condition_res = $this->check_user_notify_pref($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->push_notification_live_post($input_params);
        
    
        }
    
        }
        
            
    
            
            $check_user_followers_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $check_user_followers_lp_pms);
        }
        
    }
}