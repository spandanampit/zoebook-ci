<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movement Users Model
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage models
 *
 * @module Movement Users
 *
 * @class Movement_users_model.php
 *
 * @path application\webservice\misc\models\Movement_users_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 18.04.2023
 */

class Movement_users_model extends CI_Model
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
     * join_movement method is used to execute database queries for Add Movement API.
     * @created Alpesh Patel | 10.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function join_movement($params_arr = array())
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
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set("eAdminStatus", $params_arr["_eadminstatus"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            if (isset($params_arr["insert_id"]))
            {
                $this->db->set("iMovementId", $params_arr["insert_id"]);
            }
            $this->db->insert("movement_users");
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
     * update_movement_users method is used to execute database queries for Edit movement API.
     * @created Alpesh Patel | 24.09.2021
     * @modified Rohit Patidar | 24.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_movement_users($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["movements_id"]) && $where_arr["movements_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movements_id"]);
            }
            $this->db->where_in("eStatus", array('Pending'));

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            $res = $this->db->update("movement_users");
            $affected_rows = $this->db->affected_rows();
            if (!$res || $affected_rows == -1)
            {
                throw new Exception("Failure in updation.");
            }
            $result_param = "update_movement_users_rows";
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
     * query_4 method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param string $movements_id movements_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function query_4($movements_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("m.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("mu.eAdminStatus AS mu_admin_status");
            $this->db->select("mu.eStatus AS mu_status");
            $this->db->select("mu.iUserId AS mu_user_id");
            $this->db->select("mu.iMovementId AS mu_movement_id");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vDeviceToken AS u_device_token");
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("mu.iMovementId =", $movements_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
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
     * join_delete_movement method is used to execute database queries for Join Movements API.
     * @created Alpesh Patel | 10.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param string $user_id user_id is used to process query block.
     * @param string $movements_id movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function join_delete_movement($user_id = '', $movements_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iUserId =", $user_id);
            }
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("iMovementId =", $movements_id);
            }
            $res = $this->db->delete("movement_users");
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
     * join_insert_movement method is used to execute database queries for Join Movements API.
     * @created Alpesh Patel | 10.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function join_insert_movement($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["movements_id"]))
            {
                $this->db->set("iMovementId", $params_arr["movements_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            $this->db->set("eAdminStatus", $params_arr["_eadminstatus"]);
            $this->db->insert("movement_users");
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
     * leave_update_movement method is used to execute database queries for Join Movements API.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function leave_update_movement($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["movements_id"]) && $where_arr["movements_id"] != "")
            {
                $this->db->where("iMovementId =", $where_arr["movements_id"]);
            }
            if (isset($where_arr["user_id"]) && $where_arr["user_id"] != "")
            {
                $this->db->where("iUserId =", $where_arr["user_id"]);
            }
            if (isset($params_arr["movements_id"]))
            {
                $this->db->set("iMovementId", $params_arr["movements_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            $res = $this->db->update("movement_users");
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
     * get_moment_joint_info method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 13.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param string $mu_movement_id mu_movement_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_moment_joint_info($mu_movement_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("m.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("mu.eAdminStatus AS mu_admin_status_1");
            $this->db->select("mu.eStatus AS mu_status_1");
            $this->db->select("mu.iUserId AS mu_user_id_1");
            $this->db->select("mu.iMovementId AS mu_movement_id_1");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            if (isset($mu_movement_id) && $mu_movement_id != "")
            {
                $this->db->where("mu.iMovementId =", $mu_movement_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
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
     * get_active_record method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 14.09.2021
     * @modified Rohit Patidar | 14.09.2021
     * @param string $movements_id movements_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_active_record($movements_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");

            $this->db->select("mu.eAdminStatus AS mu_admin_status_3");
            $this->db->select("mu.eStatus AS mu_status_3");
            $this->db->select("mu.iMovementId AS mu_movement_id_3");
            $this->db->select("mu.iUserId AS mu_user_id_3");
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("mu.iMovementId =", $movements_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
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
     * privet_movement_con method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 16.09.2021
     * @modified Rohit Patidar | 20.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function privet_movement_con($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            if (isset($params_arr["movements_id"]))
            {
                $this->db->set("iMovementId", $params_arr["movements_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set("eAdminStatus", $params_arr["_eadminstatus"]);
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->insert("movement_users");
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
     * get_private_movements method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param string $insert_id1 insert_id1 is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_private_movements($insert_id1 = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");

            $this->db->select("mu.iMovementId AS mu_movement_id_4");
            $this->db->select("mu.iUserId AS mu_user_id_4");
            $this->db->select("mu.eStatus AS mu_status_4");
            if (isset($insert_id1) && $insert_id1 != "")
            {
                $this->db->where("mu.iMovementUsersId =", $insert_id1);
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
     * follower_users_details method is used to execute database queries for My Movements API.
     * @created Rohit Patidar | 15.09.2021
     * @modified Jay Rajput | 17.04.2023
     * @param string $user_id user_id is used to process query block.
     * @param string $mm_ids mm_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function follower_users_details($user_id = '', $mm_ids = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("uf.iUserId")."  AND (uf.iUserId = ".$user_id." OR uf.iFollowerId = ".$user_id.") AND uf.eStatus = 'Accepted'";
            $this->db->join("user_followers AS uf", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("mu.iMovementId AS mu_movement_id");
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("mu.eAdminStatus", array('No'));
            $this->db->where("mu.iMovementId in ('".$mm_ids."')", FALSE, FALSE);

            $this->db->group_by(array("mu.iUserId"));
            $this->db->order_by("uf.dAddedDate", "desc");
            $this->db->order_by("mu.iMovementUsersId", "desc");

            $this->db->limit(2);

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
     * get_moment_user_follwers method is used to execute database queries for Popular movements API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 16.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $mm_ids mm_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_moment_user_follwers($user_id = '', $mm_ids = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("uf.iUserId")."  AND (uf.iUserId = ".$user_id." OR uf.iFollowerId = ".$user_id.") AND uf.eStatus = 'Accepted'";
            $this->db->join("user_followers AS uf", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("DISTINCT(u.iUsersId) AS f_users_id");
            $this->db->select("u.vName AS f_name");
            $this->db->select("u.vEmail AS f_email");
            $this->db->select("u.vProfileImage AS f_profile_image");
            $this->db->select("mu.iMovementId AS mu_movement_id");
            $this->db->where("mu.iMovementId =", '{%REQUEST.movement_id%}');
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("mu.eAdminStatus", array('No'));
            $this->db->where("mu.iMovementId in ('".$mm_ids."')", FALSE, FALSE);

            $this->db->group_by(array("mu.iUserId"));
            $this->db->order_by("uf.dAddedDate", "desc");
            $this->db->order_by("mu.iMovementUsersId", "desc");

            $this->db->limit(2);

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
     * moment_users_query_block method is used to execute database queries for Get movement followers user API.
     * @created Rohit Patidar | 16.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $movement_id movement_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function moment_users_query_block($user_id = '', $movement_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("uf.iUserId")."  AND (uf.iUserId = ".$user_id." OR uf.iFollowerId = ".$user_id.") AND uf.eStatus = 'Accepted'";
            $this->db->join("user_followers AS uf", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("DISTINCT(u.iUsersId) AS u_users_id_1");
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vEmail AS u_email_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("uf.dAddedDate AS uf_added_date");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("mu.iMovementId =", $movement_id);
            }
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("mu.eAdminStatus", array('No'));

            $this->db->group_by(array("mu.iUserId"));
            $this->db->order_by("uf.dAddedDate", "desc");
            $this->db->order_by("mu.iMovementUsersId", "desc");

            $this->db->limit(2);

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
     * get_movements_user method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 19.10.2021
     * @param string $movement_id movement_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movements_user($movement_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("m.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u2.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u2', 'NR');
            $this->db->join("users AS u2", $join_condition, "left", FALSE);

            $this->db->select("mu.iMovementUsersId AS mu_movement_users_id");
            $this->db->select("mu.iMovementId AS mu_movement_id");
            $this->db->select("mu.iUserId AS mu_user_id");
            $this->db->select("mu.eStatus AS mu_status");
            $this->db->select("mu.eAdminStatus AS mu_admin_status");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vDeviceToken AS u_device_token");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u2.iUsersId AS u2_users_id");
            $this->db->select("u2.vName AS u2_name");
            $this->db->select("u2.vEmail AS u2_email");
            $this->db->select("u2.eNotificationPref AS u2_notification_pref");
            $this->db->select("u2.vDeviceToken AS u2_device_token");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("mu.iMovementId =", $movement_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
            }
            $this->db->where_in("m.eVisibility", array('Private'));
            $this->db->where_in("mu.eAdminStatus", array('No'));

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
     * private_movement_active method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 20.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function private_movement_active($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["mu_movement_users_id"]) && $where_arr["mu_movement_users_id"] != "")
            {
                $this->db->where("iMovementUsersId =", $where_arr["mu_movement_users_id"]);
            }

            $this->db->set("eStatus", $params_arr["status"]);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            $res = $this->db->update("movement_users");
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
     * private_movements_inactive method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param string $mu_movement_users_id mu_movement_users_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function private_movements_inactive($mu_movement_users_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($mu_movement_users_id) && $mu_movement_users_id != "")
            {
                $this->db->where("iMovementUsersId =", $mu_movement_users_id);
            }
            $res = $this->db->delete("movement_users");
            if (!$res)
            {
                throw new Exception("Failure in deletion.");
            }
            $affected_rows = $this->db->affected_rows();
            $result_param = "affected_rows1";
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
     * get_activet_record method is used to execute database queries for private movements access reject API.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 20.09.2021
     * @param string $mu_movement_users_id mu_movement_users_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_activet_record($mu_movement_users_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");

            $this->db->select("mu.iMovementId AS mu_movement_id_1");
            $this->db->select("mu.iUserId AS mu_user_id_1");
            $this->db->select("mu.eStatus AS mu_status_1");
            if (isset($mu_movement_users_id) && $mu_movement_users_id != "")
            {
                $this->db->where("mu.iMovementUsersId =", $mu_movement_users_id);
            }
            $this->db->where_in("mu.eStatus", array('Active'));

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
     * follower_details method is used to execute database queries for Movements Details API.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $m_movements_id m_movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function follower_details($user_id = '', $m_movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("uf.iUserId")."  AND (uf.iUserId = ".$user_id." OR uf.iFollowerId = ".$user_id.") AND uf.eStatus = 'Accepted'";
            $this->db->join("user_followers AS uf", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vEmail AS u_email_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            if (isset($m_movements_id) && $m_movements_id != "")
            {
                $this->db->where("mu.iMovementId =", $m_movements_id);
            }
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("mu.eAdminStatus", array('No'));

            $this->db->group_by(array("mu.iUserId"));
            $this->db->order_by("uf.dAddedDate", "desc");
            $this->db->order_by("mu.iMovementUsersId", "desc");

            $this->db->limit(2);

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
     * get_follower_users method is used to execute database queries for Movements follower API.
     * @created Rohit Patidar | 22.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $movements_id movements_id is used to process query block.
     * @param string $search_text search_text is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_follower_users($user_id = '', $movements_id = '', $search_text = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("uf.iUserId")."  AND (uf.iUserId = ".$user_id." OR uf.iFollowerId = ".$user_id.") AND uf.eStatus = 'Accepted'";
            $this->db->join("user_followers AS uf", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("mu.iMovementId =", $movements_id);
            }
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where("u.vName LIKE '%".$search_text."%'", FALSE, FALSE);

            $this->db->group_by(array("mu.iUserId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(mu.iMovementUsersId) AS iMovementUsersId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("IF(uf.iUserId IS NOT NULL,1,0) AS uf_user_id");
            $this->db->select("IF(mu.eAdminStatus = 'YES' ,1,0) AS mu_admin_status");

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("mu.eAdminStatus", "asc");
            $this->db->order_by("uf.dAddedDate", "desc");
            $this->db->order_by("mu.iMovementUsersId", "desc");
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
     * get_moment_users method is used to execute database queries for Search movements API.
     * @created Rohit Patidar | 24.09.2021
     * @modified Jay Rajput | 17.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $mm_ids mm_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_moment_users($user_id = '', $mm_ids = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("uf.iUserId")."  AND (uf.iUserId = ".$user_id." OR uf.iFollowerId = ".$user_id.") AND uf.eStatus = 'Accepted'";
            $this->db->join("user_followers AS uf", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("mu.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("DISTINCT(u.iUsersId) AS u_users_id_1");
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vEmail AS u_email_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("mu.iMovementId AS mu_movement_id");
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("mu.eAdminStatus", array('No'));
            $this->db->where("mu.iMovementId in ('".$mm_ids."')", FALSE, FALSE);

            $this->db->group_by(array("mu.iUserId"));
            $this->db->order_by("uf.dAddedDate", "desc");
            $this->db->order_by("mu.iMovementUsersId", "desc");

            $this->db->limit(2);

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
     * get_movements_users method is used to execute database queries for Movement follower remove API.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param string $movement_id movement_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movements_users($movement_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("m.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.iUserId AS m_user_id");
            $this->db->select("mu.iMovementUsersId AS mu_movement_users_id");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("mu.iMovementId =", $movement_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
            }
            $this->db->where_in("mu.eStatus", array('Active'));

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
     * query_7 method is used to execute database queries for Movement follower remove API.
     * @created Rohit Patidar | 24.09.2021
     * @modified Rohit Patidar | 24.09.2021
     * @param string $movement_id movement_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function query_7($movement_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("iMovementId =", $movement_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iUserId =", $user_id);
            }
            $this->db->where_in("eStatus", array('Active'));
            $res = $this->db->delete("movement_users");
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
     * user_exists_this_movement method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param string $movement_id movement_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function user_exists_this_movement($movement_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("m.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("mu.eAdminStatus AS mu_admin_status");
            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("mu.eStatus AS mu_status");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("mu.iMovementId =", $movement_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
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
     * join_public_movement method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function join_public_movement($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["movement_id"]))
            {
                $this->db->set("iMovementId", $params_arr["movement_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set("eStatus", $params_arr["status"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            $this->db->set("eAdminStatus", $params_arr["_eadminstatus"]);
            $this->db->insert("movement_users");
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
     * send_private_movement_join_request method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function send_private_movement_join_request($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["movement_id"]))
            {
                $this->db->set("iMovementId", $params_arr["movement_id"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set("eAdminStatus", $params_arr["_eadminstatus"]);
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dUpdatedDate"), $params_arr["_dupdateddate"], FALSE);
            $this->db->insert("movement_users");
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
     * get_movements_token method is used to execute database queries for get_mevements_token API.
     * @created Rohit Patidar | 18.10.2021
     * @modified Rohit Patidar | 20.10.2021
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movements_token($user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_users AS mu");
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("m.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movements', 'm', 'NR');
            $this->db->join("movements AS m", $join_condition, "left", FALSE);

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("m.eStatus", array('Active'));
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("mu.iUserId =", $user_id);
            }
            $this->db->where_in("mu.eAdminStatus", array('No'));

            $this->db->group_by(array("mu.iMovementId"));
            $this->db->order_by("mu.iMovementId", "desc");

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
