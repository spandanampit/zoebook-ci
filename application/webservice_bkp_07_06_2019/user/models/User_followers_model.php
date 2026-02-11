<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Followers Model
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage models
 *
 * @module User Followers
 *
 * @class User_followers_model.php
 *
 * @path application\webservice\user\models\User_followers_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 07.01.2019
 */

class User_followers_model extends CI_Model
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
     * add_follow_request method is used to execute database queries for Follow Request API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function add_follow_request($params_arr = array())
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
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iFollowerId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->insert("user_followers");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "user_follower_Id";
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
     * check_req_exist_status method is used to execute database queries for Follow Request API.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param string $following_user_id following_user_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_req_exist_status($following_user_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");

            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            $this->db->select("uf.eStatus AS uf_status");
            if (isset($following_user_id) && $following_user_id != "")
            {
                $this->db->where("uf.iUserId =", $following_user_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("uf.iFollowerId =", $user_id);
            }
            $this->db->where_in("uf.eStatus", array('Pending', 'Accepted'));

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
     * update_follow_status method is used to execute database queries for Follow Accept Reject Cancel API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_follow_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_follow_request_id"]) && $where_arr["user_follow_request_id"] != "")
            {
                $this->db->where("iUserFollowerId =", $where_arr["user_follow_request_id"]);
            }
            if (isset($params_arr["status"]))
            {
                $this->db->set("eStatus", $params_arr["status"]);
            }
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("user_followers");
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
     * check_status method is used to execute database queries for Follow Accept Reject Cancel API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 15.10.2018
     * @param string $user_follow_request_id user_follow_request_id is used to process query block.
     * @param string $status status is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_status($user_follow_request_id = '', $status = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");
            $this->db->join("users AS u", "uf.iUserId = u.iUsersId", "left");
            $this->db->join("users AS u1", "uf.iFollowerId = u1.iUsersId", "left");

            $this->db->select("uf.eStatus AS uf_status");
            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            $this->db->select("uf.iUserId AS uf_user_id");
            $this->db->select("uf.iFollowerId AS uf_follower_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u1.eDeviceType AS u1_device_type");
            $this->db->select("u1.vDeviceName AS u1_device_name");
            $this->db->select("u1.vDeviceToken AS u1_device_token");
            $this->db->select("u1.vName AS u1_name");
            $this->db->select("u1.vEmail AS u1_email");
            $this->db->select("u1.iUsersId AS u1_users_id");
            $this->db->select("u1.eNotificationPref AS u1_notification_pref");
            $this->db->select("u.iUsersId AS u_users_id");
            if (isset($user_follow_request_id) && $user_follow_request_id != "")
            {
                $this->db->where("uf.iUserFollowerId =", $user_follow_request_id);
            }
            $this->db->where("CASE '".$status."'
	WHEN 'Accepted' THEN uf.iUserId = '".$user_id."'
	WHEN 'Rejected' THEN uf.iUserId = '".$user_id."'
	WHEN 'Deleted' THEN uf.iFollowerId = '".$user_id."'
	ELSE TRUE
END

", FALSE, FALSE);

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
     * get_follow_request method is used to execute database queries for My Following Requests API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_follow_request($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");
            $this->db->join("users AS u", "uf.iUserId = u.iUsersId", "left");

            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            $this->db->select("uf.eStatus AS uf_status");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId  AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId  AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("u.iUsersId AS u_users_id");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("uf.iFollowerId =", $user_id);
            }
            $this->db->where_in("uf.eStatus", array('Pending'));

            $this->db->order_by("uf.iUserFollowerId", "desc");

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
     * get_follower_requests method is used to execute database queries for My Follower Requests API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_follower_requests($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");
            $this->db->join("users AS u", "uf.iFollowerId = u.iUsersId", "left");

            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            $this->db->select("uf.eStatus AS uf_status");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId  AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId  AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->where_in("uf.eStatus", array('Pending'));
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("uf.iUserId =", $user_id);
            }

            $this->db->order_by("uf.iUserFollowerId", "desc");

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
     * update_follow_request method is used to execute database queries for Unfollow User API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_follow_request($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["following_user_id"]) && $where_arr["following_user_id"] != "")
            {
                $this->db->where("iUserId =", $where_arr["following_user_id"]);
            }
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iFollowerId =", $where_arr["user_id"]);
            }
            $this->db->where_in("eStatus", array('Accepted'));

            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $res = $this->db->update("user_followers");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
            $result_param = "user_follower_Id";
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
     * get_follow_status method is used to execute database queries for Unfollow User API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.09.2018
     * @param string $following_user_id following_user_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_follow_status($following_user_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");

            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            if (isset($following_user_id) && $following_user_id != "")
            {
                $this->db->where("uf.iUserId =", $following_user_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("uf.iFollowerId =", $user_id);
            }
            $this->db->where_in("uf.eStatus", array('Accepted'));

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
     * get_following_users method is used to execute database queries for User Following API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_following_users($params_arr = array())
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");
            $this->db->join("users AS u", "uf.iUserId = u.iUsersId", "left");

            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            $this->db->select("uf.eStatus AS uf_status");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId  AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId  AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$params_arr["user_id"]."' AND eStatus IN ('Accepted','Pending')) AS is_following", FALSE);
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$params_arr["user_id"]."' AND eStatus IN ('Pending')) AS pending_request_id", FALSE);
            if (isset($params_arr["profile_user_id"]) && $params_arr["profile_user_id"] != "")
            {
                $this->db->where("uf.iFollowerId =", $params_arr["profile_user_id"]);
            }
            $this->db->where_in("uf.eStatus", array('Accepted'));
            if (isset($params_arr["user_id"]) && $params_arr["user_id"] != "")
            {
                $this->db->where("uf.iUserId <>", $params_arr["user_id"]);
            }
            $this->db->where("IF('".$params_arr["user_id"]."' != '".$params_arr["profile_user_id"]."',uf.iFollowerId != '".$params_arr["user_id"]."',TRUE)", FALSE, FALSE);

            $this->db->group_by(array("uf.iUserId"));
            $this->db->order_by("u.vName", "asc");

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
     * get_my_followers method is used to execute database queries for User Followers API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @param string $profile_user_id profile_user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_followers($user_id = '', $profile_user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");
            $this->db->join("users AS u", "uf.iFollowerId = u.iUsersId", "left");

            $this->db->select("uf.iUserFollowerId AS uf_user_follower_id");
            $this->db->select("uf.eStatus AS uf_status");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId  AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId  AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$user_id."' AND eStatus IN ('Accepted','Pending')) AS is_following", FALSE);
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$user_id."' AND eStatus IN ('Pending')) AS pending_request_id", FALSE);
            $this->db->where_in("uf.eStatus", array('Accepted'));
            if (isset($profile_user_id) && $profile_user_id != "")
            {
                $this->db->where("uf.iUserId =", $profile_user_id);
            }
            $this->db->where("uf.iFollowerId != '".$user_id."'", FALSE, FALSE);

            $this->db->order_by("u.vName", "asc");

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
     * check_user_followers method is used to execute database queries for Send Post Notification API.
     * @created CIT Dev Team
     * @modified Anjaneyulu Gulla | 24.10.2018
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_followers($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("user_followers AS uf");
            $this->db->join("users AS u", "uf.iFollowerId = u.iUsersId", "left");

            $this->db->select("u.vDeviceToken AS user_device_token");
            $this->db->select("u.iUsersId AS follower_users_id");
            $this->db->select("u.eNotificationPref AS user_notification_pref");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("uf.iUserId =", $user_id);
            }
            $this->db->where_in("uf.eStatus", array('Accepted'));
            $this->db->where_in("u.eStatus", array('Active'));

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
}
