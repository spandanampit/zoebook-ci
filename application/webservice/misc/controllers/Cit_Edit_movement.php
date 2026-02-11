<?php

   
/**
 * Description of Edit movement Extended Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Extended Edit movement
 *
 * @class Cit_Edit_movement.php
 *
 * @path application\webservice\misc\controllers\Cit_Edit_movement.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Edit_movement extends Edit_movement {
        public function __construct()
{
    parent::__construct();
}

public function delete_media_from_folder($input_params = array()){
	$this->load->library('listing');	
	$media_arr = $input_params['get_movement_image'];
    if(!empty($media_arr)){
        $config_arr = array(
			'file_server' => $this->config->item('FILE_UPLOAD_SERVER_LOCATION'),
			'file_folder' => 'movements_files',
			'file_keep' => TRUE,	
	   );
       foreach($media_arr as $media_key => $media_item){
    	$this->listing->deleteFiles($config_arr,$media_item['mi_upload_file'],$media_item['mi_movements_id']);
    	}   
    }
	 
	$return_arr = array();
	$return_arr['delete_success'] = 1;
	return $return_arr;
}
}
