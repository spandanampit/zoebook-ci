<?php

   
/**
 * Description of Edit Profile Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended Edit Profile
 *
 * @class Cit_Edit_profile.php
 *
 * @path application\webservice\user\controllers\Cit_Edit_profile.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.11.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Edit_profile extends Edit_profile {
        public function __construct()
{
    parent::__construct();
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
}

public function extractImagefromVideo($value='',&$input_params=array()) {
    $ret_val = '';
    if($_FILES['cover_photo']) {
    if(end(explode(".",$_FILES["cover_photo"]["name"])) =="mp4" || strtolower($_REQUEST['file_type'])=='video') {
        $source = $_FILES["cover_photo"]["tmp_name"];
        
        $thumbnail_path = $this->config->item('upload_path') . 'covervideo_thumbnail/';
        $this->general->createUploadFolderIfNotExists('covervideo_thumbnail');
        $thumbname = uniqid().time().'.jpg';
        $thumbvideo = time().'.mp4';
        $video = $thumbnail_path.$thumbvideo;
        copy($source, $video);
        
        $second = 1;
        $image  = $thumbnail_path . $thumbname;
        
        $cmd = "/usr/bin/ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";    
        
        exec($cmd, $output, $retval);
        
        $thumb_file_path = $image;
        $info = @getimagesize($thumb_file_path);
        if($info){
            $input_params['width'] = $info[0];
            $input_params['height'] = $info[1];
        }
        if(file_exists($thumb_file_path)){
            $file_path = "covervideo_thumbnail";
            $file_name = $thumbname;
            $file_tmp_path = $thumb_file_path;
            $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
            $video_thumbnail = $thumbname;
            unlink($thumbnail_path . $thumbname);
        }
        $ret_val = $thumbname;
    }
   #pr( $ret_val,1);
    return $ret_val;
    } else {
      $this->db->select('vCoverVideo');
      $this->db->from('users');
      $this->db->where('iUsersId',$input_params['user_id']);
      $query=$this->db->get();
      $result=is_object($query)?$query->row_array():array();
      $ret_val =$result['vCoverVideo'];
      return $ret_val;
    }
}
}
