<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Tokbox Session Subscriber Model
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage models
 *
 * @module Tokbox Session Subscriber
 *
 * @class Tokbox_session_subscriber_model.php
 *
 * @path application\webservice\tokbox\models\Tokbox_session_subscriber_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Tokbox_session_subscriber_model extends CI_Model
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
     * insert_session_subscriber method is used to execute database queries for Join Live Stream API.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_session_subscriber($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["ts_tokbox_session_id"]))
            {
                $this->db->set("iTokboxSessionId", $params_arr["ts_tokbox_session_id"]);
            }
            if (isset($params_arr["ts_post_id"]))
            {
                $this->db->set("iPostId", $params_arr["ts_post_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dtJoinDateTime"), $params_arr["_dtjoindatetime"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["tokbox_token"]))
            {
                $this->db->set("vToken", $params_arr["tokbox_token"]);
            }
            $this->db->insert("tokbox_session_subscriber");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "subscriber_id";
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
     * check_user_already_joined method is used to execute database queries for Join Live Stream API.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 12.06.2020
     * @param string $ts_tokbox_session_id ts_tokbox_session_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_already_joined($ts_tokbox_session_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session_subscriber AS tss");
            $this->db->join("tokbox_session AS ts", "tss.iTokboxSessionId = ts.iTokboxSessionId", "left");

            $this->db->select("tss.iTokboxSessionSubscriberId AS tss_tokbox_session_subscriber_id");
            $this->db->select("tss.iTokboxSessionId AS tss_tokbox_session_id");
            $this->db->select("tss.vToken AS tss_token");
            $this->db->select("tss.eStatus AS tss_status");
            $this->db->select("tss.iPostId AS tss_post_id");
            $this->db->select("ts.vSessionId AS ts_session_id");
            if (isset($ts_tokbox_session_id) && $ts_tokbox_session_id != "")
            {
                $this->db->where("tss.iTokboxSessionId =", $ts_tokbox_session_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("tss.iUserId =", $user_id);
            }

            $this->db->order_by("tss.iTokboxSessionSubscriberId", "desc");

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
     * get_new_tokbox_token method is used to execute database queries for Join Live Stream API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 09.08.2022
     * @param string $subscriber_id subscriber_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_new_tokbox_token($subscriber_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session_subscriber AS tss");
            $this->db->join("tokbox_session AS ts", "tss.iTokboxSessionId = ts.iTokboxSessionId", "left");

            $this->db->select("tss.iTokboxSessionSubscriberId AS tss_tokbox_session_subscriber_id_1");
            $this->db->select("tss.iTokboxSessionId AS tss_tokbox_session_id_1");
            $this->db->select("tss.vToken AS tss_token_1");
            $this->db->select("tss.eStatus AS tss_status_1");
            $this->db->select("tss.iPostId AS tss_post_id_1");
            $this->db->select("ts.vSessionId AS ts_session_id_1");
            if (isset($subscriber_id) && $subscriber_id != "")
            {
                $this->db->where("tss.iTokboxSessionSubscriberId =", $subscriber_id);
            }

            $this->db->order_by("tss.iTokboxSessionSubscriberId", "desc");

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
     * update_stream_subs_status method is used to execute database queries for End Live Stream API.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_stream_subs_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["ts_tokbox_session_id"]) && $where_arr["ts_tokbox_session_id"] != "")
            {
                $this->db->where("iTokboxSessionId =", $where_arr["ts_tokbox_session_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dtLeaveDateTime"), $params_arr["_dtleavedatetime"], FALSE);
            $res = $this->db->update("tokbox_session_subscriber");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows1";
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
