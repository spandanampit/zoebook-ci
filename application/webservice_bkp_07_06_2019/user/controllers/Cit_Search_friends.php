<?php
            
/**
 * Description of Search friends Extended Controller
 * 
 * @module Extended Search friends
 * 
 * @class Cit_Search_friends.php
 * 
 * @path application\webservice\user\controllers\Cit_Search_friends.php
 * 
 * @author CIT Dev Team
 * 
 * @date 11.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Search_friends extends Search_friends {
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
