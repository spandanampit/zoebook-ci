<?php

   
/**
 * Description of Share Live Video Post Extended Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Extended Share Live Video Post
 *
 * @class Cit_Share_live_video_post.php
 *
 * @path application\webservice\tokbox\controllers\Cit_Share_live_video_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 20.07.2022
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
	try{  
	  $this->load->library('tokbox');
      if($input_params['ts_archive_id'] != ''){
        $response  = $this->tokbox->getArchive($input_params['ts_archive_id']);
        $ret_arr[0]['final_archive_status'] = $response['status'];
        $ret_arr[0]['archive_url'] = $response['url'];
      }else{
        $ret_arr[0]['final_archive_status'] = 'failed';
        $ret_arr[0]['archive_url'] = $response['url'];
      }
	}catch(Exception $e){
	  $ret_arr[0]['final_archive_status'] = 'failed';
      $ret_arr[0]['archive_url'] ='';  
	}  
	return $ret_arr;
}
}
