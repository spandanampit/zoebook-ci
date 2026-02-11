<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Media Model
 *
 * @category notification
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post Media
 *
 * @class Post_media_model.php
 *
 * @path application\notification\post\models\Post_media_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 31.12.2018
 */

class Post_media_model extends CI_Model
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
     * insert_live_media method is used to execute database queries for Update Live Video Post Status notification.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 18.10.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_live_media($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["ts_post_id"]))
            {
                $this->db->set("iPostId", $params_arr["ts_post_id"]);
            }
            $this->db->set("eMediaType", $params_arr["_emediatype"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            if (isset($params_arr["archive_file_name"]))
            {
                $this->db->set("vUploadFile", $params_arr["archive_file_name"]);
            }
            if (isset($params_arr["live_video_thumb"]))
            {
                $this->db->set("vVideoThumbnail", $params_arr["live_video_thumb"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->insert("post_media");
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
}
