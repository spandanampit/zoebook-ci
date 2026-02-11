<?php


/**
 * Description of Bulk Mailer Extended Model
 * 
 * @module Extended Bulk Mailer
 * 
 * @class Cit_Bulk_mailer_model.php
 * 
 * @path application\admin\user\models\Cit_Bulk_mailer_model.php
 * 
 * @author CIT Dev Team
 * 
 * @date 05.10.2021
 */
   
Class Cit_Bulk_mailer_model extends Bulk_mailer_model {
        public function __construct()
{
    parent::__construct();
}

public function getUsers(){
    $this->db->select('iUsersId');
    
    //$where='eStatus = "Active" AND eEmailVerified = "1" OR vAppleId = '' OR vFacebookId= "" ';
    $where='`eStatus` = "Active" AND `eEmailVerified` = "1" AND (`vFacebookId` IS NULL OR `vFacebookId` = "") AND (`vAppleId` IS NULL OR `vAppleId` = "")';
    $this->db->where($where);
    $sqlQuery=$this->db->get('users')->result_array();
    return $sqlQuery;
}

public function getUsersAction(){
    $this->db->select('iUsersId');
    $this->db->where('eStatus','Active');
    $this->db->where('eEmailVerified','1');
    $this->db->limit(1);
    $sqlQuery=$this->db->get('users')->row();
    //pr($sqlQuery);die();
    return $sqlQuery;
}

public function insertInToUserCredit($insert_array){
   $this->db->insert_batch('mailer_log_history', $insert_array); 
   return true;
}

public function getUsersingleDatasAction($userid){
    $this->db->select('iUsersId,vName,vEmail,vPhone,eSubscribeEmail,vAppleId,vFacebookId');
    $this->db->where('eStatus','Active');
    $this->db->where('eEmailVerified','1');
    $this->db->where('iUsersId',$userid);
    $sqlQuery=$this->db->get('users')->row();
    //pr($sqlQuery);die();
    return $sqlQuery;
}

public function get_email_tamplate($tamplateId){
    $this->db->select('*');
    $this->db->where('iEmailTemplateId',$tamplateId);
    $sqlQuery=$this->db->get('mod_system_email')->row();
    return $sqlQuery;
}
}
