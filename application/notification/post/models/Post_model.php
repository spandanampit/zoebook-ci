<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Model
 *
 * @category notification
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post
 *
 * @class Post_model.php
 *
 * @path application\notification\post\models\Post_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.05.2019
 */

class Post_model extends CI_Model
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
     * update_post_status method is used to execute database queries for Update Live Video Post Status notification.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 03.12.2018
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_post_status($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["ts_post_id"]) && $where_arr["ts_post_id"] != "")
            {
                $this->db->where("iPostId =", $where_arr["ts_post_id"]);
            }

            $this->db->set("eStatus", $params_arr["final_archive_status"]);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("ePostType", $params_arr["_eposttype"]);
            $res = $this->db->update("post");
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
     * update_viral_post method is used to execute database queries for Update viral post to public notification.
     * @created Vamsi Ippe | 02.05.2019
     * @modified Vamsi Ippe | 08.05.2019
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_viral_post($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();

            $this->db->where_in("eVisibility", array('Viral'));
            $this->db->where_in("eStatus", array('Active'));
            $this->db->where("DATE_ADD(dAddedDate, INTERVAL 2 DAY) <= NOW()", FALSE, FALSE);

            $this->db->set("eVisibility", $params_arr["_evisibility"]);
            $res = $this->db->update("post");
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
