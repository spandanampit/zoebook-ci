<?php  

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Media Likes Model
 * 
 * @category webservice
 *            
 * @package post
 *
 * @subpackage models
 *
 * @module Post Media Likes
 * 
 * @class Post_media_likes_model.php
 * 
 * @path application\webservice\post\models\Post_media_likes_model.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 07.01.2019
 */
 
class Post_media_likes_model extends CI_Model
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
     * check_post_media_likes method is used to execute database queries for Like Post Media API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param string $media_id media_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_media_likes($media_id = '', $user_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_media_likes AS pml");
            
            $this->db->select("pml.iPostMediaLikesId AS pml_post_media_likes_id");
            $this->db->select("pml.iUserId AS pml_user_id");
            $this->db->select("pml.iPostMediaId AS pml_post_media_id");
            $this->db->select("pml.dModifiedDate AS pml_address");
            $this->db->select("pml.eStatus AS pml_status");
            if(isset($media_id) && $media_id != ""){ 
                $this->db->where("pml.iPostMediaId =", $media_id);
            }
            if(isset($user_id) && $user_id != ""){ 
                $this->db->where("pml.iUserId =", $user_id);
            }
            
            
            
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
     * update_post_media_likes method is used to execute database queries for Like Post Media API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_media_likes($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
                        
            
            
            if(isset($where_arr["media_id"]) && $where_arr["media_id"] != ""){ 
                $this->db->where("iPostMediaId =", $where_arr["media_id"]);
            }
            if(isset($where_arr["user_id"]) && $where_arr["user_id"] != ""){ 
                $this->db->where("iUserId =", $where_arr["user_id"]);
            }
            
            
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            if(isset($params_arr["status"])){
                $this->db->set("eStatus", $params_arr["status"]);
            }
            $res = $this->db->update("post_media_likes");
            $affected_rows = $this->db->affected_rows();
            if(!$res || $affected_rows == -1){
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows";
            $result_arr[0][$result_param] = $affected_rows;
            $success = 1;
            
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->db->flush_cache();
        $this->db->_reset_all();
        //echo $this->db->last_query();
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["data"] = $result_arr;
        return $return_arr;
    }
    
    
    /**
     * insert_post_media_likes method is used to execute database queries for Like Post Media API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_post_media_likes($params_arr = array())
    {
        try {
            $result_arr = array();
                        
            if(!is_array($params_arr) || count($params_arr) == 0){
                throw new Exception("Insert data not found.");
            }

            
            if(isset($params_arr["media_id"])){
                $this->db->set("iPostMediaId", $params_arr["media_id"]);
            }
            if(isset($params_arr["user_id"])){
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            if(isset($params_arr["status"])){
                $this->db->set("eStatus", $params_arr["status"]);
            }
            $this->db->insert("post_media_likes");
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
    
    
    /**
     * get_post_media_likes method is used to execute database queries for Get Post Media Likes API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_likes($media_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_media_likes AS pml");
            $this->db->join("users AS u", "pml.iUserId = u.iUsersId", "left");
            $this->db->join("post_media AS pm", "pml.iPostMediaId = pm.iPostMediaId", "left");
            
            $this->db->select("pm.iPostId AS pm_post_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("pml.dModifiedDate AS pml_address");
            if(isset($media_id) && $media_id != ""){ 
                $this->db->where("pml.iPostMediaId =", $media_id);
            }
            $this->db->where("pml.eStatus = (1)", FALSE, FALSE);
            
            
            
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
}