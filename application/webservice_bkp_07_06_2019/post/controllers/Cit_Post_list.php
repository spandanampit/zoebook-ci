<?php
            
/**
 * Description of Post List Extended Controller
 * 
 * @module Extended Post List
 * 
 * @class Cit_Post_list.php
 * 
 * @path application\webservice\post\controllers\Cit_Post_list.php
 * 
 * @author CIT Dev Team
 * 
 * @date 26.10.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Post_list extends Post_list {
        public function __construct()
{
    parent::__construct();
}


public function get_display_image($value ='', $data_arr = array()){
	if (array_key_exists('pm_media_type_3', $data_arr)) {
		$value = $data_arr['pm_upload_file_3'];
		if($data_arr['pm_media_type_3'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail_3'];
		}
	} else if (array_key_exists('pm_media_type_2', $data_arr)) {
		$value = $data_arr['pm_upload_file_2'];
		if($data_arr['pm_media_type_2'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail_2'];
		}
	} else if (array_key_exists('pm_media_type_1', $data_arr)) {
		$value = $data_arr['pm_upload_file_1'];
		if($data_arr['pm_media_type_1'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail_1'];
		}
	} else {
		$value = $data_arr['pm_upload_file'];
		if($data_arr['pm_media_type'] == 'Video'){
			$value = $data_arr['pm_video_thumbnail'];
		}
	}
	return $value;
}

public function get_display_image_others($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file_1'];
	if($data_arr['pm_media_type_1'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail_1'];
	}
	return $value;
}
}
