<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Report Abuse Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post Report Abuse
 *
 * @class Post_report_abuse_model.php
 *
 * @path application\webservice\post\models\Post_report_abuse_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 19.10.2022
 */

class Post_report_abuse_model extends CI_Model
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
     * insert_abuse method is used to execute database queries for Report abuse on post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 28.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_abuse($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            $this->db->set("eReportOn", $params_arr["_ereporton"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iReportedBy", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["report_notes"]))
            {
                $this->db->set("tReportNotes", $params_arr["report_notes"]);
            }
            if (isset($params_arr["type"]))
            {
                $this->db->set("eType", $params_arr["type"]);
            }
            $this->db->insert("post_report_abuse");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id";
            $result_arr[0][$result_param] = $insert_id;
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
     * insert_abuse_on_comment method is used to execute database queries for Report abuse on comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 28.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_abuse_on_comment($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            $this->db->set("eReportOn", $params_arr["_ereporton"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iReportedBy", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["report_notes"]))
            {
                $this->db->set("tReportNotes", $params_arr["report_notes"]);
            }
            if (isset($params_arr["post_comment_id"]))
            {
                $this->db->set("iPostCommentId", $params_arr["post_comment_id"]);
            }
            if (isset($params_arr["type"]))
            {
                $this->db->set("eType", $params_arr["type"]);
            }
            $this->db->insert("post_report_abuse");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id";
            $result_arr[0][$result_param] = $insert_id;
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
     * select_post_report_abuse method is used to execute database queries for Hide post API.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param string $user_id user_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function select_post_report_abuse($user_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_report_abuse AS pra");

            $this->db->select("pra.iPostReportAbuseId AS pra_post_report_abuse_id");
            $this->db->select("pra.iPostId AS pra_post_id");
            $this->db->select("pra.eType AS pra_type");
            $this->db->select("pra.eReportOn AS pra_report_on");
            $this->db->select("pra.iReportedBy AS pra_reported_by");
            $this->db->select("pra.dAddedDate AS pra_added_date");
            $this->db->select("pra.eStatus AS pra_status");
            $this->db->where_in("pra.eType", array('HidePost'));
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("pra.iReportedBy =", $user_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pra.iPostId =", $post_id);
            }

            $this->db->limit(1);

            $result_obj = $this->db->get();
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
     * remove_hide_post method is used to execute database queries for Hide post API.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param string $pra_post_report_abuse_id pra_post_report_abuse_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function remove_hide_post($pra_post_report_abuse_id = '', $post_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($pra_post_report_abuse_id) && $pra_post_report_abuse_id != "")
            {
                $this->db->where("iPostReportAbuseId =", $pra_post_report_abuse_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("iPostId =", $post_id);
            }
            $this->db->where_in("eStatus", array('Approved'));
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iReportedBy =", $user_id);
            }
            $this->db->where_in("eType", array('HidePost'));
            $res = $this->db->delete("post_report_abuse");
            if (!$res)
            {
                throw new Exception("Failure in deletion.");
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

        $this->db->_reset_all();
        //echo $this->db->last_query();
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["data"] = $result_arr;
        return $return_arr;
    }

    /**
     * add_hide_post method is used to execute database queries for Hide post API.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function add_hide_post($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            $this->db->set("eType", $params_arr["_etype"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iReportedBy", $params_arr["user_id"]);
            }
            $this->db->set("dAddedDate", $params_arr["_daddeddate"]);
            $this->db->set("dModifiedDate", $params_arr["_dmodifieddate"]);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->insert("post_report_abuse");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id";
            $result_arr[0][$result_param] = $insert_id;
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
     * get_hide_post method is used to execute database queries for Hide post list API.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 19.10.2022
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_hide_post($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post_report_abuse AS pra");
            $this->db->join("post AS p", "pra.iPostId = p.iPostId", "inner");
            $join_condition = $this->db->protect("p.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("pra.iReportedBy =", $user_id);
            }
            $this->db->where_in("pra.eType", array('HidePost'));
            $this->db->where_in("pra.eStatus", array('Approved'));

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("p.iPostId AS p_post_id");
            $this->db->select("p.iUserId AS p_user_id");
            $this->db->select("p.ePostType AS p_post_type");
            $this->db->select("p.tPostText AS p_post_text");
            $this->db->select("p.dAddedDate AS p_added_date");
            $this->db->select("(DATE_ADD(p.dAddedDate, INTERVAL 2 DAY)) AS expire_date", FALSE);
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("p.eStatus AS p_status");
            $this->db->select("p.iActualPostId AS p_actual_post_id");
            $this->db->select("p.eVisibility AS p_visibility");
            $this->db->select("(".$this->db->escape("0").") AS comment_count", FALSE);
            $this->db->select("(".$this->db->escape("0").") AS likes_count", FALSE);
            $this->db->select("(".$this->db->escape("0").") AS shared_count", FALSE);
            $this->db->select("p.tPostMetaData AS p_post_meta_data");
            $this->db->select("p.vVideoThumbnail AS p_video_thumbnail");
            $this->db->select("p.tPostTextEmoji AS p_post_text_emoji");
            $this->db->select("(".$this->db->escape("concat(p.iUserId,'@@',p.iPostId)").") AS custom_field_6", FALSE);
            $this->db->select("p.iImpressionCount AS p_impression_count");
            $this->db->select("0 AS pl_post_like_id");
            $this->db->select("0 AS is_impressed");

            $settings_params['count'] = $total_records;

            $record_limit = 20;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("pra.iPostReportAbuseId", "desc");
            $this->db->limit($record_limit, $start_index);
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            $this->db->flush_cache();
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
     * hide_post_list method is used to execute database queries for Delete Account API.
     * @created Jay Rajput | 19.10.2022
     * @modified Jay Rajput | 19.10.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function hide_post_list($user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iReportedBy =", $user_id);
            }
            $res = $this->db->delete("post_report_abuse");
            if (!$res)
            {
                throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows7";
            $result_arr[0][$result_param] = $affected_rows;
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
