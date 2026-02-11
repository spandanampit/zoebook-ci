<?php
            
/**
 * Description of End Live Stream Extended Controller
 * 
 * @module Extended End Live Stream
 * 
 * @class Cit_End_live_stream.php
 * 
 * @path application\webservice\tokbox\controllers\Cit_End_live_stream.php
 * 
 * @author CIT Dev Team
 * 
 * @date 18.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_End_live_stream extends End_live_stream {
        public function __construct()
{
    parent::__construct();
}


public function stop_tokbox_archive($input_params = array()){
	$this->load->library('tokbox');
	$response  = $this->tokbox->stopArchive($input_params['ts_archive_id']);
	$ret_arr[0]['archive_status'] = 'stopped';	
	return $ret_arr;
}

public function get_archive_status($input_params = array()){
	$this->load->library('tokbox');
	$response  = $this->tokbox->getArchive($input_params['ts_archive_id']);
	$ret_arr[0]['final_archive_status'] = $response['status'];	
	$ret_arr[0]['archive_url'] = $response['url'];	
	return $ret_arr;
}
}
