<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update Media View Count Controller
 * 
 * @category webservice
 *            
 * @package post
 * 
 * @subpackage controllers 
 * 
 * @module Update Media View Count
 * 
 * @class Update_media_view_count.php
 * 
 * @path application\webservice\post\controllers\Update_media_view_count.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 17.10.2022
 */ 
 
class Update_media_view_count extends Cit_Controller
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
        $this->single_keys = array("check_user_media_view","insert_media_view","update_view_count");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('update_media_view_count_model');
        $this->load->model("post/post_media_view_model");
    $this->load->model("post/post_media_model");
    }
      
    /**
     * rules_update_media_view_count method is used to validate api input params.
     * @created Pavan  | 16.11.2018
     * @modified Jay Rajput | 08.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_update_media_view_count($request_arr = array()){
        $valid_arr = array(
                "iPostMediaId" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "iPostMediaId_required"
                    )
                )
            );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "update_media_view_count");
        
        return $valid_res;
    }
    
    /**
     * start_update_media_view_count method is used to initiate api execution flow.
     * @created Pavan  | 16.11.2018
     * @modified Jay Rajput | 08.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_update_media_view_count($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_update_media_view_count($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            
        
        $condition_res = $this->check_user($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->check_user_media_view($input_params);
        
    
        $condition_res = $this->condition_view_exists($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->insert_media_view($input_params);
        
    
        }
    
        else {
        
    
        $output_response = $this->post_media_view_finish_success($input_params);
        return $output_response;
        
    
        }
        
    
        }
    
        $input_params = $this->update_view_count($input_params);
        
    
        $output_response = $this->post_media_finish_success($input_params);
        return $output_response;
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    

    /**
     * check_user method is used to process conditions.
     * @created Vamsi Ippe | 25.06.2020
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_user($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = 0;
            
            $cc_fr_0 = ($cc_lo_0 > $cc_ro_0) ? TRUE : FALSE;    
            
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
     * check_user_media_view method is used to process query block.
     * @created Vamsi Ippe | 22.05.2019
     * @modified Vamsi Ippe | 22.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_user_media_view($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $iPostMediaId = isset($input_params["iPostMediaId"]) ? $input_params["iPostMediaId"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_media_view_model->check_user_media_view($iPostMediaId, $user_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["check_user_media_view"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * condition_view_exists method is used to process conditions.
     * @created Vamsi Ippe | 22.05.2019
     * @modified Vamsi Ippe | 22.05.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_view_exists($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["check_user_media_view"]) ? 0 : 1);
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
     * insert_media_view method is used to process query block.
     * @created Vamsi Ippe | 22.05.2019
     * @modified Vamsi Ippe | 22.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_media_view($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $params_arr = array();
            if(isset($input_params["iPostMediaId"])){
                $params_arr["iPostMediaId"] = $input_params["iPostMediaId"];
            }
            if(isset($input_params["user_id"])){
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $this->block_result = $this->post_media_view_model->insert_media_view($params_arr);
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["insert_media_view"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * post_media_view_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 22.05.2019
     * @modified Vamsi Ippe | 22.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_view_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "post_media_view_finish_success"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "update_media_view_count";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
                                
    /**
     * update_view_count method is used to process query block.
     * @created Pavan  | 28.11.2018
     * @modified Vamsi Ippe | 22.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_view_count($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $params_arr = $where_arr = array();
            if(isset($input_params["iPostMediaId"])){
                $where_arr["iPostMediaId"] = $input_params["iPostMediaId"];
            }
            $params_arr["_iviewscount"] = "iViewsCount+1";
            $this->block_result = $this->post_media_model->update_view_count($params_arr, $where_arr);
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["update_view_count"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * post_media_finish_success method is used to process finish flow.
     * @created Pavan  | 28.11.2018
     * @modified Pavan  | 28.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "post_media_finish_success"
            );
            $output_fields = array('affected_rows');
            $output_keys = array('update_view_count');
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "update_media_view_count";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}