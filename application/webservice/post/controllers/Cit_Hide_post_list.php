<?php

   
/**
 * Description of Hide post list Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Hide post list
 *
 * @class Cit_Hide_post_list.php
 *
 * @path application\webservice\post\controllers\Cit_Hide_post_list.php
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
 
Class Cit_Hide_post_list extends Hide_post_list {
        public function __construct()
{
    parent::__construct();
}

public function post_detail_url($value) {
    $getval = @explode('@@',$value);
    if(!empty($value)){
      $enc_id = $this->general->encryptDataMethod($getval[1], "cit");
      $url = $this->config->item('site_url').'post-detail-'.$enc_id.'.html';
    }
    return $url;
}

public function getUserPostIDList($input_params = array())
{
    $get_hide_post = $input_params['get_hide_post'];
    $post_ids = array();
    if(!empty($post_ids)){
      foreach($get_hide_post as $val){
        $post_ids[] = $val['p_post_id'];
      } 
      $return_arr = array();
      $return_arr[0]['post_ids'] = $post_ids;
      $return_arr[0]['post_stats_cond'] = " AND `p`.`iPostId` IN('".  @implode("','", $post_ids)."')";
    }
    return $return_arr;
}

public function assignUserPostStats(&$input_params = array())
{
    $get_hide_post = $input_params['get_hide_post'];
    $get_comment_stats = $input_params['get_user_post_comment_stats1'];
    $get_like_stats = $input_params['get_user_post_like_stats1'];
    $get_share_stats = $input_params['get_user_post_share_stats1'];
    if(!empty($get_hide_post) && count($get_hide_post)>=1){
      foreach($get_hide_post as $outerKey => $outerVal)
      {
            if(!empty($get_comment_stats) && count($get_comment_stats)>=1)
            {
                foreach($get_comment_stats as $innerVal)
                {
                    if($outerVal['p_post_id'] == $innerVal['ps_post_id_c']) // ps_post_id_1 // p_post_id_c1
                    {
                        $input_params['get_hide_post'][$outerKey]['comment_count'] = $innerVal['ps_total_comments'];
                        break;
                    }
                }
            }
            if(!empty($get_like_stats) && count($get_like_stats)>=1)
            {
                foreach($get_like_stats as $innerVal)
                {
                    if($outerVal['p_post_id_l'] == $innerVal['ps_post_id'])
                    {
                        $input_params['get_hide_post'][$outerKey]['likes_count'] = $innerVal['ps_total_likes'];
                        break;
                    }
                }
            }
            if(!empty($get_share_stats) && count($get_share_stats)>=1)
            {
                foreach($get_share_stats as $innerVal)
                {
                    if($outerVal['p_post_id_s'] == $innerVal['ps_post_id'])
                    {
                        $input_params['get_hide_post'][$outerKey]['shared_count'] = $innerVal['ps_total_shares'];
                        break;
                    }
                }
            }
        }
    }
    $return_arr = array();
    return $return_arr;
}

public function get_display_image_others($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file'];
	if($data_arr['pm_media_type'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail'];
	}
	return $value;
}

public function addAdsHidePost(&$input_params = array()){
        if(!isset($input_params['page_index'])){
            $input_params['page_index']=1;
        }
        $advrtisment_position=$this->config->item('GOOGLE_AD_POSITION_POSTLIST')-1;
        $total=count($input_params['get_hide_post']);
        if($input_params['is_ads_show']==1){
            
                if(!empty($input_params['page_index']) && $input_params['page_index']!=1)
                {
                    if($total==20){
                    $start_index = (($input_params['page_index']*$total)-$total)+1;
                    }else{
                    $start_index = (($input_params['page_index']*20)-20)+1;   
                    }
                }else{
                    $start_index=1; 
                }
                if($total==20){
                $end_index = $input_params['page_index']*$total+1;
                }else{
                $end_index = $total;  
                }
                $store_index = array();
                for($i=$end_index; $i>=$start_index; $i--){
                    if($i%$advrtisment_position==0){
                       $store_index[] = $i+1; 
                    }
                }
                if(($input_params['page_index']==1 && $total<$advrtisment_position)){
                }else{
                    $temp_array_key = array_keys($input_params['get_hide_post'][0]);
                    $temp_array_val = array_fill(0,count($temp_array_key),'');
                    $temp_array[0] = array_combine($temp_array_key,$temp_array_val);
                    $temp_array[0]['p_post_type'] = 'Google_Ads';
                    $temp_array[0]['get_user_post_media1'] = [];
                    foreach ($store_index as $value){
                        $index=  $value-$start_index;
                        array_splice($input_params['get_hide_post'],$index, 0, $temp_array);
                    }
                }
                    
            }
}
public function post_ids($input_params = array()) {
      $get_hide_post = $input_params['get_hide_post'];
      if(!empty($get_hide_post)){
        $post_ids=[];
        foreach($get_hide_post as $key=>$value){
          $post_ids[]=$value['p_post_id'];    
        }
        #pr($v_post_ids,1);
        if(!empty($post_ids)){
          $return_arr[0]['post_id']=implode("','",$post_ids);
          #pr( $return_arr,1);
          return $return_arr;
        }else{$return_arr = array();}
        return $return_arr;      
      }  
}
public function success(&$inputParams = array()){
  $result_data = parent::success($inputParams);
  $new_array=array();
  if(!empty($result_data)) {
    foreach ($result_data['data']['get_hide_post'] as $key => $obj_value) {
      $new_array[$key] = $obj_value ;  
    }
    $post_media_ary=[];$pp_ids=[];
    foreach ($result_data['data']['get_post_media'] as $k => $obj_value1) {
      $pp_ids[]=$obj_value1['post_id'];
      $post_media_ary[$obj_value1['post_id']][]=$obj_value1;    
    }
    #pr($post_media_ary,1);
    if(!empty($new_array)){
         foreach ($new_array as $key =>$value){
          if(in_array($value['post_id'],$pp_ids)){
            $new_array[$key]['get_post_media']=$post_media_ary[$value['post_id']];  
          }else{
             $new_array[$key]['get_post_media']=[];  
          }
         }  
       }
    // $current_page=$result_data['settings']['curr_page'];
    // if($current_page>0)
    // {
    //         $prev_page  = $current_page-1;
    //         $next_page  = $current_page+1;
    //         //$result_data['settings']['count'] = count($new_array['data']);
    //         //$result_data['settings']['prev_page']  = $prev_page;
    //         //$result_data['settings']['next_page']  = $next_page;
    // } 
    $result_data['data']=$new_array;
    #pr($result_data,1);
    return $result_data;
  }
  
  
}
}
