<?php  

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Website Screenshots Model
 * 
 * @category webservice
 *            
 * @package tools
 *
 * @subpackage models
 *
 * @module Website Screenshots
 * 
 * @class Website_screenshots_model.php
 * 
 * @path application\webservice\tools\models\Website_screenshots_model.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 18.03.2020
 */
 
class Website_screenshots_model extends CI_Model
{
    public $default_lang = 'EN';
    
    /**
     * __construct method is used to set model preferences while model object initialization.
     */
    public function __construct() {
        parent::__construct();
        $this->load->helper('listing');
        $this->default_lang = $this->general->getLangRequestValue();
    }
    
    /**
     * type_wise_screenshots method is used to execute database queries for Get Website Screenshots API.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param string $type type is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function type_wise_screenshots($type = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("website_screenshots AS ws");
            
            $this->db->select("ws.iWebsiteScreenshotsId AS screenshots_id");
            $this->db->select("ws.vScreenshot AS screenshot");
            $this->db->select("ws.iSequence AS sequence");
            if($tmp_arr = filterEmptyValues($type)){
                $old_arr = $type;
                $type = $tmp_arr;
                $this->db->where_in("ws.eType", $type);
                $type = $old_arr;
            }
            
            $this->db->order_by("ws.iSequence", "asc");
            
            
            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            
            if(!is_array($result_arr) || count($result_arr) == 0){
                throw new Exception('No records found.');
            }
            $success = 1;
        } catch (Exception $e) {
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