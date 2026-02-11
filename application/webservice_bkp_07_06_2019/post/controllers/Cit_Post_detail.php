<?php
            
/**
 * Description of Post Detail Extended Controller
 * 
 * @module Extended Post Detail
 * 
 * @class Cit_Post_detail.php
 * 
 * @path application\webservice\post\controllers\Cit_Post_detail.php
 * 
 * @author CIT Dev Team
 * 
 * @date 26.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Post_detail extends Post_detail {
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
