<?php

   
/**
 * Description of My Movements Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended My Movements
 *
 * @class Cit_My_movements.php
 *
 * @path application\webservice\user\controllers\Cit_My_movements.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 11.10.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_My_movements extends My_movements {
        public function __construct()
{
    parent::__construct();
}
public function get_moments_ids($input_params=array()) {
 $get_my_movement=$input_params['get_my_movement'];
 if(!empty($get_my_movement) && count($get_my_movement)>=1){
    $mm_ids=[];
    foreach ($get_my_movement as $key=>$value){
     $mm_ids[]=$value['m_movements_id'];        
    }
    if(!empty($mm_ids)){
      $return_arr[0]['mm_ids']=implode("','",$mm_ids);
      return $return_arr;
    }else{$return_arr = array();}
    return $return_arr;
 }
}
public function movements_finish_success(&$inputParams = array()) {
 $result_data = parent::movements_finish_success($inputParams);
 $new_array=array();$set_value1=[];$mm_ids=[];$get_movement_file=[];$get_movement_followers=[];
 if(!empty($result_data)) {
    #pr($result_data,1); 
  
    foreach ($result_data['data']['get_movement'] as $key => $obj_value) {
       $set_value[$key]['total_members']=$obj_value['total_members'];
       $set_value[$key]['join_status']=$obj_value['join_status'];
       $set_value[$key]['is_movement_active']=$obj_value['is_movement_active'];
       $set_value[$key]['movements_id']=$obj_value['movements_id'];
       $set_value[$key]['movement_name']=$obj_value['movement_name'];
       $set_value[$key]['description']=$obj_value['description'];
       $set_value[$key]['theme']=$obj_value['theme'];
       $set_value[$key]['visibility']=$obj_value['visibility'];
       $set_value[$key]['device_group_token']=$obj_value['device_group_token'];
       $set_value[$key]['users_name']=$obj_value['users_name'];
       $set_value[$key]['users_id']=$obj_value['users_id'];
       $set_value[$key]['users_profile_image']=$obj_value['users_profile_image'];
       $set_value[$key]['added_date']=$obj_value['added_date'];
       $set_value[$key]['status']=$obj_value['status'];
       $mm_ids[]=$obj_value['movements_id'];
       $new_array= $set_value; 
    }
    foreach ($result_data['data']['get_movement_followers'] as $key => $obj_value) {
       $get_movement_followers[$obj_value['mu_movement_id']][]=$obj_value;
        
    }
    #pr($result_data['data'],1);
    foreach ($result_data['data']['get_movement_file'] as $key => $obj_value) {
       $get_movement_file[$obj_value['mi_movements_id']][]=$obj_value;
       #$new_array= $set_value; 
    }
    #
    if(!empty($mm_ids)){
        
        foreach ($new_array as $key =>$value){
          if(in_array($value['movements_id'],$mm_ids)){
            $new_array[$key]['get_movement_followers']=!empty($get_movement_followers[$value['movements_id']])?$get_movement_followers[$value['movements_id']]:array();
            $new_array[$key]['get_movement_file']=!empty($get_movement_file[$value['movements_id']])?$get_movement_file[$value['movements_id']]:array();
          }
         }  
       }
    
    $result_data['data']=$new_array;
    return $result_data;
   
 }      
}
}
