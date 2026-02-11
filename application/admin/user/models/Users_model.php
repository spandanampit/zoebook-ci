<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Users Model
 *
 * @category admin
 *
 * @package user
 *
 * @subpackage models
 *
 * @module Users
 *
 * @class Users_model.php
 *
 * @path application\admin\user\models\Users_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @date 01.10.2021
 */

class Users_model extends CI_Model
{
    public $table_name;
    public $table_alias;
    public $primary_key;
    public $primary_alias;
    public $insert_id;
    //
    public $grid_fields;
    public $join_tables;
    public $extra_cond;
    public $groupby_cond;
    public $orderby_cond;
    public $unique_type;
    public $unique_fields;
    public $switchto_fields;
    public $default_filters;
    public $global_filters;
    public $search_config;
    public $relation_modules;
    public $deletion_modules;
    public $print_rec;
    public $print_list;
    public $multi_lingual;
    public $physical_data_remove;
    //
    public $listing_data;
    public $rec_per_page;
    public $message;

    /**
     * __construct method is used to set model preferences while model object initialization.
     * @created Vamsi Ippe | 10.09.2018
     * @modified Rohit Patidar | 01.10.2021
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->library('listing');
        $this->load->library('filter');
        $this->load->library('dropdown');
        $this->module_name = "users";
        $this->table_name = "users";
        $this->table_alias = "u";
        $this->primary_key = "iUsersId";
        $this->primary_alias = "u_users_id";
        $this->physical_data_remove = "Yes";
        $this->grid_fields = array(
            "u_profile_image",
            "u_name",
            "u_email",
            "u_facebook_id",
            "u_google_id",
            "u_apple_id",
            "u_email_verified",
            "u_added_date",
            "u_status",
            "u_subscribe_email",
        );
        $this->join_tables = array();
        $this->extra_cond = "";
        $this->groupby_cond = array();
        $this->having_cond = "";
        $this->orderby_cond = array(
            array(
                "field" => "u.iUsersId",
                "order" => "DESC",
            )
        );
        $this->unique_type = "AND";
        $this->unique_fields = array(
            "vEmail",
        );
        $this->switchto_fields = array(
            $this->db->protect("u.vName")
        );
        $this->switchto_options = array(
            $this->db->protect("u.vName")." AS name1",
        );
        $this->default_filters = array();
        $this->global_filters = array();
        $this->search_config = array();
        $this->relation_modules = array();
        $this->deletion_modules = array();
        $this->print_rec = "No";
        $this->print_list = "No";
        $this->multi_lingual = "No";

        $this->rec_per_page = $this->config->item('REC_LIMIT');
    }

    /**
     * insert method is used to insert data records to the database table.
     * @param array $data data array for insert into table.
     * @return numeric $insert_id returns last inserted id.
     */
    public function insert($data = array())
    {
        $this->db->insert($this->table_name, $data);
        $insert_id = $this->db->insert_id();
        $this->insert_id = $insert_id;
        return $insert_id;
    }

    /**
     * update method is used to update data records to the database table.
     * @param array $data data array for update into table.
     * @param string $where where is the query condition for updating.
     * @param string $alias alias is to keep aliases for query or not.
     * @param string $join join is to make joins while updating records.
     * @return boolean $res returns TRUE or FALSE.
     */
    public function update($data = array(), $where = '', $alias = "No", $join = "No")
    {
        if ($alias == "Yes")
        {
            if ($join == "Yes")
            {
                $join_tbls = $this->addJoinTables("NR");
            }
            if (trim($join_tbls) != '')
            {
                $set_cond = array();
                foreach ($data as $key => $val)
                {
                    $set_cond[] = $this->db->protect($key)." = ".$this->db->escape($val);
                }
                if (is_numeric($where))
                {
                    $extra_cond = " WHERE ".$this->db->protect($this->table_alias.".".$this->primary_key)." = ".$this->db->escape($where);
                }
                elseif ($where)
                {
                    $extra_cond = " WHERE ".$where;
                }
                else
                {
                    return FALSE;
                }
                $update_query = "UPDATE ".$this->db->protect($this->table_name)." AS ".$this->db->protect($this->table_alias)." ".$join_tbls." SET ".implode(", ", $set_cond)." ".$extra_cond;
                $res = $this->db->query($update_query);
            }
            else
            {
                if (is_numeric($where))
                {
                    $this->db->where($this->table_alias.".".$this->primary_key, $where);
                }
                elseif ($where)
                {
                    $this->db->where($where, FALSE, FALSE);
                }
                else
                {
                    return FALSE;
                }
                $res = $this->db->update($this->table_name." AS ".$this->table_alias, $data);
            }
        }
        else
        {
            if (is_numeric($where))
            {
                $this->db->where($this->primary_key, $where);
            }
            elseif ($where)
            {
                $this->db->where($where, FALSE, FALSE);
            }
            else
            {
                return FALSE;
            }
            $res = $this->db->update($this->table_name, $data);
        }
        return $res;
    }

