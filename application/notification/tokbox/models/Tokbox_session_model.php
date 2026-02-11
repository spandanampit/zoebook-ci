<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Tokbox Session Model
 *
 * @category notification
 *
 * @package tokbox
 *
 * @subpackage models
 *
 * @module Tokbox Session
 *
 * @class Tokbox_session_model.php
 *
 * @path application\notification\tokbox\models\Tokbox_session_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 31.12.2018
 */

class Tokbox_session_model extends CI_Model
{
    /**
     * __construct method is used to set model preferences while model object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('listing');
    }

    /**
     * get_live_tokbox_session method is used to execute database queries for Update Live Video Post Status notification.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param string $archive_url archive_url is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_live_tokbox_session($archive_url = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session AS ts");
            $this->db->join("users AS u", "ts.iUserId = u.iUsersId", "left");

            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("ts.iPostId AS ts_post_id");
            $this->db->select("ts.vArchiveId AS ts_archive_id");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status");
            $this->db->select("ts.eStatus AS ts_status");
            $this->db->select("ts.iUserId AS user_id");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.vDeviceToken AS u_device_token");
            $this->db->where_in("ts.eArchiveStatus", array('available', 'stopped', 'uploaded'));
            $this->db->where_in("ts.eStatus", array('Shared'));
            $this->db->where("(ts.vArchiveId IS NOT NULL AND ts.vArchiveId <> '')", FALSE, FALSE);
            if (isset($archive_url) && $archive_url != "")
            {
                $this->db->where("(ts.vURL IS NULL OR ts.vURL = '')", FALSE, FALSE);
            }
            $this->db->where("NOW() > (DATE_ADD(ts.dtEndDateTime, INTERVAL 1 MINUTE))", FALSE, FALSE);

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
     * update_tokbox_status method is used to execute database queries for Update Live Video Post Status notification.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_tokbox_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["ts_tokbox_session_id"]) && $where_arr["ts_tokbox_session_id"] != "")
            {
                $this->db->where("iTokboxSessionId =", $where_arr["ts_tokbox_session_id"]);
            }
            if (isset($params_arr["final_archive_status"]))
            {
                $this->db->set("eArchiveStatus", $params_arr["final_archive_status"]);
            }
            if (isset($params_arr["archive_url"]))
            {
                $this->db->set("vURL", $params_arr["archive_url"]);
            }
            $this->db->set("eStatus", $params_arr["ts_archive_status"]);
            $res = $this->db->update("tokbox_session");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
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
     * update_tokbox_latest_status method is used to execute database queries for Update Live Video Post Status notification.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_tokbox_latest_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["ts_tokbox_session_id"]) && $where_arr["ts_tokbox_session_id"] != "")
            {
                $this->db->where("iTokboxSessionId =", $where_arr["ts_tokbox_session_id"]);
            }
            if (isset($params_arr["final_archive_status"]))
            {
                $this->db->set("eArchiveStatus", $params_arr["final_archive_status"]);
            }
            if (isset($params_arr["archive_url"]))
            {
                $this->db->set("vURL", $params_arr["archive_url"]);
            }
            $res = $this->db->update("tokbox_session");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
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
}
