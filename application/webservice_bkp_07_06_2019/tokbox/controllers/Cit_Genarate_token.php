<?php
            
/**
 * Description of Generate Token Extended Controller
 * 
 * @module Extended Generate Token
 * 
 * @class Cit_Genarate_token.php
 * 
 * @path application\webservice\tokbox\controllers\Cit_Genarate_token.php
 * 
 * @author CIT Dev Team
 * 
 * @date 25.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Genarate_token extends Genarate_token {
        public function __construct()
{
    parent::__construct();
}


public function generate_tokbox_token($input_params = array()){
	$this->load->library('tokbox');
	pr($this->tokbox);exit;
	$tokbox_token = $this->tokbox->generateToken($input_params['tokbox_session_id']);
	$return_arr = array();
	$return_arr['tokbox_token'] = $tokbox_token;
	return $return_arr;
}
}