    /**
     * delete method is used to delete data records from the database table.
     * @param string $where where is the query condition for deletion.
     * @param string $alias alias is to keep aliases for query or not.
     * @param string $join join is to make joins while deleting records.
     * @return boolean $res returns TRUE or FALSE.
     */
    public function delete($where = "", $alias = "No", $join = "No")
    {
        if ($this->config->item('PHYSICAL_RECORD_DELETE') && $this->physical_data_remove == 'No')
        {
            if ($alias == "Yes")
            {
                if (is_array($join['joins']) && count($join['joins']))
                {
                    $join_tbls = '';
                    if ($join['list'] == "Yes")
                    {
                        $join_tbls = $this->addJoinTables("NR");
                    }
                    $join_tbls .= ' '.$this->listing->addJoinTables($join['joins'], "NR");
                }
                elseif ($join == "Yes")
                {
                    $join_tbls = $this->addJoinTables("NR");
                }
                $data = $this->general->getPhysicalRecordUpdate($this->table_alias);
                if (trim($join_tbls) != '')
                {
                    $set_cond = array();
                    foreach ($data as $key => $val)
                    {
                        $set_cond[] = $this->db->protect($key)." = ".$this->db->escape($val);
                    }
                    if (is_numeric($where))
                    {
                        $extra_cond = " WHERE ".$this->db->protect($this->table_alias.".".$this->primary_key)." = ".$this->db->escape($where);
                    }
                    elseif ($where)
                    {
                        $extra_cond = " WHERE ".$where;
                    }
                    else
                    {
                        return FALSE;
                    }
                    $update_query = "UPDATE ".$this->db->protect($this->table_name)." AS ".$this->db->protect($this->table_alias)." ".$join_tbls." SET ".implode(", ", $set_cond)." ".$extra_cond;
                    $res = $this->db->query($update_query);
                }
                else
                {
                    if (is_numeric($where))
                    {
                        $this->db->where($this->table_alias.".".$this->primary_key, $where);
                    }
                    elseif ($where)
                    {
                        $this->db->where($where, FALSE, FALSE);
                    }
                    else
                    {
                        return FALSE;
                    }
                    $res = $this->db->update($this->table_name." AS ".$this->table_alias, $data);
                }
            }
            else
            {
                if (is_numeric($where))
                {
                    $this->db->where($this->primary_key, $where);
                }
                elseif ($where)
                {
                    $this->db->where($where, FALSE, FALSE);
                }
                else
                {
                    return FALSE;
                }
                $data = $this->general->getPhysicalRecordUpdate();
                $res = $this->db->update($this->table_name, $data);
            }
        }
        else
        {
            if ($alias == "Yes")
            {
                $del_query = "DELETE ".$this->db->protect($this->table_alias).".* FROM ".$this->db->protect($this->table_name)." AS ".$this->db->protect($this->table_alias);
                if (is_array($join['joins']) && count($join['joins']))
                {
                    if ($join['list'] == "Yes")
                    {
                        $del_query .= $this->addJoinTables("NR");
                    }
                    $del_query .= ' '.$this->listing->addJoinTables($join['joins'], "NR");
                }
                elseif ($join == "Yes")
                {
                    $del_query .= $this->addJoinTables("NR");
                }
                if (is_numeric($where))
                {
                    $del_query .= " WHERE ".$this->db->protect($this->table_alias).".".$this->db->protect($this->primary_key)." = ".$this->db->escape($where);
                }
                elseif ($where)
                {
                    $del_query .= " WHERE ".$where;
                }
                else
                {
                    return FALSE;
                }
                $res = $this->db->query($del_query);
            }
            else
            {
                if (is_numeric($where))
                {
                    $this->db->where($this->primary_key, $where);
                }
                elseif ($where)
                {
                    $this->db->where($where, FALSE, FALSE);
                }
                else
                {
                    return FALSE;
                }
                $res = $this->db->delete($this->table_name);
            }
        }
        return $res;
    }

    /**
     * getData method is used to get data records for this module.
     * @param string $extra_cond extra_cond is the query condition for getting filtered data.
     * @param string $fields fields are either array or string.
     * @param string $order_by order_by is to append order by condition.
     * @param string $group_by group_by is to append group by condition.
     * @param string $limit limit is to append limit condition.
     * @param string $join join is to make joins with relation tables.
     * @param boolean $having_cond having cond is the query condition for getting conditional data.
     * @param boolean $list list is to differ listing fields or form fields.
     * @return array $data_arr returns data records array.
     */
    public function getData($extra_cond = "", $fields = "", $order_by = "", $group_by = "", $limit = "", $join = "No", $having_cond = '', $list = FALSE)
    {
        if (is_array($fields))
        {
            $this->listing->addSelectFields($fields);
        }
        elseif ($fields != "")
        {
            $this->db->select($fields);
        }
        elseif ($list == TRUE)
        {
            $this->db->select($this->table_alias.".".$this->primary_key." AS ".$this->primary_key);
            if ($this->primary_alias != "")
            {
                $this->db->select($this->table_alias.".".$this->primary_key." AS ".$this->primary_alias);
            }
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vFacebookId AS u_facebook_id");
            $this->db->select("u.vGoogleID AS u_google_id");
            $this->db->select("u.vAppleId AS u_apple_id");
            $this->db->select("(if(eEmailVerified = \"1\", 1,0)) AS u_email_verified");
            $this->db->select("u.dAddedDate AS u_added_date");
            $this->db->select("u.eStatus AS u_status");
            $this->db->select("u.eSubscribeEmail AS u_subscribe_email");
        }
        else
        {
            $this->db->select("u.iUsersId AS iUsersId");
            $this->db->select("u.iUsersId AS u_users_id");
            $this->db->select("u.vProfileImage AS u_profile_image");
            $this->db->select("u.vName AS u_name");
            $this->db->select("u.vEmail AS u_email");
            $this->db->select("u.vPassword AS u_password");
            $this->db->select("u.vFacebookId AS u_facebook_id");
            $this->db->select("u.vGoogleID AS u_google_id");
            $this->db->select("u.vPhone AS u_phone");
            $this->db->select("u.eEmailVerified AS u_email_verified");
            $this->db->select("u.eStatus AS u_status");
            $this->db->select("u.tAboutMe AS u_about_me");
            $this->db->select("u.vLatitude AS u_latitude");
            $this->db->select("u.vLongtitude AS u_longtitude");
            $this->db->select("u.dtModifiedDate AS u_modified_date");
            $this->db->select("u.vTempPassword AS u_temp_password");
            $this->db->select("u.vDeviceToken AS u_device_token");
            $this->db->select("u.vCoverPhoto AS u_cover_photo");
            $this->db->select("u.dDOB AS u_d_ob");
            $this->db->select("u.eGender AS u_gender");
            $this->db->select("u.vCoverYDimention AS u_cover_ydimention");
            $this->db->select("u.vCoverVideo AS u_cover_video");
            $this->db->select("u.vAppleId AS u_apple_id");
            $this->db->select("u.dtVpUpdateDate AS u_vp_update_date");
            $this->db->select("u.dtMyFeedUpdateDate AS u_my_feed_update_date");
            $this->db->select("u.vCvHeight AS u_cv_height");
            $this->db->select("u.vCvWidth AS u_cv_width");
            $this->db->select("u.eSubscribeEmail AS u_subscribe_email");
            $this->db->select("u.iUnsubscribeReasonsId AS u_unsubscribe_reasons_id");
            $this->db->select("u.eNotificationPref AS u_notification_pref");
            $this->db->select("u.ePrivacy AS u_privacy");
            $this->db->select("u.eDeviceType AS u_device_type");
            $this->db->select("u.vDeviceName AS u_device_name");
            $this->db->select("u.vDeviceOs AS u_device_os");
            $this->db->select("u.vAppVersion AS u_app_version");
            $this->db->select("u.dAddedDate AS u_added_date");
            $this->db->select("u.dLastLogin AS u_last_login");
        }

        $this->db->from($this->table_name." AS ".$this->table_alias);
        if (is_array($join) && is_array($join['joins']) && count($join['joins']) > 0)
        {
            $this->listing->addJoinTables($join['joins']);
        }
        else
        {


        }
        if (is_array($extra_cond) && count($extra_cond) > 0)
        {
            $this->listing->addWhereFields($extra_cond);
        }
        elseif (is_numeric($extra_cond))
        {
            $this->db->where($this->table_alias.".".$this->primary_key, intval($extra_cond));
        }
        elseif ($extra_cond)
        {
            $this->db->where($extra_cond, FALSE, FALSE);
        }
        $this->general->getPhysicalRecordWhere($this->table_name, $this->table_alias, "AR");
        if ($group_by != "")
        {
            $this->db->group_by($group_by);
        }
        if ($having_cond != "")
        {
            $this->db->having($having_cond, FALSE, FALSE);
        }
        if ($order_by != "")
        {
            $this->db->order_by($order_by);
        }
        if ($limit != "")
        {
            if (is_numeric($limit))
            {
                $this->db->limit($limit);
            }
            else
            {
                list($offset, $limit) = explode(",", $limit);
                $this->db->limit($offset, $limit);
            }
        }
        $data_obj = $this->db->get();
        $data_arr = is_object($data_obj) ? $data_obj->result_array() : array();
        #echo $this->db->last_query();
        return $data_arr;
    }

