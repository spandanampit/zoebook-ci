<?php  

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Media Comments Model
 * 
 * @category webservice
 *            
 * @package post
 *
 * @subpackage models
 *
 * @module Post Media Comments
 * 
 * @class Post_media_comments_model.php
 * 
 * @path application\webservice\post\models\Post_media_comments_model.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 07.01.2019
 */
 
class Post_media_comments_model extends CI_Model
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
     * get_post_media_comments method is used to execute database queries for Get Post Media Comments API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_comments($media_id = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("post_media_comments AS pmc");
            $this->db->join("post_media AS pm", "pmc.iPostMediaId = pm.iPostMediaId", "left");
            $this->db->join("users AS u", "pmc.iUserId = u.iUsersId", "left");
            
            $this->db->select("u.vName AS u_name");
            $this->db->select("(SELECT count(iPostMediaLikesId) FROM `post_media_likes` WHERE  iPostMediaId = pmc.iPostMediaId) AS count_post_media_comment_likes", FALSE);
            $this->db->select("(SELECT count(iPostMediaLikesId) FROM `post_media_likes` WHERE  iPostMediaId = pmc.iPostMediaId And iUserId = u.iUsersId) AS is_post_media_comment_like", FALSE);
            $this->db->select("(SELECT count(iPostMediaId) FROM `post_media` WHERE iPostId = pm.iPostId ANd iParentCommentId = pmc.iPostMediaId AND eStatus = 'Active') AS is_reply_count", FALSE);
            $this->db->select("pmc.iPostMediaCommentsId AS pmc_post_media_comments_id");
            $this->db->select("pmc.iPostMediaId AS pmc_post_media_id");
            $this->db->select("pmc.tComment AS pmc_comment");
            $this->db->select("pmc.dAddedDate AS pmc_added_date");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("pm.iPostId AS pm_post_id");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("pmc.iUserId AS pmc_user_id");
            $this->db->select("pmc.iParentCommentId AS pmc_parent_comment_id");
            if(isset($media_id) && $media_id != ""){ 
                $this->db->where("pmc.iPostMediaId =", $media_id);
            }
            $this->db->where_in("pmc.eStatus", array('Active'));
            
            
            
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