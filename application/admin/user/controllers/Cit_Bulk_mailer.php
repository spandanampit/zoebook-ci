<?php


/**
 * Description of Bulk Mailer Extended Controller
 * 
 * @module Extended Bulk Mailer
 * 
 * @class Cit_Bulk_mailer.php
 * 
 * @path application\admin\user\controllers\Cit_Bulk_mailer.php
 * 
 * @author CIT Dev Team
 * 
 * @date 05.10.2021
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

Class Cit_Bulk_mailer extends Bulk_mailer {
        public function __construct()
{
    parent::__construct();
}
/*public function addAction()
    {
        $params_arr = $this->params_arr;
        $mode = ($params_arr['mode'] == "Update") ? "Update" : "Add";
        $id = $params_arr['id'];
        try {
            $ret_arr = array();
            if($this->config->item("ENABLE_ROLES_CAPABILITIES")){
                if($mode == "Update"){
                    $add_edit_access = $this->filter->checkAccessCapability("bulk_mailer_update", TRUE);
                } else {
                    $add_edit_access = $this->filter->checkAccessCapability("bulk_mailer_add", TRUE);
                }
            } else {
                $add_edit_access = $this->filter->getModuleWiseAccess("bulk_mailer", $mode, TRUE, TRUE);
            }
            
            if(!$add_edit_access){
                if($mode == "Update"){
                    throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_MODIFY_THESE_DETAILS_C46_C46_C33'));
                } else {
                    throw new Exception($this->general->processMessageLabel('ACTION_YOU_ARE_NOT_AUTHORIZED_TO_ADD_THESE_DETAILS_C46_C46_C33'));
                }
            }
                if (method_exists($this, 'beforeFormSave')) {
                    $event_res = $this->beforeFormSave($mode, $id, $params_arr['parID'], $params_arr['parMod']);
                    if (!$event_res['success']) {
                        $before_error_msg = $this->general->processMessageLabel('ACTION_BEFORE_EVENT_HAS_BEEN_FAILED_C46_C46_C33');
                        $error_msg = ($event_res['message']) ? $event_res['message'] : $before_error_msg;
                        throw new Exception($error_msg);
                    } elseif (intval($event_res['success']) == 2) {
                        $ret_arr['success'] = $event_res['success'];
                        if(isset($event_res['data'])){
                            $ret_arr['data'] = $event_res['data'];
                        }
                        if($mode == 'Update'){
                            $before_success_msg = $this->general->processMessageLabel('ACTION_RECORD_SUCCESSFULLY_UPDATED_C46_C46_C33');
                        } else {
                            $before_success_msg = $this->general->processMessageLabel('ACTION_RECORD_ADDED_SUCCESSFULLY_C46_C46_C33');
                        }
                        $success_msg = ($event_res['message']) ? $event_res['message'] : $before_success_msg;
                        throw new Exception($success_msg);
                    }
                } 
                
            $form_config = $this->bulk_mailer_model->getFormConfiguration();
            $params_arr = $this->_request_params();
            
            $mlh_userid = $params_arr['mlh_userid'];
             if($params_arr['selectusers']=='All'){
                $user_data1 = $this->bulk_mailer_model->getUsersAction();
                $mlh_userid = $user_data1->iUsersId; 
             }
            //echo $mlh_userid;
            //die();
                    $mlh_email_template_id = $params_arr["mlh_email_template_id"];
                    $mlh_massage_body = $params_arr["mlh_massage_body"];
                    $mlh_mail_send_status = $params_arr["mlh_mail_send_status"];
                    $mlh_added_date = date('Y-m-d H:i:s');
                    $mlh_mail_sent_date = date('Y-m-d H:i:s');
                    
            
            $data = $save_data_arr = $file_data = array();
                        $data["iUserid"] = $mlh_userid;
                        $data["iEmailTemplateId"] = $mlh_email_template_id;
                        $data["tMassageBody"] = $mlh_massage_body;
                        $data["iMailSendStatus"] = $mlh_mail_send_status;
                        $data["dAddedDate"] = $this->filter->formatActionData($mlh_added_date, $form_config["mlh_added_date"]);
                        $data["dMailSentDate"] = $this->filter->formatActionData($mlh_mail_sent_date,$form_config["mlh_mail_sent_date"]);
                        
            $save_data_arr["mlh_userid"] = $data["iUserid"];
                        $save_data_arr["mlh_email_template_id"] = $data["iEmailTemplateId"];
                        $save_data_arr["mlh_massage_body"] = $data["tMassageBody"];
                        $save_data_arr["mlh_mail_send_status"] = $data["iMailSendStatus"];
                        $save_data_arr["mlh_added_date"] = $data["dAddedDate"];
                        $save_data_arr["mlh_mail_sent_date"] = $data["dMailSentDate"];
                        
            
            
            if ($mode == 'Add') {
                $id = $this->bulk_mailer_model->insert($data);
                if (intval($id) > 0) {
                    $save_data_arr["iMailerLogHistoryId"] = $data["iMailerLogHistoryId"] = $id;
                    $msg = $this->general->processMessageLabel('ACTION_RECORD_ADDED_SUCCESSFULLY_C46_C46_C33');
                } else {
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_ADDING_RECORD_C46_C46_C33'));
                }
                $track_cond = $this->db->protect("mlh.iMailerLogHistoryId") . " = " . $this->db->escape($id); 
                $switch_combo = $this->bulk_mailer_model->getSwitchTo($track_cond);
                $recName = $switch_combo[0]["val"];
                $this->general->trackModuleNavigation("Module", "Form", "Added", $this->mod_enc_url["add"], "bulk_mailer", $recName, "mode|" . $this->general->getAdminEncodeURL("Update") . "|id|" . $this->general->getAdminEncodeURL($id));
            } elseif ($mode == 'Update') {
                $res = $this->bulk_mailer_model->update($data, intval($id));
                if (intval($res) > 0) {
                    $save_data_arr["iMailerLogHistoryId"] = $data["iMailerLogHistoryId"] = $id;
                    $msg = $this->general->processMessageLabel('ACTION_RECORD_SUCCESSFULLY_UPDATED_C46_C46_C33');
                } else {
                    throw new Exception($this->general->processMessageLabel('ACTION_FAILURE_IN_UPDATING_OF_THIS_RECORD_C46_C46_C33'));
                }
                $track_cond = $this->db->protect("mlh.iMailerLogHistoryId") . " = " . $this->db->escape($id); 
                $switch_combo = $this->bulk_mailer_model->getSwitchTo($track_cond);
                $recName = $switch_combo[0]["val"];
                $this->general->trackModuleNavigation("Module", "Form", "Modified", $this->mod_enc_url["add"], "bulk_mailer", $recName, "mode|" . $this->general->getAdminEncodeURL("Update") . "|id|" . $this->general->getAdminEncodeURL($id));
            }
            $ret_arr['id'] = $id;
            $ret_arr['mode'] = $mode;
            $ret_arr['message'] = $msg;
            $ret_arr['success'] = 1;
            
            
            
            
            
                if (method_exists($this, 'afterFormSave')) {
                    $event_res = $this->afterFormSave($mode, $id, $params_arr['parID'], $params_arr['parMod']);
                    $ret_arr['success'] = $event_res['success'];
                    if(isset($event_res['data'])){
                        $ret_arr['data'] = $event_res['data'];
                    }
                    if (!$event_res['success']) {
                        $after_error_msg = $this->general->processMessageLabel('ACTION_AFTER_EVENT_HAS_BEEN_FAILED_C46_C46_C33');
                        $error_msg = ($event_res['message']) ? $event_res['message'] : $after_error_msg;
                        $ret_arr['message'] = $error_msg;
                    } elseif($event_res['message'] != ''){
                        $ret_arr['message'] = $event_res['message'];
                    }
                    if (intval($event_res['success']) == 2) {
                        throw new Exception($ret_arr['message']);
                    }
                }
                
            $params_arr = $this->_request_params();
            
        } catch (Exception $e) {
            if($ret_arr["success"] > 0){
                $ret_arr["message"] = $e->getMessage();
            } else {
                $ret_arr["message"] = $e->getMessage();
                $ret_arr["success"] = 0;
            }
        }
        $ret_arr['mod_enc_url']['add'] = $this->mod_enc_url['add'];
        $ret_arr['mod_enc_url']['index'] = $this->mod_enc_url['index'];
        $ret_arr['red_type'] = 'List';
        $this->filter->getPageFlowURL($ret_arr, $this->module_config, $params_arr, $id, $data);
        
        $this->response_arr = $ret_arr;
        echo json_encode($ret_arr);
        $this->skip_template_view();
    }
    
public function beforeFormSave($mode = '', $id = '', $parID = ''){
    $post_data = $this->input->get_post(null,true);
    //pr($post_data); die();
    $user_type = $post_data['selectusers'];
    if($user_type == 'All'){
        $user_data = $this->bulk_mailer_model->getUsers();
        $user_ids = array();
        foreach ($user_data as $key1 => $val1){
            $user_ids[] = $val1['iUsersId'];
        }
    }else{
        if(!empty($post_data['mlh_userid'])){
         $user_ids = explode(',',$post_data['mlh_userid']);
        }
        //unset($user_ids[0]);
    }
    $current_date = date('Y-m-d H:i:s');
    $ret_arr['success'] = 1; 
    if($user_type == 'All' || $user_type=='Select'){
        if(empty($user_ids)){
            $ret_arr['success'] = 0; 
            $ret_arr['message'] = $this->lang->line('CUSTOM_USER_TYPE');
        }    
    }
    return $ret_arr;
}

public function afterFormSave($mode = '', $id = '', $parID = ''){
    $post_data = $this->input->get_post(null,true);
    $user_type = $post_data['selectusers'];
    if($post_data['selectusers'] == 'All'){
        $user_data = $this->bulk_mailer_model->getUsers();
        $user_ids = array();
        foreach ($user_data as $key1 => $val1){
            $user_ids[] = $val1['iUsersId'];
        }
        unset($user_ids[0]);
    }elseif($post_data['selectusers'] == 'Select'){
        if(!empty($post_data['mlh_userid'])){
         $user_ids = explode(',',$post_data['mlh_userid']);
        }
        unset($user_ids[0]);
    }
    $mlh_email_template_id = $post_data['mlh_email_template_id'];
    $mlh_massage_body = $post_data['mlh_massage_body'];
    $insert_array = array();
    if(count($user_ids) >0){
        foreach (array_values($user_ids) as $key => $val){
            if(!empty($val)){
            $insert_array[$key]['iUserid'] = $val;
            $insert_array[$key]['iEmailTemplateId']  = $mlh_email_template_id;
            $insert_array[$key]['tMassageBody']  = $mlh_massage_body;
            $insert_array[$key]['dAddedDate']  = date('Y-m-d H:i:s');
            $insert_array[$key]['dMailSentDate']  = date('Y-m-d H:i:s');
            }
        }
    }
    if(!empty($insert_array)){
        $this->bulk_mailer_model->insertInToUserCredit($insert_array);    
    }
    unset($user_ids);
    unset($insert_array);
    $ret_arr['success'] = true;     
    return $ret_arr;
}*/

