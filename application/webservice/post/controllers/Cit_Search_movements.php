<?php

   
/**
 * Description of Search movements Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Search movements
 *
 * @class Cit_Search_movements.php
 *
 * @path application\webservice\post\controllers\Cit_Search_movements.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 12.12.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Search_movements extends Search_movements {
        public function __construct()
{
    parent::__construct();
}
public function checkSerachKeyword($inpute_params=array()){
        
        $return[0]['search_key'] = "`m`.`eStatus` IN('Active') ";
        
        if(strlen($inpute_params['keyword'])>=3){
            $return[0]['search_key'].=" And (m.vMovementName LIKE '%".$inpute_params['keyword']."%'  OR m.tDescription LIKE '%".$inpute_params['keyword']."%')";
            $return[0]['is_valid']=1;
        }else{
            if(empty($inpute_params['keyword']) || $inpute_params['keyword'] == ''){
                 $return[0]['is_valid']=0;
            }else{
                 $return[0]['is_valid']=0;
            }
           
        }
        
        #pr($return,1);
        return $return;
        
    }
public function check_data($inpute_params=array()){
        pr($inpute_params,1);
}
public function fetch_mm_ids($inpute_params=array()) {
     $search_new_moments = $inpute_params['search_new_moments'];
     #pr($search_new_moments,1);
     $mm_ids = [];
     if(!empty($search_new_moments) && count($search_new_moments)>=1) {
       $mm_ids =array_column($search_new_moments,'m_movements_id_1');
     }
     if(!empty($mm_ids) && count($mm_ids)>=1) {
         $retarr[0]['mm_ids'] =implode("','",$mm_ids);
     }else {
         $retarr=array(); 
     }
     return $retarr;
}
public function movement_users_finish_success(&$inputParams = array()){
  $result_data = parent::movement_users_finish_success($inputParams);
  $new_array=array();$set_value1=[];$mm_ids=[];$get_moment_users=[];$moment_images=[];
 
  if(!empty($result_data) && count($result_data)>=1) {
     foreach ($result_data['data']['search_new_moments'] as $key => $obj_value) {
        $set_value1[$key] = $obj_value;
        $new_array = $set_value1;
        
     }
     foreach ($result_data['data']['get_moment_users'] as $key => $obj_value) {
          $get_moment_users[$obj_value['mu_movement_id']][]=$obj_value;
          $mm_ids[]=$obj_value['mu_movement_id'];
     }
     foreach ($result_data['data']['moment_images'] as $key => $obj_value) {
          $moment_images[$obj_value['mi_movements_id']][]=$obj_value;
     }
     #pr($moment_images,1);
     if(!empty($new_array)) {
       foreach ($new_array as $key =>$value){
             #pr($key,1);
          if(in_array($value['movements_id'],$mm_ids)){
            $new_array[$key]['get_movement_followers']=$get_moment_users[$value['movements_id']];
            $new_array[$key]['get_movement_file']=$moment_images[$value['movements_id']]; 
          }
          else{
            $new_array[$key]['get_movement_followers']=[];
            $new_array[$key]['get_movement_file']=[];   
          }
         }    
     }
     
     $result_data['data']=$new_array;
      return $result_data;
     #pr($mm_ids,1);
  }
}
}
