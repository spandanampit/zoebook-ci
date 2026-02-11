<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movement follower remove Controller
 * 
 * @category webservice
 *            
 * @package misc
 * 
 * @subpackage controllers 
 * 
 * @module Movement follower remove
 * 
 * @class Movement_follower_remove.php
 * 
 * @path application\webservice\misc\controllers\Movement_follower_remove.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 27.09.2021
 */ 
 
class Movement_follower_remove extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
    public $block_result;
      
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct() {
        parent::__construct();
        $this->settings_params = array();
        $this->output_params = array();
        $this->single_keys = array("get_movements_users","query_7");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('movement_follower_remove_model');
        $this->load->model("misc/movement_users_model");
    }
      
    /**
     * rules_movement_follower_remove method is used to validate api input params.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_movement_follower_remove($request_arr = array()){
        $valid_arr = array(
                "admin_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "admin_id_required"
                    )
                ),
                "movement_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "movement_id_required"
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "movement_follower_remove");
        
        return $valid_res;
    }
    
    /**
     * start_movement_follower_remove method is used to initiate api execution flow.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_movement_follower_remove($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_movement_follower_remove($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            
        
        $input_params = $this->get_movements_users($input_params);
        
    
        $condition_res = $this->condition($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->query_7($input_params);
        
    
        $output_response = $this->movement_users_finish_success($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $condition_res = $this->condition_1($input_params);
        
        if($condition_res["success"]) {
        
    
        $output_response = $this->movement_users_finish_success_1($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $condition_res = $this->condition_2($input_params);
        
        if($condition_res["success"]) {
        
    
        $output_response = $this->movement_users_finish_success_2($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->movement_users_finish_success_3($input_params);
        return $output_response;
        
    
        }
        
    
        }
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    
                                
    /**
     * get_movements_users method is used to process query block.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movements_users($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->get_movements_users($movement_id, $user_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["get_movements_users"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["get_movements_users"]) ? 0 : 1);
            $cc_ro_0 = 1;
            
            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;    
            
            if(!$cc_fr_0){
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["m_user_id"];
            $cc_ro_1 = $input_params["admin_id"];
            
            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;    
            
            if(!$cc_fr_1){
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_2 = $input_params["m_user_id"];
            $cc_ro_2 = $input_params["user_id"];
            
            $cc_fr_2 = ($cc_lo_2 != $cc_ro_2) ? TRUE : FALSE;    
            
            if(!$cc_fr_2){
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
     * query_7 method is used to process query block.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 24.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function query_7($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->query_7($movement_id, $user_id);
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["query_7"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * movement_users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "movement_users_finish_success"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "movement_follower_remove";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["get_movements_users"]) ? 0 : 1);
            $cc_ro_0 = 0;
            
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
     * movement_users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_1($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "movement_users_finish_success_1"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "movement_follower_remove";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 27.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["m_user_id"];
            $cc_ro_0 = $input_params["admin_id"];
            
            $cc_fr_0 = ($cc_lo_0 != $cc_ro_0) ? TRUE : FALSE;    
            
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
     * movement_users_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_2($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "movement_users_finish_success_2"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "movement_follower_remove";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * movement_users_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 27.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_3($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "movement_users_finish_success_3"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "movement_follower_remove";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}