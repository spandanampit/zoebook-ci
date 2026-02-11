<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Content Controller
 *
 * @category front
 *
 * @package content
 *
 * @subpackage controllers
 *
 * @module Content
 *
 * @class Content.php
 *
 * @path application\front\content\controllers\Content.php
 *
 * @version 4.0
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2016
 */

class Content extends Cit_Controller
{

    private $firebase;
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('cit_api_model');
    }

    /**
     * index method is used to initialize index function.
     */
    public function index()
    {
        if($this->input->get('debug') == "yes"){
            error_reporting(1);
            ini_set("display_errors", 1);
            //echo phpinfo();
            $dateval = $this->general->getLocalDateTime("2020-07-06 15:18:25", "F j, Y- g:i A");
            echo "<br>Timezone : ".$dateval;
            pr($_SERVER,1);
        }
        if ($this->session->userdata('iUserId')) {
            redirect($this->url->make('home/home/viral_posts'));
        }


        $this->smarty->assign("islandinglcass","yes");

        // Load facebook oauth library
        $this->load->library('facebook');
        if($this->facebook->is_authenticated()){
        } else {
            $datafb['fbauthURL'] =  $this->facebook->login_url();
        }
        $this->smarty->assign($datafb);

        /* login with google */
         //load google login library
        $datagoogle = array();
        $this->load->library('googleplus');
        if(isset($_GET['code'])){
        } else {
            $datagoogle['googleloginURL'] = $this->googleplus->loginURL();
        }
        $this->smarty->assign($datagoogle);
    }


    public function contactus()
    {

        $postArr  = $this->input->get_post();
        if($postArr) {
            try {
                $params = array();
                $params['name'] = $postArr['vContactName'];
                $params['email'] = $postArr['vContactEmail'];
                $params['message_text'] = $postArr['vContactMessage'];
                $api_resp = $this->cit_api_model->callAPI("contact_us_submit", $params);

                if ($api_resp['settings']['success'] == '1') {
                    $this->session->set_flashdata('success',$api_resp['settings']['message']);
                } else {
                    throw new Exception($api_resp['settings']['message']);
                }

                $redirect_url = $this->config->item('site_url')."contactus.html";
                redirect($redirect_url);
            } catch (Exception $e) {
                $var_msg = $e->getMessage();
                $this->session->set_flashdata('failure', $var_msg);
                redirect($this->config->item("site_url")."contactus.html");
            }

        }

    }


    /**
     * staticpage method is used to display static pages.
     */
    public function staticpage($page_code = '', $arg_lang = '')
    {
        $params['page_code'] = $page_code;

        $api_resp = $this->cit_api_model->callAPI('static_pages', $params);

        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $page_details = $api_resp['data'];

         $render_arr = array(
            "display_lang" => $lang,
            "page_code" => $page_code,
            "page_title" => $page_details[0]["page_title"],
            "page_content" => $page_details[0]["page_content"],
            "meta_info" => array(
                "title" => $page_details[0]["page_meta_title"],
                "description" => $page_details[0]["page_meta_desc"],
                "keywords" => $page_details[0]["page_meta_keyword"]
            )
        );
        $this->smarty->assign($render_arr);

        if ($this->config->item('static_page_template') != '') {
            $this->set_template($this->config->item('static_page_template'));
        }
        if ($this->config->item('static_page_view') != '') {
            $this->loadView($this->config->item('static_page_view'));
        }

        /*$this->load->model('tools/staticpages');
        $fields = array("vPageTitle", "vPageCode", "vContent", "tMetaTitle", "tMetaKeyword", "tMetaDesc");
        $render_arr = array();
        $req_lang = $this->input->get('lang', TRUE);

        if (!is_null($req_lang) && !empty($req_lang)) {
            $lang = strtolower($req_lang);
        } elseif (!is_null($arg_lang) && !empty($arg_lang)) {
            $lang = strtolower($arg_lang);
        } else {
            $lang = "en";
            if ($this->config->item('MULTI_LINGUAL_PROJECT') == "Yes") {
                $sess_lang = $this->session->userdata('sess_lang_id');
                if (!is_null($sess_lang) && !empty($sess_lang)) {
                    $lang = strtolower($sess_lang);
                }
            }
        }
        if ($lang == "en") {
            $page_details = $this->staticpages->getStaticPageData($page_code, $fields);
        } else {
            $lang_fields = $this->staticpages->getLangTableFields();
            if (is_array($lang_fields) && count($lang_fields) > 0) {
                $lang_arr = array();
                foreach ($fields as $key => $val) {
                    if (in_array($val, $lang_fields)) {
                        $lang_arr[] = "mps_lang." . $val;
                    } else {
                        $lang_arr[] = "mps." . $val;
                    }
                }
                $page_details = $this->staticpages->getStaticPageLangData($lang, $page_code, $lang_arr);
            }
            if (!is_array($page_details) || count($page_details) == 0) {
                $page_details = $this->staticpages->getStaticPageData($page_code, $fields);
            }
        }
        $render_arr = array(
            "display_lang" => $lang,
            "page_code" => $page_code,
            "page_title" => $page_details[0]["vPageTitle"],
            "page_content" => $page_details[0]["vContent"],
            "meta_info" => array(
                "title" => $page_details[0]["tMetaTitle"],
                "description" => $page_details[0]["tMetaDesc"],
                "keywords" => $page_details[0]["tMetaKeyword"]
            )
        );
        $this->smarty->assign($render_arr);
        if ($this->config->item('static_page_template') != '') {
            $this->set_template($this->config->item('static_page_template'));
        }
        if ($this->config->item('static_page_view') != '') {
            $this->loadView($this->config->item('static_page_view'));
        }*/
    }

    /**
     * error method is used to display database connection errors.
     */
    public function error()
    {
        $file_name = "error_template";
        $this->set_template($file_name);
    }

    /**
     * captcha method is used to refresh captcha code.
     */
    public function captcha()
    {
        $this->load->library('captcha');
        $this->captcha->show('session', TRUE);
        $this->skip_template_view();
    }

    public function chat() {
        $render_arr = array();
        $render_arr['token'] = $this->session->userdata('firebase_token');
        $render_arr['username'] = $this->session->userdata('vName');
        $render_arr['email'] = $this->session->userdata('vEmail');
        $render_arr['profile_image'] = $this->session->userdata('vProfileImage');
        $render_arr['user_id'] = $this->session->userdata('iUserId');
        $this->smarty->assign($render_arr);
    }

    public function get_users(){
        $term = $this->input->post('term');
        $exclude_arr = $this->input->post('exclude');
        $params = array(
            'keyword' => $term,
            'user_id' => $this->session->userdata('iUserId'),
        );
        if(count($exclude_arr) > 0){
            $params['exclude'] = implode(",",  $exclude_arr);
        }
        $api_resp = $this->cit_api_model->callAPI("search_friends", $params);
        $final_arr = array();
        if ($api_resp['settings']['success'] == '1') {
            foreach ($api_resp['data'] as $key => $value) {
               $final_arr[$key]['id'] = $value['u_users_id'];
               $final_arr[$key]['value'] = $value['u_name'];
               $final_arr[$key]['label'] = $value['u_name'];
               $final_arr[$key]['email'] = $value['u_email'];
               $final_arr[$key]['image'] = $value['u_profile_image'];
            }
        }
        echo json_encode($final_arr);exit;
    }

    public function get_user_profile(){
        $params = array(
            'user_id' => $this->input->post('user_id'),
            'profile_user_id' => $this->input->post('profile_user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("my_profile", $params);
        $final_arr = array();
        if ($api_resp['settings']['success'] == '1') {
            $final_arr = $api_resp['data'];
        }
        echo json_encode($final_arr);exit;
    }

    public function set_follow_accept_reject_cancel(){
        $params = array(
            'user_follow_request_id' => $this->input->post('user_follow_request_id'),
            'status' => 'Deleted',
            'user_id' => $this->input->post('user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("follow_accept_reject_cancel", $params);
        echo json_encode($api_resp);exit;
    }

    public function follow_user(){
        $params = array(
            'following_user_id' => $this->input->post('following_user_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("follow_request", $params);
        echo json_encode($api_resp);exit;
    }

    public function unfollow_user(){
        $params = array(
            'following_user_id' => $this->input->post('following_user_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("unfollow_user", $params);
        echo json_encode($api_resp);exit;
    }

    public function setUserTimezone() {
        $user_timezone = $this->input->post('timezoneval');
        $this->session->set_userdata('user_timezone', $user_timezone);
        echo 'success';
        exit;
    }

}
