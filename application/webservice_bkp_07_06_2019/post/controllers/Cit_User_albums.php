<?php
            
/**
 * Description of User Albums Extended Controller
 * 
 * @module Extended User Albums
 * 
 * @class Cit_User_albums.php
 * 
 * @path application\webservice\post\controllers\Cit_User_albums.php
 * 
 * @author CIT Dev Team
 * 
 * @date 26.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_User_albums extends User_albums {
        public function __construct()
{
    parent::__construct();
}

public function get_display_image($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file'];
	if($data_arr['pm_media_type'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail'];
	}
	return $value;
}
}
