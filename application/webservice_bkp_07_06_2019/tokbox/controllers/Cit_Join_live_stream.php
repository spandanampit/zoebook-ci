<?php
            
/**
 * Description of Join Live Stream Extended Controller
 * 
 * @module Extended Join Live Stream
 * 
 * @class Cit_Join_live_stream.php
 * 
 * @path application\webservice\tokbox\controllers\Cit_Join_live_stream.php
 * 
 * @author CIT Dev Team
 * 
 * @date 08.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Join_live_stream extends Join_live_stream {
        public function __construct()
{
    parent::__construct();
}


public function generate_tokbox_token($input_params = array()){
	$this->load->library('tokbox');
	$tokbox_token = $this->tokbox->generateToken($input_params['tokbox_live_session_id']);
	$return_arr = array();
	$return_arr['tokbox_token'] = $tokbox_token;
	$return_arr['tokbox_server_session_id'] = $input_params['tokbox_live_session_id'];
	return $return_arr;
}
}
