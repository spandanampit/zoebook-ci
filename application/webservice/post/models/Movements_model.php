<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movements Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Movements
 *
 * @class Movements_model.php
 *
 * @path application\webservice\post\models\Movements_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 18.04.2023
 */

class Movements_model extends CI_Model
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
     * insert_movement method is used to execute database queries for Add Movement API.
     * @created Rohit Patidar | 02.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_movement($params_arr = array())
    {
        try
        {
            $result_arr = array();
            if (!is_array($params_arr) || count($params_arr) == 0)
            {
                throw new Exception("Insert data not found.");
            }
            if (isset($params_arr["movement_name"]))
            {
                $this->db->set("vMovementName", $params_arr["movement_name"]);
            }
            if (isset($params_arr["description"]))
            {
                $this->db->set("tDescription", $params_arr["description"]);
            }
            if (isset($params_arr["theme"]))
            {
                $this->db->set("eTheme", $params_arr["theme"]);
            }
            if (isset($params_arr["visibility"]))
            {
                $this->db->set("eVisibility", $params_arr["visibility"]);
            }
            if (isset($params_arr["user_id"]))
            {
                $this->db->set("iUserId", $params_arr["user_id"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->insert("movements");
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
     * update_movement_token method is used to execute database queries for Add Movement API.
     * @created Rohit Patidar | 09.09.2021
     * @modified Rohit Patidar | 16.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_movement_token($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["insert_id"]) && $where_arr["insert_id"] != "")
            {
                $this->db->where("iMovementsId =", $where_arr["insert_id"]);
            }
            if (isset($params_arr["getToken"]))
            {
                $this->db->set("tDeviceGroupToken", $params_arr["getToken"]);
            }
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $res = $this->db->update("movements");
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
     * movements_exits method is used to execute database queries for Edit movement API.
     * @created Rohit Patidar | 08.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param string $movements_id movements_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function movements_exits($movements_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");

            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.iUserId AS m_user_id");
            $this->db->select("m.eTheme AS m_theme");
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("m.iMovementsId =", $movements_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("m.iUserId =", $user_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * update_movements method is used to execute database queries for Edit movement API.
     * @created Rohit Patidar | 08.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function update_movements($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["movements_id"]) && $where_arr["movements_id"] != "")
            {
                $this->db->where("iMovementsId =", $where_arr["movements_id"]);
            }
            if (isset($params_arr["movement_name"]))
            {
                $this->db->set("vMovementName", $params_arr["movement_name"]);
            }
            if (isset($params_arr["description"]))
            {
                $this->db->set("tDescription", $params_arr["description"]);
            }
            if (isset($params_arr["theme"]))
            {
                $this->db->set("eTheme", $params_arr["theme"]);
            }
            if (isset($params_arr["visibility"]))
            {
                $this->db->set("eVisibility", $params_arr["visibility"]);
            }
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("movements");
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
     * get_movement method is used to execute database queries for Add movement  image API.
     * @created Rohit Patidar | 06.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param string $movements_id movements_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement($movements_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.iUserId AS m_user_id");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("m.iMovementsId =", $movements_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("m.iUserId =", $user_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * movement_owner_details method is used to execute database queries for Join Movements API.
     * @created Rohit Patidar | 17.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param string $movements_id movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function movement_owner_details($movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vDeviceToken AS u_device_token_1");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.eDeviceType AS u_device_type");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.eVisibility AS m_visibility_1");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.tDescription AS m_description");
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("m.iMovementsId =", $movements_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * get_my_movement method is used to execute database queries for My Movements API.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_movement($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $this->db->join("movement_users AS mu", "m.iMovementsId = mu.iMovementId", "inner");

            $this->db->where("(m.eStatus = 'Active' AND mu.iUserId=".$user_id." AND mu.eStatus = 'Active') OR (m.iUserId = ".$user_id.")", FALSE, FALSE);
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

            $this->db->group_by(array("m.iMovementsId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(m.iMovementsId) AS iMovementsId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            $this->db->select("m.dModifiedDate AS m_modified_date");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT count(iMovementUsersId) FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.eStatus = 'Active'  AND mu.eAdminStatus != 'Yes') AS total_members", FALSE);
            $this->db->select("m.dAddedDate AS m_added_date");
            $this->db->select("mu.dUpdatedDate AS mu_updated_date");
            $this->db->select("(SELECT mu.eStatus FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.iUserId = ".$user_id.") AS join_status", FALSE);
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("(if(m.eStatus = 'Active',\"1\",\"0\")) AS is_movement_active", FALSE);

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("if(mu.eAdminStatus = 'Yes',1,0) Desc,mu.dUpdatedDate Desc", FALSE, FALSE);
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
     * get_popular_movement method is used to execute database queries for Popular movements API.
     * @created Rohit Patidar | 15.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_popular_movement($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "inner", FALSE);
            $this->db->join("movement_user_count AS muc", "m.iMovementsId = muc.iMovementId", "inner");

            $this->db->where_in("m.eStatus", array('Active'));
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

            $this->db->group_by(array("m.iMovementsId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(m.iMovementsId) AS iMovementsId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            $this->db->select("m.dAddedDate AS m_added_date");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT mu.eStatus FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.iUserId = ".$user_id.") AS join_status", FALSE);
            $this->db->select("(if(m.eStatus = 'Active',\"1\",\"0\")) AS is_movement_active", FALSE);
            $this->db->select("muc.iTotal AS total_members");
            $this->db->select("(SELECT COUNT(DISTINCT(mu.iMovementUsersId)) FROM  movement_users AS mu JOIN   user_followers2 AS fu ON (fu.iFollowerId = mu.iUserId) WHERE   mu.eStatus = 'Active' AND mu.eAdminStatus = 'No' AND mu.iMovementId = m.iMovementsId AND(fu.iUserId = ".$user_id.")) AS follower_count", FALSE);

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("follower_count Desc,total_members Desc
", FALSE, FALSE);
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
     * get_movements method is used to execute database queries for Movements Details API.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $movements_id movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movements($user_id = '', $movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $join_condition = $this->db->protect("m.iMovementsId")." = ".$this->db->protect("mu.iMovementId")."  AND mu.iUserId = ".$user_id."";
            $this->db->join("movement_users AS mu", $join_condition, "left", FALSE);

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            $this->db->select("m.dAddedDate AS m_added_date");
            $this->db->select("(SELECT count(iMovementUsersId) FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.eStatus = 'Active'  AND mu.eAdminStatus != 'Yes') AS total_members", FALSE);
            $this->db->select("(mu.eStatus) AS join_status", FALSE);
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT COUNT( DISTINCT ( mu.iMovementUsersId ) ) FROM movement_users AS mu JOIN user_followers AS fu ON fu.iUserId = mu.iUserId OR fu.iFollowerId = mu.iUserId WHERE mu.eStatus = 'Active' AND mu.eAdminStatus = 'No' AND mu.iMovementId = m.iMovementsId AND ( fu.iUserId = ".$user_id." OR fu.iFollowerId = ".$user_id.") AND fu.eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(IF(m.eStatus = 'Active',\"1\",\"0\")) AS is_movement_active", FALSE);
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("m.iMovementsId =", $movements_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * search_new_moments method is used to execute database queries for Search movements API.
     * @created Ravi Chauhan | 06.04.2022
     * @modified Jay Rajput | 12.12.2022
     * @param string $user_id user_id is used to process query block.
     * @param string $search_key search_key is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function search_new_moments($user_id = '', $search_key = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $this->db->join("movement_user_count AS muc", "m.iMovementsId = muc.iMovementId", "left");

            $this->db->where("".$search_key."", FALSE, FALSE);
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

            $this->db->group_by(array("m.iMovementsId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(m.iMovementsId) AS iMovementsId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("m.iMovementsId AS m_movements_id_1");
            $this->db->select("m.vMovementName AS m_movement_name_1");
            $this->db->select("m.tDescription AS m_description_1");
            $this->db->select("m.eTheme AS m_theme_1");
            $this->db->select("m.eVisibility AS m_visibility_1");
            $this->db->select("m.eStatus AS m_status_1");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token_1");
            $this->db->select("m.dAddedDate AS m_added_date_1");
            $this->db->select("u.iUsersId AS u_users_id_2");
            $this->db->select("u.vName AS u_name_2");
            $this->db->select("u.vEmail AS u_email_2");
            $this->db->select("u.vProfileImage AS u_profile_image_2");
            $this->db->select("(SELECT COUNT(DISTINCT(mu.iMovementUsersId)) FROM  movement_users AS mu JOIN   user_followers2 AS fu ON (fu.iFollowerId = mu.iUserId) WHERE   mu.eStatus = 'Active' AND mu.eAdminStatus = 'No' AND mu.iMovementId = m.iMovementsId AND(fu.iUserId = ".$user_id.")) AS follower_count_1", FALSE);
            $this->db->select("((SELECT mu.eStatus FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.iUserId = 1)) AS join_status_1", FALSE);
            $this->db->select("m.iUserId AS m_user_id");
            $this->db->select("((IF(m.iUserId = 1,1,0))) AS self_movements_1", FALSE);
            $this->db->select("muc.iTotal AS total_members_1");

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("self_movements_1 Desc, total_members_1 Desc", FALSE, FALSE);
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
     * get_insta_movements method is used to execute database queries for Movement insta view API.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_insta_movements($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);
            $this->db->join("movement_users AS mu", "m.iMovementsId = mu.iMovementId", "inner");
            $this->db->join("user_followers AS uf", "m.iUserId = uf.iUserId", "left");
            $join_condition = $this->db->protect("mu.iMovementId")." = ".$this->db->protect("mi.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movement_images', 'mi', 'NR');
            $this->db->join("movement_images AS mi", $join_condition, "inner", FALSE);

            $this->db->where_in("mu.eStatus", array('Active'));
            $this->db->where_in("m.eStatus", array('Active'));
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

            $this->db->group_by(array("m.iMovementsId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(m.iMovementsId) AS iMovementsId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eTheme AS m_theme");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            $this->db->select("m.dAddedDate AS m_added_date");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(SELECT COUNT( DISTINCT ( mu.iMovementUsersId ) ) FROM movement_users AS mu JOIN user_followers AS fu ON fu.iUserId = mu.iUserId OR fu.iFollowerId = mu.iUserId WHERE mu.eStatus = 'Active' AND mu.eAdminStatus = 'No' AND mu.iMovementId = m.iMovementsId AND ( fu.iUserId = ".$user_id." OR fu.iFollowerId = ".$user_id.") AND fu.eStatus = 'Accepted') AS follower_count", FALSE);
            $this->db->select("(SELECT count(DISTINCT(iMovementUsersId)) FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.eStatus = 'Active'  AND mu.eAdminStatus = 'No') AS total_members", FALSE);
            $this->db->select("(SELECT mu.eStatus FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.iUserId = ".$user_id.") AS join_status", FALSE);
            $this->db->select("(IF(u.iUsersId = ".$user_id.",1,0)) AS self_movements", FALSE);
            $this->db->select("(if(m.eStatus = 'Active',\"1\",\"0\")) AS is_movement_active", FALSE);

            $settings_params['count'] = $total_records;

            $max_rec = 20;
            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $tot_count = $start_index+$record_limit;
            if (($start_index >= $max_rec) || ($start_index >= $total_records))
            {
                throw new Exception('No records found.');
            }
            $record_limit = ($tot_count > $max_rec) ? $max_rec-$start_index : $record_limit;
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            if ($total_records > $tot_count)
            {
                $settings_params['next_page'] = ($tot_count >= $max_rec) ? 0 : 1;
            }
            else
            {
                $settings_params['next_page'] = 0;
            }

            $this->db->order_by("self_movements Desc, follower_count Desc, total_members Desc", FALSE, FALSE);
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
     * get_movement_instaviews method is used to execute database queries for Movement insta view API.
     * @created Rohit Patidar | 14.04.2022
     * @modified Jay Rajput | 09.08.2022
     * @param string $user_id user_id is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_instaviews($user_id = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "inner", FALSE);
            $join_condition = $this->db->protect("m.iMovementsId")." = ".$this->db->protect("mi.iMovementsId")."  AND ".$this->general->getPhysicalRecordWhere('movement_images', 'mi', 'NR');
            $this->db->join("movement_images AS mi", $join_condition, "inner", FALSE);
            $this->db->join("movement_user_count AS muc", "m.iMovementsId = muc.iMovementId", "inner");

            $this->db->where_in("m.eStatus", array('Active'));
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

            $this->db->group_by(array("m.iMovementsId"));
            $this->db->stop_cache();
            $this->db->select("COUNT(m.iMovementsId) AS iMovementsId", FALSE);
            $paging_data = $this->db->get();
            $total_records = is_object($paging_data) ? $paging_data->num_rows() : 0;

            $this->db->select("m.iMovementsId AS m_movements_id_1");
            $this->db->select("m.vMovementName AS m_movement_name_1");
            $this->db->select("m.tDescription AS m_description_1");
            $this->db->select("m.eTheme AS m_theme_1");
            $this->db->select("m.eVisibility AS m_visibility_1");
            $this->db->select("m.eStatus AS m_status_1");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token_1");
            $this->db->select("m.dAddedDate AS m_added_date_1");
            $this->db->select("u.iUsersId AS u_users_id_1");
            $this->db->select("m.iUserId AS m_user_id");
            $this->db->select("u.vName AS u_name_1");
            $this->db->select("u.vEmail AS u_email_1");
            $this->db->select("u.vProfileImage AS u_profile_image_1");
            $this->db->select("(SELECT mu.eStatus FROM movement_users mu WHERE mu.iMovementId = m.iMovementsId AND mu.iUserId = ".$user_id.") AS join_status_1", FALSE);
            $this->db->select("(IF(m.iUserId = ".$user_id.",1,0)) AS self_movements_1", FALSE);
            $this->db->select("(if(m.eStatus = 'Active',\"1\",\"0\")) AS is_movement_active_1", FALSE);
            $this->db->select("(SELECT COUNT(DISTINCT(mu.iMovementUsersId)) FROM  movement_users AS mu JOIN   user_followers2 AS fu ON (fu.iFollowerId = mu.iUserId) WHERE   mu.eStatus = 'Active' AND mu.eAdminStatus = 'No' AND mu.iMovementId = m.iMovementsId AND(fu.iUserId = ".$user_id.")) AS follower_count_1", FALSE);
            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id_2");
            $this->db->select("mi.iMovementsId AS mi_movements_id_2");
            $this->db->select("mi.eMediaType AS mi_media_type_2");
            $this->db->select("mi.vUploadFile AS mi_upload_file_2");
            $this->db->select("mi.vMheight AS mi_mheight_2");
            $this->db->select("mi.vMwidth AS mi_mwidth_2");
            $this->db->select("muc.iTotal AS total_members_1");

            $settings_params['count'] = $total_records;

            $max_rec = 20;
            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $tot_count = $start_index+$record_limit;
            if (($start_index >= $max_rec) || ($start_index >= $total_records))
            {
                throw new Exception('No records found.');
            }
            $record_limit = ($tot_count > $max_rec) ? $max_rec-$start_index : $record_limit;
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            if ($total_records > $tot_count)
            {
                $settings_params['next_page'] = ($tot_count >= $max_rec) ? 0 : 1;
            }
            else
            {
                $settings_params['next_page'] = 0;
            }

            $this->db->order_by("self_movements_1 Desc, follower_count_1 Desc, total_members_1 Desc", FALSE, FALSE);
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
     * get_movement_active_inactive method is used to execute database queries for Movement Active Inactive API.
     * @created Rohit Patidar | 30.09.2021
     * @modified Rohit Patidar | 30.09.2021
     * @param string $movement_id movement_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_active_inactive($movement_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.iUserId AS m_user_id");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("m.iMovementsId =", $movement_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * active_movements method is used to execute database queries for Movement Active Inactive API.
     * @created Rohit Patidar | 30.09.2021
     * @modified Rohit Patidar | 30.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function active_movements($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["m_movements_id"]) && $where_arr["m_movements_id"] != "")
            {
                $this->db->where("iMovementsId =", $where_arr["m_movements_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("movements");
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
     * inactive_movement method is used to execute database queries for Movement Active Inactive API.
     * @created Rohit Patidar | 30.09.2021
     * @modified Rohit Patidar | 30.09.2021
     * @param array $params_arr params_arr array to process query block.
     * @param array $where_arr where_arr are used to process where condition(s).
     * @return array $return_arr returns response of query block.
     */
    public function inactive_movement($params_arr = array(), $where_arr = array())
    {
        try
        {
            $result_arr = array();
            if (isset($where_arr["m_movements_id"]) && $where_arr["m_movements_id"] != "")
            {
                $this->db->where("iMovementsId =", $where_arr["m_movements_id"]);
            }

            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $res = $this->db->update("movements");
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
     * get_active_movements method is used to execute database queries for Movement Active Inactive API.
     * @created Rohit Patidar | 30.09.2021
     * @modified Rohit Patidar | 30.09.2021
     * @return array $return_arr returns response of query block.
     */
    public function get_active_movements()
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");

            $this->db->select("m.iMovementsId AS m_movements_id_1");
            $this->db->select("m.eStatus AS m_status");
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * get_inactive_movements method is used to execute database queries for Movement Active Inactive API.
     * @created Rohit Patidar | 30.09.2021
     * @modified Rohit Patidar | 30.09.2021
     * @param string $m_movements_id m_movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_inactive_movements($m_movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");

            $this->db->select("m.iMovementsId AS m_movements_id_2");
            $this->db->select("m.eStatus AS m_status_1");
            if (isset($m_movements_id) && $m_movements_id != "")
            {
                $this->db->where("m.iMovementsId =", $m_movements_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * movement_exist method is used to execute database queries for Movement invitation API.
     * @created Rohit Patidar | 06.10.2021
     * @modified Rohit Patidar | 06.10.2021
     * @param string $movement_id movement_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function movement_exist($movement_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.tDescription AS m_description");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("m.eStatus AS m_status");
            $this->db->select("m.iUserId AS m_user_id");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("m.iMovementsId =", $movement_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * get_send_movement_details method is used to execute database queries for Movement invitation accept reject API.
     * @created Rohit Patidar | 07.10.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param string $movement_id movement_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_send_movement_details($movement_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("m.iMovementsId AS m_movements_id_1");
            $this->db->select("m.vMovementName AS m_movement_name_1");
            $this->db->select("m.eVisibility AS m_visibility_1");
            $this->db->select("m.eStatus AS m_status_1");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.vDeviceToken AS u_device_token");
            $this->db->select("u.eSubscribeEmail AS u_subscribe_email");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("m.iMovementsId =", $movement_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
     * send_movement_push_notification method is used to execute database queries for Send_movement_pushnotification API.
     * @created Rohit Patidar | 22.10.2021
     * @modified Jay Rajput | 21.07.2022
     * @param string $movement_id movement_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function send_movement_push_notification($movement_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movements AS m");
            $join_condition = $this->db->protect("m.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("m.iMovementsId AS m_movements_id");
            $this->db->select("m.vMovementName AS m_movement_name");
            $this->db->select("m.eVisibility AS m_visibility");
            $this->db->select("u.iUsersId AS u_users_id_3");
            $this->db->select("u.vName AS u_name_3");
            $this->db->select("u.vProfileImage AS u_profile_image_3");
            $this->db->select("m.tDeviceGroupToken AS m_device_group_token");
            if (isset($movement_id) && $movement_id != "")
            {
                $this->db->where("m.iMovementsId =", $movement_id);
            }
            $this->general->getPhysicalRecordWhere("movements", "m", "AR");

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
