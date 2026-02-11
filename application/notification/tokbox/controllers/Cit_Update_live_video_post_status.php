<?php

/**
 * Description of update_live_video_post_status Extended Controller
 * 
 * @module Extended update_live_video_post_status
 * 
 * @class Cit_Update_live_video_post_status.php
 * 
 * @path application
otification\tokbox\controllers\Cit_Update_live_video_post_status.php
 * 
 * @author CIT Dev Team
 * 
 * @date 02.11.2018
 */        

if (!defined('BASEPATH')) {
	exit('No direct script access allowed');
}

Class Cit_Update_live_video_post_status extends Update_live_video_post_status {
	public function __construct()
	{
		parent::__construct();
	}


	public function get_archive_status($input_params = array()){
		$this->load->library('tokbox');
		$timestamp = date('YmdHis');
		$response  = $this->tokbox->getArchive($input_params["ts_archive_id"]);

		$data = 'archive.mp4';
		$image_arr = array();
		$image_arr["image_name"] = $data;
		$image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
		$image_arr["pk"] = $input_params["ts_archive_id"];
		$image_arr["color"] = "FFFFFF";
		$image_arr["path"] = $this->config->item("TOKBOX_PROJECT_API_KEY");
		$archive_url = $this->general->get_image_aws($image_arr);

		$ret_arr[0]['final_archive_status'] = $response['status'];	
		$ret_arr[0]['archive_url'] = $archive_url;	

		if($response['status'] == 'uploaded'){
			$upload_path = $this->config->item('upload_path').'post_media'.'/'.$input_params['user_id'];

			$this->general->createFolder($upload_path);

			$image_name = 'live_video_thumb_'.$input_params['user_id'].'_'.$timestamp.'.jpg';  
			$image = $upload_path.'/'.$image_name;  
				// where ffmpeg is located  
			$ffmpeg = '/usr/bin/ffmpeg'; 
			$cmd = "$ffmpeg -i $archive_url -ss 00:00:00.500 -vframes 1 $image";
			exec($cmd);
			$ret_arr[0]['archive_file_name'] = $archive_url;
			$ret_arr[0]['archive_url'] = $archive_url;
			if($this->general->createPermission($image)){
				/*upload to aws*/
                $file_path = 'post_media'.'/'.$input_params['user_id'];
                $file_name = $image_name;
                $file_tmp_path = $this->config->item('upload_path').$file_path.'/'.$file_name;
            
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
            
                if($response){
                    $file_url =  $response['ObjectURL'];
                    unlink($file_tmp_path);
                    /*remove existing local files*/
                }
                /*AWS upload end*/
				$ret_arr[0]['live_video_thumb'] = 	$image_name;
			}
		}

		$ret_arr[0]['notify_text'] = 'Your Live Video is published on feed';	
		return $ret_arr;
	}

	public function send_post_notify_to_follower($input_params = array()){
		$this->load->model('cit_api_model'); 
		$api_params = array(
			"user_id" => $input_params['user_id'],
			"post_id" => $input_params['ts_post_id'],
			"tokbox_session_id" => $input_params['ts_tokbox_session_id'],
			"type" => 'Media'
			);
		$api_url = $this->config->item('front_ws_url').'send_post_notification?&'.http_build_query($api_params);

		$response = $this->general->getCurlResponse($api_url); 	

		$ret_arr = array();
		$ret_arr['notify_success'] = 1;
		return $ret_arr;
	}
}
