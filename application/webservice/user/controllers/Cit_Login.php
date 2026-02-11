<?php

   
/**
 * Description of Login Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended Login
 *
 * @class Cit_Login.php
 *
 * @path application\webservice\user\controllers\Cit_Login.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Login extends Login {
        public function __construct()
{
    parent::__construct();
}

public function update_firebase_users($input_params = array()){
    $final_arr = array(
        'activeChatRoom' => '',
        'deviceToken' => $input_params['device_token'],
        'deviceType' => $input_params['device_type'],
        'email' => $input_params['user_email'],
        'isOnline' => true,
        'lastLoginTime' => (time()*1000),
        'profileImage' => str_replace("&height=500&width=500","&height=100&width=100", $input_params['u_profile_image']),
        'userName' => $input_params['u_name'],
    );
    //Push Firebase
    // $firebase_arr = array();
    // $firebase_arr[$input_params['u_users_id']] = $final_arr;
    
    // $this->load->library('firebase');
    // // $this->firebase->insert('users',$firebase_arr);
    // if(stristr($_SERVER['REMOTE_ADDR'], '192.168') || $_SERVER['SERVER_NAME']=='localhost' || $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['SERVER_NAME']=='zoebook.projectspreview.net' || $_SERVER['HTTP_HOST']=='zoebook.projectspreview.net')
    // {
    //     $node = "test/users";
    // }else{
    //     $node = "users";
    // }
    // $contacts_new_ref = $this->firebase->get($node,$input_params['u_users_id']);
    // if(!$contacts_new_ref){
    //     // $contact_arr[$input_params['u_users_id']] = '';
    //     $this->firebase->push($node,$firebase_arr);
    // }else{
    //     $this->firebase->update($node.'/'.$input_params['u_users_id'],$final_arr);
    // }
    
    return true;
}
}
