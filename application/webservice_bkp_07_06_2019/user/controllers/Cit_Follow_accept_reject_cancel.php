<?php
            
/**
 * Description of Follow Accept Reject Cancel Extended Controller
 * 
 * @module Extended Follow Accept Reject Cancel
 * 
 * @class Cit_Follow_accept_reject_cancel.php
 * 
 * @path application\webservice\user\controllers\Cit_Follow_accept_reject_cancel.php
 * 
 * @author CIT Dev Team
 * 
 * @date 12.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Follow_accept_reject_cancel extends Follow_accept_reject_cancel {
        public function __construct()
{
    parent::__construct();
}

public function getNotificationText($value){
	return "'" .$value." has accepted your follow request'";
}
}
