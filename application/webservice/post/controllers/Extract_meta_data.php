<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Extract meta data Controller
 * 
 * @category webservice
 *            
 * @package post
 * 
 * @subpackage controllers 
 * 
 * @module Extract meta data
 * 
 * @class Extract_meta_data.php
 * 
 * @path application\webservice\post\controllers\Extract_meta_data.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 12.12.2022
 */ 
 
class Extract_meta_data extends Cit_Controller
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
        $this->single_keys = array("extract_posts_meta_data","query_for_post");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('extract_meta_data_model');
        $this->load->model("post/post_model");
    }
      
    /**
     * rules_extract_meta_data method is used to validate api input params.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Jay Rajput | 12.12.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_extract_meta_data($request_arr = array()){
        $valid_arr = array(
                "post_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "post_id_required"
                    )
                ),
                "post_text" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "post_text_required"
                    )
                )
            );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "extract_meta_data");
        
        return $valid_res;
    }
    
    /**
     * start_extract_meta_data method is used to initiate api execution flow.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Jay Rajput | 12.12.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_extract_meta_data($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_extract_meta_data($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            
        
        $input_params = $this->extract_posts_meta_data($input_params);
        
    
        $condition_res = $this->condition_for_is_meta($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->query_for_post($input_params);
        
    
        $output_response = $this->post_finish_success($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->finish_success_1($input_params);
        return $output_response;
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    
                                
    /**
     * extract_posts_meta_data method is used to process custom function.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function extract_posts_meta_data($input_params = array())
    {
                    
            if (!method_exists($this, "extract_posts_metadata")) {
                $result_arr["data"] = array();
            } else {
                $result_arr["data"] = $this->extract_posts_metadata($input_params);
            }
            $format_arr = $result_arr;
            
            $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
            $input_params["extract_posts_meta_data"] = $format_arr;
            
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition_for_is_meta method is used to process conditions.
     * @created Nandini Santoki | 18.09.2020
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_is_meta($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = $input_params["is_meta"];
            $cc_ro_0 = "Yes";
            
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
     * query_for_post method is used to process query block.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function query_for_post($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $params_arr = $where_arr = array();
            if(isset($input_params["post_id"])){
                $where_arr["post_id"] = $input_params["post_id"];
            }
            if(isset($input_params["json_post_metadata"])){
                $params_arr["json_post_metadata"] = $input_params["json_post_metadata"];
            }
            $this->block_result = $this->post_model->query_for_post($params_arr, $where_arr);
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["query_for_post"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Ashok Pidugu | 24.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "post_finish_success"
            );
            $output_fields = array('json_post_metadata','affected_rows');
            $output_keys = array('extract_posts_meta_data','query_for_post');
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "extract_meta_data";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * finish_success_1 method is used to process finish flow.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Ashok Pidugu | 24.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success_1($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "", 
                "message" => "finish_success_1"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "extract_meta_data";
            $func_array["function"]["single_keys"] = $this->single_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}