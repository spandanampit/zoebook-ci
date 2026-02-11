<?php

   
/**
 * Description of My Following Requests Extended Controller
 * 
 * @module Extended My Following Requests
 * 
 * @class Cit_My_following_requests.php
 * 
 * @path application\webservice\user\controllers\Cit_My_following_requests.php
 * 
 * @author CIT Dev Team
 * 
 * @date 14.10.2019
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_My_following_requests extends My_following_requests {
        public function __construct()
{
    parent::__construct();
}

public function getUserIds($input_params=array())
{
    if(is_array($input_params['get_follow_request']) && count($input_params['get_follow_request']) > 0)
    {
        foreach ($input_params['get_follow_request'] as $val)
        {
            $user_ids[] = $val['u_users_id'];
        }
        $return_arr[0]['user_ids'] = $user_ids;
    }
    return $return_arr;

}
public function prepareFollowerRequests(&$input_params=array())
{
    $return_arr = $follower_count = $following_count = $post_count = array();
    foreach ( $input_params['get_follower_count_v1'] as $val)
    {
        $follower_count[$val['uf_user_id_1']] = $val['user_follower_count'];
    }
    foreach ( $input_params['get_following_count_v1'] as $val)
    {
        $following_count[$val['uf_follower_id']] = $val['user_following_count'];
    }
    foreach ( $input_params['fetch_post_count_v1'] as $val)
    {
        $post_count[$val['p_user_id']] = $val['user_post_count'];
    }
    
    foreach ($input_params['get_follow_request'] as $key => $val)
    {
        $val['follower_count'] = $follower_count[$val['u_users_id']];
        $val['following_count'] = $following_count[$val['u_users_id']];
        $val['post_count'] = $post_count[$val['u_users_id']];
        $input_params['get_follow_request'][$key] = $val;
    }
    return $return_arr;
}
}
