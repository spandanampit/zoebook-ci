<?php

   
/**
 * Description of User Albums Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended User Albums
 *
 * @class Cit_User_albums.php
 *
 * @path application\webservice\post\controllers\Cit_User_albums.php
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
 
Class Cit_User_albums extends User_albums {
        public function __construct()
{
    parent::__construct();
}
public function get_display_image($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file'];
	if($data_arr['pm_media_type'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail'];
	}elseif($data_arr['pm_media_type_1'] == 'Video'){
	    $value = $data_arr['pm_video_thumbnail_1'];
	}else{
	    $value = isset($data_arr['pm_upload_file'])?$data_arr['pm_upload_file']:$data_arr['pm_upload_file_1'];
	}
	return $value;
}
public function fetch_post_id($input_params=array()) {
    $get_users_post =  $input_params['get_users_post'];
    if(!empty($get_users_post) && count($get_users_post)>=1) {
     $post_ids=[];
     foreach ($get_users_post as $key => $value) {
       $post_ids[] = $value['p_post_id_1'];  
     }
   }
    if(!empty($post_ids)){
      $return_arr[0]['p_ids']=implode("','",$post_ids);
    }else{$return_arr = array();}
    return $return_arr;  
}
public function fetch_mm_ids($input_params=array()) {
   $get_users_post =  $input_params['get_media_posts'];
    if(!empty($get_users_post) && count($get_users_post)>=1) {
     $post_ids=[];
     foreach ($get_users_post as $key => $value) {
       $post_ids[] = $value['p_post_id'];  
     }
   }
    if(!empty($post_ids)){
      $return_arr[0]['mm_ids']=implode("','",$post_ids);
    }else{$return_arr = array();}
    #pr($return_arr,1);
    return $return_arr;   
}
public function post_finish_success(&$inputParams = array()){
     $result_data = parent::post_finish_success($inputParams);
     $new_array=array();$set_value1=[];
     if(!empty($result_data)){
         foreach ($result_data['data']['get_users_post'] as $key => $obj_value){
            $new_array[$key] = $obj_value; 
         }     
        $post_id_ary=[];$n_ary=[];
        #pr($result_data['data']['get_media_post_media'],1);
        foreach ($result_data['data']['get_media_post_media'] as $key => $obj_value1) {
         
             $n_ary[]=$obj_value1['pm_post_id'];
             $post_id_ary[$obj_value1['pm_post_id']][]=$obj_value1; 
        }
        if(!empty($new_array)) {
            foreach ($new_array as $key =>$value) {
                if(in_array($value['post_id'],$n_ary)){
                  $new_array[$key]['get_media_post_media']=$post_id_ary[$value['post_id']][0];  
                }    
                else{
                  $new_array[$key]['get_media_post_media']=(object)[];  
                }
                
            
            }
            
        }
        
        $result_data['data']=$new_array;
        return $result_data;
     }     
}
public function post_finish_success_2(&$inputParams = array()){
   $result_data = parent::post_finish_success_2($inputParams);
  # pr($result_data,1);
   $new_array=array();$set_value1=[];
     if(!empty($result_data)){
         foreach ($result_data['data']['get_media_posts'] as $key => $obj_value){
            $new_array[$key] = $obj_value; 
         }     
        $post_id_ary=[];$n_ary=[];
        #pr($result_data['data'],1);
        foreach ($result_data['data']['get_media_post_media'] as $key => $obj_value1) {
         
             $n_ary[]=$obj_value1['pm_post_id'];
             $post_id_ary[$obj_value1['pm_post_id']][]=$obj_value1; 
        }
        #pr($post_id_ary,1);
        if(!empty($new_array)) {
            foreach ($new_array as $key =>$value) {
                if(in_array($value['post_id'],$n_ary)){
                  $new_array[$key]['get_media_post_media']=$post_id_ary[$value['post_id']][0];  
                }    
                else{
                  $new_array[$key]['get_media_post_media']=(object)[];  
                }
                
            
            }
            
        }
       # pr($new_array,1);
        $result_data['data']=$new_array;
        return $result_data;
     }
}
}
