<?php
defined('BASEPATH') || exit('No direct script access allowed');


class Get_users extends Cit_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model("user/users_model");
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function getUserDeviceToken()
    {
        $fiveHoursAgo = date('Y-m-d H:i:s', strtotime('-5 hours'));

        $this->db->select('iUsersId, vDeviceToken, vName, dLastLogin, eDeviceType');
        $this->db->from('users');
        $this->db->where('eDeviceType !=', 'Website');
        $this->db->where('eStatus', 'Active');
        $this->db->where('vDeviceToken IS NOT NULL', null, false);
        $this->db->where('vDeviceToken !=', '');
        $this->db->where("dLastLogin < '{$fiveHoursAgo}'", null, false);

        $users = $this->db->get()->result();

        $response = [
            'status' => $users ? 'success' : 'error',
            'message' => $users ? 'User data fetched successfully' : 'User data not found',
            'data' => $users ?: []
        ];

        echo json_encode($response);
        exit;
    }
}
