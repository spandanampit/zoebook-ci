<?php

   
/**
 * Description of Add Post Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Add Post
 *
 * @class Cit_Add_post.php
 *
 * @path application\webservice\post\controllers\Cit_Add_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.10.2021
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Add_post extends Add_post {
        public function __construct()
{
    parent::__construct();
}

public function get_post_status($value='',$dataArr=array()){
	$ret_value = 'Active';
	if($dataArr['post_type'] == 'Media' || $dataArr['post_type'] == 'Image' || $dataArr['post_type'] == 'Video'){
		$ret_value = 'Inprogress';
	}
	return $ret_value;
	
}

public function getPostTextEmoji($value='',$dataArr=array()) {
    if($dataArr['post_text_emoji'] == '') {
        $output=$dataArr['post_text'];
    } else {
        $output=$dataArr['post_text_emoji'];
    }
    return $output;
}
}
