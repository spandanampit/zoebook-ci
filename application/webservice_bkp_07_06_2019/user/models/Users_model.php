<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Users Model
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage models
 *
 * @module Users
 *
 * @class Users_model.php
 *
 * @path application\webservice\user\models\Users_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 11.01.2019
 */

class Users_model extends CI_Model
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
     * check_user_password method is used to execute database queries for Change Password API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.09.2018
     * @param string $user_id user_id is used to process query block.
     * @param string $old_password old_password is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_password($user_id = '', $old_password = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS users_id");
            $this->db->select("u.vPassword AS password");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
            }
            $this->db->where("(u.vPassword = '".$old_password."' OR u.vTempPassword = '".$old_password."')", FALSE, FALSE);

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
     * update_user_password method is used to execute database queries for Change Password API.
     * @created CIT Dev Team
     * @modified ---
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_user_password($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["users_id"]) && $where_arr["users_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["users_id"]);
            }
            if (isset($params_arr["new_password"]))
            {
                $this->db->set("vPassword", $params_arr["new_password"]);
            }
            $this->db->set($this->db->protect("vTempPassword"), $params_arr["_vtemppassword"], FALSE);
            $res = $this->db->update("users");
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
     * get_customer_by_email_v1 method is used to execute database queries for Forgot Password API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $user_email user_email is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_customer_by_email_v1($user_email = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS users_id");
            $this->db->select("u.vName AS user_name");
            $this->db->select("u.vEmail AS users_email");
            if (isset($user_email) && $user_email != "")
            {
                $this->db->where("u.vEmail =", $user_email);
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
     * change_customer_password_v1 method is used to execute database queries for Forgot Password API.
     * @created CIT Dev Team
     * @modified ---
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function change_customer_password_v1($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["users_id"]) && $where_arr["users_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["users_id"]);
            }
            if (isset($params_arr["random_password"]))
            {
                $this->db->set("vTempPassword", $params_arr["random_password"]);
            }
            $res = $this->db->update("users");
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
     * get_user_profile method is used to execute database queries for My Profile API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @param string $profile_user_id profile_user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_profile($user_id = '', $profile_user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$user_id."' AND eStatus IN ( 'Accepted','Pending')) AS is_follwing", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$user_id."' AND eStatus IN ('Pending') ORDER BY 1 DESC LIMIT 1) AS pending_request_id", FALSE);
            $this->db->select("u.eNotificationPref AS u_notification_pref_1");
            $this->db->select("u.ePrivacy AS u_privacy_1");
            if (isset($profile_user_id) && $profile_user_id != "")
            {
                $this->db->where("u.iUsersId =", $profile_user_id);
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
     * get_my_profile method is used to execute database queries for My Profile API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_profile($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_my_id");
            $this->db->select("u.vName AS u_my_name");
            $this->db->select("u.vProfileImage AS u_my_profile_image");
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS my_follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId AND eStatus = 'Accepted') AS my_following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId AND eStatus = 'Active') AS my_post_count", FALSE);
            $this->db->select("u.vEmail AS u_my_email");
            $this->db->select("u.vPhone AS u_my_phone");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.ePrivacy AS u_privacy");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * check_email_dup method is used to execute database queries for Edit Profile API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $user_email user_email is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_email_dup($user_email = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            if (isset($user_email) && $user_email != "")
            {
                $this->db->where("u.vEmail =", $user_email);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId <>", $user_id);
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
     * update_user_details method is used to execute database queries for Edit Profile API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_user_details($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }
            $this->db->stop_cache();
            if (isset($params_arr["user_name"]))
            {
                $this->db->set("vName", $params_arr["user_name"]);
            }
            if (isset($params_arr["user_email"]))
            {
                $this->db->set("vEmail", $params_arr["user_email"]);
            }
            if (isset($params_arr["user_phone"]))
            {
                $this->db->set("vPhone", $params_arr["user_phone"]);
            }
            if (isset($params_arr["profile_image"]) && !empty($params_arr["profile_image"]))
            {
                $this->db->set("vProfileImage", $params_arr["profile_image"]);
            }
            if (isset($params_arr["about_me"]))
            {
                $this->db->set("tAboutMe", $params_arr["about_me"]);
            }
            $this->db->set($this->db->protect("dtModifiedDate"), $params_arr["_dtmodifieddate"], FALSE);
            $res = $this->db->update("users");
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
     * update_user_detail method is used to execute database queries for Edit Profile API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_user_detail($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }
            $this->db->stop_cache();
            if (isset($params_arr["user_name"]))
            {
                $this->db->set("vName", $params_arr["user_name"]);
            }
            if (isset($params_arr["user_email"]))
            {
                $this->db->set("vEmail", $params_arr["user_email"]);
            }
            if (isset($params_arr["user_phone"]))
            {
                $this->db->set("vPhone", $params_arr["user_phone"]);
            }
            if (isset($params_arr["profile_image"]) && !empty($params_arr["profile_image"]))
            {
                $this->db->set("vProfileImage", $params_arr["profile_image"]);
            }
            if (isset($params_arr["about_me"]))
            {
                $this->db->set("tAboutMe", $params_arr["about_me"]);
            }
            $this->db->set($this->db->protect("dtModifiedDate"), $params_arr["_dtmodifieddate"], FALSE);
            $res = $this->db->update("users");
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

    /**
     * get_profile_details method is used to execute database queries for Edit Profile API.
     * @created Vamsi Ippe | 11.01.2019
     * @modified Vamsi Ippe | 11.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_profile_details($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("u.vProfileImage AS u_profile_image");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * get_profile_data method is used to execute database queries for Edit Profile API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_profile_data($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id_1_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * select_user method is used to execute database queries for Login API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_email user_email is used to process query block.
     * @param string $password password is used to process query block.
     * @param string $fb_id fb_id is used to process query block.
     * @param string $g_id g_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function select_user($user_email = '', $password = '', $fb_id = '', $g_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.eStatus AS u_status");
            $this->db->select("u.eEmailVerified AS u_email_verified");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->where("(u.vEmail = '".$user_email."' AND (u.vPassword = '".$password."' OR u.vTempPassword = '".$password."') )

OR

u.vFacebookId = '".$fb_id."'

OR

u.vGoogleID = '".$g_id."'", FALSE, FALSE);

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
     * update_user_lat_long method is used to execute database queries for Login API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_user_lat_long($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["u_users_id"]) && $where_arr["u_users_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["u_users_id"]);
            }
            if (isset($params_arr["latitude"]))
            {
                $this->db->set("vLatitude", $params_arr["latitude"]);
            }
            if (isset($params_arr["longitude"]))
            {
                $this->db->set("vLongtitude", $params_arr["longitude"]);
            }
            if (isset($params_arr["device_type"]))
            {
                $this->db->set("eDeviceType", $params_arr["device_type"]);
            }
            if (isset($params_arr["device_name"]))
            {
                $this->db->set("vDeviceName", $params_arr["device_name"]);
            }
            if (isset($params_arr["app_version"]))
            {
                $this->db->set("vAppVersion", $params_arr["app_version"]);
            }
            if (isset($params_arr["device_os"]))
            {
                $this->db->set("vDeviceOs", $params_arr["device_os"]);
            }
            if (isset($params_arr["device_token"]))
            {
                $this->db->set("vDeviceToken", $params_arr["device_token"]);
            }
            $this->db->set($this->db->protect("dLastLogin"), $params_arr["_dlastlogin"], FALSE);
            $res = $this->db->update("users");
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
     * empty_devicetoken method is used to execute database queries for Device Token Update API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function empty_devicetoken($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["device_token"]) && $where_arr["device_token"] != "")
            {
                $this->db->where("vDeviceToken =", $where_arr["device_token"]);
            }

            $this->db->set($this->db->protect("vDeviceToken"), $params_arr["device_token"], FALSE);
            $res = $this->db->update("users");
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
     * update_device_token method is used to execute database queries for Device Token Update API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_device_token($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }
            if (isset($params_arr["device_token"]))
            {
                $this->db->set("vDeviceToken", $params_arr["device_token"]);
            }
            if (isset($params_arr["device_type"]))
            {
                $this->db->set("eDeviceType", $params_arr["device_type"]);
            }
            $res = $this->db->update("users");
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

    /**
     * email_duplicate_v1 method is used to execute database queries for Signup API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $user_email user_email is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function email_duplicate_v1($user_email = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            if (isset($user_email) && $user_email != "")
            {
                $this->db->where("u.vEmail =", $user_email);
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
     * insert_user method is used to execute database queries for Signup API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_user($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["user_name"]))
            {
                $this->db->set("vName", $params_arr["user_name"]);
            }
            if (isset($params_arr["user_email"]))
            {
                $this->db->set("vEmail", $params_arr["user_email"]);
            }
            if (isset($params_arr["password"]))
            {
                $this->db->set("vPassword", $params_arr["password"]);
            }
            if (isset($params_arr["lattitude"]))
            {
                $this->db->set("vLatitude", $params_arr["lattitude"]);
            }
            if (isset($params_arr["longitude"]))
            {
                $this->db->set("vLongtitude", $params_arr["longitude"]);
            }
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            if (isset($params_arr["app_version"]))
            {
                $this->db->set("vAppVersion", $params_arr["app_version"]);
            }
            if (isset($params_arr["device_os"]))
            {
                $this->db->set("vDeviceOs", $params_arr["device_os"]);
            }
            if (isset($params_arr["device_name"]))
            {
                $this->db->set("vDeviceName", $params_arr["device_name"]);
            }
            if (isset($params_arr["device_type"]))
            {
                $this->db->set("eDeviceType", $params_arr["device_type"]);
            }
            $this->db->set($this->db->protect("eEmailVerified"), $params_arr["_eemailverified"], FALSE);
            if (isset($params_arr["mobile_num"]))
            {
                $this->db->set("vPhone", $params_arr["mobile_num"]);
            }
            if (isset($params_arr["profile_image"]) && !empty($params_arr["profile_image"]))
            {
                $this->db->set("vProfileImage", $params_arr["profile_image"]);
            }
            $this->db->set($this->db->protect("eNotificationPref"), $params_arr["_enotificationpref"], FALSE);
            $this->db->insert("users");
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
     * get_activate_url method is used to execute database queries for Signup API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $insert_id insert_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_activate_url($insert_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.eEmailVerified AS u_email_verified");
            $this->db->select("u.eStatus AS u_status");
            $this->db->select("(CONCAT('WS/account_activation?user_id=',u.iUsersId)) AS activation_url", FALSE);
            if (isset($insert_id) && $insert_id != "")
            {
                $this->db->where("u.iUsersId =", $insert_id);
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
     * update_aactive method is used to execute database queries for Account Activation API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_aactive($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set("eEmailVerified", $params_arr["_eemailverified"]);
            $res = $this->db->update("users");
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
     * users_exist method is used to execute database queries for Check Existed Accounts API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 11.09.2018
     * @param string $facebook_id facebook_id is used to process query block.
     * @param string $google_id google_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function users_exist($facebook_id = '', $google_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vLatitude AS u_latitude");
            $this->db->select("u.vLongtitude AS u_longtitude");
            $this->db->select("u.vDeviceToken AS u_device_token");
            $this->db->select("u.eDeviceType AS u_device_type");
            $this->db->select("u.vDeviceName AS u_device_name");
            $this->db->select("u.vAppVersion AS u_app_version");
            $this->db->select("u.vDeviceOs AS u_device_os");
            $this->db->where_in("u.eStatus", array('Active'));
            $this->db->where("CASE
WHEN LENGTH('".$facebook_id."') > 0 THEN u.vFacebookId =  '".$facebook_id."'
WHEN LENGTH('".$google_id."') > 0 THEN u.vGoogleID =  '".$google_id."'
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
     * check_dup_fbid_google method is used to execute database queries for Social Signup API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 26.09.2018
     * @param string $facebook_id facebook_id is used to process query block.
     * @param string $google_id google_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_dup_fbid_google($facebook_id = '', $google_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->where("CASE
 WHEN	'".$facebook_id."' != '' THEN u.vFacebookId = '".$facebook_id."'
 WHEN '".$google_id."' != '' THEN u.vGoogleID = '".$google_id."'
END", FALSE, FALSE);

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
     * insert_social_user method is used to execute database queries for Social Signup API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_social_user($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["user_name"]))
            {
                $this->db->set("vName", $params_arr["user_name"]);
            }
            if (isset($params_arr["user_email"]))
            {
                $this->db->set("vEmail", $params_arr["user_email"]);
            }
            $this->db->set("vPassword", $params_arr["_vpassword"]);
            if (isset($params_arr["lattitude"]))
            {
                $this->db->set("vLatitude", $params_arr["lattitude"]);
            }
            if (isset($params_arr["longitude"]))
            {
                $this->db->set("vLongtitude", $params_arr["longitude"]);
            }
            if (isset($params_arr["facebook_id"]))
            {
                $this->db->set("vFacebookId", $params_arr["facebook_id"]);
            }
            if (isset($params_arr["google_id"]))
            {
                $this->db->set("vGoogleID", $params_arr["google_id"]);
            }
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            if (isset($params_arr["app_version"]))
            {
                $this->db->set("vAppVersion", $params_arr["app_version"]);
            }
            if (isset($params_arr["device_os"]))
            {
                $this->db->set("vDeviceOs", $params_arr["device_os"]);
            }
            if (isset($params_arr["device_name"]))
            {
                $this->db->set("vDeviceName", $params_arr["device_name"]);
            }
            if (isset($params_arr["device_type"]))
            {
                $this->db->set("eDeviceType", $params_arr["device_type"]);
            }
            $this->db->set($this->db->protect("eEmailVerified"), $params_arr["_eemailverified"], FALSE);
            if (isset($params_arr["profile_image_social"]))
            {
                $this->db->set("vProfileImage", $params_arr["profile_image_social"]);
            }
            if (isset($params_arr["mobile_num"]))
            {
                $this->db->set("vPhone", $params_arr["mobile_num"]);
            }
            $this->db->set($this->db->protect("eNotificationPref"), $params_arr["_enotificationpref"], FALSE);
            $this->db->insert("users");
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
     * get_user_data method is used to execute database queries for Search friends API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 10.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_data($params_arr = array(), $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT eStatus FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$params_arr["user_id"]."' AND eStatus IN ('Accepted','Pending')) AS is_follwing", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId  AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId  AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("(ROUND(GeoDistMiles(u.vLatitude,u.vLongtitude,'".$params_arr["latitude"]."','".$params_arr["longitude"]."','km'),2)) AS distance_kms", FALSE);
            $this->db->select("(SELECT iUserFollowerId FROM user_followers WHERE iUserId  = u.iUsersId AND iFollowerId = '".$params_arr["user_id"]."' AND eStatus IN ('Pending')) AS pending_request_id", FALSE);
            $this->db->where_in("u.eStatus", array('Active'));
            $this->db->where_in("u.eEmailVerified", array('1'));
            if (isset($params_arr["user_id"]) && $params_arr["user_id"] != "")
            {
                $this->db->where("u.iUsersId <>", $params_arr["user_id"]);
            }
            $this->db->where_in("u.ePrivacy", array('0'));
            $this->db->where("(u.vName LIKE '%".$params_arr["keyword"]."%' OR u.vEmail LIKE '%".$params_arr["keyword"]."%')", FALSE, FALSE);

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $settings_params['count'] = $total_records;

            $record_limit = 20;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("IF('".$params_arr["latitude"]."' != '',distance_kms, u.vName) ASC", FALSE, FALSE);
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
     * get_notify_user_details method is used to execute database queries for Follow Request API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $following_user_id following_user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_notify_user_details($following_user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("u.vDeviceToken AS u_device_token");
            $this->db->select("u.eDeviceType AS u_device_type");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iUserId  = u.iUsersId  AND eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(iUserFollowerId) FROM user_followers WHERE iFollowerId = u.iUsersId  AND eStatus = 'Accepted') AS following_count", FALSE);
            $this->db->select("(SELECT count(iPostId) FROM post WHERE iUserId =  u.iUsersId  AND eStatus = 'Active') AS post_count", FALSE);
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            if (isset($following_user_id) && $following_user_id != "")
            {
                $this->db->where("u.iUsersId =", $following_user_id);
            }
            $this->db->where_in("u.eStatus", array('Active'));

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
     * get_user_details method is used to execute database queries for Follow Request API.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_details($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.vName AS follower_name");
            $this->db->select("u.vEmail AS follower_email");
            $this->db->select("u.vProfileImage AS follower_profile_image");
            $this->db->select("(CONCAT(\"You have a new follow request from \",u.vName)) AS notification_text", FALSE);
            $this->db->select("u.iUsersId AS notify_users_id");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * update_current_user_lat_long method is used to execute database queries for Update User Location API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_current_user_lat_long($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }
            if (isset($params_arr["latitude"]))
            {
                $this->db->set("vLatitude", $params_arr["latitude"]);
            }
            if (isset($params_arr["longitude"]))
            {
                $this->db->set("vLongtitude", $params_arr["longitude"]);
            }
            $res = $this->db->update("users");
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
     * check_user method is used to execute database queries for Add Post API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
            }
            $this->db->where_in("u.eStatus", array('Active'));

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
     * get_liked_user_details method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 23.10.2018
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_liked_user_details($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.vName AS liked_name");
            $this->db->select("u.iUsersId AS liked_users_id");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * get_commented_user_details method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_commented_user_details($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * get_commented_user_details_v1 method is used to execute database queries for Reply on comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_commented_user_details_v1($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * get_user_name method is used to execute database queries for Send Post Notification API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_name($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * get_commet_liked_user_data method is used to execute database queries for Like Comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_commet_liked_user_data($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.vName AS liked_name");
            $this->db->select("u.iUsersId AS liked_users_id");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
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
     * update_notification_status method is used to execute database queries for Notification Preference Change API.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_notification_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }
            if (isset($params_arr["status"]))
            {
                $this->db->set("eNotificationPref", $params_arr["status"]);
            }
            $this->db->set($this->db->protect("dtModifiedDate"), $params_arr["_dtmodifieddate"], FALSE);
            $res = $this->db->update("users");
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
     * update_privacy_status method is used to execute database queries for Privacy Preference Change API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 28.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_privacy_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }

            $this->db->set($this->db->protect("dtModifiedDate"), $params_arr["_dtmodifieddate"], FALSE);
            if (isset($params_arr["status"]))
            {
                $this->db->set("ePrivacy", $params_arr["status"]);
            }
            $res = $this->db->update("users");
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
     * get_activate_url_for_resend method is used to execute database queries for Resend Verification Email API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $email email is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_activate_url_for_resend($email = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.eEmailVerified AS u_email_verified");
            $this->db->select("u.eStatus AS u_status");
            $this->db->select("(CONCAT('WS/account_activation?user_id=',u.iUsersId)) AS activation_url", FALSE);
            $this->db->select("u.vPassword AS u_password");
            if (isset($email) && $email != "")
            {
                $this->db->where("u.vEmail =", $email);
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
     * check_user_v1 method is used to execute database queries for Share Post API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_user_v1($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("users AS u");

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("u.iUsersId =", $user_id);
            }
            $this->db->where_in("u.eStatus", array('Active'));

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
     * clear_device_token method is used to execute database queries for logout API.
     * @created  | 11.01.2019
     * @modified  | 11.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function clear_device_token($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUsersId =", $where_arr["user_id"]);
            }

            $this->db->set($this->db->protect("vDeviceToken"), $params_arr["_vdevicetoken"], FALSE);
            $res = $this->db->update("users");
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