    /**
     * getListingData method is used to get grid listing data records for this module.
     * @param array $config_arr config_arr for grid listing settigs.
     * @return array $listing_data returns data records array for grid.
     */
    public function getListingData($config_arr = array())
    {
        $page = $config_arr['page'];
        $rows = $config_arr['rows'];
        $sidx = $config_arr['sidx'];
        $sord = $config_arr['sord'];
        $sdef = $config_arr['sdef'];
        $filters = $config_arr['filters'];

        $extra_cond = $config_arr['extra_cond'];
        $group_by = $config_arr['group_by'];
        $having_cond = $config_arr['having_cond'];
        $order_by = $config_arr['order_by'];

        $page = ($page != '') ? $page : 1;
        $rec_per_page = (intval($rows) > 0) ? intval($rows) : $this->rec_per_page;
        $extra_cond = ($extra_cond != "") ? $extra_cond : "";

        $this->db->start_cache();
        $this->db->from($this->table_name." AS ".$this->table_alias);
        $this->addJoinTables("AR");
        if ($extra_cond != "")
        {
            $this->db->where($extra_cond, FALSE, FALSE);
        }
        $this->general->getPhysicalRecordWhere($this->table_name, $this->table_alias, "AR");
        if (is_array($group_by) && count($group_by) > 0)
        {
            $this->db->group_by($group_by);
        }
        if ($having_cond != "")
        {
            $this->db->having($having_cond, FALSE, FALSE);
        }
        $filter_config = array();
        $filter_config['module_config'] = $config_arr['module_config'];
        $filter_config['list_config'] = $config_arr['list_config'];
        $filter_config['form_config'] = $config_arr['form_config'];
        $filter_config['dropdown_arr'] = $config_arr['dropdown_arr'];
        $filter_config['search_config'] = $this->search_config;
        $filter_config['global_filters'] = $this->global_filters;
        $filter_config['table_name'] = $this->table_name;
        $filter_config['table_alias'] = $this->table_alias;
        $filter_config['primary_key'] = $this->primary_key;
        $filter_config['grid_fields'] = $this->grid_fields;

        $filter_main = $this->filter->applyFilter($filters, $filter_config, "Select");
        $filter_left = $this->filter->applyLeftFilter($filters, $filter_config, "Select");
        $filter_range = $this->filter->applyRangeFilter($filters, $filter_config, "Select");
        if ($filter_main != "")
        {
            $this->db->where("(".$filter_main.")", FALSE, FALSE);
        }
        if ($filter_left != "")
        {
            $this->db->where("(".$filter_left.")", FALSE, FALSE);
        }
        if ($filter_range != "")
        {
            $this->db->where("(".$filter_range.")", FALSE, FALSE);
        }

        $this->db->stop_cache();
        if ((is_array($group_by) && count($group_by) > 0) || trim($having_cond) != "")
        {
            $total_records_arr = $this->db->get();
            $total_records = is_object($total_records_arr) ? $total_records_arr->num_rows() : 0;
        }
        else
        {
            $total_records = $this->db->count_all_results();
        }
        $total_pages = $this->listing->getTotalPages($total_records, $rec_per_page);

        $this->db->select($this->table_alias.".".$this->primary_key." AS ".$this->primary_key);
        if ($this->primary_alias != "")
        {
            $this->db->select($this->table_alias.".".$this->primary_key." AS ".$this->primary_alias);
        }
        $this->db->select("u.vProfileImage AS u_profile_image");
        $this->db->select("u.vName AS u_name");
        $this->db->select("u.vEmail AS u_email");
        $this->db->select("u.vFacebookId AS u_facebook_id");
        $this->db->select("u.vGoogleID AS u_google_id");
        $this->db->select("u.vAppleId AS u_apple_id");
        $this->db->select("(if(eEmailVerified = \"1\", 1,0)) AS u_email_verified");
        $this->db->select("u.dAddedDate AS u_added_date");
        $this->db->select("u.eStatus AS u_status");
        $this->db->select("u.eSubscribeEmail AS u_subscribe_email");
        if ($sdef == "Yes")
        {
            if (is_array($order_by) && count($order_by) > 0)
            {
                foreach ($order_by as $orK => $orV)
                {
                    $sort_filed = $orV['field'];
                    $sort_order = (strtolower($orV['order']) == "desc") ? "DESC" : "ASC";
                    $this->db->order_by($sort_filed, $sort_order);
                }
            }
            else
            if (!empty($order_by) && is_string($order_by))
            {
                $this->db->order_by($order_by);
            }
        }
        if ($sidx != "")
        {
            $this->listing->addGridOrderBy($sidx, $sord, $config_arr['list_config']);
        }
        $limit_offset = $this->listing->getStartIndex($total_records, $page, $rec_per_page);
        $this->db->limit($rec_per_page, $limit_offset);
        $return_data_obj = $this->db->get();
        $return_data = is_object($return_data_obj) ? $return_data_obj->result_array() : array();
        $this->db->flush_cache();
        $listing_data = $this->listing->getDataForJqGrid($return_data, $filter_config, $page, $total_pages, $total_records);
        $this->listing_data = $return_data;
        #echo $this->db->last_query();
        return $listing_data;
    }

