<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Wscustom Model
 *
 * @category webservice
 *
 * @package wscustom
 *
 * @subpackage models
 *
 * @module Wscustom
 *
 * @class Wscustom_model.php
 *
 * @path application\webservice\wscustom\models\Wscustom_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 07.01.2019
 */

class Wscustom_model extends CI_Model
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
     * get_fbid_google_id method is used to execute database queries for Login API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $facebook_id facebook_id is used to process query block.
     * @param string $google_id google_id is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_fbid_google_id($facebook_id = '', $google_id = '')
    {
        try
        {
            $result_arr = array();

            $sql_query = "SELECT if('".$facebook_id."' = '',0,'".$facebook_id."') as fb_id, if('".$google_id."' = '',0,'".$google_id."') as g_id LIMIT 1";
            $result_obj = $this->db->query($sql_query);
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
