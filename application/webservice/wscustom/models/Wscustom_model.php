<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Wscustom Model
 *
 * @category webservice
 *
 * @package wscustom
 *
 * @subpackage models
 *
 * @module Wscustom
 *
 * @class Wscustom_model.php
 *
 * @path application\webservice\wscustom\models\Wscustom_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 14.04.2023
 */

class Wscustom_model extends CI_Model
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
     * get_fbid_google_id method is used to execute database queries for Login API.
     * @created CIT Dev Team
     * @modified Alpesh Patel | 26.08.2021
     * @param string $facebook_id facebook_id is used to process query block.
     * @param string $google_id google_id is used to process query block.
     * @param string $apple_id apple_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_fbid_google_id($facebook_id = '', $google_id = '', $apple_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "SELECT if('".$facebook_id."' = '','','".$facebook_id."') as fb_id, if('".$google_id."' = '','','".$google_id."') as g_id, if('".$apple_id."' = '','','".$apple_id."') as a_id LIMIT 1";
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

    /**
     * get_my_post_comment_stats method is used to execute database queries for Post List API.
     * @created  | 06.09.2019
     * @modified Nandini Santoki | 23.09.2020
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_post_comment_stats($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
order by `p`.`iPostId` DESC";
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

    /**
     * get_user_post_comment_stats method is used to execute database queries for Post List API.
     * @created  | 06.09.2019
     * @modified Nandini Santoki | 23.09.2020
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_comment_stats($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c1`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
order by `p`.`iPostId` DESC";
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

    /**
     * get_user_actual_post_statistics method is used to execute database queries for Post List API.
     * @created  | 09.09.2019
     * @modified Nandini Santoki | 03.11.2020
     * @param string $p_actual_post_id_1 p_actual_post_id_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_actual_post_statistics($p_actual_post_id_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_3`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments_3`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes_3`,
count(`ps`.`iPostId`) AS `ps_total_shares_3`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
left join `users` u on u.iUsersId = pl.iUserId and u.eStatus = 'Active'
where `p`.`iSysRecDeleted` <> '1' AND `p`.`iPostId`= '".$p_actual_post_id_1."'
group by `p`.`iPostId` LIMIT 1";
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

    /**
     * get_actual_post_statistics method is used to execute database queries for Post List API.
     * @created  | 09.09.2019
     * @modified Nandini Santoki | 03.11.2020
     * @param string $p_actual_post_id p_actual_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_actual_post_statistics($p_actual_post_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_2`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments_2`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes_2`,
count(`ps`.`iPostId`) AS `ps_total_shares_2`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
left join `users` u on u.iUsersId = pl.iUserId and u.eStatus = 'Active'
where `p`.`iSysRecDeleted` <> '1' AND `p`.`iPostId`= '".$p_actual_post_id."'
group by `p`.`iPostId` LIMIT 1";
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

    /**
     * get_user_post_like_stats method is used to execute database queries for Post List API.
     * @created  | 07.11.2019
     * @modified Nandini Santoki | 03.11.2020
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_like_stats($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l1`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
left join `users` u on u.iUsersId = pl.iUserId and u.eStatus = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_user_post_share_stats method is used to execute database queries for Post List API.
     * @created  | 07.11.2019
     * @modified Nandini Santoki | 18.09.2020
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_share_stats($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s1`,
count(`ps`.`iPostId`) AS `ps_total_shares_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_my_post_like_stats method is used to execute database queries for Post List API.
     * @created  | 07.11.2019
     * @modified Nandini Santoki | 03.11.2020
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_post_like_stats($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
left join `users` u on u.iUsersId = pl.iUserId and u.eStatus = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_my_post_share_stats method is used to execute database queries for Post List API.
     * @created  | 07.11.2019
     * @modified Nandini Santoki | 18.09.2020
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_post_share_stats($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s`,
count(`ps`.`iPostId`) AS `ps_total_shares`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_post_detail_comment_stats method is used to execute database queries for Post Detail API.
     * @created  | 09.09.2019
     * @modified  | 15.11.2019
     * @param string $p_post_id p_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_detail_comment_stats($p_post_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
where `p`.`iSysRecDeleted` <> '1' AND `p`.`iPostId`= '".$p_post_id."'
group by `p`.`iPostId` LIMIT 1";
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

    /**
     * get_post_detail_like_stats method is used to execute database queries for Post Detail API.
     * @created  | 15.11.2019
     * @modified  | 15.11.2019
     * @param string $p_post_id p_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_detail_like_stats($p_post_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
where `p`.`iSysRecDeleted` <> '1' AND `p`.`iPostId`= '".$p_post_id."'
group by `p`.`iPostId` LIMIT 1";
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

    /**
     * get_post_detail_share_stats method is used to execute database queries for Post Detail API.
     * @created  | 15.11.2019
     * @modified  | 15.11.2019
     * @param string $p_post_id p_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_detail_share_stats($p_post_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s`,
count(`ps`.`iPostId`) AS `ps_total_shares`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' AND `p`.`iPostId`= '".$p_post_id."'
group by `p`.`iPostId` LIMIT 1";
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

    /**
     * get_viral_post_comment_stats method is used to execute database queries for Viral Post List API.
     * @created  | 06.09.2019
     * @modified Nandini Santoki | 18.09.2020
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_viral_post_comment_stats($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_1`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_viral_post_like_stats method is used to execute database queries for Viral Post List API.
     * @created  | 07.11.2019
     * @modified Rohit Patidar | 28.09.2021
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_viral_post_like_stats($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_2`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_viral_post_share_stats method is used to execute database queries for Viral Post List API.
     * @created  | 07.11.2019
     * @modified Nandini Santoki | 18.09.2020
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_viral_post_share_stats($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_1`,
count(`ps`.`iPostId`) AS `ps_total_shares_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * update_post_impression_count method is used to execute database queries for Update Impression Count API.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process custom query block.
     * @return array $return_arr returns response of query block.
     */
    public function update_post_impression_count($input_params = array())
    {
        try
        {
            $result_arr = array();

            $sql_query = "UPDATE post SET iImpressionCount = (iImpressionCount + 1)
WHERE iPostId = '".$input_params["post_id"]."';";
            $res = $this->db->query($sql_query);
            if (!$res)
            {
                throw new Exception("Failure in updation.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows";
            $result_arr[0][$result_param] = $affected_rows;
            $success = 1;
        }
        catch(Exception $e)
        {
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
     * get_post_comment_status method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_comment_status($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
order by `p`.`iPostId` DESC";
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

    /**
     * get_post_like_status method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param string $post_media_cond post_media_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_like_status($post_media_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l`,
count(`pl`.`iPostMediaId`) AS `ps_total_likes`,`pl`.`iPostMediaId`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_media` `pm` on `pm`.`iPostId` = `p`.`iPostId`
left join `post_media_likes` `pl` on `pl`.`iPostMediaId` = `pm`.`iPostMediaId`
where `p`.`iSysRecDeleted` <> '1' ".$post_media_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_post_share_status method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_share_status($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s`,
count(`ps`.`iPostId`) AS `ps_total_shares`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_randome_post_comment method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 14.06.2021
     * @modified Rohit Patidar | 14.06.2021
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_randome_post_comment($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
order by `p`.`iPostId` DESC";
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

    /**
     * get_randome_post_like method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 14.06.2021
     * @modified Rohit Patidar | 14.06.2021
     * @param string $post_media_cond_1 post_media_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_randome_post_like($post_media_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l`,
count(`pl`.`iPostMediaId`) AS `ps_total_likes`,`pl`.`iPostMediaId`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_media` `pm` on `pm`.`iPostId` = `p`.`iPostId`
left join `post_media_likes` `pl` on `pl`.`iPostMediaId` = `pm`.`iPostMediaId`
where `p`.`iSysRecDeleted` <> '1' ".$post_media_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_randome_post_share method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 14.06.2021
     * @modified Rohit Patidar | 14.06.2021
     * @param string $post_stats_cond_1 post_stats_cond_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_randome_post_share($post_stats_cond_1 = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s`,
count(`ps`.`iPostId`) AS `ps_total_shares`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond_1."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_movement_post_like_status method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param string $post_media_cond post_media_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_post_like_status($post_media_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l_3`,
count(`pl`.`iPostMediaId`) AS `ps_total_likes_3`,`pl`.`iPostMediaId`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_media` `pm` on `pm`.`iPostId` = `p`.`iPostId`
left join `post_media_likes` `pl` on `pl`.`iPostMediaId` = `pm`.`iPostMediaId`
where `p`.`iSysRecDeleted` <> '1' ".$post_media_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_movement_post_comment method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param string $post_movement_cond post_movement_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_post_comment($post_movement_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c_3`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments_3`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_movement_cond."
group by `p`.`iPostId`
order by `p`.`iPostId` DESC";
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

    /**
     * get_movement_post_share_status method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param string $post_movement_cond post_movement_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_post_share_status($post_movement_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s_3`,
count(`ps`.`iPostId`) AS `ps_total_shares_3`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_movement_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_user_post_comment_stats1 method is used to execute database queries for Hide post list API.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_comment_stats1($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_c`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
order by `p`.`iPostId` DESC";
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

    /**
     * get_user_post_like_stats1 method is used to execute database queries for Hide post list API.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_like_stats1($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_l`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
left join `users` u on u.iUsersId = pl.iUserId and u.eStatus = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_user_post_share_stats1 method is used to execute database queries for Hide post list API.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_share_stats1($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_s`,
count(`ps`.`iPostId`) AS `ps_total_shares`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * movements method is used to execute database queries for Movements follower API.
     * @created Rohit Patidar | 23.09.2021
     * @modified Rohit Patidar | 28.09.2021
     * @param string $movements_id movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function movements($movements_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "SELECT count(mu.iMovementUsersId) as total_members FROM movement_users mu WHERE mu.iMovementId = ".$movements_id." AND mu.eStatus = 'Active' LIMIT 1";
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

    /**
     * get_movement_post_count method is used to execute database queries for Movements post list API.
     * @created Rohit Patidar | 28.09.2021
     * @modified Rohit Patidar | 28.09.2021
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_post_count($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_1`,
count(`pc`.`iPostCommentId`) AS `ps_total_comments_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_comment` `pc` on `pc`.`iPostId` = `p`.`iPostId` and `pc`.`iParentId` = 0 and `pc`.`eStatus` = 'Active' and `pc`.`iPostMediaId` <= 0
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_movements_post_like method is used to execute database queries for Movements post list API.
     * @created Rohit Patidar | 28.09.2021
     * @modified Rohit Patidar | 28.09.2021
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movements_post_like($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_2`,
count(`pl`.`iPostLikeId`) AS `ps_total_likes_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post_like` `pl` on `pl`.`iPostId` = `p`.`iPostId`
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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

    /**
     * get_movement_post_share_count method is used to execute database queries for Movements post list API.
     * @created Rohit Patidar | 28.09.2021
     * @modified Rohit Patidar | 28.09.2021
     * @param string $post_stats_cond post_stats_cond is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_post_share_count($post_stats_cond = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "select
`p`.`iPostId` AS `ps_post_id_1`,
count(`ps`.`iPostId`) AS `ps_total_shares_1`,
`p`.`iSysRecDeleted`
from `post` `p`
left join `post` `ps` on `ps`.`iActualPostId` = `p`.`iPostId` and `ps`.`eStatus` = 'Active'
where `p`.`iSysRecDeleted` <> '1' ".$post_stats_cond."
group by `p`.`iPostId`
ORDER BY `p`.`iPostId` DESC";
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
