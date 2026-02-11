<?php

   
/**
 * Description of Account Activation Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended Account Activation
 *
 * @class Cit_Account_activation.php
 *
 * @path application\webservice\user\controllers\Cit_Account_activation.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 19.07.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Account_activation extends Account_activation {
        public function __construct()
{
    parent::__construct();
}
public function redirect_to_verified_page($input_params=array()){
	header('Location: '.$this->config->item('site_url').'account_verified.html');exit;
}
public function redirect_to_verified_failure_page($input_params=array()){
	header('Location: '.$this->config->item('site_url').'account_verification_failed.html');exit;
}
}
