<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Mailer Log History Model
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage models
 *
 * @module Mailer Log History
 *
 * @class Mailer_log_history_model.php
 *
 * @path application\webservice\user\models\Mailer_log_history_model.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Mailer_log_history_model extends CI_Model
{
    public $default_lang = 'EN';

    /**
     * __construct method is used to set model preferences while model object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('listing');
        $this->default_lang = $this->general->getLangRequestValue();
    }

    /**
     * get_bulk_mail method is used to execute database queries for send_bulk_mail API.
     * @created Rohit Patidar | 24.06.2021
     * @modified Rohit Patidar | 24.06.2021
     * @return array $return_arr returns response of query block.
     */
    public function get_bulk_mail()
    {
        try
        {
            $result_arr = array();

            $this->db->from("mailer_log_history AS mlh");

            $this->db->select("mlh.vFromeName AS mlh_frome_name");
            $this->db->select("mlh.vFromEmail AS mlh_from_email");
            $this->db->select("mlh.vCcEmail AS mlh_cc_email");
            $this->db->select("mlh.eEmailFormate AS mlh_email_formate");
            $this->db->select("mlh.vEmailSubject AS mlh_email_subject");
            $this->db->select("mlh.vToEmail AS mlh_to_email");
            $this->db->select("mlh.vUserName AS mlh_user_name");
            $this->db->select("mlh.vEmailCode AS mlh_email_code");
            $this->db->select("mlh.dMailSentDate AS mlh_mail_sent_date");
            $this->db->select("mlh.dAddedDate AS mlh_added_date");
            $this->db->select("mlh.iMailSendStatus AS mlh_mail_send_status");
            $this->db->select("mlh.tMassageBody AS mlh_massage_body");
            $this->db->select("mlh.iEmailTemplateId AS mlh_email_template_id");
            $this->db->select("mlh.iUserid AS mlh_userid");
            $this->db->select("mlh.iMailerLogHistoryId AS mlh_mailer_log_history_id");
            $this->db->where("mlh.iMailSendStatus =", "0");

            $this->db->limit(300);

            $result_obj = $this->db->get();
            $result_arr = is_object($result_obj) ? $result_obj->result_array() : array();
            if (!is_array($result_arr) || count($result_arr) == 0)
            {
                throw new Exception('No records found.');
            }
            $success = 1;
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }

        $this->db->_reset_all();
        //echo $this->db->last_query();
        $return_arr["success"] = $success;
        $return_arr["message"] = $message;
        $return_arr["data"] = $result_arr;
        return $return_arr;
    }
}
