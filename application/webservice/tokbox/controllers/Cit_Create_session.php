<?php
            
/**
 * Description of Create Session Extended Controller
 * 
 * @module Extended Create Session
 * 
 * @class Cit_Create_session.php
 * 
 * @path application\webservice\tokbox\controllers\Cit_Create_session.php
 * 
 * @author CIT Dev Team
 * 
 * @date 24.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Create_session extends Create_session {
        public function __construct()
{
    parent::__construct();
}

public function create_tokbox_session(){
	$this->load->library('tokbox');
	$session_id = $this->tokbox->createSession();
	$ret_arr = array();
	$ret_arr['session_id'] = $session_id;
	return $ret_arr;
}
}
