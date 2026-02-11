<?php

   
/**
 * Description of viral post notification Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended viral post notification
 *
 * @class Cit_Viral_post_notification.php
 *
 * @path application\webservice\user\controllers\Cit_Viral_post_notification.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 11.05.2021
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Viral_post_notification extends Viral_post_notification {
        public function __construct()
{
    parent::__construct();
}
}
