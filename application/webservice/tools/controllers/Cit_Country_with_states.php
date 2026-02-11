<?php

   
/**
 * Description of Country With States Extended Controller
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage controllers
 *
 * @module Extended Country With States
 *
 * @class Cit_Country_with_states.php
 *
 * @path application\webservice\tools\controllers\Cit_Country_with_states.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 20.07.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Country_with_states extends Country_with_states {
        public function __construct()
{
    parent::__construct();
}
}
