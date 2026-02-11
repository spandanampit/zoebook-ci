<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Media Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post Media
 *
 * @class Post_media_model.php
 *
 * @path application\webservice\post\models\Post_media_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.02.2019
 */

class Post_media_model extends CI_Model
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
     * insert_post_media method is used to execute database queries for Add Post Media API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified  | 17.01.2019
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_post_media($params_arr = array())
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
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["upload_file"]) && !empty($params_arr["upload_file"]))
            {
                $this->db->set("vUploadFile", $params_arr["upload_file"]);
            }
            if (isset($params_arr["file_type"]))
            {
                $this->db->set("eMediaType", $params_arr["file_type"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["video_thumbnail"]) && !empty($params_arr["video_thumbnail"]))
            {
                $this->db->set("vVideoThumbnail", $params_arr["video_thumbnail"]);
            }
            $this->db->insert("post_media");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id";
            $result_arr[0][$result_param] = $insert_id;
            $success = 1;

            $this->db->where("iPostMediaId", $insert_id);
            $this->db->select("iUserId", "iUserId");
            $data_obj = $this->db->get("post_media");
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
     * get_my_post_media method is used to execute database queries for Post List API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 01.02.2019
     * @param string $p_post_id p_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_post_media($p_post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostId AS pm_post_id");
            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.eMediaType AS pm_media_type");
            $this->db->select("pm.iUserId AS pm_user_id");
            $this->db->select("pm.vUploadFile AS pm_upload_file");
            $this->db->select("pm.dAddedDate AS pm_added_date");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail");
            $this->db->select("(".$this->db->escape("").") AS display_image", FALSE);
            $this->db->select("pm.iViewsCount AS pm_views_count_1");
            if (isset($p_post_id) && $p_post_id != "")
            {
                $this->db->where("pm.iPostId =", $p_post_id);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

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
     * get_user_post_media method is used to execute database queries for Post List API.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 01.02.2019
     * @param string $p_post_id_1 p_post_id_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_post_media($p_post_id_1 = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id_1");
            $this->db->select("pm.iPostId AS pm_post_id_1");
            $this->db->select("pm.eMediaType AS pm_media_type_1");
            $this->db->select("pm.iUserId AS pm_user_id_1");
            $this->db->select("pm.vUploadFile AS pm_upload_file_1");
            $this->db->select("pm.dAddedDate AS pm_added_date_1");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail_1");
            $this->db->select("(".$this->db->escape("").") AS display_image_1", FALSE);
            $this->db->select("pm.iViewsCount AS pm_views_count_3");
            if (isset($p_post_id_1) && $p_post_id_1 != "")
            {
                $this->db->where("pm.iPostId =", $p_post_id_1);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

            $this->db->order_by("pm.iPostMediaId", "asc");

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
     * get_actual_post_media method is used to execute database queries for Post List API.
     * @created Anjaneyulu Gulla | 25.10.2018
     * @modified Vamsi Ippe | 01.02.2019
     * @param string $p_actual_post_id p_actual_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_actual_post_media($p_actual_post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostId AS pm_post_id_2");
            $this->db->select("pm.iPostMediaId AS pm_post_media_id_2");
            $this->db->select("pm.eMediaType AS pm_media_type_2");
            $this->db->select("pm.iUserId AS pm_user_id_2");
            $this->db->select("pm.vUploadFile AS pm_upload_file_2");
            $this->db->select("pm.dAddedDate AS pm_added_date_2");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail_2");
            $this->db->select("(".$this->db->escape("").") AS display_image_2", FALSE);
            $this->db->select("pm.iViewsCount AS pm_views_count");
            if (isset($p_actual_post_id) && $p_actual_post_id != "")
            {
                $this->db->where("pm.iPostId =", $p_actual_post_id);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

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
     * get_uesr_post_media method is used to execute database queries for Post List API.
     * @created Anjaneyulu Gulla | 26.10.2018
     * @modified Vamsi Ippe | 01.02.2019
     * @param string $p_actual_post_id_1 p_actual_post_id_1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_uesr_post_media($p_actual_post_id_1 = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostId AS pm_post_id_3");
            $this->db->select("pm.iPostMediaId AS pm_post_media_id_3");
            $this->db->select("pm.eMediaType AS pm_media_type_3");
            $this->db->select("pm.iUserId AS pm_user_id_3");
            $this->db->select("pm.vUploadFile AS pm_upload_file_3");
            $this->db->select("pm.dAddedDate AS pm_added_date_3");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail_3");
            $this->db->select("(".$this->db->escape("").") AS display_image_3", FALSE);
            $this->db->select("pm.iViewsCount AS pm_views_count_2");
            if (isset($p_actual_post_id_1) && $p_actual_post_id_1 != "")
            {
                $this->db->where("pm.iPostId =", $p_actual_post_id_1);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

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
     * get_post_media method is used to execute database queries for Post Detail API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $user_id user_id is used to process query block.
     * @param string $p_post_id p_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media($user_id = '', $p_post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.vUploadFile AS pm_upload_file");
            $this->db->select("pm.dAddedDate AS pm_added_date");
            $this->db->select("pm.iUserId AS pm_user_id");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail");
            $this->db->select("pm.eMediaType AS pm_media_type");
            $this->db->select("(".$this->db->escape("").") AS display_image", FALSE);
            $this->db->select("((IF((SELECT COUNT(pml.iPostMediaLikesId) FROM post_media_likes pml WHERE pml.iPostMediaId = pm.iPostMediaId AND pml.eStatus=1 AND pml.iUserId='".$user_id."')>0,1,0))) AS is_liked", FALSE);
            $this->db->select("((SELECT COUNT(pml.iPostMediaLikesId) FROM post_media_likes pml WHERE pml.iPostMediaId = pm.iPostMediaId AND pml.eStatus=1)) AS total_likes_count", FALSE);
            $this->db->select("((SELECT count(iPostCommentId) FROM post_comment WHERE iPostId = pm.iPostId AND iParentId = 0 AND eStatus = 'Active' AND iPostMediaId = pm.iPostMediaId)) AS total_comments_count", FALSE);
            $this->db->select("pm.iPostId AS pm_post_id");
            $this->db->select("pm.iViewsCount AS pm_views_count");
            if (isset($p_post_id) && $p_post_id != "")
            {
                $this->db->where("pm.iPostId =", $p_post_id);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

            $this->db->order_by("pm.iPostMediaId", "asc");

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
     * get_post_media_list method is used to execute database queries for Post Detail API.
     * @created  | 02.11.2018
     * @modified  | 02.11.2018
     * @param string $post_media_id post_media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_list($post_media_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id_1");
            $this->db->select("pm.iPostId AS pm_post_id_1");
            if (isset($post_media_id) && $post_media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $post_media_id);
            }
            $this->db->where("1=2", FALSE, FALSE);

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
     * get_post_media_info method is used to execute database queries for Comment On Post API.
     * @created CIT Dev Team
     * @modified  | 02.11.2018
     * @param string $post_media_id post_media_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_info($post_media_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.iPostId AS pm_post_id");
            if (isset($post_media_id) && $post_media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $post_media_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pm.iPostId =", $post_id);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

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
     * get_post_media_info_v1 method is used to execute database queries for Comments List API.
     * @created CIT Dev Team
     * @modified  | 02.11.2018
     * @param string $post_media_id post_media_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_media_info_v1($post_media_id = '', $post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.iPostId AS pm_post_id");
            if (isset($post_media_id) && $post_media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $post_media_id);
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pm.iPostId =", $post_id);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

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
     * get_media_post_media method is used to execute database queries for User Albums API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param string $p_post_id p_post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_media_post_media($p_post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostId AS pm_post_id");
            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.eMediaType AS pm_media_type");
            $this->db->select("pm.iUserId AS pm_user_id");
            $this->db->select("pm.vUploadFile AS pm_upload_file");
            $this->db->select("pm.dAddedDate AS pm_added_date");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail");
            $this->db->select("(".$this->db->escape("").") AS display_image", FALSE);
            if (isset($p_post_id) && $p_post_id != "")
            {
                $this->db->where("pm.iPostId =", $p_post_id);
            }
            $this->db->where_in("pm.eStatus", array('Active'));

            $this->db->order_by("pm.iPostMediaId", "asc");

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
     * get_media method is used to execute database queries for Delete Media API.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param string $post_media_id post_media_id is used to process query block.
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_media($post_media_id = '', $post_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.eMediaType AS pm_media_type");
            $this->db->select("pm.iUserId AS pm_user_id");
            $this->db->select("pm.vUploadFile AS pm_upload_file");
            $this->db->select("pm.vVideoThumbnail AS pm_video_thumbnail");
            if ($tmp_arr = filterEmptyValues($post_media_id))
            {
                $old_arr = $post_media_id;
                $post_media_id = $tmp_arr;
                $this->db->where_in("pm.iPostMediaId", $post_media_id);
                $post_media_id = $old_arr;
            }
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pm.iPostId =", $post_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("pm.iUserId =", $user_id);
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
     * delete_media_individual method is used to execute database queries for Delete Media API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 27.09.2018
     * @param string $post_id post_id is used to process query block.
     * @param string $post_media_id post_media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_media_individual($post_id = '', $post_media_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("iPostId =", $post_id);
            }
            if ($tmp_arr = filterEmptyValues($post_media_id))
            {
                $old_arr = $post_media_id;
                $post_media_id = $tmp_arr;
                $this->db->where_in("iPostMediaId", $post_media_id);
                $post_media_id = $old_arr;
            }
            $res = $this->db->delete("post_media");
            if (!$res)
            {
                throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows4";
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
     * check_post_media method is used to execute database queries for Like Post Media API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_media($media_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.eStatus AS pm_status");
            if (isset($media_id) && $media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $media_id);
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
     * check_post_media_id method is used to execute database queries for Get Post Media Likes API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_media_id($media_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.iPostMediaId AS pm_post_media_id");
            $this->db->select("pm.eStatus AS pm_status");
            if (isset($media_id) && $media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $media_id);
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
     * check_post_media_id_v1 method is used to execute database queries for Comment Post Media API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_media_id_v1($media_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.eStatus AS pm_status");
            if (isset($media_id) && $media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $media_id);
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
     * check_post_media_id_v2 method is used to execute database queries for Get Post Media Comments API.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param string $media_id media_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_post_media_id_v2($media_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_media AS pm");

            $this->db->select("pm.eStatus AS pm_status");
            if (isset($media_id) && $media_id != "")
            {
                $this->db->where("pm.iPostMediaId =", $media_id);
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
     * query method is used to execute database queries for Update Media View Count API.
     * @created  | 28.11.2018
     * @modified  | 28.11.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function query($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["iPostMediaId"]) && $where_arr["iPostMediaId"] != "")
            {
                $this->db->where("iPostMediaId =", $where_arr["iPostMediaId"]);
            }

            $this->db->set($this->db->protect("iViewsCount"), $params_arr["_iviewscount"], FALSE);
            $res = $this->db->update("post_media");
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
