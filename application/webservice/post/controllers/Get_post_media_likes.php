<?php  
            
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Get Post Media Likes Controller
 * 
 * @category webservice
 *            
 * @package post
 * 
 * @subpackage controllers 
 * 
 * @module Get Post Media Likes
 * 
 * @class Get_post_media_likes.php
 * 
 * @path application\webservice\post\controllers\Get_post_media_likes.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 17.11.2022
 */ 
 
class Get_post_media_likes extends Cit_Controller
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
        $this->single_keys = array("check_post_media_id");
        $this->multiple_keys = array("get_post_media_likes");
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('get_post_media_likes_model');
        $this->load->model("post/post_media_model");
    $this->load->model("post/post_media_likes_model");
    }
      
    /**
     * rules_get_post_media_likes method is used to validate api input params.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 23.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_get_post_media_likes($request_arr = array()){
        $valid_arr = array(
                "media_id" => array(
                    array(
                        "rule" => "required",
                        "value" => TRUE,
                        "message" => "media_id_required"
                    )
                )
            );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "get_post_media_likes");
        
        return $valid_res;
    }
    
    /**
     * start_get_post_media_likes method is used to initiate api execution flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 23.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_get_post_media_likes($request_arr  = array(), $inner_api = FALSE) {
        try {
            $validation_res = $this->rules_get_post_media_likes($request_arr);
            if ($validation_res["success"] == "-5") {
                if($inner_api === TRUE){
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];
            
        
        $input_params = $this->check_post_media_id($input_params);
        
    
        $condition_res = $this->check_post_media_id_condition($input_params);
        
        if($condition_res["success"]) {
        
    
        $input_params = $this->get_post_media_likes($input_params);
        
    
        $condition_res = $this->get_post_media_likes_condition($input_params);
        
        if($condition_res["success"]) {
        
    
        $output_response = $this->post_media_finish_success($input_params);
        return $output_response;
        
    
        }
    
        else {
        
    
        $output_response = $this->post_media_finish_success_1($input_params);
        return $output_response;
        
    
        }
        
    
        }
    
        else {
        
    
        $output_response = $this->post_media_finish_success_2($input_params);
        return $output_response;
        
    
        }
        
        
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }
    
                                
    /**
     * check_post_media_id method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_media_id($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $media_id = isset($input_params["media_id"]) ? $input_params["media_id"] : "";
            $this->block_result = $this->post_media_model->check_post_media_id($media_id);
            
            if(!$this->block_result["success"]){
                throw new Exception("No records found.");
            }
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["check_post_media_id"] = $this->block_result["data"];
            $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
            
        return $input_params;
    }

    /**
     * check_post_media_id_condition method is used to process conditions.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_post_media_id_condition($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["check_post_media_id"]) ? 0 : 1);
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
     * get_post_media_likes method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_media_likes($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $media_id = isset($input_params["media_id"]) ? $input_params["media_id"] : "";
            $this->block_result = $this->post_media_likes_model->get_post_media_likes($media_id);
            
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
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);
                    
                    $result_arr[$data_key]["u_profile_image"] = $data;
                    
                    $data = $data_arr["pml_address"];
                    if (method_exists($this->general, "dateTimeSystemFormat")) {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["pml_address"] = $data;
                    
                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
            
            } catch (Exception $e) {
                $success = 0;
                $this->block_result["data"] = array();
            }
            $input_params["get_post_media_likes"] = $this->block_result["data"];
            
        return $input_params;
    }

    /**
     * get_post_media_likes_condition method is used to process conditions.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function get_post_media_likes_condition($input_params = array())
    {
        
            $this->block_result = array();
            try {
                
            $cc_lo_0 = (empty($input_params["get_post_media_likes"]) ? 0 : 1);
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
     * post_media_finish_success method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 30.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "1", 
                "message" => "post_media_finish_success"
            );
            $output_fields = array('pm_post_id','u_users_id','u_name','u_profile_image','pml_address');
            $output_keys = array('get_post_media_likes');
            $ouput_aliases = array("pm_post_id" => "post_id","u_users_id" => "user_id","u_name" => "user_name","u_profile_image" => "user_profile_image","pml_address" => "liked_at");
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "get_post_media_likes";
            $func_array["function"]["output_keys"] = $output_keys;
            $func_array["function"]["output_alias"] = $ouput_aliases;
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * post_media_finish_success_1 method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_1($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "post_media_finish_success_1"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "get_post_media_likes";
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }

    /**
     * post_media_finish_success_2 method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_2($input_params = array())
    {
        
            $setting_fields = array(
                "success" => "0", 
                "message" => "post_media_finish_success_2"
            );
            $output_fields = array();
            
            $output_array["settings"] = $setting_fields;
            $output_array["settings"]["fields"] = $output_fields;
            $output_array["data"] = $input_params;
                        
            $func_array["function"]["name"] = "get_post_media_likes";
            $func_array["function"]["single_keys"] = $this->single_keys;
            $func_array["function"]["multiple_keys"] = $this->multiple_keys;
            
            $this->wsresponse->setResponseStatus(200);
            
            $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);
            
        return $responce_arr;
    }
    
}