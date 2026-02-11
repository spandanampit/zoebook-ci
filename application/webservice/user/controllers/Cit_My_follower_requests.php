<?php

   
/**
 * Description of My Follower Requests Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended My Follower Requests
 *
 * @class Cit_My_follower_requests.php
 *
 * @path application\webservice\user\controllers\Cit_My_follower_requests.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.07.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_My_follower_requests extends My_follower_requests {
        public function __construct()
{
    parent::__construct();
}

public function getUserIds($input_params=array())
{
    if(!empty($input_params['get_follower_requests']))
    {
        foreach ($input_params['get_follower_requests'] as $val)
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
    if(!empty($input_params['get_follower_count'])){
        foreach ($input_params['get_follower_count'] as $val)
        {
            $follower_count[$val['uf_user_id_1']] = $val['user_follower_count'];
        }    
    }
    if(!empty($input_params['get_following_count'])){
        foreach ( $input_params['get_following_count'] as $val)
        {
            $following_count[$val['uf_follower_id']] = $val['user_following_count'];
        }
    }
    if(!empty($input_params['fetch_post_count'])){
       foreach ($input_params['fetch_post_count'] as $val)
       {
        $post_count[$val['p_user_id']] = $val['user_post_count'];
       }            
    }
    if(!empty($input_params['get_follower_requests'])){
      foreach ($input_params['get_follower_requests'] as $key => $val)
      {
        $val['follower_count'] = $follower_count[$val['u_users_id']];
        $val['following_count'] = $following_count[$val['u_users_id']];
        $val['post_count'] = $post_count[$val['u_users_id']];
        $input_params['get_follower_requests'][$key] = $val;
      }  
    }
    return $return_arr;
}
}
