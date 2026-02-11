<?php

   
/**
 * Description of Start Live Archive Extended Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Extended Start Live Archive
 *
 * @class Cit_Start_live_archive.php
 *
 * @path application\webservice\tokbox\controllers\Cit_Start_live_archive.php
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
 
Class Cit_Start_live_archive extends Start_live_archive {
        public function __construct()
{
    parent::__construct();
}

public function start_tokbox_archive($input_params = array()){
	try{
	   $this->load->library('tokbox');
	   $archive_id = $this->tokbox->startArchive($input_params['tokbox_live_session_id'],$input_params['u_name'].' on Live');
	   $ret_arr = array();
	   if(!empty($archive_id)){
	    $ret_arr[0]['archive_id'] = $archive_id;   
	   }else{
	    throw new Exception();   
	   }
	}
	catch(Exception $e){
	  $ret_arr[0]['archive_id']='';   
	}
	return $ret_arr;
}
}
