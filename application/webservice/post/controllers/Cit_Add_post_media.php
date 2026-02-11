<?php

   
/**
 * Description of Add Post Media Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Add Post Media
 *
 * @class Cit_Add_post_media.php
 *
 * @path application\webservice\post\controllers\Cit_Add_post_media.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 21.12.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Add_post_media extends Add_post_media {
        public function __construct()
{
    parent::__construct();
}

    public function getFileHieght(){
        $return_data = array();
        $return_data['width'] = null;
        $return_data['height'] = null;
        
        if(strtolower($_REQUEST['file_type']) == 'image'){
            $fileinfo = @getimagesize($_FILES["upload_file"]["tmp_name"]);
            $return_data['width'] = $fileinfo[0];
            $return_data['height'] = $fileinfo[1];
        }
        
        return $return_data;
    }
    
    public function getFileWidth(){
        $width = null;
        if(isset($_FILES['upload_file']) && $_REQUEST['file_type'] == 'Image'){
        $fileinfo = @getimagesize($_FILES["upload_file"]["tmp_name"]);
        $width = $fileinfo[0];
        }
        return $width ;
    }
    
    public function UnlinkFile($input_array=array()){
       
        if(!empty(trim($input_array['compress_function']['compress_video_path']))){
            unlink($input_array['compress_function']['compress_video_path']);
        }
        
        if(!empty(trim($input_array['compress_function']['image_path']))){
            unlink($input_array['compress_function']['image_path']);
        }
         
    }
    public function test_path_data($input_array=array()) {
      $file_type = $input_array['file_type'];
      $test_path =(strtolower($file_type)=="image")?"post_media":"compress_post_video";
      $return_data['test_path'] = $test_path;
      $ary = explode(".",$input_array['upload_file']);
      $new_name = $ary[0].".jpeg";
      $return_data['video_path']=$new_name;
    
      return $return_data;
      
    }
}