    /**
     * getExportData method is used to get grid export data records for this module.
     * @param array $config_arr config_arr for grid export settigs.
     * @return array $export_data returns data records array for export.
     */
    public function getExportData($config_arr = array())
    {
        $page = $config_arr['page'];
        $id = $config_arr['id'];
        $rows = $config_arr['rows'];
        $rowlimit = $config_arr['rowlimit'];
        $sidx = $config_arr['sidx'];
        $sord = $config_arr['sord'];
        $sdef = $config_arr['sdef'];
        $filters = $config_arr['filters'];

        $extra_cond = $config_arr['extra_cond'];
        $group_by = $config_arr['group_by'];
        $having_cond = $config_arr['having_cond'];
        $order_by = $config_arr['order_by'];

        $page = ($page != '') ? $page : 1;
        $extra_cond = ($extra_cond != "") ? $extra_cond : "";

        $this->db->from($this->table_name." AS ".$this->table_alias);
        $this->addJoinTables("AR");
        if (is_array($id) && count($id) > 0)
        {
            $this->db->where_in($this->table_alias.".".$this->primary_key, $id);
        }
        if ($extra_cond != "")
        {
            $this->db->where($extra_cond, FALSE, FALSE);
        }
        $this->general->getPhysicalRecordWhere($this->table_name, $this->table_alias, "AR");
        if (is_array($group_by) && count($group_by) > 0)
        {
            $this->db->group_by($group_by);
        }
        if ($having_cond != "")
        {
            $this->db->having($having_cond, FALSE, FALSE);
        }
        $filter_config = array();
        $filter_config['module_config'] = $config_arr['module_config'];
        $filter_config['list_config'] = $config_arr['list_config'];
        $filter_config['form_config'] = $config_arr['form_config'];
        $filter_config['dropdown_arr'] = $config_arr['dropdown_arr'];
        $filter_config['search_config'] = $this->search_config;
        $filter_config['global_filters'] = $this->global_filters;
        $filter_config['table_name'] = $this->table_name;
        $filter_config['table_alias'] = $this->table_alias;
        $filter_config['primary_key'] = $this->primary_key;

        $filter_main = $this->filter->applyFilter($filters, $filter_config, "Select");
        $filter_left = $this->filter->applyLeftFilter($filters, $filter_config, "Select");
        $filter_range = $this->filter->applyRangeFilter($filters, $filter_config, "Select");
        if ($filter_main != "")
        {
            $this->db->where("(".$filter_main.")", FALSE, FALSE);
        }
        if ($filter_left != "")
        {
            $this->db->where("(".$filter_left.")", FALSE, FALSE);
        }
        if ($filter_range != "")
        {
            $this->db->where("(".$filter_range.")", FALSE, FALSE);
        }

        $this->db->select($this->table_alias.".".$this->primary_key." AS ".$this->primary_key);
        if ($this->primary_alias != "")
        {
            $this->db->select($this->table_alias.".".$this->primary_key." AS ".$this->primary_alias);
        }
        $this->db->select("u.vProfileImage AS u_profile_image");
        $this->db->select("u.vName AS u_name");
        $this->db->select("u.vEmail AS u_email");
        $this->db->select("u.vFacebookId AS u_facebook_id");
        $this->db->select("u.vGoogleID AS u_google_id");
        $this->db->select("u.vAppleId AS u_apple_id");
        $this->db->select("(if(eEmailVerified = \"1\", 1,0)) AS u_email_verified");
        $this->db->select("u.dAddedDate AS u_added_date");
        $this->db->select("u.eStatus AS u_status");
        $this->db->select("u.eSubscribeEmail AS u_subscribe_email");
        if ($sdef == "Yes")
        {
            if (is_array($order_by) && count($order_by) > 0)
            {
                foreach ($order_by as $orK => $orV)
                {
                    $sort_filed = $orV['field'];
                    $sort_order = (strtolower($orV['order']) == "desc") ? "DESC" : "ASC";
                    $this->db->order_by($sort_filed, $sort_order);
                }
            }
            else
            if (!empty($order_by) && is_string($order_by))
            {
                $this->db->order_by($order_by);
            }
        }
        if ($sidx != "")
        {
            $this->listing->addGridOrderBy($sidx, $sord, $config_arr['list_config']);
        }
        if ($rowlimit != "")
        {
            $offset = $rowlimit;
            $limit = ($rowlimit*$page-$rowlimit);
            $this->db->limit($offset, $limit);
        }
        $export_data_obj = $this->db->get();
        $export_data = is_object($export_data_obj) ? $export_data_obj->result_array() : array();
        #echo $this->db->last_query();
        return $export_data;
    }

