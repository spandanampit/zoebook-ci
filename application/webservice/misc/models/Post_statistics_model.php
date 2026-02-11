<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Statistics Model
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage models
 *
 * @module Post Statistics
 *
 * @class Post_statistics_model.php
 *
 * @path application\webservice\misc\models\Post_statistics_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 06.09.2019
 */

class Post_statistics_model extends CI_Model
{
    public $default_lang = 'EN';

    /**
     * __construct method is used to set model preferences while model object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('listing');
        $this->default_lang = $this->general->getLangRequestValue();
    }

    /**
     * get_post_statistics method is used to execute database queries for Post List API.
     * @created  | 06.09.2019
     * @modified  | 06.09.2019
     * @param string $post_ids post_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_statistics($post_ids = '')
    {
        try
        {
            $result_arr = array();

//            $this->db->from("post_statistics AS ps");
//
//            $this->db->select("ps.iPostId AS ps_post_id");
//            $this->db->select("ps.iTotalComments AS ps_total_comments");
//            $this->db->select("ps.iTotalLikes AS ps_total_likes");
//            $this->db->select("ps.iTotalShares AS ps_total_shares");
//            if ($tmp_arr = filterEmptyValues($post_ids))
//            {
//                $old_arr = $post_ids;
//                $post_ids = $tmp_arr;
//                $this->db->where_in("ps.iPostId", $post_ids);
//                $post_ids = $old_arr;
//            }
//
//            $result_obj = $this->db->get();
            
            $sql_query = "select 
	`p`.`iPostId` AS `iPostId`,
	count(`pc`.`iPostCommentId`) AS `iTotalComments`,
	count(`pl`.`iPostLikeId`) AS `iTotalLikes`,
	count(`ps`.`iPostId`) AS `iTotalShares`,
	`p`.`iSysRecDeleted`
from `post` `p` 
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' AND `p`.`iPostId` IN('".  @implode("','", $post_ids)."')
group by `p`.`iPostId`";
            
            $result_obj = $this->db->query($sql_query);
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0)
            {
                throw new Exception('No records found.');
            }
            $success = 1;
        }
        catch(Exception $e)
        {
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
