<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of viral post notification Controller
 * 
 * @category webservice
 *            
 * @package user
 * 
 * @subpackage controllers 
 * 
 * @module viral post notification
 * 
 * @class Viral_post_notification.php
 * 
 * @path application\webservice\user\controllers\Viral_post_notification.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 29.07.2021
 */ 
 
class Viral_post_notification extends Cit_Controller
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
        $this->single_keys = array("custom_function");
        $this->multiple_keys = array("get_user_recored","custom_function_1","get_users_myfeed_record");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('viral_post_notification_model');
        $this->load->model("user/users_model");
    }
      
    /**
     * rules_viral_post_notification method is used to validate api input params.
     * @created Rohit Patidar | 11.05.2021
     * @modified Alpesh Patel | 29.07.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_viral_post_notification($request_arr = array()){
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "viral_post_notification");
        
        return $valid_res;
    }
    
    /**
     * start_viral_post_notification method is used to initiate api execution flow.
     * @created Rohit Patidar | 11.05.2021
     * @modified Alpesh Patel | 29.07.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_viral_post_notification($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_viral_post_notification($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            
        
        $condition_res = $this->condition_1($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->get_user_recored($input_params);
        
    
        $condition_res = $this->condition($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->custom_function_1($input_params);
        
    
        $input_params = $this->push_notification($input_params);
        
    
        $condition_res = $this->condition_4($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->push_notification_2($input_params);
        
    
        }
    
        $output_response = $this->users_finish_success_1($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->users_finish_success($input_params);
        return $output_response;
        
    
        }
        
    
        }
    
        else {
        
    
        $input_params = $this->get_users_myfeed_record($input_params);
        
    
        $condition_res = $this->condition_2($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->custom_function($input_params);
        
    
        $input_params = $this->push_notification_and($input_params);
        
    
        $condition_res = $this->condition_3($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->push_notification_1($input_params);
        
    
        }
    
        $output_response = $this->users_finish_success_2($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->users_finish_success_3($input_params);
        return $output_response;
        
    
        }
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    

    /**
     * condition_1 method is used to process conditions.
     * @created Rohit Patidar | 19.05.2021
     * @modified Rohit Patidar | 25.05.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["post_type"];
            $cc_ro_0 = "Viral";
            
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
     * get_user_recored method is used to process query block.
     * @created Rohit Patidar | 11.05.2021
     * @modified Alpesh Patel | 08.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_recored($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_user_recored($user_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["get_user_recored"] = $this->block_result["data"];
            
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 11.05.2021
     * @modified Rohit Patidar | 11.05.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["get_user_recored"]) ? 0 : 1);
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
     * custom_function_1 method is used to process custom function.
     * @created Alpesh Patel | 06.07.2021
     * @modified Alpesh Patel | 08.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function_1($input_params = array())
    {
                    
            if (!method_exists($this->general, "getDeviceTokens")) {
                $result_arr["data"] = array();
            } else {
                $result_arr["data"] = $this->general->getDeviceTokens($input_params);
            }
            $format_arr = $result_arr;
            
            $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
            $input_params["custom_function_1"] = $format_arr;
            
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }
                                
    /**
     * push_notification method is used to process mobile push notification.
     * @created Rohit Patidar | 11.05.2021
     * @modified Alpesh Patel | 29.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {
        
            $this->block_result = array();
            try {
                                
            $device_id = $input_params["android_device_tokens1"];
            $code = "NPA";
            $sound = "";
            $badge = "";
            $silent = "";
            $title = "Added new viral post";
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
                ),
                array(
                    "key" => "post_type",
                    "value" => $input_params["post_type"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "priority",
                    "value" => "5",
                    "send" => "Yes"
                )
                );
            $push_msg = "Users push notification for added new viral post";
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
            $input_params["push_notification"] = $this->block_result["success"];
            
        return $input_params;
    }

    /**
     * condition_4 method is used to process conditions.
     * @created Alpesh Patel | 08.07.2021
     * @modified Alpesh Patel | 08.07.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_4($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["ios_device_tokens1"];
            
            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;    
            
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
     * push_notification_2 method is used to process mobile push notification.
     * @created Alpesh Patel | 08.07.2021
     * @modified Alpesh Patel | 29.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_2($input_params = array())
    {
        
            $this->block_result = array();
            try {
                                
            $device_id = $input_params["ios_device_tokens1"];
            $code = "NPA";
            $sound = "";
            $badge = "";
            $silent = "";
            $title = "Added new viral post";
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
                ),
                array(
                    "key" => "post_type",
                    "value" => $input_params["post_type"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "priority",
                    "value" => "5",
                    "send" => "Yes"
                )
                );
            $push_msg = "Users push notification for added new viral post";
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
            $input_params["push_notification_2"] = $this->block_result["success"];
            
        return $input_params;
    }

    /**
     * users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 11.05.2021
     * @modified Rohit Patidar | 11.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_1($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "users_finish_success_1"
            );
            $output_fields = array('u_users_id','u_vp_update_date','u_device_token');
            $output_keys = array('get_user_recored');
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "viral_post_notification";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 11.05.2021
     * @modified Rohit Patidar | 11.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "users_finish_success"
            );
            $output_fields = array('u_users_id','u_vp_update_date','u_device_token');
            $output_keys = array('get_user_recored');
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "viral_post_notification";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
                                
    /**
     * get_users_myfeed_record method is used to process query block.
     * @created Rohit Patidar | 19.05.2021
     * @modified Alpesh Patel | 08.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_users_myfeed_record($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_users_myfeed_record($user_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["get_users_myfeed_record"] = $this->block_result["data"];
            
        return $input_params;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 19.05.2021
     * @modified Alpesh Patel | 21.05.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["get_users_myfeed_record"]) ? 0 : 1);
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
     * custom_function method is used to process custom function.
     * @created Alpesh Patel | 06.07.2021
     * @modified Alpesh Patel | 08.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
    {
                    
            if (!method_exists($this->general, "getDeviceTokens")) {
                $result_arr["data"] = array();
            } else {
                $result_arr["data"] = $this->general->getDeviceTokens($input_params);
            }
            $format_arr = $result_arr;
            
            $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
            $input_params["custom_function"] = $format_arr;
            
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }
                                
    /**
     * push_notification_and method is used to process mobile push notification.
     * @created Rohit Patidar | 19.05.2021
     * @modified Alpesh Patel | 29.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_and($input_params = array())
    {
        
            $this->block_result = array();
            try {
                                
            $device_id = $input_params["android_device_tokens"];
            $code = "NPA";
            $sound = "";
            $badge = "";
            $silent = "";
            $title = "Added new MyFeed post";
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
                ),
                array(
                    "key" => "post_type",
                    "value" => $input_params["post_type"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "priority",
                    "value" => "5",
                    "send" => "Yes"
                )
                );
            $push_msg = "Users push notification for added new My Feed post";
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
            $input_params["push_notification_and"] = $this->block_result["success"];
            
        return $input_params;
    }

    /**
     * condition_3 method is used to process conditions.
     * @created Alpesh Patel | 08.07.2021
     * @modified Alpesh Patel | 08.07.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_3($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["ios_device_tokens"];
            
            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;    
            
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
     * push_notification_1 method is used to process mobile push notification.
     * @created Alpesh Patel | 08.07.2021
     * @modified Alpesh Patel | 29.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_1($input_params = array())
    {
        
            $this->block_result = array();
            try {
                                
            $device_id = $input_params["ios_device_tokens"];
            $code = "NPA";
            $sound = "";
            $badge = "post_id";
            $silent = "";
            $title = "Added new MyFeed post";
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
                ),
                array(
                    "key" => "post_type",
                    "value" => $input_params["post_type"],
                    "send" => "Yes"
                ),
                array(
                    "key" => "priority",
                    "value" => "5",
                    "send" => "Yes"
                )
                );
            $push_msg = "Users push notification for added new My Feed post";
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
            $input_params["push_notification_1"] = $this->block_result["success"];
            
        return $input_params;
    }

    /**
     * users_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 19.05.2021
     * @modified Rohit Patidar | 25.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_2($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "users_finish_success_2"
            );
            $output_fields = array('u_users_id_1','u_device_token_1','u_my_feed_update_date');
            $output_keys = array('get_users_myfeed_record');
            $ouput_aliases = array("get_users_myfeed_record" => "get_user_recored","u_users_id_1" => "u_users_id","u_device_token_1" => "u_device_token");
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "viral_post_notification";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["output_alias"] = $ouput_aliases;
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * users_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 19.05.2021
     * @modified Rohit Patidar | 25.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_3($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "users_finish_success_3"
            );
            $output_fields = array('u_users_id_1','u_device_token_1','u_my_feed_update_date');
            $output_keys = array('get_users_myfeed_record');
            $ouput_aliases = array("get_users_myfeed_record" => "get_user_recored","u_users_id_1" => "u_users_id","u_device_token_1" => "u_device_token");
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "viral_post_notification";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["output_alias"] = $ouput_aliases;
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}