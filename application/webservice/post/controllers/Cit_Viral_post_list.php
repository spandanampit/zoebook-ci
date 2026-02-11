<?php

   
/**
 * Description of Viral Post List Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Viral Post List
 *
 * @class Cit_Viral_post_list.php
 *
 * @path application\webservice\post\controllers\Cit_Viral_post_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 13.10.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Viral_post_list extends Viral_post_list {
        public function __construct()
{
    parent::__construct();
}

public function post_detail_url($value) {
    $getval = @explode('@@',$value);
    
    $enc_id = $this->general->encryptDataMethod($getval[1], "cit");
    $url = $this->config->item('site_url').'post-detail-'.$enc_id.'.html';
        
    return $url;
}

public function get_display_image_others($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file_1'];
	if($data_arr['pm_media_type_1'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail_1'];
	}
	return $value;
}

public function getViralPostIDList($input_params = array())
{
    $get_viral_posts = $input_params['get_viral_posts'];
    #pr($input_params,1);
    if(!empty($get_viral_posts)){
    $post_ids_1 = array();
    foreach($get_viral_posts as $val)
     {
        $post_ids_1[] = $val['p_post_id_1'];
    }
    }
    $return_arr = array();
    $return_arr[0]['post_ids_1'] = $post_ids_1;
    $return_arr[0]['post_stats_cond_1'] = " AND `p`.`iPostId` IN('".  @implode("','", $post_ids_1)."')";
    return $return_arr;
}

public function assignViralPostStats(&$input_params = array())
{
    $get_viral_posts = $input_params['get_viral_posts'];
    #pr($get_viral_posts,1);
    $get_comment_stats = $input_params['get_viral_post_comment_stats'];
    $get_like_stats = $input_params['get_viral_post_like_stats'];
    $get_share_stats = $input_params['get_viral_post_share_stats'];
    $post_ids = array();
    if(!empty($get_viral_posts)){
     foreach($get_viral_posts as $outerKey => $outerVal)
     {
        if(!empty($get_comment_stats))
        {
            foreach($get_comment_stats as $innerVal)
            {
                if($outerVal['p_post_id_1'] == $innerVal['ps_post_id_1'])
                {
                    $input_params['get_viral_posts'][$outerKey]['comment_count_1'] = $innerVal['ps_total_comments_1'];
                    break;
                }
            }
        }
        if(!empty($get_like_stats))
        {
            foreach($get_like_stats as $innerVal)
            {
                if($outerVal['p_post_id_1'] == $innerVal['ps_post_id_2'])
                {
                    $input_params['get_viral_posts'][$outerKey]['likes_count_1'] = $innerVal['ps_total_likes_1'];
                    break;
                }
            }
        }
        if(!empty($get_share_stats))
        {
            foreach($get_share_stats as $innerVal)
            {
                if($outerVal['p_post_id_1'] == $innerVal['ps_post_id_3'])
                {
                    $input_params['get_viral_posts'][$outerKey]['shared_count_1'] = $innerVal['ps_total_shares_1'];
                    break;
                }
            }
        }
     }
    }
    #pr($input_params,1);
    $return_arr = array();
    return $return_arr;
}
public function getUserUpdateDate(){
    $date=date('Y-m-d H:i:s');
    $dates = "'$date'"; 
    return $dates; 
}

public function addAds(&$input_params = array()){
      if(!isset($input_params['page_index'])){
            $input_params['page_index']=1;
        }
      if($input_params['is_ads_show']==1){
        $advrtisment_position=$this->config->item('GOOGLE_AD_POSITION_POSTLIST')-1;
        $total=count($input_params['get_viral_posts']);
        if(empty($input_params['page_index']) || $input_params['page_index']==1){
           $start_index=1;
        }else{
          if($total==20){
            $start_index = (($input_params['page_index']*$total)-$total)+1;
          }else{
            $start_index = (($input_params['page_index']*20)-20)+1;   
          }
        }
        if($total==20){
            $end_index = $input_params['page_index']*$total;
        }else{
            $end_index = $start_index+$total;  
        }
        $store_index = array();
        for($i=$end_index; $i>=$start_index; $i--){
            if($i%$advrtisment_position==0){
               $store_index[] = $i+1; 
            }
        }
        if(($input_params['page_index']==1 && $total<$advrtisment_position)){
        }else{
            $temp_array_key = array_keys($input_params['get_viral_posts'][0]);
            $temp_array_val = array_fill(0,count($temp_array_key),'');
            $temp_array[0] = array_combine($temp_array_key,$temp_array_val);
            $temp_array[0]['p_post_type_1'] = 'Google_Ads';
            $temp_array[0]['get_viral_post_media'] = [];
            foreach ($store_index as $value){
                $index=  $value-$start_index;
                array_splice( $input_params['get_viral_posts'],$index, 0, $temp_array );
            }
        }
      
    }
      
}

public function viral_post_ids($input_params = array()){
  $get_viral_posts = $input_params['get_viral_posts'];
  if(!empty($get_viral_posts)){
    $v_post_ids=[];
    foreach($get_viral_posts as $key=>$value){
      $v_post_ids[]=$value['p_post_id_1'];    
    }
   
    if(!empty($v_post_ids)){
      $return_arr[0]['p_ids']=implode("','",$v_post_ids);
     
      return $return_arr;
    }else{$return_arr = array();}
    return $return_arr;      
  }
}
public function post_finish_success_1(&$inputParams = array()){
  $result_data = parent::post_finish_success_1($inputParams);
  $new_array=array();$set_value1=[];
  #pr($inputParams,1); 
  #pr($result_data['data']['get_viral_post_media'],1);
  if(!empty($result_data)){
    foreach ($result_data['data']['get_viral_posts'] as $key => $obj_value){
      #pr($key,1);
      $set_value[$key]['post_id']=$obj_value['p_post_id'];
      $set_value[$key]['user_name']=$obj_value['user_name'];
      $set_value[$key]['expire_date']=$obj_value['expire_date'];
      $set_value[$key]['user_profile_image']=$obj_value['user_profile_image'];
      $set_value[$key]['is_impressed']=$obj_value['is_impressed'];
      $set_value[$key]['p_post_meta_data']=$obj_value['p_post_meta_data'];
      $set_value[$key]['posted_user_id']=$obj_value['p_user_id'];
      $set_value[$key]['post_type']=$obj_value['p_post_type'];
      $set_value[$key]['post_text_emoji']=$obj_value['p_post_text_1'];
      $set_value[$key]['added_date']=$obj_value['p_added_date_1'];
      $set_value[$key]['is_like']=$obj_value['is_like'];
      $set_value[$key]['status']=$obj_value['p_status'];
      $set_value[$key]['actual_post_id']=$obj_value['p_actual_post_id'];
      $set_value[$key]['visibility']=$obj_value['p_visibility'];
      $set_value[$key]['tokbox_session_id']=$obj_value['ts_tokbox_session_id'];
      $set_value[$key]['impression_count']=$obj_value['p_impression_count'];
      $set_value[$key]['comment_count']=$obj_value['comment_count'];
      $set_value[$key]['likes_count']=$obj_value['likes_count_1'];
      $set_value[$key]['shared_count']=$obj_value['shared_count_1'];
      $set_value[$key]['post_text']=$obj_value['p_post_text_1'];
      $set_value[$key]['post_detail_url']=$obj_value['custom_field'];
    
   
      $new_array= $set_value; 
     
       
     }  
       $post_id_ary=[];$n_ary=[];
       foreach ($result_data['data']['get_viral_post_media'] as $k => $obj_value1){
              
              $n_ary[]=$obj_value1['post_id'];
             $post_id_ary[$obj_value1['post_id']][]=$obj_value1;
       }
      
       if(!empty($post_id_ary)){
         foreach ($new_array as $key =>$value){
           
          if(in_array($value['post_id'],$n_ary)){
            $new_array[$key]['get_post_media']=$post_id_ary[$value['post_id']];  
          }else{
             $new_array[$key]['get_post_media']=[];  
          }
         }  
       }
     
         unset($result_data['data']['assign_user_post_statistics']);
         unset($result_data['data']['fetch_viral_post_ids']);
         unset($result_data['data']['get_viral_post_media']);
         unset($final_result['settings']['fields']); 
        $current_page=$result_data['settings']['curr_page'];
       
        // if($current_page>0)
        // {
        //     $prev_page  = $current_page-1;
        //     $next_page  = 1;
        //     $result_data['settings']['count'] = count($new_array['data']);
        //     $result_data['settings']['prev_page']  = $prev_page;
        //     $result_data['settings']['next_page']  = $next_page;
        // }
  
      $result_data['data']=$new_array;
      return $result_data;
  } 
  
}
}
