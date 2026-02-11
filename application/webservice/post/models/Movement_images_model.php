<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Movement Images Model
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage models
 *
 * @module Movement Images
 *
 * @class Movement_images_model.php
 *
 * @path application\webservice\post\models\Movement_images_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 18.04.2023
 */

class Movement_images_model extends CI_Model
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
     * get_movement_image method is used to execute database queries for Edit movement API.
     * @created Rohit Patidar | 09.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param string $movement_image_id movement_image_id is used to process query block.
     * @param string $movements_id movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_image($movement_image_id = '', $movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            if ($tmp_arr = filterEmptyValues($movement_image_id))
            {
                $old_arr = $movement_image_id;
                $movement_image_id = $tmp_arr;
                $this->db->where_in("mi.iMovementImagesId", $movement_image_id);
                $movement_image_id = $old_arr;
            }
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("mi.iMovementsId =", $movements_id);
            }
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

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
     * delete_form_movement_image method is used to execute database queries for Edit movement API.
     * @created Rohit Patidar | 09.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param string $movements_id movements_id is used to process query block.
     * @param string $movement_image_id movement_image_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function delete_form_movement_image($movements_id = '', $movement_image_id = '')
    {
        try
        {
            $result_arr = array();
            if ($this->config->item('PHYSICAL_RECORD_DELETE'))
            {
                if (isset($movements_id) && $movements_id != "")
                {
                    $this->db->where("iMovementsId =", $movements_id);
                }
                if ($tmp_arr = filterEmptyValues($movement_image_id))
                {
                    $old_arr = $movement_image_id;
                    $movement_image_id = $tmp_arr;
                    $this->db->where_in("iMovementImagesId", $movement_image_id);
                    $movement_image_id = $old_arr;
                }
                $data = $this->general->getPhysicalRecordUpdate();
                $res = $this->db->update("movement_images", $data);
            }
            else
            {
                if (isset($movements_id) && $movements_id != "")
                {
                    $this->db->where("iMovementsId =", $movements_id);
                }
                if ($tmp_arr = filterEmptyValues($movement_image_id))
                {
                    $old_arr = $movement_image_id;
                    $movement_image_id = $tmp_arr;
                    $this->db->where_in("iMovementImagesId", $movement_image_id);
                    $movement_image_id = $old_arr;
                }
                $res = $this->db->delete("movement_images");
            }
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
     * insert_movement_image method is used to execute database queries for Add movement  image API.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $params_arr params_arr array to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function insert_movement_image($params_arr = array())
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
                $this->db->set("iMovementsId", $params_arr["movements_id"]);
            }
            if (isset($params_arr["upload_file"]) && !empty($params_arr["upload_file"]))
            {
                $this->db->set("vUploadFile", $params_arr["upload_file"]);
            }
            if (isset($params_arr["media_type"]))
            {
                $this->db->set("eMediaType", $params_arr["media_type"]);
            }
            if (isset($params_arr["video_tumbnail"]))
            {
                $this->db->set("vVideoTumbnail", $params_arr["video_tumbnail"]);
            }
            if (isset($params_arr["width"]))
            {
                $this->db->set("vMheight", $params_arr["width"]);
            }
            if (isset($params_arr["height"]))
            {
                $this->db->set("vMwidth", $params_arr["height"]);
            }
            $this->db->set($this->db->protect("dAddedDate"), $params_arr["_daddeddate"], FALSE);
            $this->db->set($this->db->protect("dModifiedDate"), $params_arr["_dmodifieddate"], FALSE);
            $this->db->set("eStatus", $params_arr["_estatus"]);
            $this->db->insert("movement_images");
            $insert_id = $this->db->insert_id();
            if (!$insert_id)
            {
                throw new Exception("Failure in insertion.");
            }
            $result_param = "insert_id";
            $result_arr[0][$result_param] = $insert_id;
            $success = 1;

            $this->db->where("iMovementImagesId", $insert_id);
            $this->db->select("iMovementsId");
            $data_obj = $this->db->get("movement_images");
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
     * get_movement_file method is used to execute database queries for Add movement  image API.
     * @created Rohit Patidar | 13.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param string $movements_id movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movement_file($movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            $this->db->select("mi.vMheight AS mi_mheight");
            $this->db->select("mi.vMwidth AS mi_mwidth");
            $this->db->select("mi.dAddedDate AS mi_added_date");
            $this->db->select("mi.dModifiedDate AS mi_modified_date");
            $this->db->select("mi.eStatus AS mi_status");
            if (isset($movements_id) && $movements_id != "")
            {
                $this->db->where("mi.iMovementsId =", $movements_id);
            }
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

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
     * get_my_movement_file method is used to execute database queries for My Movements API.
     * @created Rohit Patidar | 13.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param string $mm_ids mm_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_my_movement_file($mm_ids = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            $this->db->select("mi.vMheight AS mi_mheight");
            $this->db->select("mi.vMwidth AS mi_mwidth");
            $this->db->where("mi.iMovementsId in('".$mm_ids."')", FALSE, FALSE);
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

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
     * get_popular_movement_file method is used to execute database queries for Popular movements API.
     * @created Rohit Patidar | 16.09.2021
     * @modified Jay Rajput | 16.08.2022
     * @param string $mm_ids mm_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_popular_movement_file($mm_ids = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            $this->db->select("mi.vMheight AS mi_mheight");
            $this->db->select("mi.vMwidth AS mi_mwidth");
            $this->db->where("mi.iMovementsId in ('".$mm_ids."')", FALSE, FALSE);
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

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
     * get_movements_file method is used to execute database queries for Movements Details API.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param string $m_movements_id m_movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_movements_file($m_movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            $this->db->select("mi.vMheight AS mi_mheight");
            $this->db->select("mi.vMwidth AS mi_mwidth");
            if (isset($m_movements_id) && $m_movements_id != "")
            {
                $this->db->where("mi.iMovementsId =", $m_movements_id);
            }
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

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
     * moment_images method is used to execute database queries for Search movements API.
     * @created Rohit Patidar | 24.09.2021
     * @modified Jay Rajput | 17.08.2022
     * @param string $mm_ids mm_ids is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function moment_images($mm_ids = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            $this->db->select("mi.vMheight AS mi_mheight");
            $this->db->select("mi.vMwidth AS mi_mwidth");
            $this->db->where("mi.iMovementsId in ('".$mm_ids."')", FALSE, FALSE);
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

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
     * get_insta_movements_file method is used to execute database queries for Movement insta view API.
     * @created Rohit Patidar | 27.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param string $m_movements_id m_movements_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_insta_movements_file($m_movements_id = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("movement_images AS mi");

            $this->db->select("mi.iMovementImagesId AS mi_movement_images_id");
            $this->db->select("mi.iMovementsId AS mi_movements_id");
            $this->db->select("mi.eMediaType AS mi_media_type");
            $this->db->select("mi.vUploadFile AS mi_upload_file");
            $this->db->select("mi.vMheight AS mi_mheight");
            $this->db->select("mi.vMwidth AS mi_mwidth");
            if (isset($m_movements_id) && $m_movements_id != "")
            {
                $this->db->where("mi.iMovementsId =", $m_movements_id);
            }
            $this->general->getPhysicalRecordWhere("movement_images", "mi", "AR");

            $this->db->order_by("mi.iMovementImagesId", "asc");

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
