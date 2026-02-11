<?php
            
/**
 * Description of My Profile Extended Controller
 * 
 * @module Extended My Profile
 * 
 * @class Cit_My_profile.php
 * 
 * @path application\webservice\user\controllers\Cit_My_profile.php
 * 
 * @author CIT Dev Team
 * 
 * @date 17.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_My_profile extends My_profile {
        public function __construct()
{
    parent::__construct();
}

public function checkUserFollowing($value='',$dataArr=array()){
	$ret_value = 'No';
	if(!empty($value) && $value != ''){
		if($value == 'Accepted'){
			$ret_value = 'Yes';
		}elseif($value == 'Pending'){
			$ret_value = 'Pending';
		}
	}
	return $ret_value;
}
}
