<?php

   
/**
 * Description of My Profile Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended My Profile
 *
 * @class Cit_My_profile.php
 *
 * @path application\webservice\user\controllers\Cit_My_profile.php
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
 
Class Cit_My_profile extends My_profile {
        public function __construct()
{
    parent::__construct();
}

public function checkUserFollowing($value='',$dataArr=array()){
	$ret_value = 'No';
	if(!empty($value) && $value != ''){
		if($value == 'Accepted'){
			$ret_value = 'Yes';
		}elseif($value == 'Pending'){
			$ret_value = 'Pending';
		}
	}
	return $ret_value;
}

public function getUserBlock(){
    $status = 0;
    $this->db->select('eStatus');
    $this->db->from("block_user_list");
    $this->db->where('iBlockByUserId',$_REQUEST['profile_user_id']);
    $this->db->where('iBlockUserId',$_REQUEST['user_id']);
    $query = $this->db->get();
    $getType = $query->row_array();
    if(!empty($getType) && $getType['eStatus']=='block'){
    $status = true;  
    }
    return $status;
}

public function getUserBlockMe(){
    $status = 0;
    $this->db->select('eStatus');
    $this->db->from("block_user_list");
    $this->db->where('iBlockByUserId',$_REQUEST['user_id']);
    $this->db->where('iBlockUserId',$_REQUEST['profile_user_id']);
    $query = $this->db->get();
    $getType = $query->row_array();
    if(!empty($getType) && $getType['eStatus']=='block'){
    $status = true;  
    }
    return $status;
}
function getHeightTo($value='',$dataArr=array()){
  if($dataArr['coverphoto_type_1'] == "Image") {
   list($width, $height, $type, $attr) = getimagesize($dataArr['u_cover_photo_1']);
  } else {
    $exec = 'ffmpeg -i ' . $dataArr['u_cover_photo_1'] . ' -vstats 2>&1';
    $output = $this->general->execShellCmd($exec);
    $regex_sizes = "/Video: ([^\r\n]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; 
    if (preg_match($regex_sizes, $output, $regs)) {
                $height = $regs [4] ? $regs [4] : null;
    }
  } 
  return $height;

}
function getWidthTo($value='',$dataArr=array()){
  if($dataArr['coverphoto_type_1'] == "Image") {
   list($width, $height, $type, $attr) = getimagesize($dataArr['u_cover_photo_1']);
  } else {
    $exec = 'ffmpeg -i ' . $dataArr['u_cover_photo_1'] . ' -vstats 2>&1';
    $output = $this->general->execShellCmd($exec);
    $regex_sizes = "/Video: ([^\r\n]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; 
    if (preg_match($regex_sizes, $output, $regs)) {
      $width = $regs [3] ? $regs [3] : null;
    }
  } 
  return $width;

}
function getHeight($value='',$dataArr=array()){
    
  if($dataArr['coverphoto_type'] == "Image") {
   list($width, $height, $type, $attr) = getimagesize($dataArr['u_cover_photo']);
  } else {
    $exec = 'ffmpeg -i ' . $dataArr['u_cover_photo'] . ' -vstats 2>&1';
    $output = $this->general->execShellCmd($exec);
    $regex_sizes = "/Video: ([^\r\n]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; 
    if (preg_match($regex_sizes, $output, $regs)) {
        $height = $regs [4] ? $regs [4] : null;
    }
  } 
  return $height;

}
function getWidth($value='',$dataArr=array()){
    
  if($dataArr['coverphoto_type'] == "Image") {
   list($width, $height, $type, $attr) = getimagesize($dataArr['u_cover_photo']);
  } else {
    $exec = 'ffmpeg -i ' . $dataArr['u_cover_photo'] . ' -vstats 2>&1';
    $output = $this->general->execShellCmd($exec);
    $regex_sizes = "/Video: ([^\r\n]*), ([^,]*), ([0-9]{1,4})x([0-9]{1,4})/"; 
    if (preg_match($regex_sizes, $output, $regs)) {
        $width = $regs [3] ? $regs [3] : null;
    }
  } 
  return $width;

}
}
