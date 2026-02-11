<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Notifications Model
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage models
 *
 * @module User Notifications
 *
 * @class User_notifications_model.php
 *
 * @path application\webservice\user\models\User_notifications_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 17.11.2022
 */

class User_notifications_model extends CI_Model
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
     * insert_user_notification method is used to execute database queries for Follow Request API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Rohit Patidar | 20.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["following_user_id"]))
            {
                $this->db->set("iUserId", $params_arr["following_user_id"]);
            }
            if (isset($params_arr["notification_text"]))
            {
                $this->db->set("vNotificationText", $params_arr["notification_text"]);
            }
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            if (isset($params_arr["user_follower_Id"]))
            {
                $this->db->set("iUserFollowerId", $params_arr["user_follower_Id"]);
            }
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["notify_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["notify_users_id"]);
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

    /**
     * insert_user_notify method is used to execute database queries for Follow Accept Reject Cancel API.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 20.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user_notify($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["u1_users_id"]))
            {
                $this->db->set("iUserId", $params_arr["u1_users_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["u_name"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["uf_user_id"]))
            {
                $this->db->set("iUserFollowerId", $params_arr["uf_user_id"]);
            }
            if (isset($params_arr["u_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["u_users_id"]);
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

    /**
     * get_notifications method is used to execute database queries for User Notifications list API.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Jay Rajput | 17.11.2022
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_notifications($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("user_notifications AS un");
            $this->db->join("user_followers AS uf", "un.iUserFollowerId = uf.iUserFollowerId", "left");
            $join_condition = $this->db->protect("un.iNotifiyUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("un.iUserId =", $user_id);
            }
            $this->db->where_in("un.eMovementReadStatus", array('No'));
            $this->db->where(" (un.eType IN ('Normal','Post','Live','Comment','MovementFollower','MovementFRequest')  OR uf.eStatus = 'Pending')", FALSE, FALSE);

            $this->db->group_by(array("un.iUserNotificationsId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(un.iUserNotificationsId) AS iUserNotificationsId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("un.vNotificationText AS un_notification_text");
            $this->db->select("un.eType AS un_type");
            $this->db->select("un.iUserFollowerId AS un_user_follower_id");
            $this->db->select("un.dtAddedDate AS un_added_date");
            $this->db->select("uf.eStatus AS uf_status");
            $this->db->select("un.iPostId AS un_post_id");
            $this->db->select("un.iPostCommentId AS un_post_comment_id");
            $this->db->select("un.iTokboxSessionId AS un_tokbox_session_id");
            $this->db->select("un.vCode AS un_code");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.vProfileImage AS u_profile_image_url"); //new 
            $this->db->select("un.iUserNotificationsId AS un_user_notifications_id");
            $this->db->select("un.eIsRead AS un_is_read");
            $this->db->select("un.iMovementId AS un_movement_id");
            $this->db->select("un.iNotifiyUserId AS un_notifiy_user_id");
            $this->db->select("un.eMovementReadStatus AS un_movement_read_status");
            $this->db->select("un.iUserId AS un_user_id");
            $this->db->select("(if((select count(*) from post_media where iPostId=un.iPostId)>0,'Yes','No')) AS is_media", FALSE);
            $this->db->select("(select iUserId from post where iPostId=un.iPostId limit 1) AS user_post_id", FALSE);

            $settings_params['count'] = $total_records;

            $record_limit = 20;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("un.iUserNotificationsId", "desc");
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
     * update_read_status method is used to execute database queries for User Notifications list API.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Rohit Patidar | 21.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
      public function update_read_status($params_arr = array(), $where_arr = array())
      {
      $result_arr = array();
      $message = "";
      $success = 0;

      try {
            $batch_limit = 1000;
            $total_updated = 0;
            $batch_number = 1;
        
            do {
                if (isset($where_arr["user_id"]) && $where_arr["user_id"] !== "") {
                    $this->db->where("iUserId", $where_arr["user_id"]);
                }
        
                $this->db->where("eIsRead", 'No');
                $this->db->set("eIsRead", $params_arr["_eisread"]);
                $this->db->limit($batch_limit);
        
                $start = microtime(true);
                $res = $this->db->update("user_notifications");
                $exec_time = round(microtime(true) - $start, 4);
        
                $affected_rows = $this->db->affected_rows();
                $total_updated += $affected_rows;
        
                error_log("Batch $batch_number: $affected_rows rows, Time: {$exec_time}s");
                $batch_number++;
        
            } while ($affected_rows > 0);
        
            if (!$res) {
                throw new Exception("Failure in update query.");
            }
        
            $result_arr[0]["affected_rows"] = $total_updated;
            $result_arr[0]["execution_time"] = $exec_time;
            $success = 1;
        
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        

            $this->db->flush_cache();
            $this->db->_reset_all();

            $return_arr["success"] = $success;
            $return_arr["message"] = $message;
            $return_arr["data"] = $result_arr;

            return $return_arr;
      }


    /**
     * get_notification_count method is used to execute database queries for Notification Count API.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Jay Rajput | 21.07.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_notification_count($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_notifications AS un");

            $this->db->select("count(un.iUserNotificationsId) AS notify_count");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("un.iUserId =", $user_id);
            }
            $this->db->where_in("un.eIsRead", array('No'));

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
     * insert_liked_notification method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_liked_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["posted_users_id"]))
            {
                $this->db->set("iUserId", $params_arr["posted_users_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["liked_name"], FALSE);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["liked_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["liked_users_id"]);
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

    /**
     * insert_user_notify_commented method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Pavan  | 02.11.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user_notify_commented($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["posted_by_user_id"]))
            {
                $this->db->set("iUserId", $params_arr["posted_by_user_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["_vnotificationtext"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["comment_id"]))
            {
                $this->db->set("iPostCommentId", $params_arr["comment_id"]);
            }
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["u_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["u_users_id"]);
            }
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_notify_id";
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
     * insert_commented_notify method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_commented_notify($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Batch insertion data not found.");
            }
            $batch_ins_arr = array();
            $params_count = count($params_arr);
            for ($i = 0; $i < $params_count; $i++)
            {
                $temp_ins_arr = array();

                $temp_ins_arr[$this->db->protect("iUserId")] = $this->db->escape($params_arr[$i]["commented_users_id"]);
                $temp_ins_arr[$this->db->protect("vNotificationText")] = $params_arr[$i]["_vnotificationtext"];
                $temp_ins_arr[$this->db->protect("eType")] = $this->db->escape($params_arr[$i]["_etype"]);
                $temp_ins_arr[$this->db->protect("eIsRead")] = $this->db->escape($params_arr[$i]["_eisread"]);
                $temp_ins_arr[$this->db->protect("dtAddedDate")] = $params_arr[$i]["_dtaddeddate"];
                $temp_ins_arr[$this->db->protect("iPostId")] = $this->db->escape($params_arr[$i]["post_id"]);
                $temp_ins_arr[$this->db->protect("iPostCommentId")] = $this->db->escape($params_arr[$i]["comment_id"]);
                $temp_ins_arr[$this->db->protect("vCode")] = $params_arr[$i]["_vcode"];
                $temp_ins_arr[$this->db->protect("iNotifiyUserId")] = $this->db->escape($params_arr[$i]["posted_by_user_id"]);

                $batch_ins_arr[] = $temp_ins_arr;
            }

            $affected_rows = $this->db->insert_batch($this->db->protect("user_notifications"), $batch_ins_arr, FALSE);
            if (!$affected_rows)
            {
                throw new Exception("Failure in insertion.");
            }

            $result_param = "insert_id";
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
     * insert_user_notify_commented_v1 method is used to execute database queries for Reply on comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user_notify_commented_v1($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["posted_by_user_id"]))
            {
                $this->db->set("iUserId", $params_arr["posted_by_user_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["_vnotificationtext"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["post_comment_id"]))
            {
                $this->db->set("iPostCommentId", $params_arr["post_comment_id"]);
            }
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["u_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["u_users_id"]);
            }
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_notify_id";
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
     * insert_user_notify_replied method is used to execute database queries for Reply on comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user_notify_replied($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["commented_users_id"]))
            {
                $this->db->set("iUserId", $params_arr["commented_users_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["_vnotificationtext"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["post_comment_id"]))
            {
                $this->db->set("iPostCommentId", $params_arr["post_comment_id"]);
            }
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["u_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["u_users_id"]);
            }
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_notify_replied_id";
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
     * ins_follwer_notification method is used to execute database queries for Send Post Notification API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function ins_follwer_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Batch insertion data not found.");
            }
            $batch_ins_arr = array();
            $params_count = count($params_arr);
            for ($i = 0; $i < $params_count; $i++)
            {
                $temp_ins_arr = array();

                $temp_ins_arr[$this->db->protect("iUserId")] = $this->db->escape($params_arr[$i]["follower_users_id"]);
                $temp_ins_arr[$this->db->protect("eType")] = $this->db->escape($params_arr[$i]["notification_type"]);
                $temp_ins_arr[$this->db->protect("eIsRead")] = $this->db->escape($params_arr[$i]["_eisread"]);
                $temp_ins_arr[$this->db->protect("dtAddedDate")] = $params_arr[$i]["_dtaddeddate"];
                $temp_ins_arr[$this->db->protect("vNotificationText")] = $this->db->escape($params_arr[$i]["notification_text"]);
                $temp_ins_arr[$this->db->protect("iPostId")] = $this->db->escape($params_arr[$i]["post_id"]);
                $temp_ins_arr[$this->db->protect("vCode")] = $this->db->escape($params_arr[$i]["notification_code"]);
                $temp_ins_arr[$this->db->protect("iTokboxSessionId")] = $this->db->escape($params_arr[$i]["tokbox_session_id"]);
                $temp_ins_arr[$this->db->protect("iNotifiyUserId")] = $this->db->escape($params_arr[$i]["user_id"]);

                $batch_ins_arr[] = $temp_ins_arr;
            }

            $affected_rows = $this->db->insert_batch($this->db->protect("user_notifications"), $batch_ins_arr, FALSE);
            if (!$affected_rows)
            {
                throw new Exception("Failure in insertion.");
            }

            $result_param = "insert_id1";
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
     * insert_commented_notification method is used to execute database queries for Like Comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_commented_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["commented_users_id"]))
            {
                $this->db->set("iUserId", $params_arr["commented_users_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["liked_name"], FALSE);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["post_comment_id"]))
            {
                $this->db->set("iPostCommentId", $params_arr["post_comment_id"]);
            }
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["liked_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["liked_users_id"]);
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

    /**
     * remove_follower_notification method is used to execute database queries for End Live Stream API.
     * @created Vamsi Ippe | 02.11.2018
     * @modified Vamsi Ippe | 02.11.2018
     * @param string $tokbox_session_id tokbox_session_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function remove_follower_notification($tokbox_session_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($tokbox_session_id) && $tokbox_session_id != "")
            {
                $this->db->where("iTokboxSessionId =", $tokbox_session_id);
            }
            $res = $this->db->delete("user_notifications");
            if (!$res)
            {
                throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows2";
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
     * remove_notification method is used to execute database queries for Remove Notification API.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param string $notification_id notification_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function remove_notification($notification_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($notification_id) && $notification_id != "")
            {
                $this->db->where("iUserNotificationsId =", $notification_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iUserId =", $user_id);
            }
            $res = $this->db->delete("user_notifications");
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
     * insert_liked_notification_v1 method is used to execute database queries for Like Post Media API.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 09.11.2020
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_liked_notification_v1($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["posted_users_id"]))
            {
                $this->db->set("iUserId", $params_arr["posted_users_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["liked_name"], FALSE);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            if (isset($params_arr["p_post_id"]))
            {
                $this->db->set("iPostId", $params_arr["p_post_id"]);
            }
            if (isset($params_arr["liked_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["liked_users_id"]);
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

    /**
     * insert_notification method is used to execute database queries for Comment Post Media API.
     * @created Mehul Prajapati | 18.03.2021
     * @modified Mehul Prajapati | 18.03.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["post_owner_id"]))
            {
                $this->db->set("iUserId", $params_arr["post_owner_id"]);
            }
            $this->db->set($this->db->protect("vNotificationText"), $params_arr["_vnotificationtext"], FALSE);
            $this->db->set("eType", $params_arr["_etype"]);
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["user_id"]);
            }
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set($this->db->protect("vCode"), $params_arr["_vcode"], FALSE);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "new_notification_id";
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
     * user_notification_query_block method is used to execute database queries for Edit movement API.
     * @created Alpesh Patel | 24.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function user_notification_query_block($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["movements_id"]) && $where_arr["movements_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movements_id"]);
            }
            $this->db->where("vCode =", "MR");

            $this->db->set("eMovementReadStatus", $params_arr["_emovementreadstatus"]);
            $res = $this->db->update("user_notifications");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
            $result_param = "user_notification_rows";
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
     * notification_user method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function notification_user($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["u_users_id_1"]))
            {
                $this->db->set("iUserId", $params_arr["u_users_id_1"]);
            }
            if (isset($params_arr["notification_text"]))
            {
                $this->db->set("vNotificationText", $params_arr["notification_text"]);
            }
            $this->db->set("eType", $params_arr["_etype"]);
            if (isset($params_arr["m_movements_id"]))
            {
                $this->db->set("iMovementId", $params_arr["m_movements_id"]);
            }
            if (isset($params_arr["uu_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["uu_users_id"]);
            }
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set("vCode", $params_arr["_vcode"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set($this->db->protect("iPostCommentId"), $params_arr["_ipostcommentid"], FALSE);
            $this->db->set($this->db->protect("iTokboxSessionId"), $params_arr["_itokboxsessionid"], FALSE);
            $this->db->set($this->db->protect("iUserFollowerId"), $params_arr["_iuserfollowerid"], FALSE);
            $this->db->set($this->db->protect("iPostId"), $params_arr["_ipostid"], FALSE);
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "notification_id";
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
     * insert_user_notifications method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user_notifications($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["mu_user_id"]))
            {
                $this->db->set("iUserId", $params_arr["mu_user_id"]);
            }
            if (isset($params_arr["u2_name"]))
            {
                $this->db->set("vNotificationText", $params_arr["u2_name"]);
            }
            $this->db->set("eType", $params_arr["_etype"]);
            if (isset($params_arr["movement_id"]))
            {
                $this->db->set("iMovementId", $params_arr["movement_id"]);
            }
            if (isset($params_arr["u2_users_id"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["u2_users_id"]);
            }
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set("vCode", $params_arr["_vcode"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->insert("user_notifications");
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
     * update_user_notification method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_user_notification($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iNotifiyUserId =", $where_arr["user_id"]);
            }
            if (isset($where_arr["movement_id"]) && $where_arr["movement_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movement_id"]);
            }
            $this->db->where_in("eMovementReadStatus", array('No'));

            $this->db->set("eMovementReadStatus", $params_arr["_emovementreadstatus"]);
            $res = $this->db->update("user_notifications");
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

    /**
     * update_user_notification_read_status method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_user_notification_read_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iNotifiyUserId =", $where_arr["user_id"]);
            }
            $this->db->where_in("eMovementReadStatus", array('No'));
            if (isset($where_arr["movement_id"]) && $where_arr["movement_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movement_id"]);
            }

            $this->db->set("eMovementReadStatus", $params_arr["_emovementreadstatus"]);
            $res = $this->db->update("user_notifications");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
            $result_param = "affected_rows3";
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
     * update_cancel_read_status method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_cancel_read_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUserId =", $where_arr["user_id"]);
            }
            $this->db->where_in("eMovementReadStatus", array('No'));
            if (isset($where_arr["movement_id"]) && $where_arr["movement_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movement_id"]);
            }
            $this->db->where("vCode =", "IMR");

            $this->db->set("eMovementReadStatus", $params_arr["_emovementreadstatus"]);
            $res = $this->db->update("user_notifications");
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
     * request_notification method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function request_notification($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["u_users_id"]))
            {
                $this->db->set("iUserId", $params_arr["u_users_id"]);
            }
            if (isset($params_arr["notification_text"]))
            {
                $this->db->set("vNotificationText", $params_arr["notification_text"]);
            }
            $this->db->set("eType", $params_arr["_etype"]);
            $this->db->set($this->db->protect("iUserFollowerId"), $params_arr["_iuserfollowerid"], FALSE);
            $this->db->set($this->db->protect("iPostId"), $params_arr["_ipostid"], FALSE);
            $this->db->set($this->db->protect("iMovementId"), $params_arr["movement_id"], FALSE);
            $this->db->set($this->db->protect("iPostCommentId"), $params_arr["_ipostcommentid"], FALSE);
            $this->db->set($this->db->protect("iTokboxSessionId"), $params_arr["_itokboxsessionid"], FALSE);
            if (isset($params_arr["u_users_id_1"]))
            {
                $this->db->set("iNotifiyUserId", $params_arr["u_users_id_1"]);
            }
            $this->db->set("eIsRead", $params_arr["_eisread"]);
            $this->db->set("vCode", $params_arr["_vcode"]);
            $this->db->set($this->db->protect("dtAddedDate"), $params_arr["_dtaddeddate"], FALSE);
            $this->db->set("eMovementReadStatus", $params_arr["_emovementreadstatus"]);
            $this->db->insert("user_notifications");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id2";
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
     * update_read_status_request method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_read_status_request($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUserId =", $where_arr["user_id"]);
            }
            $this->db->where_in("eType", array('MovementFRequest'));
            if (isset($where_arr["movement_id"]) && $where_arr["movement_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movement_id"]);
            }

            $this->db->set("eMovementReadStatus", $params_arr["_emovementreadstatus"]);
            $res = $this->db->update("user_notifications");
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
