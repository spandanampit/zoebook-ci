<?php

   
/**
 * Description of logout Extended Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Extended logout
 *
 * @class Cit_Logout.php
 *
 * @path application\webservice\user\controllers\Cit_Logout.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 19.07.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Logout extends Logout {
        public function __construct()
{
    parent::__construct();
}
}
