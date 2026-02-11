<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Report Abuse Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post Report Abuse
 *
 * @class Post_report_abuse_model.php
 *
 * @path application\webservice\post\models\Post_report_abuse_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 23.01.2019
 */

class Post_report_abuse_model extends CI_Model
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
     * insert_abuse method is used to execute database queries for Report abuse on post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 28.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_abuse($params_arr = array())
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
            $this->db->set("eReportOn", $params_arr["_ereporton"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iReportedBy", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["report_notes"]))
            {
                $this->db->set("tReportNotes", $params_arr["report_notes"]);
            }
            if (isset($params_arr["type"]))
            {
                $this->db->set("eType", $params_arr["type"]);
            }
            $this->db->insert("post_report_abuse");
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
     * insert_abuse_on_comment method is used to execute database queries for Report abuse on comment API.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 28.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_abuse_on_comment($params_arr = array())
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
            $this->db->set("eReportOn", $params_arr["_ereporton"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iReportedBy", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["report_notes"]))
            {
                $this->db->set("tReportNotes", $params_arr["report_notes"]);
            }
            if (isset($params_arr["post_comment_id"]))
            {
                $this->db->set("iPostCommentId", $params_arr["post_comment_id"]);
            }
            if (isset($params_arr["type"]))
            {
                $this->db->set("eType", $params_arr["type"]);
            }
            $this->db->insert("post_report_abuse");
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
