<?php

   
/**
 * Description of Update media post height width Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Update media post height width
 *
 * @class Cit_Update_media_post_height_width.php
 *
 * @path application\webservice\post\controllers\Cit_Update_media_post_height_width.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 11.06.2021
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Update_media_post_height_width extends Update_media_post_height_width {
        public function __construct()
{
    parent::__construct();
}

public function testDemo(){
   $var=array('1','2');
   pr($var);die();
}
}
