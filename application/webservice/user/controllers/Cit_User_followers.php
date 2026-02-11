<?php

   
/**
 * Description of User Followers Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended User Followers
 *
 * @class Cit_User_followers.php
 *
 * @path application\webservice\user\controllers\Cit_User_followers.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 03.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_User_followers extends User_followers {
        public function __construct()
{
    parent::__construct();
}

public function getSearchIds($input_params='')
{
    $search_ids = array();
    if(!empty($input_params['get_my_followers']))
    {
        foreach ($input_params['get_my_followers'] as $val){
            $search_ids[] = $val['u_users_id'];
        }
        $return_arr[0]['search_ids'] = $search_ids;
    }
    return $return_arr;
}
public function modifyDetails(&$input_params = array())
{
    if(!empty($input_params['fetch_is_follwing_v1'])){
     foreach ($input_params['fetch_is_follwing_v1'] as $val){
            $is_follwing[$val['uf_user_id_2']]['status'] = $val['uf_status_1'];
            $is_follwing[$val['uf_user_id_2']]['follower_id'] = $val['uf_user_follower_id_1'];
        }
    }
    if(!empty($input_params['fetch_follower_count_v1'])){
     foreach ($input_params['fetch_follower_count_v1'] as $val){
        $follower_count[$val['uf_user_id']] = $val['user_follower_count'];
     }    
    }
    if(!empty($input_params['fetch_following_count_v1'])){
     foreach ($input_params['fetch_following_count_v1'] as $val){
        $following_count[$val['uf_follower_id']] = $val['user_following_count'];
      }    
    }
    if(!empty($input_params['get_post_count_v1'])){
     foreach ($input_params['get_post_count_v1'] as $val){
        $post_count[$val['p_user_id']] = $val['post_id'];
     }     
    }
    if(!empty($input_params['get_my_followers'])){
     foreach ($input_params['get_my_followers'] as $key => $val){
        $val['is_following'] = "No";
        if($is_follwing_val == 'Accepted'){
			$val['is_following'] = 'Yes';
		} elseif ($is_follwing_val == 'Pending'){
			$val['is_following'] = 'Pending';
		}
        $val['follower_count'] = ($follower_count[$val['u_users_id']] == '' ) ? 0 : $follower_count[$val['u_users_id']];
        $val['following_count'] = ($following_count[$val['u_users_id']] == '' ) ? 0 : $following_count[$val['u_users_id']];
        $val['post_count'] = ($post_count[$val['u_users_id']] == '' ) ? 0 : $post_count[$val['u_users_id']];
        $val['pending_request_id'] = $is_follwing[$val['u_users_id']]['follower_id'];
        $input_params['get_my_followers'][$key] = $val;
    }
    }
    $return_arr = array();
    return $return_arr;    
}
}
