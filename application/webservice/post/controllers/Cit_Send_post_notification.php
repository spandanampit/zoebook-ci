<?php
            
/**
 * Description of Send Post Notification Extended Controller
 * 
 * @module Extended Send Post Notification
 * 
 * @class Cit_Send_post_notification.php
 * 
 * @path application\webservice\post\controllers\Cit_Send_post_notification.php
 * 
 * @author CIT Dev Team
 * 
 * @date 24.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Send_post_notification extends Send_post_notification {
        public function __construct()
{
    parent::__construct();
}


public function getNotificationText($input_params = array()){
	$return_arr = array();
	if($input_params['type'] == 'Live'){
		$return_arr[0]['notification_text'] = $input_params['u_name']." is now live";
		$return_arr[0]['notification_type'] = "Live";
		$return_arr[0]['notification_code'] = "LVP";
	}else if($input_params['type'] == 'Share'){
		$return_arr[0]['notification_text'] = $input_params['u_name']." shared a post";
		$return_arr[0]['notification_type'] = "Share";
		$return_arr[0]['notification_code'] = "NPS";
	}else{
		$return_arr[0]['notification_text'] = $input_params['u_name']." added a new post";
		$return_arr[0]['notification_type'] = "Post";
		$return_arr[0]['notification_code'] = "NPA";
	}
	return $return_arr ;
}
}
