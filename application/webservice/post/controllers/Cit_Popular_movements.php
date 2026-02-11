<?php

   
/**
 * Description of Popular movements Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Popular movements
 *
 * @class Cit_Popular_movements.php
 *
 * @path application\webservice\post\controllers\Cit_Popular_movements.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 23.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Popular_movements extends Popular_movements {
        public function __construct()
{
    parent::__construct();
    $this->load->model('cit_api_model');
}
// public function getMovementFollowers(&$input_params = array()){
//     $movment = $input_params['get_popular_movement'][$input_params['i']];
//     $params = array('user_id'=>$input_params['user_id'],'follower_count'=>$movment['follower_count'],'movement_id'=>$movment['m_movements_id']);
//     $api_resp = $this->cit_api_model->callAPI("get_movement_follower_user", $params);
//     return $api_resp['data'];
// }
public function fetch_mm_ids($input_params=array()){
  $popular_moments = $input_params['get_popular_movement'];
  $mm_ids=[];
  if(!empty($popular_moments) && count($popular_moments)>=1) {
    foreach ($popular_moments as $key => $value) {
      $mm_ids[] = $value['m_movements_id'];    
    }  
  }
  if(!empty($mm_ids)) {
    $ret_arr[0]['mm_ids'] = implode("','",$mm_ids); 
  } else {
    $ret_arr=array();  
  }
  return $ret_arr;
 }
public function movements_finish_success_1(&$input_params=array()) {
  $result_data = parent::movements_finish_success_1($input_params);
  $new_array=array();$set_value1=[];$mm_ids=[];$post_id_ary=[];$get_moment_user_follwers=[];
  if(!empty($result_data)) {
     #pr($result_data,1); 
     foreach ($result_data['data']['get_movement'] as $key => $obj_value){
      #pr($key,1);
      $set_value[$key]['join_status'] = $obj_value['join_status'];
      $set_value[$key]['is_movement_active'] = $obj_value['is_movement_active'];
      $set_value[$key]['total_members'] = $obj_value['total_members'];
      $set_value[$key]['movements_id'] = $obj_value['movements_id'];
      $set_value[$key]['movement_name'] = $obj_value['movement_name'];
      $set_value[$key]['description'] = $obj_value['description'];
      $set_value[$key]['theme'] = $obj_value['theme'];
      $set_value[$key]['visibility'] = $obj_value['visibility'];
      $set_value[$key]['status'] = $obj_value['status'];
      $set_value[$key]['device_group_token'] = $obj_value['device_group_token'];
      $set_value[$key]['added_date'] = $obj_value['added_date'];
      $set_value[$key]['users_id'] = $obj_value['users_id'];
      $set_value[$key]['users_name'] = $obj_value['users_name'];
      $set_value[$key]['users_profile_image'] = $obj_value['users_profile_image'];
      $mm_ids[] = $obj_value['movements_id'];
      $new_array = $set_value; 
      }
     foreach ($result_data['data']['get_popular_movement_file'] as $k => $obj_value1){
        $post_id_ary[$obj_value1['mi_movements_id']][]=$obj_value1;
     }
     foreach ($result_data['data']['get_moment_user_follwers'] as $k => $obj_value1){
        $get_moment_user_follwers[$obj_value1['mu_movement_id']][]=$obj_value1;
     } 
     if(!empty($result_data['data']['get_popular_movement_file'])){
         foreach ($new_array as $key =>$value){
          if(in_array($value['movements_id'],$mm_ids)){
            $new_array[$key]['get_movement_file']=!empty($post_id_ary[$value['movements_id']])?$post_id_ary[$value['movements_id']]:array();
            $new_array[$key]['get_movement_followers']=!empty($get_moment_user_follwers[$value['movements_id']])?$get_moment_user_follwers[$value['movements_id']]:array();
          }
          else{
             $new_array[$key]['get_movement_file']=  array();
             $new_array[$key]['get_movement_followers']=array();
          }
         }  
       }
  }
  $result_data['data']=$new_array;
  return $result_data;
}
}
