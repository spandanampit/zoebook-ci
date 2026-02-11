<?php

   
/**
 * Description of send_bulk_mail Extended Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Extended send_bulk_mail
 *
 * @class Cit_Send_bulk_mail.php
 *
 * @path application\webservice\misc\controllers\Cit_Send_bulk_mail.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 24.06.2021
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Send_bulk_mail extends Send_bulk_mail {
        public function __construct()
{
    parent::__construct();
}

public function sendMail($data){
    $this->load->library('general');
    foreach ($data['get_bulk_mail'] as $key => $val){
        
        $to = $val['mlh_to_email'];
        $subject = $val['mlh_email_subject'];
        $body = $val['mlh_massage_body'];
        $from = $val['mlh_from_email'];
        $from_name = $val['mlh_frome_name'];
        $cc = $val['mlh_cc_email'];
        $bcc='';
        $attach ='';
        $params ='';
        
        $SendMail=$this->general->CISendMail($to, $subject, $body, $from, $from_name, $cc, $bcc, $attach, $params);
        if($SendMail){
          $sendMailStatus=1;
          $dataUpdate=array('iMailSendStatus'=>1,'dMailSentDate'=>date('Y-m-d H:i:s'));
          $this->db->where('iMailerLogHistoryId',$val['mlh_mailer_log_history_id']);
          $this->db->update('mailer_log_history',$dataUpdate);
        }else{
          $sendMailStatus=0;   
        }
    }
}
}
