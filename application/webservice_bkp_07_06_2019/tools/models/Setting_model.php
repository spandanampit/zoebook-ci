<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Setting Model
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage models
 *
 * @module Setting
 *
 * @class Setting_model.php
 *
 * @path application\webservice\tools\models\Setting_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 04.10.2018
 */

class Setting_model extends CI_Model
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
     * promotional_links method is used to execute database queries for Get Promotional Links API.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @return array $return_arr returns response of query block.
     */
    public function promotional_links()
    {
        try
        {
            $result_arr = array();

            $this->db->from("mod_setting AS ms");

            $this->db->select("(SELECT vValue FROM mod_setting WHERE vName = 'PLAY_STORE_LINK') AS play_store_link", FALSE);
            $this->db->select("(SELECT vValue FROM mod_setting WHERE vName = 'APP_STORE_LINK') AS app_store_link", FALSE);
            $this->db->select("(SELECT vValue FROM mod_setting WHERE vName = 'FACEBOOK_LINK') AS facebook_link", FALSE);
            $this->db->select("(SELECT vValue FROM mod_setting WHERE vName = 'GOOGLE_PLUS_LINK') AS google_plus_link", FALSE);

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