public function setSendMailStatus($value = '',$id = '',$data = array()){
    if($value==0){
     $ret ="Not Send";
    }else if($value==1){
     $ret = "Send";
    }
     return $ret;
}

public function SaveNow(){
    $this->load->library('general');
    $post_data = $this->input->get_post(null,true);
    if($post_data['selectusers'] == 'All'){
        $user_data = $this->bulk_mailer_model->getUsers();
        $user_ids = array();
        foreach ($user_data as $key1 => $val1){
            $user_ids[] = $val1['iUsersId'];
        }
    }elseif($post_data['selectusers'] == 'Select'){
        if(!empty($post_data['mlh_userid'])){
         $user_ids = explode(',',$post_data['mlh_userid']);
        }
    }
    
    $mlh_email_template_id = $post_data['mlh_email_template_id'];
    $email_template = $this->bulk_mailer_model->get_email_tamplate($mlh_email_template_id);
    $mlh_massage_body = $post_data['mlh_massage_body'];
    if(count($user_ids) >0){
        $insert_array = array();
        foreach (array_values($user_ids) as $key => $val){
        if(!empty($val)){        
            $userDetails=$this->bulk_mailer_model->getUsersingleDatasAction($val); 
            
            $New_link='';
            if($email_template->vEmailCode == 'USER_EMAIL_VERIFICATION' && $userDetails->eSubscribeEmail == 'No'){
               $New_link=$this->config->item('site_url').'WS/account_activation?user_id='.$userDetails->iUsersId;
            }
         
            $search  = array('#NAME#', '#Massage#', '#URL#', '#EMAIL#', '#COMMENT#','#vName#','#vUserEmail#','#vUserName#','#vPassword#','#vPhone#','#SYSTEM.COMPANY_NAME#','#SYSTEM.site_url#');
            
            $replace = array($userDetails->vName, ' ',$New_link, $userDetails->vEmail, ' ', $userDetails->vName, $userDetails->vEmail, $userDetails->vName, $userDetails->vPassword, $userDetails->vPhone, 'Zoebook', $this->config->item('site_url'));
            
            $emai_body=$email_template->tEmailMessage;
            $bodyMail=str_replace($search, $replace, $emai_body);
        
            $fromMail = $email_template->vFromEmail;
            if(empty($fromMail)){
            $fromMail=$this->config->item('COMPANY_SUPPORT_EMAIL');
            }
            
            $formName = $email_template->vFromName;
            if(empty($formName)){
            $formName = 'Zoebook';  
            }
            
                if($email_template->vEmailCode == 'USER_EMAIL_VERIFICATION' && $userDetails->eSubscribeEmail == 'No'){
                    $insert_array[$key]['iUserid'] = $userDetails->iUsersId;
                    $insert_array[$key]['vUserName'] = $userDetails->vName;
                    $insert_array[$key]['iEmailTemplateId']  = $email_template->iEmailTemplateId;
                    $insert_array[$key]['vEmailCode']  = $email_template->vEmailCode;
                    $insert_array[$key]['vFromeName']  = $formName;
                    $insert_array[$key]['vFromEmail']  = $fromMail;
                    $insert_array[$key]['vCcEmail']  = $email_template->vCcEmail;
                    $insert_array[$key]['eEmailFormate']  = $email_template->eEmailFormat;
                    $insert_array[$key]['vEmailSubject']  = $email_template->vEmailSubject;
                    $insert_array[$key]['vToEmail']  = $userDetails->vEmail;
                    $insert_array[$key]['iMailSendStatus']  = 0;
                    $insert_array[$key]['tMassageBody']  = $bodyMail;
                    $insert_array[$key]['dAddedDate']  = date('Y-m-d H:i:s');
                    $insert_array[$key]['dMailSentDate']  = date('Y-m-d H:i:s');
                }elseif($email_template->vEmailCode != 'USER_EMAIL_VERIFICATION' && $userDetails->eSubscribeEmail == 'Yes'){
                    $insert_array[$key]['iUserid'] = $userDetails->iUsersId;
                    $insert_array[$key]['vUserName'] = $userDetails->vName;
                    $insert_array[$key]['iEmailTemplateId']  = $email_template->iEmailTemplateId;
                    $insert_array[$key]['vEmailCode']  = $email_template->vEmailCode;
                    $insert_array[$key]['vFromeName']  = $formName;
                    $insert_array[$key]['vFromEmail']  = $fromMail;
                    $insert_array[$key]['vCcEmail']  = $email_template->vCcEmail;
                    $insert_array[$key]['eEmailFormate']  = $email_template->eEmailFormat;
                    $insert_array[$key]['vEmailSubject']  = $email_template->vEmailSubject;
                    $insert_array[$key]['vToEmail']  = $userDetails->vEmail;
                    $insert_array[$key]['iMailSendStatus']  = 0;
                    $insert_array[$key]['tMassageBody']  = $bodyMail;
                    $insert_array[$key]['dAddedDate']  = date('Y-m-d H:i:s');
                    $insert_array[$key]['dMailSentDate']  = date('Y-m-d H:i:s');
                }
            
            }
        }
    }
    //pr($insert_array);die();
    $data='';
    if(!empty($insert_array)){
    $data = $this->bulk_mailer_model->insertInToUserCredit($insert_array);
    }
    unset($insert_array);
    $json= array('status'=>0,'massage'=>"failure");
    if($data){
        $json= array('status'=>1,'massage'=>"Record added successfully!");
    }
    echo json_encode($json);
    $this->skip_template_view();
}

