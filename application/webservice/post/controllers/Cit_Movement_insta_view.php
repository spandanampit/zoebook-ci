<?php

   
/**
 * Description of Movement insta view Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Movement insta view
 *
 * @class Cit_Movement_insta_view.php
 *
 * @path application\webservice\post\controllers\Cit_Movement_insta_view.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 09.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Movement_insta_view extends Movement_insta_view {
        public function __construct()
{
    parent::__construct();
}

//added custume where in condition,
public function finish_success(&$inputParams = array()){
  $result_data = parent::finish_success($inputParams);
  
  $get_obj_value=$result_data['data']; 
  foreach ($result_data['data'] as $key => $obj_value){
    $set_value['mi_movement_images_id']=$obj_value['mi_movement_images_id'];
    $set_value['mi_movements_id']=$obj_value['mi_movements_id'];
    $set_value['mi_media_type']=$obj_value['mi_media_type'];
    $set_value['mi_upload_file']=$obj_value['mi_upload_file'];
    $set_value['mi_mheight']=$obj_value['mi_mheight'];
    $set_value['mi_mwidth']=$obj_value['mi_mwidth'];
    $result_data['data'][$key]['get_movements_file'] = $set_value; 
  }
   
  /*$result = array();
  $result['settings'] = $result_data['settings'];
  $result['data'] = $result_data['data'];*/
  return $result_data;
  //get_insta_movements
  //pr($result_data);die();
}
}
