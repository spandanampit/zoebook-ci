<?php
            
/**
 * Description of Share Live Video Post Extended Controller
 * 
 * @module Extended Share Live Video Post
 * 
 * @class Cit_Share_live_video_post.php
 * 
 * @path application\webservice\tokbox\controllers\Cit_Share_live_video_post.php
 * 
 * @author CIT Dev Team
 * 
 * @date 18.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Share_live_video_post extends Share_live_video_post {
        public function __construct()
{
    parent::__construct();
}


public function get_archive_status($input_params = array()){
	$this->load->library('tokbox');
	$response  = $this->tokbox->getArchive($input_params['ts_archive_id']);
	$ret_arr[0]['final_archive_status'] = $response['status'];	
	$ret_arr[0]['archive_url'] = $response['url'];	
	return $ret_arr;
}
}
