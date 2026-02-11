<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Block User List Model
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage models
 *
 * @module Block User List
 *
 * @class Block_user_list_model.php
 *
 * @path application\webservice\user\models\Block_user_list_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Block_user_list_model extends CI_Model
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
     * query_block_list method is used to execute database queries for blocked user list API.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 19.07.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function query_block_list($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("block_user_list AS bc");
            $this->db->join("users AS u", "bc.iBlockUserId = u.iUsersId", "left");

            $this->db->select("bc.eStatus AS bc_eStatus");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->where_in("bc.eStatus", array('block'));
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("bc.iBlockByUserId =", $user_id);
            }

            $this->db->order_by("bc.dAddedDate", "asc");

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
     * block_user_query_block method is used to execute database queries for upsert_block_user_list API.
     * if record exist
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param string $blocked_user_id blocked_user_id is used to process query block.
     * @param string $block_by_user_id block_by_user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function block_user_query_block($blocked_user_id = '', $block_by_user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("block_user_list AS bc");

            $this->db->select("bc.iBlockListUserId AS bc_block_list_user_id");
            $this->db->select("bc.eStatus AS bc_eStatus");
            if (isset($blocked_user_id) && $blocked_user_id != "")
            {
                $this->db->where("bc.iBlockUserId =", $blocked_user_id);
            }
            if (isset($block_by_user_id) && $block_by_user_id != "")
            {
                $this->db->where("bc.iBlockByUserId =", $block_by_user_id);
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
     * block_user_condition_block_only method is used to execute database queries for upsert_block_user_list API.
     * @created Kiran Jain | 04.05.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function block_user_condition_block_only($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            if (isset($params_arr["blocked_user_id"]))
            {
                $this->db->set("iBlockUserId", $params_arr["blocked_user_id"]);
            }
            if (isset($params_arr["block_by_user_id"]))
            {
                $this->db->set("iBlockByUserId", $params_arr["block_by_user_id"]);
            }
            $this->db->insert("block_user_list");
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
     * unblock_user method is used to execute database queries for upsert_block_user_list API.
     * if block then unblock
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function unblock_user($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["bc_block_list_user_id"]) && $where_arr["bc_block_list_user_id"] != "")
            {
                $this->db->where("iBlockListUserId =", $where_arr["bc_block_list_user_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $res = $this->db->update("block_user_list");
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
     * block_update_query method is used to execute database queries for upsert_block_user_list API.
     * if unblock then block
     * @created Kiran Jain | 04.05.2021
     * @modified Kiran Jain | 04.05.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function block_update_query($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["bc_block_list_user_id"]) && $where_arr["bc_block_list_user_id"] != "")
            {
                $this->db->where("iBlockListUserId =", $where_arr["bc_block_list_user_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $res = $this->db->update("block_user_list");
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
}