    /**
     * addJoinTables method is used to make relation tables joins with main table.
     * @param string $type type is to get active record or join string.
     * @param boolean $allow_tables allow_table is to restrict some set of tables.
     * @return string $ret_joins returns relation tables join string.
     */
    public function addJoinTables($type = 'AR', $allow_tables = FALSE)
    {
        $join_tables = $this->join_tables;
        if (!is_array($join_tables) || count($join_tables) == 0)
        {
            return '';
        }
        $ret_joins = $this->listing->addJoinTables($join_tables, $type, $allow_tables);
        return $ret_joins;
    }

    /**
     * getListConfiguration method is used to get listing configuration array.
     * @param string $name name is to get specific field configuration.
     * @return array $config_arr returns listing configuration array.
     */
    public function getListConfiguration($name = "")
    {
        $list_config = array(
            "u_profile_image" => array(
                "name" => "u_profile_image",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vProfileImage",
                "source_field" => "u_profile_image",
                "display_query" => "u.vProfileImage",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_in" => "Both",
                "type" => "file",
                "align" => "left",
                "label" => "Profile Image",
                "lang_code" => "USERS_PROFILE_IMAGE",
                "label_lang" => $this->lang->line('USERS_PROFILE_IMAGE'),
                "width" => 50,
                "search" => "Yes",
                "export" => "No",
                "sortable" => "No",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
                "file_upload" => "Yes",
                "file_inline" => "Yes",
                "file_server" => "amazon",
                "file_folder" => "profile_image",
                "file_width" => "50",
                "file_height" => "50",
            ),
            "u_name" => array(
                "name" => "u_name",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vName",
                "source_field" => "u_name",
                "display_query" => "u.vName",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_in" => "Both",
                "type" => "textbox",
                "align" => "left",
                "label" => "Name",
                "lang_code" => "USERS_NAME",
                "label_lang" => $this->lang->line('USERS_NAME'),
                "width" => 50,
                "search" => "Yes",
                "export" => "No",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
                "edit_link" => "Yes",
            ),
            "u_email" => array(
                "name" => "u_email",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vEmail",
                "source_field" => "u_email",
                "display_query" => "u.vEmail",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_in" => "Both",
                "type" => "textbox",
                "align" => "left",
                "label" => "Email",
                "lang_code" => "USERS_EMAIL",
                "label_lang" => $this->lang->line('USERS_EMAIL'),
                "width" => 70,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
            ),
            "u_facebook_id" => array(
                "name" => "u_facebook_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vFacebookId",
                "source_field" => "u_facebook_id",
                "display_query" => "u.vFacebookId",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_in" => "Both",
                "type" => "textbox",
                "align" => "left",
                "label" => "Facebook ID",
                "lang_code" => "USERS_FACEBOOK_ID",
                "label_lang" => $this->lang->line('USERS_FACEBOOK_ID'),
                "width" => 70,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
            ),
            "u_google_id" => array(
                "name" => "u_google_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vGoogleID",
                "source_field" => "u_google_id",
                "display_query" => "u.vGoogleID",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_in" => "Both",
                "type" => "textbox",
                "align" => "left",
                "label" => "Google ID",
                "lang_code" => "USERS_GOOGLE_ID",
                "label_lang" => $this->lang->line('USERS_GOOGLE_ID'),
                "width" => 70,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
            ),
            "u_apple_id" => array(
                "name" => "u_apple_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vAppleId",
                "source_field" => "u_apple_id",
                "display_query" => "u.vAppleId",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_in" => "Both",
                "type" => "textbox",
                "align" => "left",
                "label" => "Apple Id",
                "lang_code" => "USERS_APPLE_ID",
                "label_lang" => $this->lang->line('USERS_APPLE_ID'),
                "width" => 70,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
            ),
            "u_email_verified" => array(
                "name" => "u_email_verified",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eEmailVerified",
                "source_field" => "u_email_verified",
                "display_query" => "(if(eEmailVerified = \"1\", 1,0))",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_in" => "Both",
                "type" => "radio_buttons",
                "align" => "center",
                "label" => "Email Verified",
                "lang_code" => "USERS_EMAIL_VERIFIED",
                "label_lang" => $this->lang->line('USERS_EMAIL_VERIFIED'),
                "width" => 50,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
                "default" => $this->filter->getDefaultValue("u_email_verified",
                "Text",
                "No")
            ),
            "u_added_date" => array(
                "name" => "u_added_date",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dAddedDate",
                "source_field" => "u_added_date",
                "display_query" => "u.dAddedDate",
                "entry_type" => "Table",
                "data_type" => "datetime",
                "show_in" => "Both",
                "type" => "date_and_time",
                "align" => "left",
                "label" => "Registered Date",
                "lang_code" => "USERS_REGISTERED_DATE",
                "label_lang" => $this->lang->line('USERS_REGISTERED_DATE'),
                "width" => 50,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
                "default" => $this->filter->getDefaultValue("u_added_date",
                "MySQL",
                "NOW()"),
                "format" => $this->general->getAdminPHPFormats('date_and_time')
            ),
            "u_status" => array(
                "name" => "u_status",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eStatus",
                "source_field" => "u_status",
                "display_query" => "u.eStatus",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_in" => "Both",
                "type" => "dropdown",
                "align" => "center",
                "label" => "Status",
                "lang_code" => "USERS_STATUS",
                "label_lang" => $this->lang->line('USERS_STATUS'),
                "width" => 50,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
                "default" => $this->filter->getDefaultValue("u_status",
                "Text",
                "Inactive")
            ),
            "u_subscribe_email" => array(
                "name" => "u_subscribe_email",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eSubscribeEmail",
                "source_field" => "u_subscribe_email",
                "display_query" => "u.eSubscribeEmail",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_in" => "Both",
                "type" => "dropdown",
                "align" => "center",
                "label" => "Subscribe Email",
                "lang_code" => "USERS_SUBSCRIBE_EMAIL",
                "label_lang" => $this->lang->line('USERS_SUBSCRIBE_EMAIL'),
                "width" => 150,
                "search" => "Yes",
                "export" => "Yes",
                "sortable" => "Yes",
                "addable" => "No",
                "editable" => "No",
                "viewedit" => "No",
            )
        );

        $config_arr = array();
        if (is_array($name) && count($name) > 0)
        {
            $name_cnt = count($name);
            for ($i = 0; $i < $name_cnt; $i++)
            {
                $config_arr[$name[$i]] = $list_config[$name[$i]];
            }
        }
        elseif ($name != "" && is_string($name))
        {
            $config_arr = $list_config[$name];
        }
        else
        {
            $config_arr = $list_config;
        }
        return $config_arr;
    }

