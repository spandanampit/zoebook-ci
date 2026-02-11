<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Notifications Model
 *
 * @category notification
 *
 * @package user
 *
 * @subpackage models
 *
 * @module User Notifications
 *
 * @class User_notifications_model.php
 *
 * @path application\notification\user\models\User_notifications_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 31.12.2018
 */

class User_notifications_model extends CI_Model
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
     * insert_post_notification method is used to execute database queries for Update Live Video Post Status notification.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 05.11.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_post_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["notify_text"]))
            {
                $this->db->set("vNotificationText", $params_arr["notify_text"]);
            }
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["ts_post_id"]))
            {
                $this->db->set("iPostId", $params_arr["ts_post_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["user_id"]);
            }
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id1";
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
}
