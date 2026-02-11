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
 * @since 17.11.2022
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
     * @modified Jay Rajput | 23.08.2022
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_likes($media_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_media_likes AS pml");
            $join_condition = $this->db->protect("pml.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
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
    
    
    /**
     * get_user_data_v1_v2 method is used to execute database queries for List Liked Post Media API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 25.07.2022
     * @param string $latitude latitude is used to process query block.
     * @param string $longitude longitude is used to process query block.
     * @param string $media_id media_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_data_v1_v2($latitude = '', $longitude = '', $media_id = '', $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();
                        
            $this->db->start_cache();
            $this->db->from("post_media_likes AS pl");
            $join_condition = $this->db->protect("pl.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            
            $this->db->where_in("u.eStatus", array('Active'));
            $this->db->where_in("u.eEmailVerified", array('1'));
            $this->db->where("pl.iPostMediaId = (".$media_id.")", FALSE, FALSE);
            
            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();
            
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(".$this->db->escape("").") AS is_follwing", FALSE);
            $this->db->select("(".$this->db->escape("").") AS follower_count", FALSE);
            $this->db->select("(".$this->db->escape("").") AS following_count", FALSE);
            $this->db->select("(".$this->db->escape("").") AS post_count", FALSE);
            $this->db->select("(".$this->db->escape("").") AS pending_request_id", FALSE);
            $this->db->select("(ROUND(GeoDistMiles(u.vLatitude,u.vLongtitude,'".$latitude."','".$longitude."','km'),2)) AS distance_kms", FALSE);
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("pl.iPostMediaId AS pl_post_media_id");

            $settings_params['count'] = $total_records;
            
            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;
            
            $this->db->order_by("pl.iPostMediaLikesId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            
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
     * delete_post_like_list method is used to execute database queries for Delete Account API.
     * @created Jay Rajput | 19.10.2022
     * @modified Jay Rajput | 19.10.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_post_like_list($user_id = '')
    {
        try {
            $result_arr = array();
                                
            
            if(isset($user_id) && $user_id != ""){ 
                $this->db->where("iUserId =", $user_id);
            }
            $res = $this->db->delete("post_media_likes");
            if(!$res){
                 throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows5";
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


    public function get_post_media_like_count($media_id = '')
    {
        try {
            $count = 0;
            if (!empty($media_id)) {
                $this->db->from("post_media_likes AS pml");
                $this->db->where("pml.iPostMediaId", $media_id);
                $this->db->where("pml.eStatus", 1);

                $count = $this->db->count_all_results();

                if ($count == 0) {
                    throw new Exception('No likes found.');
                }
            } else {
                throw new Exception('Media ID is required.');
            }

            $success = 1;
            $message = 'fetched successfully';
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }

        $this->db->_reset_all();

        return [
            "success" => $success,
            "message" => $message,
            "like_count" => $count
        ];
    }
    
    
}