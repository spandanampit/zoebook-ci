<?php
            
/**
 * Description of Delete Media Extended Controller
 * 
 * @module Extended Delete Media
 * 
 * @class Cit_Delete_media.php
 * 
 * @path application\webservice\post\controllers\Cit_Delete_media.php
 * 
 * @author CIT Dev Team
 * 
 * @date 27.09.2018
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Delete_media extends Delete_media {
        public function __construct()
{
    parent::__construct();
}


public function delete_media_from_folder($input_params = array()){
	$this->load->library('listing');	
	$media_arr = $input_params['get_media'];
	$config_arr = array(
			'file_server' => $this->config->item('FILE_UPLOAD_SERVER_LOCATION'),
			'file_folder' => 'post_media',
			'file_keep' => TRUE,	
	);

	foreach($media_arr as $media_key => $media_item){
		$this->listing->deleteFiles($config_arr,$media_item['pm_upload_file'],$media_item['pm_user_id']);
		if($media_item['pm_media_type'] == 'Video'){
			$this->listing->deleteFiles($config_arr,$media_item['pm_video_thumbnail'],$media_item['pm_user_id']);
		}
	}
	$return_arr = array();
	$return_arr['delete_success'] = 1;
	return $return_arr;
}
}
