<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post
 *
 * @class Post_model.php
 *
 * @path application\webservice\post\models\Post_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 18.04.2023
 */

class Post_model extends CI_Model
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
     * get_post_count method is used to execute database queries for Search Friends API.
     * @created  | 11.10.2019
     * @modified  | 11.10.2019
     * @param string $search_ids search_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_count($search_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(count(p.iPostId)) AS post_id", FALSE);
            if ($tmp_arr = filterEmptyValues($search_ids)) {
                $old_arr = $search_ids;
                $search_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $search_ids);
                $search_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * fetch_post_count_v1 method is used to execute database queries for My Following Requests API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $user_ids user_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function fetch_post_count_v1($user_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("(count(iPostId)) AS user_post_count", FALSE);
            $this->db->select("p.iUserId AS p_user_id");
            if ($tmp_arr = filterEmptyValues($user_ids)) {
                $old_arr = $user_ids;
                $user_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $user_ids);
                $user_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * fetch_post_count method is used to execute database queries for My Follower Requests API.
     * @created  | 14.10.2019
     * @modified  | 14.10.2019
     * @param string $user_ids user_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function fetch_post_count($user_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("(count(iPostId)) AS user_post_count", FALSE);
            $this->db->select("p.iUserId AS p_user_id");
            if ($tmp_arr = filterEmptyValues($user_ids)) {
                $old_arr = $user_ids;
                $user_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $user_ids);
                $user_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_post_count_v2 method is used to execute database queries for User Following API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $search_ids search_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_count_v2($search_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(count(p.iPostId)) AS post_id", FALSE);
            if ($tmp_arr = filterEmptyValues($search_ids)) {
                $old_arr = $search_ids;
                $search_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $search_ids);
                $search_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_post_count_v1 method is used to execute database queries for User Followers API.
     * @created CIT Dev Team
     * @modified  | 14.10.2019
     * @param string $search_ids search_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_count_v1($search_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(count(p.iPostId)) AS post_id", FALSE);
            if ($tmp_arr = filterEmptyValues($search_ids)) {
                $old_arr = $search_ids;
                $search_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $search_ids);
                $search_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * insert_post method is used to execute database queries for Add Post API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Rohit Patidar | 26.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_post($params_arr = array())
    {
        try {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0) {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["user_id"])) {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["post_type"])) {
                $this->db->set("ePostType", $params_arr["post_type"]);
            }
            if (isset($params_arr["post_text"])) {
                $this->db->set("tPostText", $params_arr["post_text"]);
            }
            if (isset($params_arr["visibility"])) {
                $this->db->set("eVisibility", $params_arr["visibility"]);
            }
            $this->db->set("eDraft", $params_arr["_edraft"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["post_text_emoji"])) {
                $this->db->set("tPostTextEmoji", $params_arr["post_text_emoji"]);
            }
            if (isset($params_arr["movements_id"])) {
                $this->db->set("iMovementsId", $params_arr["movements_id"]);
            }
            $this->db->insert("post");
            $insert_id = $this->db->insert_id();
            if (!$insert_id) {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id_12";
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
     * getviralpostcount method is used to execute database queries for Add Post API.
     * @created Alpesh Patel | 16.09.2021
     * @modified Alpesh Patel | 17.09.2021
     * @param string $VIRAL_POST_LIMIT VIRAL_POST_LIMIT is used to process query block.
     * @param string $VIRAL_POST_TIME_LIMIT VIRAL_POST_TIME_LIMIT is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function getviralpostcount($VIRAL_POST_LIMIT = '', $VIRAL_POST_TIME_LIMIT = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("count(p.iPostId) AS count_post");
            $this->db->select("(" . $this->db->escape("" . $VIRAL_POST_LIMIT . "") . ") AS max_limit", FALSE);
            $this->db->select("(TIMESTAMPDIFF(MINUTE,DATE_SUB(NOW(),INTERVAL '" . $VIRAL_POST_TIME_LIMIT . "' HOUR),min(p.dAddedDate))) AS difference_time", FALSE);
            $this->db->select("min(p.dAddedDate) AS p_added_date");
            if (isset($user_id) && $user_id != "") {
                $this->db->where("p.iUserId =", $user_id);
            }
            $this->db->where_in("p.eVisibility", array('Viral'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where("p.dAddedDate > DATE_SUB(NOW(),INTERVAL '" . $VIRAL_POST_TIME_LIMIT . "' HOUR)", FALSE, FALSE);

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_post method is used to execute database queries for Add Post Media API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 21.12.2022
     * @param string $file_type file_type is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post($file_type = '', $post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.eStatus AS p_status");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("p.iMovementsId AS p_movements_id");
            $this->db->select("(if('" . $file_type . "'=\"Image\",'post_media','compress_post_video')) AS folder_path", FALSE);
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            if (isset($user_id) && $user_id != "") {
                $this->db->where("p.iUserId =", $user_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
                throw new Exception('No records found.');
            }
            $success = 1;
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }

        $this->db->_reset_all();
        
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["data"] = $result_arr;
        return $return_arr;
    }

    /**
     * update_post_status method is used to execute database queries for Add Post Media API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 28.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_status($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
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
     * get_my_posts_web method is used to execute database queries for Post List API For Website.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 22.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_posts_web($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType IN('LiveNow' ,'Live')";
            $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active', 'InProgress'));
            $this->db->where_not_in("p.eVisibility", array('Movement'));
            $this->db->where("p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' )
AND (p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' )) AND
IF('" . $params_arr["is_feed"] . "' = '1', ( (p.iUserId = '" . $params_arr["user_id"] . "'  OR  p.iUserId IN( SELECT iUserId  FROM user_followers WHERE iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus = 'Accepted' )) AND p.eVisibility = 'Public'  ),  p.iUserId = '" . $params_arr["user_id"] . "')
AND p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' )", FALSE, FALSE);

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.dAddedDate AS p_added_date");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "') AS is_like", FALSE);
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("p.eStatus AS p_status");
            $this->db->select("p.iActualPostId AS p_actual_post_id");
            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date", FALSE);
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("p.iImpressionCount AS p_impression_count");
            $this->db->select("(SELECT count(iPostImpressionId) FROM post_impression pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "') AS is_impressed", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count", FALSE);
            $this->db->select("p.tPostMetaData AS p_post_meta_data_1");
            $this->db->select("p.vVideoThumbnail AS p_video_thumbnail");
            $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
            $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS post_detail_url", FALSE);
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("ts.vArchiveId AS ts_archive_id");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status");
            $this->db->select("ts.vURL AS live_video_url");

            $settings_params['count'] = $total_records;

            $record_limit = 5;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            $this->db->order_by("p.iPostId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_my_posts method is used to execute database queries for Post List API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 22.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_posts($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType IN('LiveNow' ,'Live')";
            $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active', 'InProgress'));
            $this->db->where_not_in("p.eVisibility", array('Movement'));
            $this->db->where("p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' )
            AND (p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' )) AND
            IF('" . $params_arr["is_feed"] . "' = '1', ( (p.iUserId = '" . $params_arr["user_id"] . "'  OR  p.iUserId IN( SELECT iUserId  FROM user_followers WHERE iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus = 'Accepted' )) AND p.eVisibility = 'Public'  ),  p.iUserId = '" . $params_arr["user_id"] . "')
            AND p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' )", FALSE, FALSE);

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.dAddedDate AS p_added_date");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "') AS is_like", FALSE);
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("p.eStatus AS p_status");
            $this->db->select("p.iActualPostId AS p_actual_post_id");
            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date", FALSE);
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("p.iImpressionCount AS p_impression_count");
            $this->db->select("(SELECT count(iPostImpressionId) FROM post_impression pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "') AS is_impressed", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count", FALSE);
            $this->db->select("p.tPostMetaData AS p_post_meta_data_1");
            $this->db->select("p.vVideoThumbnail AS p_video_thumbnail");
            $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
            $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS post_detail_url", FALSE);
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("ts.vArchiveId AS ts_archive_id");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status");
            $this->db->select("ts.vURL AS live_video_url");

            $settings_params['count'] = $total_records;

            $record_limit = 20;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            $this->db->order_by("p.iPostId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_user_posts method is used to execute database queries for Post List API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 22.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_posts($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType = 'LiveNow'";
            $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active', 'InProgress'));
            $this->db->where_in("p.eVisibility", array('Public'));
            if ($tmp_arr = filterEmptyValues($params_arr["p_post_type"])) {
                $old_arr = $params_arr["p_post_type"];
                $params_arr["p_post_type"] = $tmp_arr;
                $this->db->where_in("p.ePostType", $params_arr["p_post_type"]);
                $params_arr["p_post_type"] = $old_arr;
            }
            $this->db->where("p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' )
AND (p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' )) AND IF('" . $params_arr["is_feed"] . "' = '1', ( (p.iUserId = '" . $params_arr["profile_user_id"] . "'  OR  p.iUserId IN( SELECT iUserId  FROM user_followers WHERE iFollowerId = '" . $params_arr["profile_user_id"] . "' AND eStatus = 'Accepted' )) AND p.eVisibility = 'Public'  ),  p.iUserId = '" . $params_arr["profile_user_id"] . "' AND p.ePostType != 'LiveNow')", FALSE, FALSE);

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("p.iPostId AS p_post_id_1");
            $this->db->select("p.iUserId AS p_user_id_1");
            $this->db->select("p.ePostType AS p_post_type_1");
            $this->db->select("p.tPostText AS p_post_text_1");
            $this->db->select("p.dAddedDate AS p_added_date_1");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "') AS is_like_1", FALSE);
            $this->db->select("u.vName AS user_name");
            $this->db->select("u.vProfileImage AS user_profile_image");
            $this->db->select("p.eStatus AS p_status_1");
            $this->db->select("p.iActualPostId AS p_actual_post_id_1");
            $this->db->select("p.eVisibility AS p_visibility_1");
            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id_1");
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_1", FALSE);
            $this->db->select("p.tPostMetaData AS p_post_meta_data");
            $this->db->select("p.vVideoThumbnail AS p_video_thumbnail_1");
            $this->db->select("p.tPostTextEmoji AS p_post_text_emoji_1");
            $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS custom_field_6", FALSE);
            $this->db->select("p.iImpressionCount AS p_impression_count_1");
            $this->db->select("ts.vArchiveId AS ts_archive_id_1");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status_1");

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            $this->db->order_by("p.iPostId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_actual_post method is used to execute database queries for Post List API.
     * @created Anjaneyulu Gulla | 25.10.2018
     * @modified Jay Rajput | 22.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $p_actual_post_id p_actual_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_actual_post($user_id = '', $p_actual_post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id_2");
            $this->db->select("p.iUserId AS p_user_id_2");
            $this->db->select("p.ePostType AS p_post_type_2");
            $this->db->select("p.tPostText AS p_post_text_2");
            $this->db->select("p.dAddedDate AS p_added_date_2");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $user_id . "') AS is_like_2", FALSE);
            $this->db->select("u.vName AS u_name_2");
            $this->db->select("u.vProfileImage AS u_profile_image_2");
            $this->db->select("p.eStatus AS p_status_2");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date_2", FALSE);
            $this->db->select("p.iImpressionCount AS p_impression_count_2");
            $this->db->select("(" . $this->db->escape("1") . ") AS is_impressed_2", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_2", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_2", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_2", FALSE);
            $this->db->select("p.tPostMetaData AS p_post_meta_data_3");
            $this->db->select("p.vVideoThumbnail AS p_video_thumbnail_3");
            if (isset($p_actual_post_id) && $p_actual_post_id != "") {
                $this->db->where("p.iPostId =", $p_actual_post_id);
            }
            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_user_actual_post method is used to execute database queries for Post List API.
     * @created Anjaneyulu Gulla | 26.10.2018
     * @modified Jay Rajput | 22.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $p_actual_post_id_1 p_actual_post_id_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_actual_post($user_id = '', $p_actual_post_id_1 = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id_3");
            $this->db->select("p.iUserId AS p_user_id_3");
            $this->db->select("p.ePostType AS p_post_type_3");
            $this->db->select("p.tPostText AS p_post_text_3");
            $this->db->select("p.dAddedDate AS p_added_date_3");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $user_id . "') AS is_like_3", FALSE);
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("p.eStatus AS p_status_3");
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_3", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_3", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_3", FALSE);
            $this->db->select("p.tPostMetaData AS p_post_meta_data_2");
            $this->db->select("p.vVideoThumbnail AS p_video_thumbnail_2");
            if (isset($p_actual_post_id_1) && $p_actual_post_id_1 != "") {
                $this->db->where("p.iPostId =", $p_actual_post_id_1);
            }
            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_posted_user_details method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_posted_user_details($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("u.iUsersId AS posted_users_id");
            $this->db->select("u.vDeviceToken AS posted_device_token");
            $this->db->select("u.eNotificationPref AS posted_notification_pref");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * check_post_exist_for_like method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 22.10.2018
     * @modified Jay Rajput | 25.07.2022
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_exist_for_like($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS posted_user_id");
            $this->db->select("p.iMovementsId AS p_movements_id");
            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where("p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * update_post_date method is used to execute database queries for Like Post API.
     * @created Rohit Patidar | 14.10.2021
     * @modified Rohit Patidar | 14.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_date($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows1";
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
     * get_post_details method is used to execute database queries for Post Detail API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 17.11.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_details($user_id = '', $post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.tPostTextEmoji AS p_post_text");
            $this->db->select("p.dAddedDate AS p_added_date");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $user_id . "') AS is_like", FALSE);
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("(" . $this->db->escape("post_media_id") . ") AS post_media_id", FALSE);
            $this->db->select("p.iImpressionCount AS p_impression_count");
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count", FALSE);
            $this->db->select("u.vLatitude AS u_latitude");
            $this->db->select("u.vLongtitude AS u_longtitude");
            $this->db->select("p.tPostMetaData AS p_post_meta_data");
            $this->db->select("(" . $this->db->escape("1") . ") AS p_is_impressed", FALSE);
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS p_expire_date", FALSE);
            $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
            $this->db->select("(p.iPostId) AS share_postdetail_url", FALSE);
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active', 'Inprogress'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * check_post_exists method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 25.10.2021
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_exists($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("u.iUsersId AS posted_by_user_id");
            $this->db->select("u.eDeviceType AS device_type");
            $this->db->select("u.vDeviceToken AS device_token");
            $this->db->select("u.eNotificationPref AS user_notification_pref");
            $this->db->select("u.vName AS posted_by_user_name");
            $this->db->select("p.iMovementsId AS p_movements_id");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where(" p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * update_movement_post_date method is used to execute database queries for Comment On Post API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_movement_post_date($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows1";
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
     * update_date_movement_post method is used to execute database queries for Comment On Post API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_date_movement_post($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows2";
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
     * check_replied_post_exists method is used to execute database queries for Reply on comment API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 25.07.2022
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_replied_post_exists($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("u.iUsersId AS posted_by_user_id");
            $this->db->select("u.eDeviceType AS posted_device_type");
            $this->db->select("u.vDeviceToken AS posted_device_token");
            $this->db->select("u.eNotificationPref AS posted_notification_pref");
            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where(" p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * update_modifydate_movement_post method is used to execute database queries for Reply on comment API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_modifydate_movement_post($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
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
     * check_post_exist method is used to execute database queries for Comments List API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_exist($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("p.eStatus AS p_status");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * check_commented_post_exists method is used to execute database queries for Replies List API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_commented_post_exists($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("p.eStatus AS p_status");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * insert_live_session_post method is used to execute database queries for Start Live Stream API.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 10.06.2020
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_live_session_post($params_arr = array())
    {
        try {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0) {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["user_id"])) {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set("ePostType", $params_arr["_eposttype"]);
            if (isset($params_arr["post_text"])) {
                $this->db->set("tPostText", $params_arr["post_text"]);
            }
            $this->db->set("eVisibility", $params_arr["_evisibility"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["video_thumbnail"]) && !empty($params_arr["video_thumbnail"])) {
                $this->db->set("vVideoThumbnail", $params_arr["video_thumbnail"]);
            }
            $this->db->insert("post");
            $insert_id = $this->db->insert_id();
            if (!$insert_id) {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "post_id";
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
     * get_media_posts method is used to execute database queries for User Albums API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 10.01.2019
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_media_posts($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where_in("p.ePostType", array('Live', 'Media'));
            if (isset($user_id) && $user_id != "") {
                $this->db->where("p.iUserId =", $user_id);
            }

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("(SELECT count(iPostMediaId) FROM post_media pm WHERE pm.iPostId = p.iPostId) AS media_count", FALSE);
            $this->db->select("p.eStatus AS p_status");

            $settings_params['count'] = $total_records;

            $record_limit = 100;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            $this->db->order_by("p.iPostId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_users_post method is used to execute database queries for User Albums API.
     * @created Rohit Patidar | 10.06.2021
     * @modified Alpesh Patel | 20.07.2021
     * @param string $profile_user_id profile_user_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_users_post($profile_user_id = '', $user_id = '', $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where_in("p.ePostType", array('Live', 'Media'));
            if (isset($profile_user_id) && $profile_user_id != "") {
                $this->db->where("p.iUserId =", $profile_user_id);
            }
            $this->db->where_in("p.eVisibility", array('Public', 'Viral'));
            $this->db->where("p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $profile_user_id . "' AND eReportOn = 'Post' )
AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $profile_user_id . "' AND eStatus = 'block') AND " . $profile_user_id . " NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block') ", FALSE, FALSE);

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("p.iPostId AS p_post_id_1");
            $this->db->select("p.iUserId AS p_user_id_1");
            $this->db->select("p.ePostType AS p_post_type_1");
            $this->db->select("(SELECT count(iPostMediaId) FROM post_media pm WHERE pm.iPostId = p.iPostId) AS media_count_1", FALSE);
            $this->db->select("p.eStatus AS p_status_1");

            $settings_params['count'] = $total_records;

            $record_limit = 100;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * is_post_exists method is used to execute database queries for Edit Post API.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function is_post_exists($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            if (isset($user_id) && $user_id != "") {
                $this->db->where("p.iUserId =", $user_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * update_post method is used to execute database queries for Edit Post API.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Nandini Santoki | 17.09.2020
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "") {
                $this->db->where("iUserId =", $where_arr["user_id"]);
            }
            if (isset($params_arr["post_type"])) {
                $this->db->set("ePostType", $params_arr["post_type"]);
            }
            if (isset($params_arr["post_text"])) {
                $this->db->set("tPostText", $params_arr["post_text"]);
            }
            if (isset($params_arr["visibility"])) {
                $this->db->set("eVisibility", $params_arr["visibility"]);
            }
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("tPostTextEmoji", $params_arr["_tposttextemoji"]);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
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
     * is_post_exist method is used to execute database queries for Delete Post API.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 15.10.2021
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function is_post_exist($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(SELECT GROUP_CONCAT(iPostMediaId) FROM post_media WHERE iPostId = p.iPostId) AS post_media_id_str", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT (count(iPostId)-1) FROM post WHERE iUserId =  u.iUsersId AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("m.iUserId AS m_user_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * delete_post method is used to execute database queries for Delete Post API.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 22.10.2021
     * @param string $post_id post_id is used to process query block.
     * @param string $p_user_id p_user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_post($post_id = '', $p_user_id = '')
    {
        try {
            $result_arr = array();
            if (isset($post_id) && $post_id != "") {
                $this->db->where("iPostId =", $post_id);
            }
            if (isset($p_user_id) && $p_user_id != "") {
                $this->db->where("iUserId =", $p_user_id);
            }
            $res = $this->db->delete("post");
            if (!$res) {
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
     * check_shares method is used to execute database queries for Delete Post API.
     * @created Vamsi Ippe | 04.01.2019
     * @modified Vamsi Ippe | 04.01.2019
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_shares($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS share_post_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iActualPostId =", $post_id);
            }

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * delete_shared_post method is used to execute database queries for Delete Post API.
     * @created Vamsi Ippe | 04.01.2019
     * @modified Vamsi Ippe | 04.01.2019
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_shared_post($post_id = '')
    {
        try {
            $result_arr = array();
            if (isset($post_id) && $post_id != "") {
                $this->db->where("iActualPostId =", $post_id);
            }
            $res = $this->db->delete("post");
            if (!$res) {
                throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows4";
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
     * post_movement_data method is used to execute database queries for Delete Media API.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 22.10.2021
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function post_movement_data($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("m.iUserId AS m_user_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * make_post_inactive method is used to execute database queries for End Live Stream API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 10.04.2020
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function make_post_inactive($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["ts_post_id"]) && $where_arr["ts_post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["ts_post_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows_11";
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
     * update_post_inactive method is used to execute database queries for Share Live Video Post API.
     * @created Vamsi Ippe | 10.01.2019
     * @modified Alpesh Patel | 08.07.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_inactive($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["ts_post_id"]) && $where_arr["ts_post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["ts_post_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set("ePostType", $params_arr["_eposttype"]);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
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
     * insert_share_post method is used to execute database queries for Share Post API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 08.09.2022
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_share_post($params_arr = array())
    {
        try {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0) {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["post_id"])) {
                $this->db->set("iActualPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["user_id"])) {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set("ePostType", $params_arr["_eposttype"]);
            if (isset($params_arr["share_text"])) {
                $this->db->set("tPostText", $params_arr["share_text"]);
            }
            $this->db->set("eDraft", $params_arr["_edraft"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["visibility"])) {
                $this->db->set("eVisibility", $params_arr["visibility"]);
            }
            if (isset($params_arr["share_text"])) {
                $this->db->set("tPostTextEmoji", $params_arr["share_text"]);
            }
            $this->db->insert("post");
            $insert_id = $this->db->insert_id();
            if (!$insert_id) {
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
     * getpost method is used to execute database queries for Share Post API.
     * @created Rohit Patidar | 31.08.2021
     * @modified Jay Rajput | 08.09.2022
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function getpost($post_id = '', $user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.iMovementsId AS m_movements_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where("p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * update_post_modified_date method is used to execute database queries for Like Post Media API.
     * @created Rohit Patidar | 14.10.2021
     * @modified Rohit Patidar | 14.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_modified_date($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["pm_post_id"]) && $where_arr["pm_post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["pm_post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows1";
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
     * update_post_date_media_block method is used to execute database queries for Like Post Media API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_date_media_block($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["pm_post_id"]) && $where_arr["pm_post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["pm_post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("tPostMetaData"), $params_arr["_tpostmetadata"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows2";
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
     * get_post_detail_with_movement method is used to execute database queries for Like Post Media API.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param string $pm_post_id pm_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_detail_with_movement($pm_post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iMovementsId") . " = " . $this->db->protect("m.iMovementsId") . "  AND " . $this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("p.iPostId AS p_post_id_1");
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            if (isset($pm_post_id) && $pm_post_id != "") {
                $this->db->where("p.iPostId =", $pm_post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * update_post_modifydate method is used to execute database queries for Comment Post Media API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_modifydate($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            $this->db->where("iMovementsId <>", "0");

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
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
     * check_post_exists_to_delete method is used to execute database queries for Delete Comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_exists_to_delete($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_viral_posts method is used to execute database queries for Viral Post List API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 17.11.2022
     * @param string $latitude latitude is used to process query block.
     * @param string $longitude longitude is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */


     /// this one function is used for get viral post list
      public function get_viral_posts($latitude = '', $longitude = '', $user_id = '', $page_index = 1, &$settings_params = array())
      {
            try {
                  $result_arr = array();

                  $this->db->start_cache();
                  $this->db->from("post AS p");
                  $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
                  $this->db->join("users AS u", $join_condition, "left", FALSE);
                  $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType = 'LiveNow'";
                  $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);

                  $this->db->where_in("p.eDraft", array('No'));
                  $this->db->where_in("p.eStatus", array('Active'));
                  $this->db->where_in("p.eVisibility", array('Viral'));
                  $this->db->where(" p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $user_id . "' AND eReportOn = 'Post' )
      AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

                  $this->db->stop_cache();
                  $total_records = $this->db->count_all_results();

                  $this->db->select("p.iPostId AS p_post_id_1");
                  $this->db->select("p.iUserId AS p_user_id_1");
                  $this->db->select("p.ePostType AS p_post_type_1");
                  $this->db->select("p.tPostText AS p_post_text_1");
                  $this->db->select("p.dAddedDate AS p_added_date_1");
                  $this->db->select("u.vName AS user_name");
                  $this->db->select("u.vProfileImage AS user_profile_image");
                  $this->db->select("p.eStatus AS p_status_1");
                  $this->db->select("p.iActualPostId AS p_actual_post_id_1");
                  $this->db->select("p.eVisibility AS p_visibility_1");
                  $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id_1");
                  $this->db->select("p.iImpressionCount AS p_impression_count");
                  $this->db->select("p.*, DATE_ADD(p.dAddedDate, INTERVAL 48 HOUR) AS expire_date");
                  $this->db->where("DATE_ADD(p.dAddedDate, INTERVAL 48 HOUR) >= NOW()");
                  $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_1", FALSE);
                  $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_1", FALSE);
                  $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_1", FALSE);
                  $this->db->select("p.tPostMetaData AS p_post_meta_data");
                  $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
                  $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS custom_field_8", FALSE);
                  $this->db->select("(ROUND(GeoDistMiles(u.vLatitude,u.vLongtitude,'" . $latitude . "','" . $longitude . "','km'),2)) AS distance_kms", FALSE);
                  $this->db->select("(select count(pl.iPostLikeId) from post_like as pl where pl.iUserId='" . $user_id . "') AS is_like_1");
                  $this->db->select("IF((select count('*') from post_impression as pi where pi.iPostId=p.iPostId and pi.iUserId='" . $user_id . "')>0,'1',0) AS is_impressed");

                  $settings_params['count'] = $total_records;

                  $record_limit = 100;
                  $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
                  $total_pages = getTotalPages($total_records, $record_limit);
                  $start_index = getStartIndex($total_records, $current_page, $record_limit);
                  $settings_params['per_page'] = $record_limit;
                  $settings_params['curr_page'] = $current_page;
                  $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
                  $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

                  $this->db->order_by("ISNULL(distance_kms) ASC,distance_kms ASC, p.iPostId DESC", FALSE, FALSE);
                  $this->db->limit($record_limit, $start_index);
                  $result_obj = $this->db->get();
                  $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
                  $this->db->flush_cache();
                  if (!is_array($result_arr) || count($result_arr) == 0) {
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
       * This method is used for collect posts for web view
       */
      public function get_web_viral_posts($latitude = '', $longitude = '', $user_id = '', $page_index = 1, &$settings_params = array())
      {
            try {
                  $result_arr = array();

                  $this->db->start_cache();
                  $this->db->from("post AS p");
                  $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
                  $this->db->join("users AS u", $join_condition, "left", FALSE);
                  $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType = 'LiveNow'";
                  $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);

                  $this->db->where_in("p.eDraft", array('No'));
                  $this->db->where_in("p.eStatus", array('Active'));
                  $this->db->where_in("p.eVisibility", array('Viral'));
                  $this->db->where(" p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $user_id . "' AND eReportOn = 'Post' )
                  AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

                  $this->db->stop_cache();
                  $total_records = $this->db->count_all_results();

                  $this->db->select("p.iPostId AS p_post_id_1");
                  $this->db->select("p.iUserId AS p_user_id_1");
                  $this->db->select("p.ePostType AS p_post_type_1");
                  $this->db->select("p.tPostText AS p_post_text_1");
                  $this->db->select("p.dAddedDate AS p_added_date_1");
                  $this->db->select("u.vName AS user_name");
                  $this->db->select("u.vProfileImage AS user_profile_image");
                  $this->db->select("p.eStatus AS p_status_1");
                  $this->db->select("p.iActualPostId AS p_actual_post_id_1");
                  $this->db->select("p.eVisibility AS p_visibility_1");
                  $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id_1");
                  $this->db->select("p.iImpressionCount AS p_impression_count");
                  $this->db->select("p.*, DATE_ADD(p.dAddedDate, INTERVAL 48 HOUR) AS expire_date");
                  $this->db->where("DATE_ADD(p.dAddedDate, INTERVAL 48 HOUR) >= NOW()");
                  $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_1", FALSE);
                  $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_1", FALSE);
                  $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_1", FALSE);
                  $this->db->select("p.tPostMetaData AS p_post_meta_data");
                  $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
                  $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS custom_field_8", FALSE);
                  $this->db->select("(ROUND(GeoDistMiles(u.vLatitude,u.vLongtitude,'" . $latitude . "','" . $longitude . "','km'),2)) AS distance_kms", FALSE);
                  $this->db->select("(select count(pl.iPostLikeId) from post_like as pl where pl.iUserId='" . $user_id . "') AS is_like_1");
                  $this->db->select("IF((select count('*') from post_impression as pi where pi.iPostId=p.iPostId and pi.iUserId='" . $user_id . "')>0,'1',0) AS is_impressed");

                  $settings_params['count'] = $total_records;

                  $record_limit = 10;
                  $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
                  $total_pages = getTotalPages($total_records, $record_limit);
                  $start_index = getStartIndex($total_records, $current_page, $record_limit);
                  $settings_params['per_page'] = $record_limit;
                  $settings_params['curr_page'] = $current_page;
                  $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
                  $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

                  $this->db->order_by("ISNULL(distance_kms) ASC,distance_kms ASC, p.iPostId DESC", FALSE, FALSE);
                  $this->db->limit($record_limit, $start_index);
                  $result_obj = $this->db->get();
                  $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
                  $this->db->flush_cache();
                  if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * check_post_viral method is used to execute database queries for Update Impression Count API.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 09.05.2019
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_viral($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(p.iImpressionCount+1) AS p_impression_count");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_other_post_user method is used to execute database queries for Other Post API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 23.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_other_post_user($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType = 'LiveNow'";
            $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);
            $this->db->join("post_media AS um", "p.iPostId = um.iPostId", "left");

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where("p.iPostId <> (" . $params_arr["post_id"] . ")", FALSE, FALSE);
            $this->db->where_in("p.ePostType", array('Image', 'Video', 'Media'));
            $this->db->where("IF('" . $params_arr["is_feed"] . "' = '1', ( (p.iUserId = '" . $params_arr["user_id"] . "'  OR  p.iUserId IN( SELECT iUserId  FROM user_followers WHERE iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus = 'Accepted' )) AND p.eVisibility = 'Public'  ),  p.iUserId = '" . $params_arr["user_id"] . "')
AND p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' ) AND  p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post' )
AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' )", FALSE, FALSE);
            $this->db->order_by("p.dAddedDate", "DESC");

            $this->db->group_by(array("p.iPostId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(p.iPostId) AS iPostId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;


            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("p.dAddedDate AS p_added_date");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "' limit 1) AS is_like", FALSE);
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("p.eStatus AS p_status");
            $this->db->select("p.iActualPostId AS p_actual_post_id");
            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date", FALSE);
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("p.iImpressionCount AS p_impression_count");
            $this->db->select("(" . $this->db->escape("1") . ") AS is_impressed", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count", FALSE);
            $this->db->select("um.vUploadFile AS um_upload_file");
            $this->db->select("um.eMediaType AS um_media_type");
            $this->db->select("um.iPostMediaId AS post_media_id");
            $this->db->select("(SELECT count(pmv.iPostMediaViewId) FROM post_media_view pmv WHERE pmv.iPostMediaId = um.iPostMediaId AND pmv.iUserId = '" . $params_arr["user_id"] . "' limit 1) AS is_viewed", FALSE);
            $this->db->select("um.iViewsCount AS views_count");
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ( 'Accepted','Pending') limit 1) AS is_following_1", FALSE);
            $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS share_postdetail_url_1", FALSE);
            $this->db->select("um.vVideoThumbnail AS um_video_thumbnail");
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ('Pending') ORDER BY 1 DESC LIMIT 1) AS pending_request_id_1", FALSE);
            $this->db->select("um.vMHeight AS um_mheight_1");
            $this->db->select("um.vMWidth AS um_mwidth_1");

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            // $this->db->order_by("p.iPostId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_random_post method is used to execute database queries for Other Post API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 14.04.2023
     * @param array $params_arr params_arr array to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_random_post($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType = 'LiveNow'";
            $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);
            $this->db->join("post_media AS um", "p.iPostId = um.iPostId", "left");

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where("p.iPostId <> (" . $params_arr["post_id"] . ")", FALSE, FALSE);
            $this->db->where_in("p.ePostType", array('Image', 'Video', 'Media'));
            $this->db->where("p.iUserId != '" . $params_arr["user_id"] . "'
            AND p.eVisibility = 'Public'
            AND p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post')
            AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' )", FALSE, FALSE);

            //get videos
            $this->db->where("um.eMediaType", "Video");
            $this->db->order_by("p.dAddedDate", "DESC");

            $this->db->group_by(array("p.iPostId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(p.iPostId) AS iPostId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("p.iPostId AS p_post_id_1");
            $this->db->select("p.iUserId AS p_user_id_1");
            $this->db->select("p.ePostType AS p_post_type_1");
            $this->db->select("p.tPostText AS p_post_text_1");
            $this->db->select("p.dAddedDate AS p_added_date_1");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "' LIMIT 1) AS is_like_1", FALSE);
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("p.eStatus AS p_status_1");
            $this->db->select("p.iActualPostId AS p_actual_post_id_1");
            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id_1");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date_1", FALSE);
            $this->db->select("p.eVisibility AS p_visibility_1");
            $this->db->select("p.iImpressionCount AS p_impression_count_1");
            $this->db->select("(" . $this->db->escape("1") . ") AS is_impressed_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_1", FALSE);
            $this->db->select("um.vUploadFile AS um_upload_file_1");
            $this->db->select("um.eMediaType AS um_media_type_1");
            $this->db->select("um.iViewsCount AS views_count_1");
            $this->db->select("um.iPostMediaId AS post_media_id_1");
            $this->db->select("(SELECT count(pmv.iPostMediaViewId) FROM post_media_view pmv WHERE pmv.iPostMediaId = um.iPostMediaId AND pmv.iUserId = '" . $params_arr["user_id"] . "' LIMIT 1) AS is_view_1", FALSE);
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ( 'Accepted','Pending') LIMIT 1) AS is_following", FALSE);
            $this->db->select("(" . $this->db->escape("concat(p.iUserId,'@@',p.iPostId)") . ") AS share_post_detail_url", FALSE);
            $this->db->select("um.vVideoThumbnail AS um_video_thumbnail_1");
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ('Pending') ORDER BY 1 DESC LIMIT 1) AS pending_request_id", FALSE);
            $this->db->select("um.vMHeight AS um_mheight");
            $this->db->select("um.vMWidth AS um_mwidth");
            // $this->db->order_by("um.iViewsCount", "DESC");
            // $this->db->order_by("p.dAddedDate", "DESC");


            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
                throw new Exception('No records found.');
            }

            usort($result_arr, function ($a, $b) {
                return strtotime($b['p_added_date_1']) - strtotime($a['p_added_date_1']);
            });
            // print_r($result_arr);die;
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
      * get_random_reels ( other post ) method is used to execute database queries for Other Post Reels for Mobile.
      */
      public function get_random_reels_old($params_arr = array(), $page_index = 1, &$settings_params = array())
      {
        try {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("p.iPostId") . " = " . $this->db->protect("ts.iPostId") . "  AND p.ePostType = 'LiveNow'";
            $this->db->join("tokbox_session AS ts", $join_condition, "left", FALSE);
            $this->db->join("post_media AS um", "p.iPostId = um.iPostId", "left");

            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where_in("p.ePostType", array('Image', 'Video', 'Media'));
            $this->db->where("p.iUserId != '" . $params_arr["user_id"] . "'
            AND p.eVisibility = 'Public'
            AND p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $params_arr["user_id"] . "' AND eReportOn = 'Post')
            AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' ) AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $params_arr["user_id"] . "' AND eStatus = 'block' )", FALSE, FALSE);

            //get videos
            $this->db->where("um.eMediaType", "Video");
            $this->db->order_by("p.dAddedDate", "DESC");

            $this->db->group_by(array("p.iPostId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(p.iPostId) AS iPostId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("p.iPostId AS p_post_id_1");
            $this->db->select("p.iUserId AS p_user_id_1");
            $this->db->select("p.ePostType AS p_post_type_1");
            $this->db->select("p.tPostText AS p_post_text_1");
            $this->db->select("p.dAddedDate AS p_added_date_1");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "' LIMIT 1) AS is_like_1", FALSE);
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("p.eStatus AS p_status_1");
            $this->db->select("p.iActualPostId AS p_actual_post_id_1");
            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id_1");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date_1", FALSE);
            $this->db->select("p.eVisibility AS p_visibility_1");
            $this->db->select("p.iImpressionCount AS p_impression_count_1");
            $this->db->select("(" . $this->db->escape("1") . ") AS is_impressed_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_1", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_1", FALSE);
            $this->db->select("um.vUploadFile AS um_upload_file_1");
            $this->db->select("um.eMediaType AS um_media_type_1");
            $this->db->select("um.iViewsCount AS views_count_1");
            $this->db->select("um.iPostMediaId AS post_media_id_1");
            $this->db->select("(SELECT count(pmv.iPostMediaViewId) FROM post_media_view pmv WHERE pmv.iPostMediaId = um.iPostMediaId AND pmv.iUserId = '" . $params_arr["user_id"] . "' LIMIT 1) AS is_view_1", FALSE);
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ( 'Accepted','Pending') LIMIT 1) AS is_following", FALSE);
            $this->db->select("(" . $this->db->escape("concat(p.iUserId,'@@',p.iPostId)") . ") AS share_post_detail_url", FALSE);
            $this->db->select("um.vVideoThumbnail AS um_video_thumbnail_1");
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ('Pending') ORDER BY 1 DESC LIMIT 1) AS pending_request_id", FALSE);
            $this->db->select("um.vMHeight AS um_mheight");
            $this->db->select("um.vMWidth AS um_mwidth");

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;
            
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            
            $result_arr = (is_object($result_obj) && method_exists($result_obj, 'result_array')) 
            ? $result_obj->result_array() 
            : array();
            
            
            $this->db->flush_cache();
            if (!is_array($result_arr) || count($result_arr) == 0) {
                throw new Exception('No records found.');
            }
            $success = 1;
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        
        $this->db->_reset_all();
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["settings"] = $settings_params;
        $return_arr["data"] = $result_arr;

        return $return_arr;
    }


    public function get_random_reels($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        $user_id = intval($params_arr['user_id']);
        $record_limit = 10;
        $current_page = max(1, intval($page_index));
        $offset = ($current_page - 1) * $record_limit;

        try {
            // ----------------------------------------
            // STEP 1: COUNT total posts
            // ----------------------------------------
            $this->db->from('post AS p');
            $this->db->where('p.eDraft', 'No');
            $this->db->where('p.eStatus', 'Active');
            $this->db->where('p.eVisibility', 'Public');
            $this->db->where_in('p.ePostType', ['Image', 'Video', 'Media']);
            $this->db->where('p.iUserId !=', $user_id);
            $total_records = $this->db->count_all_results();

            if ($total_records == 0) {
                throw new Exception('No records found.');
            }

            // ----------------------------------------
            // STEP 2: Main optimized query
            // ----------------------------------------
            $this->db->select("
                p.iPostId AS p_post_id_1,
                p.iUserId AS p_user_id_1,
                p.ePostType AS p_post_type_1,
                p.tPostText AS p_post_text_1,
                p.dAddedDate AS p_added_date_1,
                p.eStatus AS p_status_1,
                p.iActualPostId AS p_actual_post_id_1,
                p.eVisibility AS p_visibility_1,
                p.iImpressionCount AS p_impression_count_1,
                (DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date_1,
                u.vName AS u_name_1,
                u.vProfileImage AS u_profile_image_1,
                um.vUploadFile AS um_upload_file_1,
                um.vVideoThumbnail AS um_video_thumbnail_1,
                um.iViewsCount AS views_count_1,
                um.iPostMediaId AS post_media_id_1,
                um.vMHeight AS um_mheight,
                um.vMWidth AS um_mwidth,
                CASE WHEN pl.iPostLikeId IS NOT NULL THEN 1 ELSE 0 END AS is_like_1,
                CASE WHEN pmv.iPostMediaViewId IS NOT NULL THEN 1 ELSE 0 END AS is_view_1,
                CASE WHEN uf.eStatus IS NOT NULL THEN uf.eStatus ELSE 'None' END AS is_following,
                uf.iUserFollowerId AS pending_request_id,
                0 AS comment_count_1,
                0 AS likes_count_1,
                0 AS shared_count_1,
                CONCAT(p.iUserId, '@@', p.iPostId) AS share_post_detail_url
            ", FALSE);

            $this->db->from('post AS p');
            $this->db->join('users AS u', 'u.iUsersId = p.iUserId', 'left');
            $this->db->join('post_media AS um', 'um.iPostId = p.iPostId AND um.eMediaType = "Video"', 'left');
            $this->db->join('post_like AS pl', "pl.iPostId = p.iPostId AND pl.iUserId = {$user_id}", 'left');
            $this->db->join('post_media_view AS pmv', "pmv.iPostMediaId = um.iPostMediaId AND pmv.iUserId = {$user_id}", 'left');
            $this->db->join('user_followers AS uf', "uf.iUserId = p.iUserId AND uf.iFollowerId = {$user_id} AND uf.eStatus IN ('Accepted', 'Pending')", 'left');

            $this->db->where('p.eDraft', 'No');
            $this->db->where('p.eStatus', 'Active');
            $this->db->where('p.eVisibility', 'Public');
            $this->db->where_in('p.ePostType', ['Video', 'Media']);
            $this->db->where('p.iUserId !=', $user_id);

            $this->db->order_by('p.dAddedDate', 'DESC');
            $this->db->limit($record_limit, $offset);

            $result_obj = $this->db->get();
            $result_arr = $result_obj->result_array();

            if (empty($result_arr)) {
                throw new Exception('No posts available.');
            }

            $total_pages = ceil($total_records / $record_limit);
            $settings_params = [
                'count' => $total_records,
                'per_page' => $record_limit,
                'curr_page' => $current_page,
                'prev_page' => ($current_page > 1) ? 1 : 0,
                'next_page' => ($current_page < $total_pages) ? 1 : 0,
            ];

            return [
                'success' => 1,
                'message' => 'Records fetched successfully.',
                'settings' => $settings_params,
                'data' => $result_arr
            ];

        } catch (Exception $e) {
            return [
                'success' => 0,
                'message' => $e->getMessage(),
                'settings' => $settings_params,
                'data' => []
            ];
        }
    }



    /**
     * post_details method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function post_details($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id_2");
            $this->db->select("p.iMovementsId AS p_movements_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_movement_releted_post method is used to execute database queries for Other Post API.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 17.11.2022
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_releted_post($params_arr = array())
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $this->db->join("post_media AS pm", "p.iPostId = pm.iPostId", "left");

            $this->db->select("p.iPostId AS p_post_id_3");
            $this->db->select("p.iActualPostId AS p_actual_post_id_2");
            $this->db->select("p.iUserId AS p_user_id_2");
            $this->db->select("p.ePostType AS p_post_type_2");
            $this->db->select("p.tPostText AS p_post_text_2");
            $this->db->select("p.eVisibility AS p_visibility_2");
            $this->db->select("p.iImpressionCount AS p_impression_count_2");
            $this->db->select("p.dAddedDate AS p_added_date_2");
            $this->db->select("p.eStatus AS p_status_2");
            $this->db->select("u.vName AS u_name_2");
            $this->db->select("u.vProfileImage AS u_profile_image_2");
            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.eMediaType AS pm_media_type");
            $this->db->select("pm.vUploadFile AS pm_upload_file");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail");
            $this->db->select("pm.iViewsCount AS pm_views_count");
            $this->db->select("pm.vMHeight AS pm_mheight");
            $this->db->select("pm.vMWidth AS pm_mwidth");
            $this->db->select("(SELECT count(iPostLikeId) FROM post_like pl WHERE pl.iPostId = p.iPostId AND pl.iUserId = '" . $params_arr["user_id"] . "' LIMIT 1) AS is_like_3", FALSE);
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date_3", FALSE);
            $this->db->select("(" . $this->db->escape("1") . ") AS is_impressed_3", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_3", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS like_count_3", FALSE);
            $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_3", FALSE);
            $this->db->select("(SELECT count(pmv.iPostMediaViewId) FROM post_media_view pmv WHERE pmv.iPostMediaId = pm.iPostMediaId AND pmv.iUserId = '" . $params_arr["user_id"] . "' LIMIT 1) AS is_viewed_3", FALSE);
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ( 'Accepted','Pending') LIMIT 1) AS is_following_3", FALSE);
            $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS share_postdetail_url_3", FALSE);
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = p.iUserId AND iFollowerId = '" . $params_arr["user_id"] . "' AND eStatus IN ('Pending') ORDER BY 1 DESC LIMIT 1) AS pending_request_id_3", FALSE);
            $this->db->select("(" . $this->db->escape("") . ") AS ts_tokbox_session_id_3", FALSE);
            if (isset($params_arr["post_id"]) && $params_arr["post_id"] != "") {
                $this->db->where("p.iPostId <>", $params_arr["post_id"]);
            }
            if (isset($params_arr["p_movements_id"]) && $params_arr["p_movements_id"] != "") {
                $this->db->where("p.iMovementsId =", $params_arr["p_movements_id"]);
            }
            $this->db->where_in("p.eVisibility", array('Movement'));
            $this->db->where_in("p.ePostType", array('Media'));

            $this->db->order_by("p.iPostId", "desc");

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_user_suggestions method is used to execute database queries for Suggestions API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 21.07.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_suggestions($user_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");
            $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $this->db->join("block_user_list AS bcl", "p.iUserId = bcl.iBlockByUserId", "left");

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("p.dAddedDate AS p_added_date");
            $this->db->select("u.vName AS user_name");
            $this->db->select("u.vProfileImage AS user_profile_image");
            $this->db->select("p.eStatus AS p_status");
            $this->db->select("p.iImpressionCount AS p_impression_count");
            $this->db->select("(SELECT COUNT(iPostLikeId) FROM post_like WHERE iPostId  = p.iPostId) AS like_count", FALSE);
            $this->db->select("(" . $this->db->escape("") . ") AS final_display_image", FALSE);
            $this->db->select("(" . $this->db->escape("") . ") AS final_upload_file", FALSE);
            $this->db->select("(" . $this->db->escape("") . ") AS final_media_type", FALSE);
            $this->db->select("(" . $this->db->escape("") . ") AS final_views_count", FALSE);
            $this->db->select("(" . $this->db->escape("") . ") AS final_video_image", FALSE);
            $this->db->where_in("p.eDraft", array('No'));
            $this->db->where_in("p.eStatus", array('Active'));
            $this->db->where_in("p.eVisibility", array('Viral'));
            $this->db->where_in("p.ePostType", array('Image', 'Video', 'Media'));
            if (isset($user_id) && $user_id != "") {
                $this->db->where("p.iUserId <>", $user_id);
            }
            $this->db->where(" p.iPostId NOT IN (SELECT iPostId FROM post_report_abuse WHERE iReportedBy  =  '" . $user_id . "' AND eReportOn = 'Post' )
AND  p.iUserId NOT IN( SELECT iUserId  FROM user_followers WHERE iFollowerId = '" . $user_id . "' AND eStatus = 'Accepted' )AND p.iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId  =  '" . $user_id . "' AND eStatus = 'block' )AND p.iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId  =  '" . $user_id . "' AND eStatus = 'block' )", FALSE, FALSE);

            // $this->db->order_by("p_impression_count DESC", FALSE, FALSE);
            $this->db->order_by("p.dAddedDate DESC, p_impression_count DESC", FALSE, FALSE);

            $this->db->limit(7);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_post_count_v3 method is used to execute database queries for List Liked Post User API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $search_ids search_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_count_v3($search_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(count(p.iPostId)) AS post_id", FALSE);
            if ($tmp_arr = filterEmptyValues($search_ids)) {
                $old_arr = $search_ids;
                $search_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $search_ids);
                $search_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_post_count_v3_v1 method is used to execute database queries for List Liked Post Comment User API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $search_ids search_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_count_v3_v1($search_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(count(p.iPostId)) AS post_id", FALSE);
            if ($tmp_arr = filterEmptyValues($search_ids)) {
                $old_arr = $search_ids;
                $search_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $search_ids);
                $search_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * get_post_count_v3_v2 method is used to execute database queries for List Liked Post Media API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $search_ids search_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_count_v3_v2($search_ids = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("(count(p.iPostId)) AS post_id", FALSE);
            if ($tmp_arr = filterEmptyValues($search_ids)) {
                $old_arr = $search_ids;
                $search_ids = $tmp_arr;
                $this->db->where_in("p.iUserId", $search_ids);
                $search_ids = $old_arr;
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->group_by(array("p.iUserId"));

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * check_post_exists_to_delete_v1 method is used to execute database queries for Delete Reply comment API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_exists_to_delete_v1($post_id = '')
    {
        try {
            $result_arr = array();

            $this->db->from("post AS p");

            $this->db->select("p.iPostId AS p_post_id");
            if (isset($post_id) && $post_id != "") {
                $this->db->where("p.iPostId =", $post_id);
            }
            $this->db->where_in("p.eStatus", array('Active'));

            $this->db->limit(1);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * query_for_post method is used to execute database queries for Extract meta data API.
     * @created Ashok Pidugu | 24.04.2020
     * @modified Jay Rajput | 23.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function query_for_post($params_arr = array(), $where_arr = array())
    {
        try {
            $result_arr = array();
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "") {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            if (isset($params_arr["json_post_metadata"])) {
                $this->db->set("tPostMetaData", $params_arr["json_post_metadata"]);
            }
            $res = $this->db->update("post");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1) {
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
     * movement_post_list method is used to execute database queries for Movements post list API.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 20.12.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $movement_id movement_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
      public function movement_post_list($user_id = '', $movement_id = '', $page_index = 1, &$settings_params = array())
      {
            try {
                  $result_arr = array();

                  $this->db->start_cache();
                  $this->db->from("post AS p");
                  $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
                  $this->db->join("users AS u", $join_condition, "left", FALSE);
                  if (isset($movement_id) && $movement_id != "") {
                        $this->db->where("p.iMovementsId =", $movement_id);
                  }
                  $this->db->where_in("p.eVisibility", array('Movement'));

                  $this->db->stop_cache();
                  $total_records = $this->db->count_all_results();

                  $this->db->select("p.iPostId AS p_post_id");
                  $this->db->select("p.iActualPostId AS p_actual_post_id");
                  $this->db->select("p.iUserId AS p_user_id");
                  $this->db->select("p.ePostType AS p_post_type");
                  $this->db->select("p.tPostText AS p_post_text");
                  $this->db->select("p.eVisibility AS p_visibility");
                  $this->db->select("p.iImpressionCount AS p_impression_count");
                  $this->db->select("p.dAddedDate AS p_added_date");
                  $this->db->select("p.eStatus AS p_status");
                  $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
                  $this->db->select("p.iMovementsId AS p_movements_id");
                  $this->db->select("u.vName AS u_name");
                  $this->db->select("u.vProfileImage AS u_profile_image");
                  $this->db->select("(" . $this->db->escape("0") . ") AS comment_count_1", FALSE);
                  $this->db->select("(" . $this->db->escape("0") . ") AS likes_count_1", FALSE);
                  $this->db->select("(" . $this->db->escape("0") . ") AS shared_count_1", FALSE);
                  $this->db->select("(concat(p.iUserId,'@@',p.iPostId)) AS custom_field_7", FALSE);
                  $this->db->select("if(DATE(p.tPostMetaData) is null,`p`.`tPostMetaData`,NULL) AS p_post_meta_data");
                  $this->db->select("(" . $this->db->escape("") . ") AS tokbox_session_id", FALSE);
                  $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date", FALSE);
                  $this->db->select("(select count(pl.iPostLikeId) from post_like as pl where pl.iUserId='" . $user_id . "') AS is_like");
                  $this->db->select("(select count('*') from post_impression as pi where pi.iPostId=p.iPostId) AS is_impressed");

                  $settings_params['count'] = $total_records;

                  $record_limit = 10;
                  $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
                  $total_pages = getTotalPages($total_records, $record_limit);
                  $start_index = getStartIndex($total_records, $current_page, $record_limit);
                  $settings_params['per_page'] = $record_limit;
                  $settings_params['curr_page'] = $current_page;
                  $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
                  $settings_params['next_page'] = ($current_page + 1 > $total_pages) ? 0 : 1;

                  $this->db->order_by("p.dModifiedDate", "desc");
                  $this->db->limit($record_limit, $start_index);
                  $result_obj = $this->db->get();
                  $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
                  $this->db->flush_cache();
                  if (!is_array($result_arr) || count($result_arr) == 0) {
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
     * delete_post_data method is used to execute database queries for Delete Account API.
     * @created Jay Rajput | 19.10.2022
     * @modified Jay Rajput | 19.10.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
      public function delete_post_data($user_id = '')
      {
            try {
                  $result_arr = array();
                  if (isset($user_id) && $user_id != "") {
                  $this->db->where("iUserId =", $user_id);
                  }
                  $res = $this->db->delete("post");
                  if (!$res) {
                  throw new Exception("Failure in deletion.");
                  }
                  $affected_rows = $this->db->affected_rows();
                  $result_param = "affected_rows1";
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


      //search Post using keyword for website
      public function search_post($keyword) {
            try {
                $result_arr = array();
                $this->db->start_cache();
                $this->db->from("post AS p");
        
                $join_condition = $this->db->protect("p.iUserId") . " = " . $this->db->protect("u.iUsersId") . "  AND " . $this->general->getPhysicalRecordWhere('users', 'u', 'NR');
                $this->db->join("users AS u", $join_condition, "left", FALSE);
        
                $this->db->where_in("p.eDraft", array('No'));
                $this->db->where_in("p.eStatus", array('Active'));
        
                if (!empty($keyword)) {
                    $keyword = $this->db->escape_like_str($keyword);
                    $this->db->where("(p.tPostText LIKE '%" . $keyword . "%' OR p.tPostTextEmoji LIKE '%" . $keyword . "%')", FALSE, FALSE);
                }
        
                $this->db->select("p.iPostId");
                $this->db->select("u.vName");
                $this->db->select("p.tPostTextEmoji");
        
                $this->db->stop_cache();
                $total_records = $this->db->count_all_results();
        
                $this->db->select("p.iPostId");
                $this->db->select("u.vName");
                $this->db->select("p.tPostTextEmoji");
        
                $this->db->order_by("p.iPostId DESC");
        
                $this->db->limit(10);
        
                $result_obj = $this->db->get();
                $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
                $this->db->flush_cache();
        
                if (!is_array($result_arr) || count($result_arr) == 0) {
                    throw new Exception('No records found.');
                }
            } catch (Exception $e) {
                $message = $e->getMessage();
                return $message;
            }
        
            $this->db->_reset_all();
            return $result_arr;
      }
}
