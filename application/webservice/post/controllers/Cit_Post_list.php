<?php

   
/**
 * Description of Post List Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Post List
 *
 * @class Cit_Post_list.php
 *
 * @path application\webservice\post\controllers\Cit_Post_list.php
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
 
Class Cit_Post_list extends Post_list {
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
public function decodeposttext($value) {
    return html_entity_decode($value);
}

public function get_display_image($value ='', $data_arr = array()){
	if (array_key_exists('pm_media_type_3', $data_arr)) {
		$value = $data_arr['pm_upload_file_3'];
		if($data_arr['pm_media_type_3'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail_3'];
		}
	} else if (array_key_exists('pm_media_type_2', $data_arr)) {
		$value = $data_arr['pm_upload_file_2'];
		if($data_arr['pm_media_type_2'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail_2'];
		}
	} else if (array_key_exists('pm_media_type_1', $data_arr)) {
		$value = $data_arr['pm_upload_file_1'];
		if($data_arr['pm_media_type_1'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail_1'];
		}
	} else {
		$value = $data_arr['pm_upload_file'];
		if($data_arr['pm_media_type'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail'];
		}
	}
	return $value;
}

public function get_display_image_others($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file_1'];
	if($data_arr['pm_media_type_1'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail_1'];
	}
	return $value;
}

public function getMyPostIDList($input_params = array())
{
    $get_my_posts = $input_params['get_my_posts'];
    $post_ids = array();
    if(!empty($get_my_posts) && count($get_my_posts)>=1){
     foreach($get_my_posts as $val) {
        $post_ids[] = $val['p_post_id'];
     }
    }
    
    $return_arr = array();
    $return_arr[0]['post_ids'] = $post_ids;
    $return_arr[0]['post_stats_cond'] = " AND `p`.`iPostId` IN('".  @implode("','", $post_ids)."')";
    return $return_arr;
}

public function assignMyPostStats(&$input_params = array())
{
    $get_my_posts = $input_params['get_my_posts'];
    $get_comment_stats = $input_params['get_my_post_comment_stats'];
    $get_like_stats = $input_params['get_my_post_like_stats'];
    $get_share_stats = $input_params['get_my_post_share_stats'];
    if(!empty($get_my_posts)) {
      foreach($get_my_posts as $outerKey => $outerVal)
      {
        if(!empty($get_comment_stats) && count($get_comment_stats) > 0)
        {
            foreach($get_comment_stats as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_c'])  // ps_post_id  // p_post_id_c
                {
                    $input_params['get_my_posts'][$outerKey]['comment_count'] = $innerVal['ps_total_comments'];
                    break;
                }
            }
        }
        if(!empty($get_like_stats) && count($get_like_stats) > 0)
        {
            foreach($get_like_stats as $innerVal)
            {
                if($outerVal['p_post_id_l'] == $innerVal['ps_post_id'])
                {
                    $input_params['get_my_posts'][$outerKey]['likes_count'] = $innerVal['ps_total_likes'];
                    break;
                }
            }
        }
        if(!empty($get_share_stats) && count($get_share_stats) > 0)
        {
            foreach($get_share_stats as $innerVal)
            {
                if($outerVal['p_post_id_s'] == $innerVal['ps_post_id'])
                {
                    $input_params['get_my_posts'][$outerKey]['shared_count'] = $innerVal['ps_total_shares'];
                    break;
                }
            }
        }
      }
    }
    
    $return_arr = array();
    return $return_arr;
}
public function fetch_postIDs($input_params=array()){
  $posts = $input_params['get_my_posts'];
  $post_id=[];
  if(!empty($posts) && count($posts)) {
    foreach ($posts as $key=>$value) {
      $post_id[] = $value['p_post_id'];    
    }         
  }
  if(!empty($post_id) && count($post_id)>=1) {
    $return_arr[0]['post_id'] =implode("','",$post_id);
  } else {
    $return_arr[0]['post_id'] = array();  
  }
  #pr($post_id,1);
  return $return_arr ;
  
}
public function fetch_user_post_id($input_params=array()) {
  $posts = $input_params['get_user_posts'];
  $post_id=[];
  if(!empty($posts) && count($posts)) {
    foreach ($posts as $key=>$value) {
      $post_id[] = $value['p_post_id_1'];    
    }         
  }
  if(!empty($post_id) && count($post_id)>=1) {
    $return_arr[0]['user_post_id'] =implode("','",$post_id);
  } else {
    $return_arr[0]['user_post_id'] = array();  
  }
  #pr($posts,1);
  return $return_arr ;  
}
public function getUserPostIDList($input_params = array())
{
    $get_user_posts = $input_params['get_user_posts'];
    $post_ids_1 = array();
    if(!empty($get_user_posts) && count($get_user_posts)>=1){
     foreach($get_user_posts as $val)
     {
        $post_ids_1[] = $val['p_post_id_1'];
    }
    }
    $return_arr = array();
    $return_arr[0]['post_ids_1'] = $post_ids_1;
    $return_arr[0]['post_stats_cond_1'] = " AND `p`.`iPostId` IN('".  @implode("','", $post_ids_1)."')";
    return $return_arr;
}

public function assignUserPostStats(&$input_params = array())
{
    $get_user_posts = $input_params['get_user_posts'];
    $get_comment_stats = $input_params['get_user_post_comment_stats'];
    $get_like_stats = $input_params['get_user_post_like_stats'];
    $get_share_stats = $input_params['get_user_post_share_stats'];
    if(!empty($get_user_posts) && count($get_user_posts)>=1){
     foreach($get_user_posts as $outerKey => $outerVal)
     {
        if(is_array($get_comment_stats) && count($get_comment_stats) > 0)
        {
            foreach($get_comment_stats as $innerVal)
            {
                if($outerVal['p_post_id_1'] == $innerVal['ps_post_id_c1']) // ps_post_id_1 // p_post_id_c1
                {
                    $input_params['get_user_posts'][$outerKey]['comment_count_1'] = $innerVal['ps_total_comments_1'];
                    break;
                }
            }
        }
        if(is_array($get_like_stats) && count($get_like_stats) > 0)
        {
            foreach($get_like_stats as $innerVal)
            {
                if($outerVal['p_post_id_l1'] == $innerVal['ps_post_id_1'])
                {
                    $input_params['get_user_posts'][$outerKey]['likes_count_1'] = $innerVal['ps_total_likes_1'];
                    break;
                }
            }
        }
        if(is_array($get_share_stats) && count($get_share_stats) > 0)
        {
            foreach($get_share_stats as $innerVal)
            {
                if($outerVal['p_post_id_s1'] == $innerVal['ps_post_id_1'])
                {
                    $input_params['get_user_posts'][$outerKey]['shared_count_1'] = $innerVal['ps_total_shares_1'];
                    break;
                }
            }
        }
    }
    }
    
    $return_arr = array();
    return $return_arr;
}

public function assignActualPostStats(&$input_params = array())
{
    $get_actual_post = $input_params['get_actual_post'];
    $get_post_statistics = $input_params['get_actual_post_statistics'];
    if(!empty($get_actual_post) && count($get_actual_post) >=1) {
     foreach($get_actual_post as $outerKey => $outerVal)
     {
        if(!empty($get_post_statistics) && count($get_post_statistics) > 0)
        {
            foreach($get_post_statistics as $innerVal)
            {
                if($outerVal['p_post_id_2'] == $innerVal['ps_post_id_2'])
                {
                    $input_params['get_actual_post'][$outerKey]['comment_count_2'] = $innerVal['ps_total_comments_2'];
                    $input_params['get_actual_post'][$outerKey]['likes_count_2'] = $innerVal['ps_total_likes_2'];
                    $input_params['get_actual_post'][$outerKey]['shared_count_2'] = $innerVal['ps_total_shares_2'];
                    break;
                }
            }
        }
     }
    }
    $return_arr = array();
    return $return_arr;
}

public function assignUserActualPostStats(&$input_params = array())
{
    $get_user_actual_post = $input_params['get_user_actual_post'];
    $get_post_statistics = $input_params['get_user_actual_post_statistics'];
    if(!empty($get_user_actual_post) && count($get_user_actual_post)>=1){
     foreach($get_user_actual_post as $outerKey => $outerVal)
     {
        if(is_array($get_post_statistics) && count($get_post_statistics) > 0)
        {
            foreach($get_post_statistics as $innerVal)
            {
                if($outerVal['p_post_id_3'] == $innerVal['ps_post_id_3'])
                {
                    $input_params['get_user_actual_post'][$outerKey]['comment_count_3'] = $innerVal['ps_total_comments_3'];
                    $input_params['get_user_actual_post'][$outerKey]['likes_count_3'] = $innerVal['ps_total_likes_3'];
                    $input_params['get_user_actual_post'][$outerKey]['shared_count_3'] = $innerVal['ps_total_shares_3'];
                    break;
                }
            }
        }
    }
    }
    
    $return_arr = array();
    return $return_arr;
}

public function getVideoHeight(){
    return 800;
}
public function getVideoWidth(){
    return 800;
}
public function getMyVideoHeight(){
    return 800;
}
public function getUserUpdateDate(){
    $date=date('Y-m-d H:i:s');
    $dates = "'$date'"; 
    return $dates; 
}
public function getLiveVideoURL(&$input_params = array()){
    if(!empty($input_params['get_my_posts'])) {
      foreach ($input_params['get_my_posts'] as &$data_arr){
        if($data_arr['p_post_type']=='Live'){
            $data_arr['live_video_url'] = $this->general->get_archive_video($data_arr['ts_archive_id']);
        }elseif($data_arr['p_post_type']=='LiveNow'){
            $data_arr['live_video_url'] = '';
        }else{
            $data_arr['live_video_url'] = '';
        }
    }
    }
    $return_arr = array();
    
    return $return_arr;
}
public function addAdsMyPost(&$input_params = array()){
    if(!isset($input_params['page_index'])){
            $input_params['page_index']=1;
    }
    
    if($input_params['is_ads_show']==1){
        $advrtisment_position=$this->config->item('GOOGLE_AD_POSITION_POSTLIST')-1;
        $total=count($input_params['get_my_posts']);
        
        if(empty($input_params['page_index']) || $input_params['page_index']==1)
        {
        $start_index=1;    
        }else{
            $start_index = (($input_params['page_index']*$total)-$total)+1;
            if($total!= 20){
            $start_index = (($input_params['page_index']*20)-20)+1;
            }
        }
        
        $end_index = $input_params['page_index']*$total;
        if($total != 20){
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
            $temp_array_key = array_keys($input_params['get_my_posts'][0]);
            $temp_array_val = array_fill(0,count($temp_array_key),'');
            $temp_array[0] = array_combine($temp_array_key,$temp_array_val);
            $temp_array[0]['p_post_type'] = 'Google_Ads';
            $temp_array[0]['get_my_post_media'] = [];
            $temp_array[0]['get_actual_post_media'] = [];
            $temp_array[0]['get_actual_post'] = (object)[];
            #pr($input_params,1);   
            #get_actual_post_media
            foreach ($store_index as $value){
                $index=  $value-$start_index;
                array_splice( $input_params['get_my_posts'],$index, 0, $temp_array );
            }
        }
    }
}
public function addAdsUserPost(&$input_params = array()){
    if(!isset($input_params['page_index'])){
            $input_params['page_index']=1;
    }
    
    if($input_params['is_ads_show']==1){
        $advrtisment_position=$this->config->item('GOOGLE_AD_POSITION_POSTLIST')-1;
        $total=count($input_params['get_user_posts']);
        
        if(empty($input_params['page_index']) || $input_params['page_index']==1)
        {
        $start_index=1;    
        }else{
            $start_index = (($input_params['page_index']*$total)-$total)+1;
            if($total != 20){
            $start_index = (($input_params['page_index']*20)-20)+1;
            }
        }
        
        $end_index = $input_params['page_index']*$total;
        if($total != 20){
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
            $temp_array_key = array_keys($input_params['get_user_posts'][0]);
            $temp_array_val = array_fill(0,count($temp_array_key),'');
            $temp_array[0] = array_combine($temp_array_key,$temp_array_val);
            #pr($input_params,1);
            $temp_array[0]['p_post_type_1'] = 'Google_Ads';
            $temp_array[0]['get_user_post_media'] = [];
            $temp_array[0]['get_actual_post_media'] = [];
            $temp_array[0]['get_user_actual_post'] = (object)[];
            foreach ($store_index as $value){
                $index=  $value-$start_index;
                array_splice( $input_params['get_user_posts'],$index, 0, $temp_array );
            }
        }
    }
}
public function post_finish_success_2(&$input_params = array()) {
   $result_data = parent::post_finish_success_2($input_params);
   #pr($result_data['data'],1);
   unset($result_data['data']['get_posts']['get_user_actual_post']);
   unset($result_data['data']['get_posts']['get_post_media']);
   unset($result_data['data']['get_posts']['get_user_actual_post']);
   $new_array=array();$post_id_ary=[];$get_post_media=[];$get_user_actual_post=[];$get_actual_post_media=[];
   if(!empty($result_data)){
    foreach ($result_data['data']['get_posts'] as $key=>$value) {
       $new_array[$key] = $value;
       //$new_array[$key]['get_actual_post_media'] = '';
    }
    if(!empty($result_data['data']['get_user_actual_post']) && count($result_data['data']['get_user_actual_post'])>=1){
      foreach ($result_data['data']['get_user_actual_post'] as $key=>$value) {
       $get_user_actual_post[$value['p_post_id']][] = $value;
      }  
    }
    // if(!empty($result_data['data']['get_actual_post_media']) && count($result_data['data']['get_actual_post_media'])>=1){
    //   foreach ($result_data['data']['get_actual_post_media'] as $key=>$value) {
    //   $get_actual_post_media[$value['pm_post_id']][] = $value;
    //   }  
    // } else {
    //     $new_array[$key]['get_actual_post_media']=array(); 
    // } 
    
    foreach ($result_data['data']['get_post_media'] as $k => $obj_value1){
       $get_post_media[$obj_value1['post_id']][]=$obj_value1; 
       $post_id_ary[] = $obj_value1['post_id'];
    }
    
    if(!empty($new_array)){
        foreach ($new_array as $key =>$value){
          #pr($value,1);
        
          if(in_array($value['post_id'],$post_id_ary)){
                 #pr($value['post_id']); 
            $new_array[$key]['get_post_media']=$get_post_media[$value['post_id']];  
            // $new_array[$key]['get_user_actual_post']=$get_user_actual_post[$value['post_id']];
            // $new_array[$key]['get_actual_post_media']=$get_post_media[$value['post_id']];
         }else{
           
             $new_array[$key]['get_post_media']=array(); 
             $new_array[$key]['get_actual_post_media']=array();
             $new_array[$key]['get_user_actual_post']=array();
         }
      }  
    }
    $current_page=$result_data['settings']['curr_page'];
    unset($result_data['data']['get_post_media']);
    unset($result_data['data']['get_actual_post_media']);

    // if($current_page>0)
    //     {
    //         $prev_page  = $current_page-1;
    //         $next_page  = $current_page+1;
    //         $result_data['settings']['count'] = count($new_array['data']);
    //         $result_data['settings']['prev_page']  = $prev_page;
    //         $result_data['settings']['next_page']  = 1;
    //     }
    #pr($new_array,1);
    $result_data['data']=$new_array;
    return $result_data;
       
   }       
}
public function post_finish_success(&$input_params = array()) {
  $result_data = parent::post_finish_success($input_params);
  $new_array=array();$post_id_ary=[];$get_post_media=[];$get_user_actual_post=[];$get_actual_post_media=[];
   #pr($result_data['data'],1);
   unset($result_data['data']['get_posts']['get_user_actual_post']);
   unset($result_data['data']['get_posts']['get_post_media']);
   unset($result_data['data']['get_posts']['get_user_actual_post']);
  if(!empty($result_data)){
    foreach ($result_data['data']['get_posts'] as $key=>$value) {
       $new_array[$key] = $value;
    }
    if(!empty($result_data['data']['get_user_actual_post']) && count($result_data['data']['get_user_actual_post'])>=1){
      foreach ($result_data['data']['get_user_actual_post'] as $key=>$value) {
       $get_user_actual_post[$value['p_post_id']][] = $value;
      }  
    }
    if(!empty($result_data['data']['get_post_media']) && count($result_data['data']['get_post_media'])>=1){
      foreach ($result_data['data']['get_post_media'] as $key=>$value) {
       $get_actual_post_media[$value['pm_post_id']][] = $value;
      }  
    }
    foreach ($result_data['data']['get_post_media'] as $k => $obj_value1){
       $get_post_media[$obj_value1['post_id']][]=$obj_value1; 
       $post_id_ary[] = $obj_value1['post_id'];
    }
    if(!empty($new_array)){
        foreach ($new_array as $key =>$value){
          #pr($value,1);
        
          if(in_array($value['post_id'],$post_id_ary)){
                 #pr($value['post_id']); 
            $new_array[$key]['get_post_media']=$get_post_media[$value['post_id']]; 
            // $new_array[$key]['get_user_actual_post']=$get_user_actual_post[$value['post_id']];
           $new_array[$key]['get_actual_post_media']=$get_post_media[$value['post_id']];
         }else{
           
             $new_array[$key]['get_post_media']=array(); 
             $new_array[$key]['get_actual_post_media']=array();
            //  $new_array[$key]['get_actual_post_media']=array();
            //  $new_array[$key]['get_user_actual_post']=array();
            
         }
      }  
    }
    #$unset($result_data['data']['get_post_media']);
    unset($result_data['data']['get_post_media']);
     unset($result_data['data']['get_actual_post_media']);
    // $current_page=$result_data['settings']['curr_page'];
    // if($current_page>0) {
    //         $prev_page  = $current_page-1;
    //         $next_page  = $current_page+1;
    //         $result_data['settings']['count'] = count($new_array['data']);
    //         $result_data['settings']['prev_page']  = $prev_page;
    //         $result_data['settings']['next_page']  = 1;
    // }
    #pr($new_array,1);
    $result_data['data']=$new_array;
    return $result_data;
  }
  
}
}