public function SendNow(){
    $this->load->library('general');
    $post_data = $this->input->get_post(null,true);
    if($post_data['selectusers'] == 'All'){
        $user_data = $this->bulk_mailer_model->getUsers();
        $user_ids = array();
        foreach ($user_data as $key1 => $val1){
            $user_ids[] = $val1['iUsersId'];
        }
    }elseif($post_data['selectusers'] == 'Select'){
        if(!empty($post_data['mlh_userid'])){
         $user_ids = explode(',',$post_data['mlh_userid']);
        }
    }
    
    
    $mlh_email_template_id = $post_data['mlh_email_template_id'];
    $email_template = $this->bulk_mailer_model->get_email_tamplate($mlh_email_template_id);
    $mlh_massage_body = $post_data['mlh_massage_body'];
    
    $message = 'All users are already unsubscribed for email notification!!!';  
    if($email_template->vEmailCode == 'USER_EMAIL_VERIFICATION')
    {
        $message = 'Selected users are already subscribed for email notification!!!';
        if($post_data['selectusers'] == 'All'){
        $message = 'All users are already subscribed for email notification!!!';    
        }
    
    }
    if(count($user_ids) >0){
        $insert_array = array();
        foreach (array_values($user_ids) as $key => $val){
            if(!empty($val)){
                
                $userDetails=$this->bulk_mailer_model->getUsersingleDatasAction($val);
               // pr($userDetails,1);d al;
                $New_link='';
                if($email_template->vEmailCode == 'USER_EMAIL_VERIFICATION' && $userDetails->eSubscribeEmail == 'No'){
                      $New_link=$this->config->item('site_url').'WS/account_activation?user_id='.$userDetails->iUsersId;
                }
                
                $search  = array('#NAME#', '#Massage#', '#URL#', '#EMAIL#', '#COMMENT#','#vName#','#vUserEmail#','#vUserName#','#vPassword#','#vPhone#','#SYSTEM.COMPANY_NAME#','#SYSTEM.site_url#');
                $replace = array($userDetails->vName, ' ', $New_link, $userDetails->vEmail, ' ', $userDetails->vName, $userDetails->vEmail, $userDetails->vName, $userDetails->vPassword, $userDetails->vPhone, 'Zoebook', $this->config->item('site_url'));
            
                $emai_body=$email_template->tEmailMessage;
                $bodyMail=str_replace($search, $replace, $emai_body);
               
                $fromMail = $email_template->vFromEmail;
                if(empty($fromMail)){
                $fromMail=$this->config->item('COMPANY_SUPPORT_EMAIL');
                }
                
                $formName = $email_template->vFromName;
                if(empty($formName)){
                $formName = 'Zoebook';  
                }
            
                $to= $userDetails->vEmail;
                $subject = $email_template->vEmailSubject;
                $body = $bodyMail;
                $from = $fromMail;
                $from_name = $formName;
                $cc= $email_template->vCcEmail;
                $bcc='';
                $attach ='';
                $params ='';
            
                $sendMailStatus=0;   
                if($email_template->vEmailCode == 'USER_EMAIL_VERIFICATION' && $userDetails->eSubscribeEmail == 'No'){
                   // pr($userDetails,0);
                    $SendMail=$this->general->CISendMail($to, $subject, $body, $from, $from_name, $cc, $bcc, $attach, $params);
                    if($SendMail){
                     $sendMailStatus=1;
                    }
                    $insert_array[$key]['iUserid'] = $userDetails->iUsersId;
                    $insert_array[$key]['vUserName'] = $userDetails->vName;
                    $insert_array[$key]['iEmailTemplateId']  = $email_template->iEmailTemplateId;
                    $insert_array[$key]['vEmailCode']  = $email_template->vEmailCode;
                    $insert_array[$key]['vFromeName']  = $from_name;
                    $insert_array[$key]['vFromEmail']  = $fromMail;
                    $insert_array[$key]['vCcEmail']  = $email_template->vCcEmail;
                    $insert_array[$key]['eEmailFormate']  = $email_template->eEmailFormat;
                    $insert_array[$key]['vEmailSubject']  = $email_template->vEmailSubject;
                    $insert_array[$key]['vToEmail']  = $userDetails->vEmail;
                    $insert_array[$key]['iMailSendStatus']  = $sendMailStatus;
                    $insert_array[$key]['tMassageBody']  = $bodyMail;
                    $insert_array[$key]['dAddedDate']  = date('Y-m-d H:i:s');
                    $insert_array[$key]['dMailSentDate']  = date('Y-m-d H:i:s');
                }else if($email_template->vEmailCode != 'USER_EMAIL_VERIFICATION' && $userDetails->eSubscribeEmail == 'Yes'){
                    //pr($email_template,0);
                    $SendMail=$this->general->CISendMail($to, $subject, $body, $from, $from_name, $cc, $bcc, $attach, $params);
                    if($SendMail){
                     $sendMailStatus=1;
                    }
                    $insert_array[$key]['iUserid'] = $userDetails->iUsersId;
                    $insert_array[$key]['vUserName'] = $userDetails->vName;
                    $insert_array[$key]['iEmailTemplateId']  = $email_template->iEmailTemplateId;
                    $insert_array[$key]['vEmailCode']  = $email_template->vEmailCode;
                    $insert_array[$key]['vFromeName']  = $from_name;
                    $insert_array[$key]['vFromEmail']  = $fromMail;
                    $insert_array[$key]['vCcEmail']  = $email_template->vCcEmail;
                    $insert_array[$key]['eEmailFormate']  = $email_template->eEmailFormat;
                    $insert_array[$key]['vEmailSubject']  = $email_template->vEmailSubject;
                    $insert_array[$key]['vToEmail']  = $userDetails->vEmail;
                    $insert_array[$key]['iMailSendStatus']  = $sendMailStatus;
                    $insert_array[$key]['tMassageBody']  = $bodyMail;
                    $insert_array[$key]['dAddedDate']  = date('Y-m-d H:i:s');
                    $insert_array[$key]['dMailSentDate']  = date('Y-m-d H:i:s');
                }
            
            }
        }
    }
    //pr($insert_array);die();
    $data='';
    if(!empty($insert_array)){
    $data = $this->bulk_mailer_model->insertInToUserCredit($insert_array);
    }
    unset($insert_array);
    $json= array('status'=>0,'massage'=>$message);
    if($data){
        $json= array('status'=>1,'massage'=>"mail sent successfully!");
    }
    echo json_encode($json);
    $this->skip_template_view();
}
}
