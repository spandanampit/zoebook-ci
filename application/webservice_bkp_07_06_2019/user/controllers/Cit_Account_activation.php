<?php
            
/**
 * Description of Account Activation Extended Controller
 * 
 * @module Extended Account Activation
 * 
 * @class Cit_Account_activation.php
 * 
 * @path application\webservice\user\controllers\Cit_Account_activation.php
 * 
 * @author CIT Dev Team
 * 
 * @date 10.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Account_activation extends Account_activation {
        public function __construct()
{
    parent::__construct();
}


public function redirect_to_verified_page($input_params){
	
	header('Location: '.$this->config->item('site_url').'account_verified.html');exit;
}

public function redirect_to_verified_failure_page($input_params){
	
	header('Location: '.$this->config->item('site_url').'account_verification_failed.html');exit;
}
}
