<?php

   
/**
 * Description of private movements access reject Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended private movements access reject
 *
 * @class Cit_Private_movements_access_reject.php
 *
 * @path application\webservice\post\controllers\Cit_Private_movements_access_reject.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 22.09.2021
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Private_movements_access_reject extends Private_movements_access_reject {
        public function __construct()
{
    parent::__construct();
}

public function getNotificationText($value,$input_array=array()){
    //pr($input_array['get_movements_user'][0]['m_movement_name']); die();
// 	return "'".$value." has accepted your .$input_array['get_movements_user'][0]['m_movement_name']." movements request";
    return $value. ' has accepted your "'.$input_array['get_movements_user'][0]['m_movement_name'].'" movement request';
}
}
