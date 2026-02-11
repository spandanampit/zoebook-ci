<?php

   
/**
 * Description of Start Live Stream Extended Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Extended Start Live Stream
 *
 * @class Cit_Start_live_stream.php
 *
 * @path application\webservice\tokbox\controllers\Cit_Start_live_stream.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 21.07.2022
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
	try{
	 $session_id = $this->tokbox->createSession();
	 $ret_arr = array();
	 if(!empty($session_id)){
	   $ret_arr[0]['session_id'] = $session_id;	
	   $ret_arr[0]['notification_type'] = 'Live';    
	 }else{
	  throw new Exception();   
	 }
	}catch(Exception $e){
	  $ret_arr[0]['session_id']='';
	  $ret_arr[0]['notification_type'] ='';
	 }
		return $ret_arr;
}

public function merge_arr($input_params = array()){
	$ret_arr = array();
	try{
	if(!empty($input_params['tokbox_session_inserted_id']) && !empty($input_params['session_id']) && !empty($input_params['tokbox_token']) && !empty($input_params['post_id'])){
	   $ret_arr[0]['final_tokbox_session_inserted_id'] = $input_params['tokbox_session_inserted_id'];
       $ret_arr[0]['final_tokbox_session_id'] = $input_params['session_id'];
	   $ret_arr[0]['final_tokbox_token'] = $input_params['tokbox_token'];
	   $ret_arr[0]['final_post_id'] = $input_params['post_id'];    
	 }else{
	     throw new Exception();
	 }
	 
	}
	catch(Exception $e){
	  $ret_arr[0]['final_tokbox_session_inserted_id']='';
	  $ret_arr[0]['final_tokbox_session_id']='';
	  $ret_arr[0]['final_tokbox_token']='';
	  $ret_arr[0]['final_post_id']='';
	 }
	
	return $ret_arr;
}
}
