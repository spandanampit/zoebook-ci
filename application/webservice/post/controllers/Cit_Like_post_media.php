<?php
            
/**
 * Description of Like Post Media Extended Controller
 * 
 * @module Extended Like Post Media
 * 
 * @class Cit_Like_post_media.php
 * 
 * @path application\webservice\post\controllers\Cit_Like_post_media.php
 * 
 * @author CIT Dev Team
 * 
 * @date 29.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Like_post_media extends Like_post_media {
        public function __construct()
{
    parent::__construct();
}
public function get_post_media_likes($inputprames = array()){
	pr($inputprames);
	exit;
}
}
