<?php  

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Like Model
 * 
 * @category webservice
 *            
 * @package post
 *
 * @subpackage models
 *
 * @module Post Like
 * 
 * @class Post_like_model.php
 * 
 * @path application\webservice\post\models\Post_like_model.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 07.01.2019
 */
 
class Post_like_model extends CI_Model
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
     * insert_like method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_like($params_arr = array())
    {
        try {
            $result_arr = array();
                        
            if(!is_array($params_arr) || count($params_arr) == 0){
                throw new Exception("Insert data not found.");
            }

            
            if(isset($params_arr["post_id"])){
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if(isset($params_arr["user_id"])){
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->insert("post_like");
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
     * delete_like method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_like($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();
                                
            
            if(isset($post_id) && $post_id != ""){ 
                $this->db->where("iPostId =", $post_id);
            }
            if(isset($user_id) && $user_id != ""){ 
                $this->db->where("iUserId =", $user_id);
            }
            $res = $this->db->delete("post_like");
            if(!$res){
                 throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows";
            $result_arr[0][$result_param] = $affected_rows;
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
     * check_like_record_exists method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 22.10.2018
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_like_record_exists($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_like AS pl");
            
            $this->db->select("pl.iPostLikeId AS pl_post_like_id");
            if(isset($post_id) && $post_id != ""){ 
                $this->db->where("pl.iPostId =", $post_id);
            }
            if(isset($user_id) && $user_id != ""){ 
                $this->db->where("pl.iUserId =", $user_id);
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
     * get_post_liked_users method is used to execute database queries for Post Liked Users API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_liked_users($post_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_like AS pl");
            $this->db->join("users AS u", "pl.iUserId = u.iUsersId", "left");
            
            $this->db->select("pl.iPostId AS pl_post_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.iUsersId AS u_users_id");
            if(isset($post_id) && $post_id != ""){ 
                $this->db->where("pl.iPostId =", $post_id);
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
    
    
}