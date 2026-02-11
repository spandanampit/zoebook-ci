<?php

   
/**
 * Description of Movement invitation Extended Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Extended Movement invitation
 *
 * @class Cit_Movement_invitation.php
 *
 * @path application\webservice\misc\controllers\Cit_Movement_invitation.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 15.12.2021
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Movement_invitation extends Movement_invitation {
        public function __construct()
{
    parent::__construct();
}


public function get_device_tokens_chunks(&$input_array = array()){
    $retrun = array();
    // pr($input_array);
    $token_array = array_filter(array_column($input_array['invitee_details'],'u_device_token_1'));
    $return= array();
    $chunk_array = array_chunk($token_array,$this->config->item('MAX_GROUP_PUSH_NOTIFY_TOKEN'));
    foreach ($chunk_array as $arr){
        $return[]['invitee_device_tokens'] =  implode(',',$arr);
    }
    /*echo $this->config->item('MAX_GROUP_PUSH_NOTIFY_TOKEN');die("here");
    if(count($token_array) > MAX_GROUP_PUSH_NOTIFY_TOKEN){
        $chunk_array = array_chunk($token_array,MAX_GROUP_PUSH_NOTIFY_TOKEN);
        foreach ($chunk_array as $arr){
            $return['invitee_device_tokens'][] =  implode(',',$arr);
        }
    }else{
        echo $return['invitee_device_tokens'][] = implode(',',$token_array);
    }*/
    // pr($return);
    return $return;
}
}
