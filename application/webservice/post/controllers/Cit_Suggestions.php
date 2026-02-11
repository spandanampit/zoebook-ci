<?php

   
/**
 * Description of Suggestions Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Suggestions
 *
 * @class Cit_Suggestions.php
 *
 * @path application\webservice\post\controllers\Cit_Suggestions.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 09.11.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Suggestions extends Suggestions {
        public function __construct()
{
    parent::__construct();
}

public function get_display_image_others($value ='', $data_arr = array()){
	$value = $data_arr['pm_upload_file'];
	if($data_arr['pm_media_type_1'] == 'Video'){
		$value = $data_arr['pm_video_thumbnail'];
	}
	return $value;
}

public function merge_arr(&$input_params=array()){
    $input_params['final_display_image'] = $input_params['get_suggestions_media'][0]['display_image'];
    $input_params['final_video_image'] = $input_params['get_suggestions_media'][0]['pm_video_thumbnail'];
    $input_params['final_upload_file'] = $input_params['get_suggestions_media'][0]['pm_upload_file'];
    $input_params['final_media_type'] = $input_params['get_suggestions_media'][0]['pm_media_type'];
    $input_params['final_views_count'] = $input_params['get_suggestions_media'][0]['pm_views_count'];
    return true;
}
}
