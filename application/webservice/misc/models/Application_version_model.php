<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Application Version Model
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage models
 *
 * @module Application Version
 *
 * @class Application_version_model.php
 *
 * @path application\webservice\misc\models\Application_version_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 12.10.2022
 */

class Application_version_model extends CI_Model
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
     * current_version method is used to execute database queries for Application Version Status API.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Jay Rajput | 08.09.2022
     * @param string $version_number version_number is used to process query block.
     * @param string $device_type device_type is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function current_version($version_number = '', $device_type = '')
    {
        try
        {
            $result_arr = array();

            $this->db->from("mod_application_version AS mav");
            $this->db->join("mod_application_master AS mam", "mav.iApplicationMasterId = mam.iApplicationMasterId", "left");

            $this->db->select("mav.vVersionName AS version_name");
            $this->db->select("mav.eForceUpdate AS force_update");
            $this->db->select("mav.vVersionNumber AS version_number1");
            $this->db->select("mam.eDeviceType AS device_type1");
            $this->db->select("mam.dDateAdded AS date_added");
            $this->db->select("(IF('".$version_number."' >= mav.vVersionNumber , 0,mav.eForceUpdate)) AS app_update_code", FALSE);
            if ($tmp_arr = filterEmptyValues($device_type))
            {
                $old_arr = $device_type;
                $device_type = $tmp_arr;
                $this->db->where_in("mam.eDeviceType", $device_type);
                $device_type = $old_arr;
            }
            $this->db->where_in("mam.eStatus", array('Active'));

            $this->db->order_by("mav.iApplicationVersionId", "desc");

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
