<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Feature Content Model
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage models
 *
 * @module Feature Content
 *
 * @class Feature_content_model.php
 *
 * @path application\webservice\tools\models\Feature_content_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 04.10.2018
 */

class Feature_content_model extends CI_Model
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
     * feature_contents method is used to execute database queries for Get Feature Contents API.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @return array $return_arr returns response of query block.
     */
    public function feature_contents()
    {
        try
        {
            $result_arr = array();

            $this->db->from("feature_content AS fc");

            $this->db->select("fc.iFeatureContentId AS feature_content_id");
            $this->db->select("fc.vFeatureTitle AS feature_title");
            $this->db->select("fc.tFeatureContent AS feature_content");
            $this->db->select("fc.vFeatureIcon AS feature_icon");
            $this->db->select("fc.iSequence AS sequence");

            $this->db->order_by("fc.iSequence", "asc");

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
