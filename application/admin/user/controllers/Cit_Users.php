<?php


/**
 * Description of Users Extended Controller
 * 
 * @module Extended Users
 * 
 * @class Cit_Users.php
 * 
 * @path application\admin\user\controllers\Cit_Users.php
 * 
 * @author CIT Dev Team
 * 
 * @date 30.09.2021
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

Class Cit_Users extends Users {
        public function __construct()
{
    parent::__construct();
}

public function Unsubscribe_user(){
    //pr($this->input->post('user_id')); die();
    $this->db->select('iUsersId,eSubscribeEmail');
    $this->db->where('eSubscribeEmail','Yes');
    $users=$this->db->get('users')->result_array();
    if($users){
        foreach ($users as $value){
           $this->db->set('eSubscribeEmail', 'No');
           $this->db->where('iUsersId', $value['iUsersId']);
           $this->db->update('users');
        }
        $json=array('status'=>1,'message'=>'All user unsubscribed email account successfully!');
    }else{
        $json=array('status'=>0,'message'=>'All user alredy unsubscribed!');
    }
    echo json_encode($json);
}
}
