<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Emailer Model
 *
 * @category models
 *
 * @package tools
 *
 * @module Emailer
 *
 * @class Emailer.php
 *
 * @path application\models\general\Emailer.php
 *
 * @version 4.0
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2016
 */
class Emailer extends CI_Model
{

    public $table_name;
    public $primary_key;

    /**
     * __construct method is used to set model preferences while model object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('listing');
        $this->table_name = "mod_system_email";
        $this->primary_key = "iEmailTemplateId";
    }

    /**
     * sendMail method is used to send e-mail to the users.
     * @param array $data data array of email information.
     * @param array $code code is email template code.
     * @return array $return returns success & message.
     */
    public function sendMail($data = array(), $code = "MEMBER_REGISTER")
    {
        $params = array();
        switch ($code) {
            case "USER_REGISTER":
            case "FORGOT_PASSWORD":
            case "FRONT_FORGOT_PASSWORD":
                $params['vName'] = $data['vName'];
                $params['vEmail'] = $data['vEmail'];
                $params['vUserName'] = $data['vUserName'];
                $params['vPassword'] = $data['vPassword'];
                break;
            default:
                $params = $data;
                break;
        }
        $success = $this->general->sendMail($params, $code);
        if (!$success) {
            $message = $this->general->getNotifyErrorOutput();
        }
        $return['success'] = $success;
        $return['message'] = $message;

        return $return;
    }
}
