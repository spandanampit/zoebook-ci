<?php

   
/**
 * Description of Movements post list Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Movements post list
 *
 * @class Cit_Movements_post_list.php
 *
 * @path application\webservice\post\controllers\Cit_Movements_post_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 20.12.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Movements_post_list extends Movements_post_list {
        public function __construct()
{
    parent::__construct();
}

public function getMovementPostIDList($input_params = array())
{
    $movement_post_list = $input_params['movement_post_list'];
    if(!empty($movement_post_list)){
    $post_ids_1 = array();
    foreach($movement_post_list as $val){
        $post_ids_1[] = $val['p_post_id'];
     }
    }
    $return_arr = array();
    $return_arr[0]['post_ids'] = $post_ids_1;
    $return_arr[0]['post_stats_cond'] = " AND `p`.`iPostId` IN('".  @implode("','", $post_ids_1)."')";
    //pr($return_arr,0); 
    return $return_arr;
}

public function assignMovementPostStats(&$input_params = array())
{
    $movement_post_list = $input_params['movement_post_list'];
    $get_comment_stats = $input_params['get_movement_post_count'];
    $get_like_stats = $input_params['get_movements_post_like'];
    $get_share_stats = $input_params['get_movement_post_share_count'];
    $post_ids = array();
    if(!empty($movement_post_list)){
        foreach($movement_post_list as $outerKey => $outerVal)
        {
        if(!empty($get_comment_stats))
        {
            foreach($get_comment_stats as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_1'])
                {
                    $input_params['movement_post_list'][$outerKey]['comment_count_1'] = $innerVal['ps_total_comments_1'];
                    break;
                }
            }
        }
        if(!empty($get_like_stats))
        {
            foreach($get_like_stats as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_2'])
                {
                    $input_params['movement_post_list'][$outerKey]['likes_count_1'] = $innerVal['ps_total_likes_1'];
                    break;
                }
            }
        }
        if(!empty($get_share_stats))
        {
            foreach($get_share_stats as $innerVal)
            {
                if($outerVal['p_post_id'] == $innerVal['ps_post_id_3'])
                {
                    $input_params['movement_post_list'][$outerKey]['shared_count_1'] = $innerVal['ps_total_shares_1'];
                    break;
                }
            }
        }
      }         
    }

}

public function post_detail_url($value) {
    $getval = @explode('@@',$value);
    
    $enc_id = $this->general->encryptDataMethod($getval[1], "cit");
    $url = $this->config->item('site_url').'post-detail-'.$enc_id.'.html';
        
    return $url;
}

public function get_display_image_others($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file'];
	if($data_arr['pm_media_type'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail'];
	}
	return $value;
}

public function addAdsMovementsPost(&$input_params = array()){
       
        if(!isset($input_params['page_index'])){
            $input_params['page_index']=1;
        }
        
        $advrtisment_position=$this->config->item('GOOGLE_AD_POSITION_POSTLIST')-1;
        $total=count($input_params['movement_post_list']);
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
                $end_index = $start_index+$total;
                }
                
                $store_index = array();
                for($i=$end_index; $i>=$start_index; $i--){
                    if($i%$advrtisment_position==0){
                       $store_index[] = $i+1; 
                    }
                }
                //echo $advrtisment_position;
                //pr($store_index);die();
                    
                if(($input_params['page_index']==1 && $total<$advrtisment_position)){
                }else{
                    $temp_array_key = array_keys($input_params['movement_post_list'][0]);
                    $temp_array_val = array_fill(0,count($temp_array_key),'');
                    $temp_array[0] = array_combine($temp_array_key,$temp_array_val);
                    $temp_array[0]['p_post_type'] = 'Google_Ads';
                    $temp_array[0]['get_movement_post_media'] = [];
                    foreach ($store_index as $value){
                        $index=  $value-$start_index;
                        array_splice( $input_params['movement_post_list'],$index, 0, $temp_array );
                    }
                }
                    
            }
        $get_movement_post_media=$input_params['get_movement_post_media'];
        if(!empty($get_movement_post_media)){
          foreach ($get_movement_post_media as $key=>$value){
            $input_params['movement_post_list']['get_movement_post_media']=$value;  
          }  
        }else{
           $input_params['movement_post_list']['get_movement_post_media']=[];    
        }
       # pr($input_params,1);
}

public function moment_post_ids($input_params = array()){
  $movement_post_list=$input_params['movement_post_list'];
   #pr($movement_post_list,1);
  if(!empty($movement_post_list)){
   $mm_ids=[];
   foreach ($movement_post_list as $key=>$value){
    $mm_ids[]=$value['p_post_id'];     
   }
   $return_arr[0]['mm_ids']=implode("','",$mm_ids);
   
  }
  #pr($return_arr,1);
  return $return_arr;
}
public function post_finish_success_1($input_params = array()) {
    $result_data = parent::post_finish_success_1($input_params);
    #pr($result_data,1);
    $new_array=array();
    unset($result_data['data']['get_posts']['get_movement_post_media']);
    if(!empty($result_data)){
     foreach ($result_data['data']['get_posts'] as $key => $obj_value){
        $new_array[] = $obj_value;
     }     
    }
   
    $get_movement_post_media=[];$mm_ids=[];
    foreach ($result_data['data']['get_movement_post_media'] as $k => $obj_value1){
       $mm_ids[]=$obj_value1['post_id'];
       $get_movement_post_media[$obj_value1['post_id']][]=$obj_value1;
    }
   # pr($result_data['data']['get_movement_post_media'],1);
    if(!empty($get_movement_post_media)){
      foreach ($new_array as $key =>$value){
         if(in_array($value['post_id'],$mm_ids)){
            $new_array[$key]['get_post_media']=$get_movement_post_media[$value['post_id']];  
          }else{
             $new_array[$key]['get_post_media']=[];  
          }
          
      }      
    }
  
    unset($result_data['data']);
    unset($result_data['data']['get_posts']);
    
    $current_page=$result_data['settings']['curr_page'];
    // if($current_page>0)
    // {
    //         $prev_page  = $current_page-1;
    //         $next_page  = $current_page+1;
    //         $result_data['settings']['count'] = count($new_array['data']);
    //         $result_data['settings']['prev_page']  = $prev_page;
    //         $result_data['settings']['next_page']  = $next_page;
    // }
    #pr($new_array,1);
    $result_data['data']=$new_array;
    
    #pr($new_array,1);
    return $result_data;
}
}
