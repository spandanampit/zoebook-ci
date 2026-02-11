<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Comment Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post Comment
 *
 * @class Post_comment_model.php
 *
 * @path application\webservice\post\models\Post_comment_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 11.01.2019
 */

class Post_comment_model extends CI_Model
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
     * insert_comment method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_comment($params_arr = array())
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
            $this->db->set($this->db->protect("iParentId"), $params_arr["_iparentid"], FALSE);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["comment"]))
            {
                $this->db->set("tComment", $params_arr["comment"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["upload_file"]) && !empty($params_arr["upload_file"]))
            {
                $this->db->set("vUploadFile", $params_arr["upload_file"]);
            }
            if (isset($params_arr["var_ipostmedia_id"]))
            {
                $this->db->set("iPostMediaId", $params_arr["var_ipostmedia_id"]);
            }
            $this->db->insert("post_comment");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "comment_id";
            $result_arr[0][$result_param] = $insert_id;
            $success = 1;

            $this->db->where("iPostCommentId", $insert_id);
            $this->db->select("iUserId");
            $data_obj = $this->db->get("post_comment");
            $data_arr = is_object($data_obj) ? $data_obj->result_array() : array();
            $return_arr["array"] = $data_arr;
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
     * get_all_commented_users method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param string $post_id post_id is used to process query block.
     * @param string $posted_by_user_id posted_by_user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_all_commented_users($post_id = '', $posted_by_user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");
            $this->db->join("users AS u", "pc.iUserId = u.iUsersId", "left");

            $this->db->select("u.vDeviceToken AS commented_user_device_token");
            $this->db->select("u.iUsersId AS commented_users_id");
            $this->db->select("u.eDeviceType AS commented_user_device_type");
            $this->db->select("u.eNotificationPref AS commented_user_notification_pref");
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
            }
            if (isset($posted_by_user_id) && $posted_by_user_id != "")
            {
                $this->db->where("pc.iUserId <>", $posted_by_user_id);
            }

            $this->db->group_by(array("pc.iUserId"));

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
     * update_comment method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_comment($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["post_comment_id"]) && $where_arr["post_comment_id"] != "")
            {
                $this->db->where("iPostCommentId =", $where_arr["post_comment_id"]);
            }
            if (isset($where_arr["post_id"]) && $where_arr["post_id"] != "")
            {
                $this->db->where("iPostId =", $where_arr["post_id"]);
            }
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUserId =", $where_arr["user_id"]);
            }
            if (isset($params_arr["comment"]))
            {
                $this->db->set("tComment", $params_arr["comment"]);
            }
            if (isset($params_arr["upload_file"]) && !empty($params_arr["upload_file"]))
            {
                $this->db->set("vUploadFile", $params_arr["upload_file"]);
            }
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["var_ipostmedia_id"]))
            {
                $this->db->set("iPostMediaId", $params_arr["var_ipostmedia_id"]);
            }
            $res = $this->db->update("post_comment");
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
     * check_comment_already_exists method is used to execute database queries for Comment On Post API.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_comment_already_exists($post_comment_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");

            $this->db->select("pc.iPostCommentId AS pc_post_comment_id");
            $this->db->select("pc.iPostId AS pc_post_id");
            $this->db->select("pc.iUserId AS pc_user_id");
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("pc.iPostCommentId =", $post_comment_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
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
     * insert_comment_reply method is used to execute database queries for Reply on comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_comment_reply($params_arr = array())
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
            if (isset($params_arr["post_comment_id"]))
            {
                $this->db->set("iParentId", $params_arr["post_comment_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["reply_text"]))
            {
                $this->db->set("tComment", $params_arr["reply_text"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["upload_file"]) && !empty($params_arr["upload_file"]))
            {
                $this->db->set("vUploadFile", $params_arr["upload_file"]);
            }
            $this->db->insert("post_comment");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "comment_reply_id";
            $result_arr[0][$result_param] = $insert_id;
            $success = 1;

            $this->db->where("iPostCommentId", $insert_id);
            $this->db->select("iUserId");
            $data_obj = $this->db->get("post_comment");
            $data_arr = is_object($data_obj) ? $data_obj->result_array() : array();
            $return_arr["array"] = $data_arr;
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
     * check_replied_comment_exists method is used to execute database queries for Reply on comment API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_replied_comment_exists($post_comment_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");
            $this->db->join("users AS u", "pc.iUserId = u.iUsersId", "left");

            $this->db->select("pc.iPostCommentId AS pc_post_comment_id");
            $this->db->select("pc.iPostId AS pc_post_id");
            $this->db->select("u.iUsersId AS commented_users_id");
            $this->db->select("u.eDeviceType AS commented_device_type");
            $this->db->select("u.vDeviceToken AS commented_device_token");
            $this->db->select("u.eNotificationPref AS commented_notification_pref");
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("pc.iPostCommentId =", $post_comment_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
            }
            $this->db->where_in("pc.eStatus", array('Active'));

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
     * get_comments method is used to execute database queries for Comments List API.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @param string $var_ipostmedia_id var_ipostmedia_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_comments($user_id = '', $post_id = '', $var_ipostmedia_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");
            $this->db->join("users AS u", "pc.iUserId = u.iUsersId", "left");

            $this->db->select("pc.iPostCommentId AS pc_post_comment_id");
            $this->db->select("pc.iPostId AS pc_post_id");
            $this->db->select("pc.tComment AS pc_comment");
            $this->db->select("pc.dAddedDate AS pc_added_date");
            $this->db->select("u.vName AS user_name");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iPostCommentLikeId) FROM post_comment_like WHERE iPostCommentId = pc.iPostCommentId AND iPostId = pc.iPostId) AS count_comment_likes", FALSE);
            $this->db->select("(SELECT count(iPostCommentLikeId) FROM post_comment_like WHERE iPostCommentId = pc.iPostCommentId AND iPostId = pc.iPostId AND iUserId = '".$user_id."') AS is_comment_like", FALSE);
            $this->db->select("(SELECT count(iPostCommentId) FROM post_comment WHERE iPostId = pc.iPostId AND iParentId = pc.iPostCommentId AND eStatus = 'Active') AS reply_count", FALSE);
            $this->db->select("pc.vUploadFile AS pc_upload_file");
            $this->db->select("pc.iUserId AS pc_user_id");
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
            }
            $this->db->where_in("pc.eStatus", array('Active'));
            $this->db->where("pc.iParentId = ('0')", FALSE, FALSE);
            if (isset($var_ipostmedia_id) && $var_ipostmedia_id != "")
            {
                $this->db->where("pc.iPostMediaId =", $var_ipostmedia_id);
            }

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
     * get_replies method is used to execute database queries for Replies List API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_replies($user_id = '', $post_id = '', $post_comment_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");
            $this->db->join("users AS u", "pc.iUserId = u.iUsersId", "left");

            $this->db->select("pc.iPostCommentId AS pc_post_comment_id");
            $this->db->select("pc.iPostId AS pc_post_id");
            $this->db->select("pc.tComment AS pc_comment");
            $this->db->select("pc.dAddedDate AS pc_added_date");
            $this->db->select("u.vName AS user_name");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iPostCommentLikeId) FROM post_comment_like WHERE iPostCommentId = pc.iPostCommentId AND iPostId = pc.iPostId) AS count_reply_likes", FALSE);
            $this->db->select("(SELECT count(iPostCommentLikeId) FROM post_comment_like WHERE iPostCommentId = pc.iPostCommentId AND iPostId = pc.iPostId AND iUserId = '".$user_id."') AS is_reply_like", FALSE);
            $this->db->select("pc.iUserId AS pc_user_id");
            $this->db->select("pc.iParentId AS pc_parent_id");
            $this->db->select("pc.vUploadFile AS pc_upload_file");
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
            }
            $this->db->where_in("pc.eStatus", array('Active'));
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("pc.iParentId =", $post_comment_id);
            }

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
     * check_comment_exists method is used to execute database queries for Replies List API.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 24.09.2018
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_comment_exists($post_comment_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");

            $this->db->select("pc.iPostCommentId AS pc_post_comment_id_1");
            $this->db->select("pc.iPostId AS pc_post_id_1");
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("pc.iPostCommentId =", $post_comment_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
            }
            $this->db->where_in("pc.eStatus", array('Active'));

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
     * get_commented_user_data method is used to execute database queries for Like Comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 16.10.2018
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_commented_user_data($post_comment_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS p");
            $this->db->join("users AS u", "p.iUserId = u.iUsersId", "left");

            $this->db->select("u.iUsersId AS commented_users_id");
            $this->db->select("u.eNotificationPref AS commented_notification_pref");
            $this->db->select("u.vDeviceToken AS commented_device_token");
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("p.iPostCommentId =", $post_comment_id);
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
     * insert_post_media_comments method is used to execute database queries for Comment Post Media API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified  | 02.11.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_post_media_comments($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["media_id"]))
            {
                $this->db->set("iPostMediaId", $params_arr["media_id"]);
            }
            if (isset($params_arr["post_id"]))
            {
                $this->db->set("iPostId", $params_arr["post_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["comment_text"]))
            {
                $this->db->set("tComment", $params_arr["comment_text"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->insert("post_comment");
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
     * get_post_media_comments_v1 method is used to execute database queries for Get Post Media Comments API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_comments_v1($media_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");
            $this->db->join("post_media AS pm", "pc.iPostMediaId = pm.iPostMediaId", "left");
            $this->db->join("users AS u", "pc.iUserId = u.iUsersId", "left");

            $this->db->select("u.vName AS u_name1");
            $this->db->select("(SELECT count(iPostMediaLikesId) FROM `post_media_likes` WHERE  iPostMediaId = pm.iPostMediaId) AS count_post_media_comment_likes1", FALSE);
            $this->db->select("(SELECT count(iPostMediaLikesId) FROM `post_media_likes` WHERE  iPostMediaId = pm.iPostMediaId And iUserId = u.iUsersId) AS is_post_media_comment_like1", FALSE);
            $this->db->select("(SELECT count(iPostMediaId) FROM `post_media` WHERE iPostId = pm.iPostId ANd iParentCommentId = pm.iPostMediaId AND eStatus = 'Active') AS is_reply_count1", FALSE);
            $this->db->select("pc.iPostCommentId AS pc_post_comment_id");
            $this->db->select("pc.iPostMediaId AS pc_post_media_id");
            $this->db->select("pc.tComment AS pc_comment");
            $this->db->select("pc.dAddedDate AS pc_added_date");
            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("pc.iPostId AS pc_post_id");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("pm.iUserId AS pm_user_id");
            $this->db->select("pc.iParentId AS pc_parent_id");
            if (isset($media_id) && $media_id != "")
            {
                $this->db->where("pc.iPostMediaId =", $media_id);
            }
            $this->db->where_in("pc.eStatus", array('Active'));

            $this->db->order_by("pc.dAddedDate", "desc");

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
     * delete_comment method is used to execute database queries for Delete Comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_comment($post_comment_id = '', $post_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("iPostCommentId =", $post_comment_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("iPostId =", $post_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iUserId =", $user_id);
            }
            $res = $this->db->delete("post_comment");
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
     * check_comment_exist_to_delete method is used to execute database queries for Delete Comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param string $post_comment_id post_comment_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_comment_exist_to_delete($post_comment_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_comment AS pc");

            $this->db->select("pc.iPostCommentId AS pc_post_comment_id");
            $this->db->select("pc.iPostId AS pc_post_id");
            $this->db->select("pc.iUserId AS pc_user_id");
            if (isset($post_comment_id) && $post_comment_id != "")
            {
                $this->db->where("pc.iPostCommentId =", $post_comment_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pc.iPostId =", $post_id);
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
}
