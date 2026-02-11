<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Post Like Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Post Like
 *
 * @class Post_like_model.php
 *
 * @path application\webservice\post\models\Post_like_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 19.10.2022
 */

class Post_like_model extends CI_Model
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
     * insert_like method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_like($params_arr = array())
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
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->insert("post_like");
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
     * delete_like method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 20.09.2018
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_like($post_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("iPostId =", $post_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iUserId =", $user_id);
            }
            $res = $this->db->delete("post_like");
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
     * check_like_record_exists method is used to execute database queries for Like Post API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Vamsi Ippe | 22.10.2018
     * @param string $post_id post_id is used to process query block.
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function check_like_record_exists($post_id = '', $user_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_like AS pl");

            $this->db->select("pl.iPostLikeId AS pl_post_like_id");
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pl.iPostId =", $post_id);
            }
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("pl.iUserId =", $user_id);
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
     * get_post_liked_users method is used to execute database queries for Post Liked Users API.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 20.07.2022
     * @param string $post_id post_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_post_liked_users($post_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("post_like AS pl");
            $join_condition = $this->db->protect("pl.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->select("pl.iPostId AS pl_post_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.iUsersId AS u_users_id");
            if (isset($post_id) && $post_id != "")
            {
                $this->db->where("pl.iPostId =", $post_id);
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
     * get_user_data_v1 method is used to execute database queries for List Liked Post User API.
     * @created CIT Dev Team
     * @modified Jay Rajput | 09.08.2022
     * @param string $latitude latitude is used to process query block.
     * @param string $longitude longitude is used to process query block.
     * @param string $post_id_1 post_id_1 is used to process query block.
     * @param array $settings_params settings_params are used for paging parameters.
     * @return array $return_arr returns response of query block.
     */
    public function get_user_data_v1($latitude = '', $longitude = '', $post_id_1 = '', $page_index = 1, &$settings_params = array())
    {
        try
        {
            $result_arr = array();

            $this->db->start_cache();
            $this->db->from("post_like AS pl");
            $join_condition = $this->db->protect("pl.iUserId")." = ".$this->db->protect("u.iUsersId")."  AND ".$this->general->getPhysicalRecordWhere('users', 'u', 'NR');
            $this->db->join("users AS u", $join_condition, "left", FALSE);

            $this->db->where_in("u.eStatus", array('Active'));
            $this->db->where_in("u.eEmailVerified", array('1'));
            $this->db->where("pl.iPostId = (".$post_id_1.")", FALSE, FALSE);

            $this->db->stop_cache();
            $total_records = $this->db->count_all_results();

            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("(".$this->db->escape("").") AS is_follwing", FALSE);
            $this->db->select("(".$this->db->escape("").") AS follower_count", FALSE);
            $this->db->select("(".$this->db->escape("").") AS following_count", FALSE);
            $this->db->select("(".$this->db->escape("").") AS post_count", FALSE);
            $this->db->select("(".$this->db->escape("").") AS pending_request_id", FALSE);
            $this->db->select("(ROUND(GeoDistMiles(u.vLatitude,u.vLongtitude,'".$latitude."','".$longitude."','km'),2)) AS distance_kms", FALSE);
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("pl.iPostId AS pl_post_id");

            $settings_params['count'] = $total_records;

            $record_limit = 10;
            $current_page = intval($page_index) > 0 ? intval($page_index) : 1;
            $total_pages = getTotalPages($total_records, $record_limit);
            $start_index = getStartIndex($total_records, $current_page, $record_limit);
            $settings_params['per_page'] = $record_limit;
            $settings_params['curr_page'] = $current_page;
            $settings_params['prev_page'] = ($current_page > 1) ? 1 : 0;
            $settings_params['next_page'] = ($current_page+1 > $total_pages) ? 0 : 1;

            $this->db->order_by("pl.dAddedDate", "desc");
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
     * post_like method is used to execute database queries for Delete Account API.
     * @created Jay Rajput | 19.10.2022
     * @modified Jay Rajput | 19.10.2022
     * @param string $user_id user_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function post_like($user_id = '')
    {
        try
        {
            $result_arr = array();
            if (isset($user_id) && $user_id != "")
            {
                $this->db->where("iUserId =", $user_id);
            }
            $res = $this->db->delete("post_like");
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
}
