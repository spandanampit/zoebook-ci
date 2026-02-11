<?php

   
/**
 * Description of Edit Post Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Edit Post
 *
 * @class Cit_Edit_post.php
 *
 * @path application\webservice\post\controllers\Cit_Edit_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 05.10.2020
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Edit_post extends Edit_post {
        public function __construct()
{
    parent::__construct();
}

public function displayPostTextEmoji($value='', $dataArr=array()) {
    if($dataArr['post_text_emoji'] == '') {
        $output=$dataArr['post_text'];
    } else {
        $output=$dataArr['post_text_emoji'];
    }
    return $output;
}
}