    /**
     * getFormConfiguration method is used to get form configuration array.
     * @param string $name name is to get specific field configuration.
     * @return array $config_arr returns form configuration array.
     */
    public function getFormConfiguration($name = "")
    {
        $form_config = array(
            "sys_static_field_1" => array(
                "name" => "sys_static_field_1",
                "table_name" => "",
                "table_alias" => "",
                "field_name" => "sysStaticField_1",
                "entry_type" => "Static",
                "data_type" => "",
                "show_input" => "Both",
                "type" => "",
                "label" => "Empty Row - 1",
                "lang_code" => "USERS_EMPTY_ROW__C45_1",
                "label_lang" => $this->lang->line('USERS_EMPTY_ROW__C45_1')
            ),
            "u_profile_image" => array(
                "name" => "u_profile_image",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vProfileImage",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Both",
                "type" => "file",
                "label" => "Profile Image",
                "lang_code" => "USERS_PROFILE_IMAGE",
                "label_lang" => $this->lang->line('USERS_PROFILE_IMAGE'),
                "file_upload" => "Yes",
                "file_server" => "amazon",
                "file_folder" => "profile_image",
                "file_width" => "50",
                "file_height" => "50",
                "file_format" => "gif,png,jpg,jpeg,jpe,bmp,ico",
                "file_size" => "102400",
                "file_label" => "Yes",
            ),
            "u_name" => array(
                "name" => "u_name",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vName",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Both",
                "type" => "textbox",
                "label" => "Name",
                "lang_code" => "USERS_NAME",
                "label_lang" => $this->lang->line('USERS_NAME')
            ),
            "u_email" => array(
                "name" => "u_email",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vEmail",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Both",
                "type" => "textbox",
                "label" => "Email",
                "lang_code" => "USERS_EMAIL",
                "label_lang" => $this->lang->line('USERS_EMAIL')
            ),
            "u_password" => array(
                "name" => "u_password",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vPassword",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "password",
                "label" => "Password",
                "lang_code" => "USERS_PASSWORD",
                "label_lang" => $this->lang->line('USERS_PASSWORD')
            ),
            "u_facebook_id" => array(
                "name" => "u_facebook_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vFacebookId",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Update",
                "type" => "textbox",
                "label" => "Facebook ID",
                "lang_code" => "USERS_FACEBOOK_ID",
                "label_lang" => $this->lang->line('USERS_FACEBOOK_ID')
            ),
            "u_google_id" => array(
                "name" => "u_google_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vGoogleID",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Update",
                "type" => "textbox",
                "label" => "Google ID",
                "lang_code" => "USERS_GOOGLE_ID",
                "label_lang" => $this->lang->line('USERS_GOOGLE_ID')
            ),
            "u_phone" => array(
                "name" => "u_phone",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vPhone",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Both",
                "type" => "phone_number",
                "label" => "Phone",
                "lang_code" => "USERS_PHONE",
                "label_lang" => $this->lang->line('USERS_PHONE'),
                "format" => $this->general->getAdminPHPFormats('phone'),
                "interface" => textbox,
            ),
            "u_email_verified" => array(
                "name" => "u_email_verified",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eEmailVerified",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Both",
                "type" => "radio_buttons",
                "label" => "Email Verified",
                "lang_code" => "USERS_EMAIL_VERIFIED",
                "label_lang" => $this->lang->line('USERS_EMAIL_VERIFIED'),
                "default" => $this->filter->getDefaultValue("u_email_verified",
                "Text",
                "No"),
                "dfapply" => "addOnly",
            ),
            "u_status" => array(
                "name" => "u_status",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eStatus",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Both",
                "type" => "dropdown",
                "label" => "Status",
                "lang_code" => "USERS_STATUS",
                "label_lang" => $this->lang->line('USERS_STATUS'),
                "default" => $this->filter->getDefaultValue("u_status",
                "Text",
                "Inactive"),
                "dfapply" => "addOnly",
            ),
            "u_about_me" => array(
                "name" => "u_about_me",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "tAboutMe",
                "entry_type" => "Table",
                "data_type" => "text",
                "show_input" => "Hidden",
                "type" => "textarea",
                "label" => "About Me",
                "lang_code" => "USERS_ABOUT_ME",
                "label_lang" => $this->lang->line('USERS_ABOUT_ME')
            ),
            "u_latitude" => array(
                "name" => "u_latitude",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vLatitude",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Latitude",
                "lang_code" => "USERS_LATITUDE",
                "label_lang" => $this->lang->line('USERS_LATITUDE')
            ),
            "u_longtitude" => array(
                "name" => "u_longtitude",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vLongtitude",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Longtitude",
                "lang_code" => "USERS_LONGTITUDE",
                "label_lang" => $this->lang->line('USERS_LONGTITUDE')
            ),
            "u_modified_date" => array(
                "name" => "u_modified_date",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dtModifiedDate",
                "entry_type" => "Table",
                "data_type" => "datetime",
                "show_input" => "Hidden",
                "type" => "date",
                "label" => "Modified Date",
                "lang_code" => "USERS_MODIFIED_DATE",
                "label_lang" => $this->lang->line('USERS_MODIFIED_DATE'),
                "default" => $this->filter->getDefaultValue("u_modified_date",
                "MySQL",
                "NOW()"),
                "dfapply" => "everyUpdate",
                "format" => 'Y-m-d',
            ),
            "u_temp_password" => array(
                "name" => "u_temp_password",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vTempPassword",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "",
                "label" => "Temp Password",
                "lang_code" => "USERS_TEMP_PASSWORD",
                "label_lang" => $this->lang->line('USERS_TEMP_PASSWORD')
            ),
            "u_device_token" => array(
                "name" => "u_device_token",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vDeviceToken",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Device Token",
                "lang_code" => "USERS_DEVICE_TOKEN",
                "label_lang" => $this->lang->line('USERS_DEVICE_TOKEN')
            ),
            "u_cover_photo" => array(
                "name" => "u_cover_photo",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vCoverPhoto",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Cover Photo",
                "lang_code" => "USERS_COVER_PHOTO",
                "label_lang" => $this->lang->line('USERS_COVER_PHOTO')
            ),
            "u_d_ob" => array(
                "name" => "u_d_ob",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dDOB",
                "entry_type" => "Table",
                "data_type" => "date",
                "show_input" => "Hidden",
                "type" => "date",
                "label" => "D Ob",
                "lang_code" => "USERS_D_OB",
                "label_lang" => $this->lang->line('USERS_D_OB'),
                "format" => '',
            ),
            "u_gender" => array(
                "name" => "u_gender",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eGender",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Hidden",
                "type" => "dropdown",
                "label" => "Gender",
                "lang_code" => "USERS_GENDER",
                "label_lang" => $this->lang->line('USERS_GENDER')
            ),
            "u_cover_ydimention" => array(
                "name" => "u_cover_ydimention",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vCoverYDimention",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Cover Ydimention",
                "lang_code" => "USERS_COVER_YDIMENTION",
                "label_lang" => $this->lang->line('USERS_COVER_YDIMENTION')
            ),
            "u_cover_video" => array(
                "name" => "u_cover_video",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vCoverVideo",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Cover Video",
                "lang_code" => "USERS_COVER_VIDEO",
                "label_lang" => $this->lang->line('USERS_COVER_VIDEO')
            ),
            "u_apple_id" => array(
                "name" => "u_apple_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vAppleId",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Apple Id",
                "lang_code" => "USERS_APPLE_ID",
                "label_lang" => $this->lang->line('USERS_APPLE_ID')
            ),
            "u_vp_update_date" => array(
                "name" => "u_vp_update_date",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dtVpUpdateDate",
                "entry_type" => "Table",
                "data_type" => "datetime",
                "show_input" => "Hidden",
                "type" => "date",
                "label" => "Vp Update Date",
                "lang_code" => "USERS_VP_UPDATE_DATE",
                "label_lang" => $this->lang->line('USERS_VP_UPDATE_DATE'),
                "format" => '',
            ),
            "u_my_feed_update_date" => array(
                "name" => "u_my_feed_update_date",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dtMyFeedUpdateDate",
                "entry_type" => "Table",
                "data_type" => "datetime",
                "show_input" => "Hidden",
                "type" => "date",
                "label" => "My Feed Update Date",
                "lang_code" => "USERS_MY_FEED_UPDATE_DATE",
                "label_lang" => $this->lang->line('USERS_MY_FEED_UPDATE_DATE'),
                "format" => '',
            ),
            "u_cv_height" => array(
                "name" => "u_cv_height",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vCvHeight",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Cv Height",
                "lang_code" => "USERS_CV_HEIGHT",
                "label_lang" => $this->lang->line('USERS_CV_HEIGHT')
            ),
            "u_cv_width" => array(
                "name" => "u_cv_width",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vCvWidth",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Hidden",
                "type" => "textbox",
                "label" => "Cv Width",
                "lang_code" => "USERS_CV_WIDTH",
                "label_lang" => $this->lang->line('USERS_CV_WIDTH')
            ),
            "u_subscribe_email" => array(
                "name" => "u_subscribe_email",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eSubscribeEmail",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Both",
                "type" => "dropdown",
                "label" => "Subscribe Email",
                "lang_code" => "USERS_SUBSCRIBE_EMAIL",
                "label_lang" => $this->lang->line('USERS_SUBSCRIBE_EMAIL')
            ),
            "u_unsubscribe_reasons_id" => array(
                "name" => "u_unsubscribe_reasons_id",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "iUnsubscribeReasonsId",
                "entry_type" => "Table",
                "data_type" => "int",
                "show_input" => "Hidden",
                "type" => "dropdown",
                "label" => "Unsubscribe Reasons Id",
                "lang_code" => "USERS_UNSUBSCRIBE_REASONS_ID",
                "label_lang" => $this->lang->line('USERS_UNSUBSCRIBE_REASONS_ID')
            ),
            "sys_static_field_2" => array(
                "name" => "sys_static_field_2",
                "table_name" => "",
                "table_alias" => "",
                "field_name" => "sysStaticField_2",
                "entry_type" => "Static",
                "data_type" => "",
                "show_input" => "Both",
                "type" => "",
                "label" => "Empty Row - 2",
                "lang_code" => "USERS_EMPTY_ROW__C45_2",
                "label_lang" => $this->lang->line('USERS_EMPTY_ROW__C45_2')
            ),
            "u_notification_pref" => array(
                "name" => "u_notification_pref",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eNotificationPref",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Both",
                "type" => "radio_buttons",
                "label" => "Notification Pref",
                "lang_code" => "USERS_NOTIFICATION_PREF",
                "label_lang" => $this->lang->line('USERS_NOTIFICATION_PREF'),
                "default" => $this->filter->getDefaultValue("u_notification_pref",
                "Text",
                "Yes"),
                "dfapply" => "addOnly",
            ),
            "u_privacy" => array(
                "name" => "u_privacy",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "ePrivacy",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Both",
                "type" => "radio_buttons",
                "label" => "Privacy",
                "lang_code" => "USERS_PRIVACY",
                "label_lang" => $this->lang->line('USERS_PRIVACY'),
                "default" => $this->filter->getDefaultValue("u_privacy",
                "Text",
                "0"),
                "dfapply" => "addOnly",
            ),
            "u_device_type" => array(
                "name" => "u_device_type",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "eDeviceType",
                "entry_type" => "Table",
                "data_type" => "enum",
                "show_input" => "Update",
                "type" => "dropdown",
                "label" => "Device Type",
                "lang_code" => "USERS_DEVICE_TYPE",
                "label_lang" => $this->lang->line('USERS_DEVICE_TYPE'),
                "default" => $this->filter->getDefaultValue("u_device_type",
                "Text",
                "-----"),
                "dfapply" => "updateOnly",
            ),
            "u_device_name" => array(
                "name" => "u_device_name",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vDeviceName",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Update",
                "type" => "textbox",
                "label" => "Device Name",
                "lang_code" => "USERS_DEVICE_NAME",
                "label_lang" => $this->lang->line('USERS_DEVICE_NAME'),
                "default" => $this->filter->getDefaultValue("u_device_name",
                "Text",
                "-----"),
                "dfapply" => "updateOnly",
            ),
            "u_device_os" => array(
                "name" => "u_device_os",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vDeviceOs",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Update",
                "type" => "textbox",
                "label" => "Device Os",
                "lang_code" => "USERS_DEVICE_OS",
                "label_lang" => $this->lang->line('USERS_DEVICE_OS'),
                "default" => $this->filter->getDefaultValue("u_device_os",
                "Text",
                "-----"),
                "dfapply" => "updateOnly",
            ),
            "u_app_version" => array(
                "name" => "u_app_version",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "vAppVersion",
                "entry_type" => "Table",
                "data_type" => "varchar",
                "show_input" => "Update",
                "type" => "textbox",
                "label" => "App Version",
                "lang_code" => "USERS_APP_VERSION",
                "label_lang" => $this->lang->line('USERS_APP_VERSION'),
                "default" => $this->filter->getDefaultValue("u_app_version",
                "Text",
                "-----"),
                "dfapply" => "updateOnly",
            ),
            "u_added_date" => array(
                "name" => "u_added_date",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dAddedDate",
                "entry_type" => "Table",
                "data_type" => "datetime",
                "show_input" => "Update",
                "type" => "date_and_time",
                "label" => "Registered Date",
                "lang_code" => "USERS_REGISTERED_DATE",
                "label_lang" => $this->lang->line('USERS_REGISTERED_DATE'),
                "default" => $this->filter->getDefaultValue("u_added_date",
                "MySQL",
                "NOW()"),
                "dfapply" => "updateOnly",
                "format" => $this->general->getAdminPHPFormats('date_and_time')
            ),
            "u_last_login" => array(
                "name" => "u_last_login",
                "table_name" => "users",
                "table_alias" => "u",
                "field_name" => "dLastLogin",
                "entry_type" => "Table",
                "data_type" => "datetime",
                "show_input" => "Both",
                "type" => "date_and_time",
                "label" => "Last Login",
                "lang_code" => "USERS_LAST_LOGIN",
                "label_lang" => $this->lang->line('USERS_LAST_LOGIN'),
                "format" => $this->general->getAdminPHPFormats('date_and_time')
            )
        );

        $config_arr = array();
        if (is_array($name) && count($name) > 0)
        {
            $name_cnt = count($name);
            for ($i = 0; $i < $name_cnt; $i++)
            {
                $config_arr[$name[$i]] = $form_config[$name[$i]];
            }
        }
        elseif ($name != "" && is_string($name))
        {
            $config_arr = $form_config[$name];
        }
        else
        {
            $config_arr = $form_config;
        }
        return $config_arr;
    }

