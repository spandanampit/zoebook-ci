<?php  

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Page Settings Model
 * 
 * @category webservice
 *            
 * @package tools
 *
 * @subpackage models
 *
 * @module Page Settings
 * 
 * @class Page_settings_model.php
 * 
 * @path application\webservice\tools\models\Page_settings_model.php
 * 
 * @version 4.3
 *
 * @author CIT Dev Team
 * 
 * @since 18.03.2020
 */
 
class Page_settings_model extends CI_Model
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
     * get_data_of_pages method is used to execute database queries for Static Pages API.
     * @created CIT Dev Team
     * @modified ---
     * @param string $page_code page_code is used to process query block.
     * @return array $return_arr returns response of query block.
     */
    public function get_data_of_pages($page_code = '')
    {
        try {
            $result_arr = array();
                                
            $this->db->from("mod_page_settings AS mps");
            
            $this->db->select("mps.vPageTitle AS page_title");
            $this->db->select("mps.vPageCode AS pages_code");
            $this->db->select("mps.vUrl AS page_url");
            $this->db->select("mps.vContent AS page_content");
            $this->db->select("mps.tMetaTitle AS page_meta_title");
            $this->db->select("mps.tMetaKeyword AS page_meta_keyword");
            $this->db->select("mps.tMetaDesc AS page_meta_desc");
            if(isset($page_code) && $page_code != ""){ 
                $this->db->where("mps.vPageCode =", $page_code);
            }
            $this->db->where_in("mps.eStatus", array('Active'));
            
            
            
            $this->db->limit(1);
            
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