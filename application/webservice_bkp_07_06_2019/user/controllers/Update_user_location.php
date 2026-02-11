<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update User Location Controller
 * 
 * @category webservice
 *            
 * @package user
 * 
 * @subpackage controllers 
 * 
 * @module Update User Location
 * 
 * @class Update_user_location.php
 * 
 * @path application\webservice\user\controllers\Update_user_location.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 26.09.2018
 */ 
 
class Update_user_location extends Cit_Controller
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
        $this->single_keys = array("update_current_user_lat_long");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('update_user_location_model');
        $this->load->model("user/users_model");
    }
      
    /**
     * rules_update_user_location method is used to validate api input params.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_update_user_location($request_arr = array()){
        $valid_arr = array(
                "user_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "user_id_required"
                    )
                ),
                "latitude" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "latitude_required"
                    )
                ),
                "longitude" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "longitude_required"
                    )
                )
            );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "update_user_location");
        
        return $valid_res;
    }
    
    /**
     * start_update_user_location method is used to initiate api execution flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_update_user_location($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_update_user_location($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            $output_array = $func_array = array();
            
        
        $input_params = $this->update_current_user_lat_long($input_params);
        
    
        $condition_res = $this->condition($input_params);
        
        if($condition_res["success"]) {
        
    
        $output_response = $this->users_finish_success($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->users_finish_success_1($input_params);
        return $output_response;
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    
                                
    /**
     * update_current_user_lat_long method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_current_user_lat_long($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $params_arr = $where_arr = array();
            if(isset($input_params["user_id"])){
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if(isset($input_params["latitude"])){
                $params_arr["latitude"] = $input_params["latitude"];
            }
            if(isset($input_params["longitude"])){
                $params_arr["longitude"] = $input_params["longitude"];
            }
            $this->block_result = $this->users_model->update_current_user_lat_long($params_arr, $where_arr);
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["update_current_user_lat_long"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["update_current_user_lat_long"]) ? 0 : 1);
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
     * users_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "users_finish_success"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "update_user_location";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * users_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_1($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "users_finish_success_1"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "update_user_location";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}