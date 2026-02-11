<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Get Website Screenshots Controller
 * 
 * @category webservice
 *            
 * @package tools
 * 
 * @subpackage controllers 
 * 
 * @module Get Website Screenshots
 * 
 * @class Get_website_screenshots.php
 * 
 * @path application\webservice\tools\controllers\Get_website_screenshots.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 18.03.2020
 */ 
 
class Get_website_screenshots extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $multiple_keys;
    public $block_result;
      
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct() {
        parent::__construct();
        $this->settings_params = array();
        $this->output_params = array();
        $this->multiple_keys = array("type_wise_screenshots");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('get_website_screenshots_model');
        $this->load->model("tools/website_screenshots_model");
    }
      
    /**
     * rules_get_website_screenshots method is used to validate api input params.
     * @created Bhagya Rachana | 03.10.2018
     * @modified  | 14.10.2019
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_get_website_screenshots($request_arr = array()){
        $valid_arr = array(
                "type" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "type_required"
                    )
                )
            );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "get_website_screenshots");
        
        return $valid_res;
    }
    
    /**
     * start_get_website_screenshots method is used to initiate api execution flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified  | 14.10.2019
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_get_website_screenshots($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_get_website_screenshots($request_arr);
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
            
        
        $input_params = $this->type_wise_screenshots($input_params);
        
    
        $condition_res = $this->is_found($input_params);
        
        if($condition_res["success"]) {
        
    
        $output_response = $this->success($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->failure($input_params);
        return $output_response;
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    
                                
    /**
     * type_wise_screenshots method is used to process query block.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function type_wise_screenshots($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $type = isset($input_params["type"]) ? $input_params["type"] : "";
            $this->block_result = $this->website_screenshots_model->type_wise_screenshots($type);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if(is_array($result_arr) && count($result_arr) > 0){
                $i = 0;
                foreach($result_arr as $data_key => $data_arr){
                    
                    $data = $data_arr["screenshot"];
                    $image_arr = array();                        
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["color"] = "FFFFFF";
                    $dest_path = "promotional_screenshots";
                    $image_arr["path"] = $this->general->getImageNestedFolders($dest_path);
                    $data = $this->general->get_image($image_arr);
                    
                    $result_arr[$data_key]["screenshot"] = $data;
                    
                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["type_wise_screenshots"] = $this->block_result["data"];
            
        return $input_params;
    }

    /**
     * is_found method is used to process conditions.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_found($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["type_wise_screenshots"]) ? 0 : 1);
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
     * success method is used to process finish flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "success"
            );
            $output_fields = array('screenshots_id','screenshot','sequence');
            $output_keys = array('type_wise_screenshots');
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "get_website_screenshots";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * failure method is used to process finish flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failure($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "failure"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "get_website_screenshots";
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}