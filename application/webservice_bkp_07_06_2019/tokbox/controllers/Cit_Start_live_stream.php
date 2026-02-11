<?php
            
/**
 * Description of Start Live Stream Extended Controller
 * 
 * @module Extended Start Live Stream
 * 
 * @class Cit_Start_live_stream.php
 * 
 * @path application\webservice\tokbox\controllers\Cit_Start_live_stream.php
 * 
 * @author CIT Dev Team
 * 
 * @date 12.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Start_live_stream extends Start_live_stream {
        public function __construct()
{
    parent::__construct();
}

public function create_tokbox_session(){
	$this->load->library('tokbox');
	$session_id = $this->tokbox->createSession();
	$ret_arr = array();
	$ret_arr[0]['session_id'] = $session_id;	
	$ret_arr[0]['notification_type'] = 'Live';
	return $ret_arr;
}

public function merge_arr($input_params = array()){
	$ret_arr = array();
	$ret_arr[0]['final_tokbox_session_inserted_id'] = $input_params['tokbox_session_inserted_id'];
	$ret_arr[0]['final_tokbox_session_id'] = $input_params['session_id'];
	$ret_arr[0]['final_tokbox_token'] = $input_params['tokbox_token'];
	return $ret_arr;
}
}
