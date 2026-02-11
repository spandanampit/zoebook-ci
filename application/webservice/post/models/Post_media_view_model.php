<?php  

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Media View Model
 * 
 * @category webservice
 *            
 * @package post
 *
 * @subpackage models
 *
 * @module Post Media View
 * 
 * @class Post_media_view_model.php
 * 
 * @path application\webservice\post\models\Post_media_view_model.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 17.10.2022
 */
 
class Post_media_view_model extends CI_Model
{
    public $default_lang = 'EN';
    
    /**
     * __construct method is used to set model preferences while model object initialization.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('listing');
        $this->default_lang = $this->general->getLangRequestValue();
    }
    
    /**
     * check_user_media_view method is used to execute database queries for Update Media View Count API.
     * @created Vamsi Ippe | 22.05.2019
     * @modified Vamsi Ippe | 22.05.2019
     * @param string $iPostMediaId iPostMediaId is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_media_view($iPostMediaId = '', $user_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_media_view AS pmv");
            
            $this->db->select("pmv.iPostMediaViewId AS pmv_post_media_view_id");
            if(isset($iPostMediaId) && $iPostMediaId != ""){ 
                $this->db->where("pmv.iPostMediaId =", $iPostMediaId);
            }
            if(isset($user_id) && $user_id != ""){ 
                $this->db->where("pmv.iUserId =", $user_id);
            }
            
            
            
            $this->db->limit(1);
            
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            
            if(!is_array($result_arr) || count($result_arr) == 0){
                throw new Exception('No records found.');
            }
            $success = 1;
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        
        $this->db->_reset_all();
        //echo $this->db->last_query();
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["data"] = $result_arr;
        return $return_arr;
    }
    
    
    /**
     * insert_media_view method is used to execute database queries for Update Media View Count API.
     * @created Vamsi Ippe | 22.05.2019
     * @modified Vamsi Ippe | 22.05.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_media_view($params_arr = array())
    {
        try {
            $result_arr = array();
                        
            if(!is_array($params_arr) || count($params_arr) == 0){
                throw new Exception("Insert data not found.");
            }

            
            if(isset($params_arr["iPostMediaId"])){
                $this->db->set("iPostMediaId", $params_arr["iPostMediaId"]);
            }
            if(isset($params_arr["user_id"])){
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->insert("post_media_view");
            $insert_id = $this->db->insert_id();
            if(!$insert_id){
                 throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id";
            $result_arr[0][$result_param] = $insert_id;
            $success = 1;
            
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        
        $this->db->_reset_all();
        //echo $this->db->last_query();
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["data"] = $result_arr;
        return $return_arr;
    }
    
    
}