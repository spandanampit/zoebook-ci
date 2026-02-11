<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Tokbox Session Model
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage models
 *
 * @module Tokbox Session
 *
 * @class Tokbox_session_model.php
 *
 * @path application\webservice\tokbox\models\Tokbox_session_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.01.2019
 */

class Tokbox_session_model extends CI_Model
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
     * insert_tokbox_session method is used to execute database queries for Start Live Stream API.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_tokbox_session($params_arr = array())
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
            if (isset($params_arr["session_id"]))
            {
                $this->db->set("vSessionId", $params_arr["session_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dtStartDateTime"), $params_arr["_dtstartdatetime"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->insert("tokbox_session");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "tokbox_session_inserted_id";
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
     * check_stream_exist method is used to execute database queries for Join Live Stream API.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param string $tokbox_session_id tokbox_session_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_stream_exist($tokbox_session_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session AS ts");

            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("ts.iPostId AS ts_post_id");
            $this->db->select("ts.vSessionId AS tokbox_live_session_id");
            $this->db->select("ts.eStatus AS ts_status");
            if (isset($tokbox_session_id) && $tokbox_session_id != "")
            {
                $this->db->or_where("ts.iTokboxSessionId =", $tokbox_session_id);
            }

            $this->db->order_by("ts.iTokboxSessionId", "desc");

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
     * update_stream_status method is used to execute database queries for End Live Stream API.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_stream_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["ts_tokbox_session_id"]) && $where_arr["ts_tokbox_session_id"] != "")
            {
                $this->db->where("iTokboxSessionId =", $where_arr["ts_tokbox_session_id"]);
            }

            $this->db->set($this->db->protect("dtEndDateTime"), $params_arr["_dtenddatetime"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set("eArchiveStatus", $params_arr["_earchivestatus"]);
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
     * check_user_stream_exist method is used to execute database queries for End Live Stream API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.10.2018
     * @param string $tokbox_session_id tokbox_session_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_stream_exist($tokbox_session_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session AS ts");

            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("ts.iPostId AS ts_post_id");
            $this->db->select("ts.vSessionId AS tokbox_live_session_id");
            $this->db->select("ts.eStatus AS ts_status");
            $this->db->select("ts.vArchiveId AS ts_archive_id");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status");
            if (isset($tokbox_session_id) && $tokbox_session_id != "")
            {
                $this->db->where("ts.iTokboxSessionId =", $tokbox_session_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("ts.iUserId =", $user_id);
            }

            $this->db->order_by("ts.iTokboxSessionId", "desc");

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
     * check_archive_stream_exist method is used to execute database queries for Start Live Archive API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.10.2018
     * @param string $tokbox_session_id tokbox_session_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_archive_stream_exist($tokbox_session_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session AS ts");
            $this->db->join("users AS u", "ts.iUserId = u.iUsersId", "left");

            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("ts.iPostId AS ts_post_id");
            $this->db->select("ts.vSessionId AS tokbox_live_session_id");
            $this->db->select("ts.eStatus AS ts_status");
            $this->db->select("ts.vArchiveId AS ts_archive_id");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status");
            $this->db->select("u.vName AS u_name");
            if (isset($tokbox_session_id) && $tokbox_session_id != "")
            {
                $this->db->or_where("ts.iTokboxSessionId =", $tokbox_session_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->or_where("ts.iUserId =", $user_id);
            }
            $this->db->or_where_in("ts.eStatus", array('Inprogress'));

            $this->db->order_by("ts.iTokboxSessionId", "desc");

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
     * update_archive_status_started method is used to execute database queries for Start Live Archive API.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_archive_status_started($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["ts_tokbox_session_id"]) && $where_arr["ts_tokbox_session_id"] != "")
            {
                $this->db->where("iTokboxSessionId =", $where_arr["ts_tokbox_session_id"]);
            }
            if (isset($params_arr["archive_id"]))
            {
                $this->db->set("vArchiveId", $params_arr["archive_id"]);
            }
            $this->db->set("eArchiveStatus", $params_arr["_earchivestatus"]);
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
     * check_user_stream_exist_v1 method is used to execute database queries for Share Live Video Post API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 15.10.2018
     * @param string $tokbox_session_id tokbox_session_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_stream_exist_v1($tokbox_session_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("tokbox_session AS ts");

            $this->db->select("ts.iTokboxSessionId AS ts_tokbox_session_id");
            $this->db->select("ts.iPostId AS ts_post_id");
            $this->db->select("ts.vSessionId AS tokbox_live_session_id");
            $this->db->select("ts.eStatus AS ts_status");
            $this->db->select("ts.vArchiveId AS ts_archive_id");
            $this->db->select("ts.eArchiveStatus AS ts_archive_status");
            if (isset($tokbox_session_id) && $tokbox_session_id != "")
            {
                $this->db->where("ts.iTokboxSessionId =", $tokbox_session_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("ts.iUserId =", $user_id);
            }

            $this->db->order_by("ts.iTokboxSessionId", "desc");

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
     * update_tokbox_status_v1 method is used to execute database queries for Share Live Video Post API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 18.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_tokbox_status_v1($params_arr = array(), $where_arr = array())
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
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $res = $this->db->update("tokbox_session");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows2";
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
