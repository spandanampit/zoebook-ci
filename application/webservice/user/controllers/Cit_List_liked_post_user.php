<?php

   
/**
 * Description of List Liked Post User Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended List Liked Post User
 *
 * @class Cit_List_liked_post_user.php
 *
 * @path application\webservice\user\controllers\Cit_List_liked_post_user.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 09.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_List_liked_post_user extends List_liked_post_user {
        public function __construct()
{
    parent::__construct();
}

// public function checkUserFollowing($value='',$dataArr=array()){
// 	$ret_value = 'No';
// 	if(!empty($value) && $value != ''){
// 		if($value == 'Accepted'){
// 			$ret_value = 'Yes';
// 		}elseif($value == 'Pending'){
// 			$ret_value = 'Pending';
// 		}
// 	}
// 	return $ret_value;
// }


public function getSearchIds($input_params=array())
{
    $search_ids = array();
    if(!empty($input_params['get_user_data_v1']))
    {
        foreach($input_params['get_user_data_v1'] as $val){
            $search_id['users_id'] = $val['u_users_id'];
            $search_ids[] = $search_id;
        }
        $return_arr[0]['search_ids'] = $search_ids;
    }
    return $return_arr;
}

public function modifyDetails(&$input_params = array())
{   
    if(!empty($input_params['fetch_is_follwing_v3'])){
      foreach ($input_params['fetch_is_follwing_v3'] as $val){
        $is_follwing[$val['uf_user_id_2']]['status'] = $val['uf_status'];
        $is_follwing[$val['uf_user_id_2']]['follower_id'] = $val['uf_user_follower_id'];
      }    
    }
    if(!empty($input_params['fetch_follower_count_v3'])){
     foreach ($input_params['fetch_follower_count_v3'] as $val){
        $follower_count[$val['uf_user_id']] = $val['user_follower_count'];
     }    
    }
    if(!empty($input_params['fetch_following_count_v3'])){
     foreach ($input_params['fetch_following_count_v3'] as $val){
        $following_count[$val['uf_user_id_1']] = $val['user_following_count'];
     }    
    }
    if(!empty($input_params['get_post_count_v3'])){
     foreach ($input_params['get_post_count_v3'] as $val)
     {
        $post_count[$val['p_user_id']] = $val['post_id'];
    }
    }
    if(!empty($input_params['get_user_data_v1'])){
     foreach ($input_params['get_user_data_v1'] as $key => $val)
     {
        $is_follwing_val = $is_follwing[$val['u_users_id']]['status'];
        $val['is_follwing'] = "No";
        if($is_follwing_val == 'Accepted'){
			$val['is_follwing'] = 'Yes';
		} elseif ($is_follwing_val == 'Pending'){
			$val['is_follwing'] = 'Pending';
		}
		
        $val['follower_count'] = ($follower_count[$val['u_users_id']] == '' ) ? 0 : $follower_count[$val['u_users_id']];
        $val['following_count'] = ($following_count[$val['u_users_id']] == '' ) ? 0 : $following_count[$val['u_users_id']];
        $val['post_count'] = ($post_count[$val['u_users_id']] == '' ) ? 0 : $post_count[$val['u_users_id']];
        $val['pending_request_id'] = $is_follwing[$val['u_users_id']]['follower_id'];
        $input_params['get_user_data_v1'][$key] = $val;
    }
    }
    $return_arr = array();
    return $return_arr;    
}
}
