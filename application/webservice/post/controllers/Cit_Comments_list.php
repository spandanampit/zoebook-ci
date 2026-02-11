<?php

   
/**
 * Description of Comments List Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Comments List
 *
 * @class Cit_Comments_list.php
 *
 * @path application\webservice\post\controllers\Cit_Comments_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Comments_list extends Comments_list {
        public function __construct()
{
    parent::__construct();
}

public function getPostCommentsIds($input_params=array())
{
    $comments_ids = array();
    if(!empty($input_params['get_comments']))
    {
        foreach ($input_params['get_comments'] as $val)
        {
            $comments_ids[] = $val['pc_post_comment_id'];
        }
        $return_arr[0]['comments_ids'] = $comments_ids;
    }
    return $return_arr;
}

public function prepareCommentsList(&$input_params=array())
{
    $return_arr = $comment_likes_count = $is_comment_liked = $reply_count = array();
    if(!empty($input_params['get_count_comment_likes'])){
       foreach ($input_params['get_count_comment_likes'] as $val)
       {
        $comment_likes_count[$val['pcl_post_comment_id']] = $val['comment_likes_count'];
       }    
    }
    if(!empty($input_params['get_is_comment_like'])){
      foreach ($input_params['get_is_comment_like'] as $val)
      {
        $is_comment_liked[$val['pcl_post_comment_id_1']] = $val['is_comment_like_count'];
      }    
    }
    if(!empty($input_params['get_reply_count'])){
      foreach ($input_params['get_reply_count'] as $val)
      {
        $reply_count[$val['pc_parent_id']] = $val['count_post_comment'];
      }    
    }
    if(!empty($input_params['get_comments'])){
        foreach ($input_params['get_comments'] as $key => $val)
        {
            $val['count_comment_likes'] = $comment_likes_count[$val['pc_post_comment_id']];
            $val['is_comment_like'] = $is_comment_liked[$val['pc_post_comment_id']];
            $val['reply_count'] = $reply_count[$val['pc_post_comment_id']];
            $input_params['get_comments'][$key] = $val;
        }
    }    
    return $return_arr;
}
}
