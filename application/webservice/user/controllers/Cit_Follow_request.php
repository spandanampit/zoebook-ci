<?php

   
/**
 * Description of Follow Request Extended Controller
 * 
 * @module Extended Follow Request
 * 
 * @class Cit_Follow_request.php
 * 
 * @path application\webservice\user\controllers\Cit_Follow_request.php
 * 
 * @author CIT Dev Team
 * 
 * @date 08.04.2020
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Follow_request extends Follow_request {
        public function __construct()
{
    parent::__construct();
}

public function merge_arr(&$input_params = array()){
    $input_params['get_notify_user_details'][0]['pending_request_id']  = $input_params['user_follower_Id'];
    return true;
}
}
