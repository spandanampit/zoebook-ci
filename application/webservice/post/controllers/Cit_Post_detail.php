<?php

   
/**
 * Description of Post Detail Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Post Detail
 *
 * @class Cit_Post_detail.php
 *
 * @path application\webservice\post\controllers\Cit_Post_detail.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 18.11.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Post_detail extends Post_detail {
        public function __construct()
{
    parent::__construct();
}

function share_postdetail_url($result_data = '') {
    $enc_id = $this->general->encryptDataMethod($result_data, "cit");
    $geturl = $this->config->item('site_url').'post-detail-'.$enc_id.'.html';
    return $geturl;
}

public function get_display_image($result_data ='', $data_arr = array()){
	$result_data = $data_arr['pm_upload_file'];
	if($data_arr['pm_media_type'] == 'Video'){
		$result_data = $data_arr['pm_video_thumbnail'];
	}
	return $result_data;
}

public function assignPostDetailStats(&$input_params = array())
{
    $get_post_details = $input_params['get_post_details'];
    $post_comment_statistics = $input_params['get_post_detail_comment_stats'];
    $post_like_statistics = $input_params['get_post_detail_like_stats'];
    $post_share_statistics = $input_params['get_post_detail_share_stats'];
    $post_ids = array();
    if(!empty($get_post_details)){
       foreach($get_post_details as $outerKey => $outerVal)
       {
        if(!empty($post_comment_statistics) && count($post_comment_statistics) > 0)
        {
            foreach($post_comment_statistics as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_c'])
                {
                    $input_params['get_post_details'][$outerKey]['comment_count'] = $innerVal['ps_total_comments'];
                    break;
                }
            }
        }
        if(!empty($post_like_statistics) && count($post_like_statistics) > 0)
        {
            foreach($post_like_statistics as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_l'])
                {
                    $input_params['get_post_details'][$outerKey]['likes_count'] = $innerVal['ps_total_likes'];
                    break;
                }
            }
        }
        if(!empty($post_share_statistics) && count($post_share_statistics) > 0)
        {
            foreach($post_share_statistics as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_s'])
                {
                    $input_params['get_post_details'][$outerKey]['shared_count'] = $innerVal['ps_total_shares'];
                    break;
                }
            }
        }
    }  
    }
   
    
    $return_arr = array();
    return $return_arr;
}
public function post_finish_success_1(&$input_params = array()) {
  $result_data = parent::post_finish_success_1($input_params);
  $set_result_data1=[];$post_media=[];$post_media_list=[];$tok_list=[];
  #pr($result_data['data']['get_post_details'],1);
  if(!empty($result_data)) {
   
      $set_result_data1['is_like'] = $result_data['data']['get_post_details']['is_like'];
      $set_result_data1['post_media_id'] = $result_data['data']['get_post_details']['post_media_id'];
      $set_result_data1['comment_count'] = $result_data['data']['get_post_details']['comment_count'];
      $set_result_data1['likes_count'] = $result_data['data']['get_post_details']['likes_count'];
      $set_result_data1['shared_count'] = $result_data['data']['get_post_details']['shared_count'];
      $set_result_data1['u_latitude'] = $result_data['data']['get_post_details']['u_latitude'];
      $set_result_data1['u_longtitude'] = $result_data['data']['get_post_details']['u_longtitude'];
      $set_result_data1['p_post_meta_data'] = $result_data['data']['get_post_details']['p_post_meta_data'];
      $set_result_data1['share_postdetail_url'] = $result_data['data']['get_post_details']['share_postdetail_url'];
      
      $set_result_data1['visibility'] = $result_data['data']['get_post_details']['visibility'];
      $set_result_data1['post_id'] = $result_data['data']['get_post_details']['post_id'];
      $set_result_data1['posted_user_id'] = $result_data['data']['get_post_details']['posted_user_id'];
      $set_result_data1['post_type'] = $result_data['data']['get_post_details']['post_type'];
      
      $set_result_data1['post_text_emoji'] = $result_data['data']['get_post_details']['post_text_emoji'];
      
      $set_result_data1['added_date'] = $result_data['data']['get_post_details']['added_date'];
      $set_result_data1['user_name'] = $result_data['data']['get_post_details']['user_name'];
      
      $set_result_data1['user_profile_image'] = $result_data['data']['get_post_details']['user_profile_image'];
     // $set_result_data1['visibility'] = $result_data['visibility'];
      $set_result_data1['impression_count'] = $result_data['data']['get_post_details']['impression_count'];
      
      $set_result_data1['is_impressed'] = $result_data['is_impressed'];
      $set_result_data1['expire_date'] = $result_data['expire_date'];
      $set_result_data1['post_text'] = $result_data['data']['get_post_details']['post_text_emoji'];
      $new_array = $set_result_data1;
      #pr($new_array,1);
      if(!empty($result_data['data']['get_post_media']) && count($result_data['data']['get_post_media'])>=1){
        foreach ($result_data['data']['get_post_media'] as $key => $value) {
          $post_media[] = $value;   
        }
       }
       if(!empty($result_data['data']['get_post_media']) && count($result_data['data']['get_post_media'])>=1){
       foreach ($result_data['data']['get_post_media_list'] as $key => $value) {
          $post_media_list[] = $value;   
        } 
       }
       if(!empty($result_data['data']['get_tokbox_detail']) && count($result_data['data']['get_tokbox_detail'])){
        foreach ($result_data['data']['get_tokbox_detail'] as $key => $value) {
          $tok_list[] = $value;   
        }    
       }
        if(!empty($new_array)) {
            $new_array['get_post_media'] = !empty($post_media) ?$post_media:array();
            $new_array['get_post_media_list'] =!empty($post_media_list) ?$post_media_list:array();
            if(!empty($tok_list) && count($tok_list)>=1){
               $new_array['get_tokbox_detail']  =$tok_list;
            }
        }
        $result_data['data']=$new_array;
        
        return $result_data;
       
    }  
   
  
}
}