    /**
     * checkRecordExists method is used to check duplication of records.
     * @param array $field_arr field_arr is having fields to check.
     * @param array $field_val field_val is having values of respective fields.
     * @param numeric $id id is to avoid current records.
     * @param string $mode mode is having either Add or Update.
     * @param string $con con is having either AND or OR.
     * @return boolean $exists returns either TRUE of FALSE.
     */
    public function checkRecordExists($field_arr = array(), $field_val = array(), $id = '', $mode = '', $con = 'AND')
    {
        $exists = FALSE;
        if (!is_array($field_arr) || count($field_arr) == 0)
        {
            return $exists;
        }
        foreach ((array) $field_arr as $key => $val)
        {
            $extra_cond_arr[] = $this->db->protect($this->table_alias.".".$field_arr[$key])." =  ".$this->db->escape(trim($field_val[$val]));
        }
        $extra_cond = "(".implode(" ".$con." ", $extra_cond_arr).")";
        if ($mode == "Add")
        {
            $data = $this->getData($extra_cond, "COUNT(*) AS tot");
            if ($data[0]['tot'] > 0)
            {
                $exists = TRUE;
            }
        }
        elseif ($mode == "Update")
        {
            $extra_cond = $this->db->protect($this->table_alias.".".$this->primary_key)." <> ".$this->db->escape($id)." AND ".$extra_cond;
            $data = $this->getData($extra_cond, "COUNT(*) AS tot");
            if ($data[0]['tot'] > 0)
            {
                $exists = TRUE;
            }
        }
        return $exists;
    }

    /**
     * getSwitchTo method is used to get switch to dropdown array.
     * @param string $extra_cond extra_cond is the query condition for getting filtered data.
     * @return array $switch_data returns data records array.
     */
    public function getSwitchTo($extra_cond = '', $type = 'records', $limit = '')
    {
        $switchto_fields = $this->switchto_fields;
        $switch_data = array();
        if (!is_array($switchto_fields) || count($switchto_fields) == 0)
        {
            if ($type == "count")
            {
                return count($switch_data);
            }
            else
            {
                return $switch_data;
            }
        }
        $fields_arr = array();
        $fields_arr[] = array(
            "field" => $this->table_alias.".".$this->primary_key." AS id",
        );
        $fields_arr[] = array(
            "field" => $this->db->concat($switchto_fields)." AS val",
            "escape" => TRUE,
        );
        if (is_array($this->switchto_options) && count($this->switchto_options) > 0)
        {
            foreach ($this->switchto_options as $option)
            {
                $fields_arr[] = array(
                    "field" => $option,
                    "escape" => TRUE,
                );
            }
        }
        if (trim($this->extra_cond) != "")
        {
            $extra_cond = (trim($extra_cond) != "") ? $extra_cond." AND ".$this->extra_cond : $this->extra_cond;
        }
        $switch_data = $this->getData($extra_cond, $fields_arr, "val ASC", "", $limit, "Yes");
        #echo $this->db->last_query();
        if ($type == "count")
        {
            return count($switch_data);
        }
        else
        {
            return $switch_data;
        }
    }
}
