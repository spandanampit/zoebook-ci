<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Controller
 *
 * @category front
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module User
 *
 * @class User.php
 *
 * @path application\front\user\controllers\User.php
 *
 * @version 4.0
 *
 * @author CIT Dev Team
 *
 * @since 01.08.2016
 */

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class User extends Cit_Controller
{

    private $firebase;
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->model('user_model');
        $this->load->model('cit_api_model');
    }

    /**
     * index method is used to define home page content.
     */
    public function index()
    {
        $view_file = "welcome_message";
        $this->loadView($view_file);
    }

    public function assign_language()
    {
        $language = $this->session->userdata('language');
        if (!$language) {
            $language = 'english';
        }
        $this->lang->load('site', $language);


        $langKeys = [
            'welcome_message',
            'home',
            'contact_us',
            'profile',
            'viral_post',
            'login',
            'register',
            'logout',
            'search',
            'my_playlist',
            'search_results',
            'search_results_for',
            'viral_post_plus',
            'hidden_post',
            'hidden_post_plus',
            'chat',
            'notification',
            'setting',
            'blocked_users',
            'movement',
            'mode',
            'no_post_available',
            'create_post',
            'what_is_on_your_mind',
            'photo',
            'video',
            'visiblity',
            'published',
            'create',
            'cancel',
            'top_play_list',
            'close',
            'post',
            'public',
            'private',
            'viral',
            'add_custom_thumbnail',
            'add_a_custom_thumbnail_to_give_your_videos_a_unique_and_personalized_touch',
            'let_your_creativity_shine',
            'go',
            'uploading',
            'see_more_in_video',
            'whats_on_your_mind',
            'replay',
            'add_to_playlist',
            'edit',
            'delete',
            'inappropriate',
            'hide_post',
            'spam',
            'block',
            'report_post',
            'in_appropriate',
            'report',
            'share_this_post',
            'share_on_my_timeline',
            'add_to_playlist',
            'message',
            'watchnow',
            'language',
            'go_live',
            'loadCover',
            'dragDesc',
            'accept',
            'reject',
            'edit_profile',
            'change_password',
            'save',
            'following',
            'follower',
            'suggestionNotFound',
            'suggested',
            'share_playlist',
            'followers',
            'suggested',
            'followers_lang',
            'welcome',
            'distraction_fact',
            'sign_up',
            'sign_in',
            'email',
            'password',
            'forgot_password',
            'dont_have_an_account',
            'already_have_an_account',
            'sign_in',
            'submit',
            'reset_password',
            'all_rights_reserved',
            'terms_conditions',
            'its_quick_and_easy',
            'name',
            'confirm_password',
            'mobile_number',
            'birthday',
            'gender',
            'male',
            'female',
            'others',
            'movement_feature',
            'movement_description',
            'terms_and_conditions',
            'about_us',
            'privacy_policy',
            'views',
            'watch',
            'most_viewd_videos',
            'newest_video',
            'view_more',
            'movement_name_menu'

        ];

        $lang = [];
        foreach ($langKeys as $key) {
            $lang[$key] = $this->lang->line($key);
        }

        $this->smarty->assign($lang);
    }

    /**
     * dashboard method is used to define dashboard data after user logged in.
     */
    public function dashboard()
    {
        // content coming here
        $view_file = "dashboard";
        $this->loadView($view_file);
    }

    /**
     * login method is used to display login page.
     */
    public function login()
    {
        if ($this->session->userdata('iUserId')) {
            redirect($this->config->item("site_url") . 'viral-posts.html');
        }
        $view_file = "login";
        $this->loadView($view_file);
    }

    /**
     * login_action method is used to process login page for authentification.
     */
    public function login_action()
    {
        try {
            $user = $this->input->get_post('User');

            $email = $user['vLoginEmail'];
            $password = $user['vLoginPassword'];

            $params['user_email'] = $email;
            $params['password'] = $password;
            $api_resp = $this->cit_api_model->callAPI('login', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($api_resp['settings']['message']);
            }

            $record = $api_resp['data'][0];

            /* added to keep user signin */
            $cookie_prefix = $this->config->item("sess_cookie_name");
            $stay_signed = 'yes';
            if (strtolower($stay_signed) == 'yes') {
                $cookie_data = array(
                    $cookie_prefix . '_username' => $email,
                    $cookie_prefix . '_password' => base64_encode($password)
                );
                $this->cookie->write('remember_me', $cookie_data);
            } else {
                $this->cookie->delete('remember_me');
            }
            /* end code */

            $this->session->set_userdata("iUserId", $record["u_user_id"]);
            $this->session->set_userdata("vName", $record["u_name"]);
            $this->session->set_userdata("vProfileImage", str_replace("&height=500&width=500", "&height=100&width=100", $record["u_profile_image"]));
            $this->session->set_userdata("vEmail", $record["u_email"]);
            $this->session->set_userdata("eStatus", $record["u_status"]);

            // This assumes that you have placed the Firebase credentials in the same directory
            require_once($this->config->item('third_party') . "firebase/vendor/autoload.php");
            $serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-c4e95-firebase-adminsdk-8bf7i-647da9b09e.json');
            //$serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-pp-firebase-adminsdk-li2bz-be8e7e89a6.json');

            $this->firebase = (new Factory)
                ->withServiceAccount($serviceAccount)
                ->create();
            $arr['user_id'] = $record["u_user_id"];
            $additionalClaims = ['username' => $record["u_name"], 'email' => $record["u_email"], 'user_id' => $arr['user_id']];
            $customToken = $this->firebase->getAuth()->createCustomToken($arr['user_id'], $additionalClaims);

            $this->session->set_userdata("firebase_token", (string)$customToken);
            $var_msg = "Welcome " . $this->session->userdata("vName") . ", you have successfully logged in.";
            $this->session->set_flashdata('success', $var_msg);
            $this->smarty->assign('alldata', $this->session->all_userdata());

            $redirecturl = $this->config->item("site_url") . "viral-posts.html";
            redirect($redirecturl);
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);

            redirect($this->config->item("site_url"));
        }
    }


    /**
     * logout method is used to log out the current login user.
     */
    public function logout()
    {
        /*$this->load->model('tools/loghistory');
        $log_id = $this->session->userdata('iLogId');
        $this->loghistory->updateLogoutUser($log_id);*/

        if ($_REQUEST['tokenexpire'] == 'yes') {
            //pr($_REQUEST);exit;
            // session token need to add here
            $this->session->sess_destroy();
            redirect($this->config->item("site_url"));
        } else {
            $sess_cookie_name = $this->config->item("sess_cookie_name");
            $cookiedata = array(
                $sess_cookie_name . '_username' => '',
                $sess_cookie_name . '_password' => ''
            );
            $this->cookie->write('remember_me', $cookiedata);

            try {
                $params['user_id'] = $this->session->userdata('iUserId');
                $api_resp = $this->cit_api_model->callAPI('logout', $params);

                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception($api_resp['settings']['message']);
                }
                $this->session->sess_destroy();
                $this->session->set_flashdata('success', "You have successfully logged out");
                redirect($this->config->item("site_url"));
            } catch (Exception $e) {
                $var_msg = $e->getMessage();
                $this->session->set_flashdata('failure', $var_msg);
                redirect($this->config->item("site_url"));
            }
        }
    }

    /**
     * register method is used to display register page.
     */
    /*public function register()
    {
        if ($this->session->userdata('iUserId')) {
            redirect($this->config->item("site_url") . 'dashboard.html');
        }
        $data['heading'] = "Register";
        $data['type'] = "register";
        $data['user'] = array('firstname' => '', 'lastname' => '', 'email' => '');
        $this->loadView('register', $data);
    }*/

    /**
     * register_action method is used to process register page for adding customer record.
     */
    /*public function register_action()
    {
        $post_arr = $this->input->get_post('User');
        pr($_FILES);exit;
        $user_arr = array();
        $user_arr['vName'] = $post_arr['vName'];
        $user_arr['dDOB'] = $post_arr['dDOB'];
        $user_arr['vEmail'] = $post_arr['vEmail'];
        $user_arr['eGender'] = $post_arr['eGender'];
        $user_arr['vPassword'] = $post_arr['vPassword'];
        $user_arr['dAddedDate'] = date('Y-m-d H:i:s', now());

        $user_id = $this->user_model->insert($user_arr);

        if (!$user_id) {
            $this->session->set_flashdata('failure', "Error occured during registering your profile.");
        } else {
            $this->session->set_flashdata('success', "You have successfully registered.");
        }

        redirect($this->config->item("site_url")."dashboard.html");
    }*/

    public function signup()
    {
        // New Signup Page
        // Load facebook oauth library
        $this->assign_language();

        $this->load->library('facebook');
        if ($this->facebook->is_authenticated()) {
        } else {
            $datafb['fbauthURL'] =  $this->facebook->login_url();
        }
        $this->smarty->assign($datafb);

        /* login with google */
        //load google login library
        $datagoogle = array();
        $this->load->library('googleplus');
        if (isset($_GET['code'])) {
        } else {
            $datagoogle['googleloginURL'] = $this->googleplus->loginURL();
        }
        $this->smarty->assign($datagoogle);
    }
    public function register_action()
    {
        try {
            $this->assign_language();
            $recaptchaSecretKey = '6LdOHLcpAAAAAKt-i0hMX8a4x_SRS8hjqJty3bsN';
            $recaptchaResponse = $this->input->get_post('g-recaptcha-response');

            $verificationUrl = 'https://www.google.com/recaptcha/api/siteverify';

            $postData = http_build_query([
                'secret' => $recaptchaSecretKey,
                'response' => $recaptchaResponse
            ]);
            $options = [
                'http' => [
                    'method' => 'POST',
                    'header' => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postData
                ]
            ];

            $context = stream_context_create($options);
            $response = file_get_contents($verificationUrl, false, $context);

            $responseData = json_decode($response);
            if (!$responseData->success) {
                $this->session->set_flashdata('error', 'Failed to verify reCAPTCHA. Please try again later.');
                redirect($this->agent->referrer());
                return;
                // throw new Exception("Failed to verify reCAPTCHA. Please try again later.");

            }

            $this->load->library('form_validation');

            $name_msg = array(
                'required' => 'Please enter %s.'
            );
            $email_message = array(
                'required' => 'Please enter %s.',
                'valid_email' => 'Please enter valid %s.'
            );
            $password_message = array(
                'required' => 'Please enter %s.',
                'min_length' => 'Password should contain minimum of 6 characters',
            );
            $confirm_password = array(
                'required' => 'Please enter %s.',
                'matches'  => "Confirm password doesn't match with password",
            );
            $this->form_validation->set_rules('User[vName]', 'name', 'required', $name_msg);
            $this->form_validation->set_rules('User[vEmail]', 'email', 'required|valid_email', $email_message);
            $this->form_validation->set_rules('User[vPassword]', 'password', 'required|min_length[6]', $password_message);
            $this->form_validation->set_rules('User[vConfirmPassword]', 'confirm password', 'required|matches[User[vPassword]]', $confirm_password);

            if ($this->form_validation->run() == FALSE) {
                throw new Exception(validation_errors());
            }

            if (empty($post_arr)) {
                throw new Exception("Customer data not found");
            }
            if ($post_arr['vPassword'] != $post_arr['vConfirmPassword']) {
                throw new Exception("Password does not match");
            }

            if (!empty($_POST['websiteUrl'])) {
                throw new Exception('Spam detected.');
            }

            $params['user_name'] = $post_arr['vName'];
            $params['user_email'] = $post_arr['vEmail'];
            $params['password'] = $post_arr['vPassword'];
            $params['ddob'] = $post_arr['dDOB'];
            //$params['profile_image'] = $_FILES;
            $params['gender'] = $post_arr['eGender'];
            $params['mobile_num'] = $post_arr['vPhone'];
            $params['device_token'] = 1;  // temp need to remove once confirm
            $params['device_type'] = 'Website';
            $api_resp = $this->cit_api_model->callAPI('signup', $params);


            if (empty($api_resp['data'])) {
                throw new Exception($api_resp['settings']['message']);
            }

            /* Logged In customer automatically after registration */
            $this->session->set_flashdata('success', "Activation email has been sent to your email address");
            redirect($this->config->item("site_url")); // redirect to homepage

        } catch (Exception $e) {
            echo "catch";
            die;
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->config->item("site_url"));
        }
    }


    /**
     * check_user_email method is used to check wether username or email already exist in data base.
     */
    public function check_user_email()
    {
        $user_arr = $this->input->get_post('User');

        if (isset($user_arr["vEmail"])) {
            $status = $this->user_model->checkUserExists('vEmail', $user_arr);
        }
        /*if (isset($user_arr["vUserName"])) {
            $status = $this->user_model->checkUserExists('vUserName', $user_arr);
        }*/

        if (!$status) {
            echo "false";
        } else {
            echo "true";
        }
        $this->skip_template_view();
    }

    /**
     * forgotpassword method is used to display forgot password page.
     */
    public function forgotpassword()
    {
        $view_file = "forgotpassword";
        $this->loadView($view_file);
    }

    /**
     * forgotpassword_action method is used to send forgot password action.
     */
    public function forgotpassword_action()
    {
        try {
            $user_arr = $this->input->get_post('User');
            $email = $user_arr['vForgotEmail'];

            $params['user_email'] = $email;
            print_r($params['user_email']);

            $api_resp = $this->cit_api_model->callAPI('forgot_password', $params);
            // echo $api_resp;
            // die;
            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($api_resp['settings']['message']);
            }

            $this->session->set_flashdata('success', "Forgot password email sent sucessfully. Please check your email.");
            redirect($this->config->item("site_url"));
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->config->item("site_url"));
        }
    }

    /**
     * profile method is used to display and  update customer page.
     */
    public function profile()
    {
        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in first to update profile.");
            redirect($this->config->item("site_url") . 'login.html');
        } else {
            if ($this->input->post()) {
                $post_arr = $this->input->get_post('User');

                $user_arr = array();
                $user_arr['vFirstName'] = $post_arr['vFirstName'];
                $user_arr['vLastName'] = $post_arr['vLastName'];
                $user_arr['vPassword'] = $post_arr['vPassword'];
                $res = $this->user_model->update($user_arr, $this->input->post('userId'));

                if (!$res) {
                    $this->session->set_flashdata('failure', "Error occured during updating user profile.");
                } else {
                    $this->session->set_flashdata('success', "User profile updated successfully.");
                }
                redirect($this->config->item("site_url") . 'profile.html');
            }

            $where = $this->db->protect("iUsersId") . " = " . $this->db->escape($user_id);
            $user = $this->user_model->getData($where);
            echo $this->db->last_query();
            exit;
            if (!is_array($user) || count($user) == 0) {
                $this->session->set_flashdata('failure', "User profile not found.");
                redirect($this->config->item("site_url") . 'logout.html');
            }
            $data['user'] = array(
                'id' => $user_id,
                'firstname' => $user[0]['vFirstName'],
                'lastname' => $user[0]['vLastName'],
                'email' => $user[0]['vEmail'],
                'username' => $user[0]['vUserName'],
                'password' => $user[0]['vPassword']
            );
            $data['heading'] = "User Profile";
            $data['type'] = "profile";
        }
        $this->loadView("register", $data);
    }

    /* used for facebook login / register */
    public function fb_signup_authentication()
    {

        // Load facebook oauth library
        $this->load->library('facebook');

        $userData = array();

        try {
            // Authenticate user with facebook
            if ($this->facebook->is_authenticated()) {
                // Get user info from facebook
                $fbUser = $this->facebook->request('get', '/me?fields=id,first_name,last_name,email,link,gender,picture');

                $params['user_name'] = $fbUser['first_name'] . ' ' . $fbUser['last_name'];
                $params['user_email'] = $fbUser['email'];
                $params['password'] = $this->general->getRandomNumber(6);  // randomly generated password
                $params['profile_image'] = $fbUser['picture']['data']['url'];
                $params['profile_image_social'] = $fbUser['picture']['data']['url'];
                $params['gender'] = $fbUser['gender'];
                $params['facebook_id'] = $fbUser['id'];
                $params['device_token'] = 1;  // temp need to remove once confirm
                $params['device_type'] = 'Website';

                $api_resp = $this->cit_api_model->callAPI('social_signup', $params);


                if (empty($api_resp['data'])) {
                    throw new Exception($api_resp['settings']['message']);
                }

                /*$fbactionarr = array(
                    'vEmail' => $params['user_email'],
                    'vPassword' => $params['password'],
                    'facebook_id' => $params['facebook_id']
                );*/

                $record = $api_resp['data'][0];

                /* added to keep user signin */
                $cookie_prefix = $this->config->item("sess_cookie_name");
                $stay_signed = 'yes';
                $email = $params['user_email'];
                $password  = $params['password'];
                if (strtolower($stay_signed) == 'yes') {
                    $cookie_data = array(
                        $cookie_prefix . '_username' => $email,
                        $cookie_prefix . '_password' => $password
                    );
                    $this->cookie->write('remember_me', $cookie_data);
                } else {
                    $this->cookie->delete('remember_me');
                }
                /* end code */

                $this->session->set_userdata("iUserId", $record["u_user_id"]);
                $this->session->set_userdata("vName", $record["u_name"]);
                $this->session->set_userdata("vEmail", $record["u_email"]);
                $this->session->set_userdata("eStatus", $record["u_status"]);
                $this->session->set_userdata("vProfileImage", $record["u_profile_image"]);

                // This assumes that you have placed the Firebase credentials in the same directory
                require_once($this->config->item('third_party') . "firebase/vendor/autoload.php");
                $serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-c4e95-firebase-adminsdk-8bf7i-647da9b09e.json');
                //$serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-pp-firebase-adminsdk-li2bz-be8e7e89a6.json');

                $this->firebase = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->create();
                $arr['user_id'] = $record["u_user_id"];
                $additionalClaims = ['username' => $record["u_name"], 'email' => $record["u_email"], 'user_id' => $arr['user_id']];
                $customToken = $this->firebase->getAuth()->createCustomToken($arr['user_id'], $additionalClaims);

                $this->session->set_userdata("firebase_token", (string)$customToken);

                $var_msg = $api_resp['settings']['message'];
                $this->session->set_flashdata('success', $var_msg);
                $this->smarty->assign('alldata', $this->session->all_userdata());

                $redirecturl = $this->config->item("site_url") . 'viral-posts.html';
                // echo $redirecturl;
                // die;
                // echo "<script language='Javascript'>window.close();opener.window.location = '" . $redirecturl . "';</script>";
                echo "<script type='text/javascript'>
                        if (window.opener) {
                            window.close();
                            window.opener.location.href = '" . $redirecturl . "';
                        } else {
                            window.location.href = '" . $redirecturl . "';
                        }
                    </script>";
            } else {
                throw new Exception("Error in connecting with Facebook !");
            }
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            $redirecturl = $this->config->item("site_url");
            // echo "<script language='Javascript'>opener.window.location.reload(false); window.close();</script>";
            echo "<script>
                    if (window.opener) {
                        window.close();
                        window.opener.location.href= '" . $redirecturl . "';
                    } else {
                         window.location.href= '" . $redirecturl . "';
                        console.error('No opener window found.');
                    }
                    </script>";
        }
    }

    public function fb_logout()
    {
        // Load facebook oauth library
        $this->load->library('facebook');

        // Remove local Facebook session
        $this->facebook->destroy_session();

        // Remove user data from session
        $this->session->sess_destroy();

        // Redirect to login page
        redirect($this->config->item("site_url"));
    }

    public function googleplus_authentication()
    {

        $this->load->library('googleplus');

        if (isset($_REQUEST['code'])) {
            $this->googleplus->getAuthenticate();

            $this->session->set_userdata('login', true);
            $this->session->set_userdata('userProfile', $this->googleplus->getUserInfo());

            try {

                if ($this->session->userdata('login') == true) {
                    $data['profileData'] = $this->session->userdata('userProfile');

                    $params = array();
                    $params['user_name'] = $data['profileData']['name'];
                    $params['user_email'] = $data['profileData']['email'];
                    $params['password'] = $this->general->getRandomNumber(6);  // randomly generated password
                    $params['profile_image_social'] = $data['profileData']['picture'];
                    $params['profile_image'] = $data['profileData']['picture'];
                    $params['google_id'] = $data['profileData']['id'];
                    $params['device_token'] = 1;  // temp need to remove once confirm
                    $params['device_type'] = 'Website';

                    //pr($params);exit;
                    $api_resp = $this->cit_api_model->callAPI('social_signup', $params);

                    //pr($api_resp);exit;
                    if (empty($api_resp['data'])) {
                        throw new Exception($api_resp['settings']['message']);
                    }

                    $record = $api_resp['data'][0];

                    /* added to keep user signin */
                    $cookie_prefix = $this->config->item("sess_cookie_name");
                    $stay_signed = 'yes';
                    $email = $params['user_email'];
                    $password  = $params['password'];
                    if (strtolower($stay_signed) == 'yes') {
                        $cookie_data = array(
                            $cookie_prefix . '_username' => $email,
                            $cookie_prefix . '_password' => $password
                        );
                        $this->cookie->write('remember_me', $cookie_data);
                    } else {
                        $this->cookie->delete('remember_me');
                    }
                    /* end code */

                    $this->session->set_userdata("iUserId", $record["u_user_id"]);
                    $this->session->set_userdata("vName", $record["u_name"]);
                    $this->session->set_userdata("vEmail", $record["u_email"]);
                    $this->session->set_userdata("eStatus", $record["u_status"]);
                    $this->session->set_userdata("vProfileImage", $record["u_profile_image"]);

                    // This assumes that you have placed the Firebase credentials in the same directory
                    require_once($this->config->item('third_party') . "firebase/vendor/autoload.php");
                    $serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-c4e95-firebase-adminsdk-8bf7i-647da9b09e.json');
                    //$serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-pp-firebase-adminsdk-li2bz-be8e7e89a6.json');

                    $this->firebase = (new Factory)
                        ->withServiceAccount($serviceAccount)
                        ->create();
                    $arr['user_id'] = $record["u_user_id"];
                    $additionalClaims = ['username' => $record["u_name"], 'email' => $record["u_email"], 'user_id' => $arr['user_id']];
                    $customToken = $this->firebase->getAuth()->createCustomToken($arr['user_id'], $additionalClaims);

                    $this->session->set_userdata("firebase_token", (string)$customToken);

                    $var_msg = $api_resp['settings']['message'];
                    $this->session->set_flashdata('success', $var_msg);
                    $this->smarty->assign('alldata', $this->session->all_userdata());

                    $redirecturl = $this->config->item("site_url") . 'viral-posts.html';
                    // echo "<script language='Javascript'>window.close();opener.window.location = '" . $redirecturl . "';</script>";
                    echo "<script type='text/javascript'>
                        if (window.opener) {
                            window.close();
                            window.opener.location.href = '" . $redirecturl . "';
                        } else {
                            window.location.href = '" . $redirecturl . "';
                        }
                    </script>";
                    // die;
                }
            } catch (Exception $e) {
                $var_msg = $e->getMessage();
                $this->session->set_flashdata('failure', $var_msg);
                $redirecturl = $this->config->item("site_url");
                //redirect($this->config->item("site_url"));
                echo "<script>
                    if (window.opener) {
                        window.close();
                        window.opener.location.href= '" . $redirecturl . "';
                    } else {
                         window.location.href= '" . $redirecturl . "';
                        console.error('No opener window found.');
                    }
                    </script>";
            }
        } else {
            $redirecturl = $this->config->item("site_url");
            echo "<script>if (window.opener) {
                        window.close();
                        window.opener.location.href= '" . $redirecturl . "';
                    } else {
                         window.location.href= '" . $redirecturl . "';
                        console.error('No opener window found.');
                    }
            </script>";
        }
    }

    public function getbrowseuserprofile()
    {
        $pageindex = $keyword = '';
        if (isset($_GET['keyword']) && $_GET['keyword'] != '') {
            $keyword = $_GET['keyword'];
        }
        if (isset($_REQUEST['pageindex']) && $_REQUEST['pageindex'] != '') {
            $pageindex = $_REQUEST['pageindex'];
        }
        if (isset($_REQUEST['postid']) && $_REQUEST['postid'] != '') {
            $postid = $_REQUEST['postid'];
        }
        if (isset($_REQUEST['type']) && $_REQUEST['type'] != '') {
            $type = $_REQUEST['type'];
        }
        if (isset($_REQUEST['postcommentid']) && $_REQUEST['postcommentid'] != '') {
            $postcommentid = $_REQUEST['postcommentid'];
        }
        if (isset($_REQUEST['mediaid']) && $_REQUEST['mediaid'] != '') {
            $mediaid = $_REQUEST['mediaid'];
        }

        if ($_REQUEST['mediaid'] == '0') {
            $type = 'likepost';
        }
        if ($this->session->userdata('iUserId') != '' || $this->session->userdata('iUserId') == '') {

            if ($this->session->userdata('iUserId') != '') {
                $user_id = $this->session->userdata('iUserId');
            } else {
                $user_id = 1;
            }
            if ($type == 'likepost') {
                $params = array();
                $params['user_id'] = $user_id;
                $params['page_index'] = $pageindex;
                if ($postid != '') {
                    $params['post_id_1'] = $postid;
                }
                $resultarr = $this->cit_api_model->callAPI("list_liked_post_user", $params);
            } else if ($type == 'likemediapost') {
                $params = array();
                $params['user_id'] = $user_id;
                $params['page_index'] = $pageindex;
                $params['media_id'] = $mediaid;
                $resultarr = $this->cit_api_model->callAPI("list_liked_post_media", $params);
            } else if ($type == 'likepostcomment') {
                $params = array();
                $params['user_id'] = $user_id;
                $params['page_index'] = $pageindex;
                if ($postid != '') {
                    $params['post_id_1'] = $postid;
                }
                $params['post_comment_id'] = $postcommentid;
                $resultarr = $this->cit_api_model->callAPI("list_liked_post_comment_user", $params);
            } else {
                if ($this->session->userdata('iUserId') > 0) {
                    $user_id = $this->session->userdata('iUserId');
                } else {
                    $user_id = 1;
                }
                // Search for profiles
                $profileResults = $this->general->getbrowseprofiles($user_id, $pageindex, $keyword);

                // Search for posts
                $this->db->from('post');
                $this->db->select('*');
                $this->db->like('tPostText', $keyword);
                $this->db->or_like('tPostTextEmoji', $keyword);
                $this->db->order_by('iPostId', 'DESC'); // Replace 'id' with your desired column name
                $postQuery = $this->db->get();
                $postResults = $postQuery->result_array();


                // Merge profile and post results
                $resultarr['data'] = array_merge($profileResults['data'], $postResults);
                $resultarr['settings'] = $profileResults['settings']; // Assuming settings are similar
            }
        } else {
            $resultarr = array();
            $resultarr['settings'] = array('curr_page' => 1, 'next_page' => 1, 'prev_page' => 0);
        }

        $this->skip_template_view();

        // print_r($resultarr);
        // Check if data is null or empty
        if (empty($resultarr['data'])) {
            $render_arr['browseprofile'] = array();
            $render_arr['no_results'] = true;
        } else {
            $render_arr['browseprofile'] = $resultarr['data'];
            $render_arr['no_results'] = false;
        }

        $render_arr['currentpage'] = $resultarr['settings']['curr_page'];
        $render_arr['nextpage'] = $resultarr['settings']['next_page'];
        $render_arr['prevpage'] = $resultarr['settings']['prev_page'];
        $render_arr['isfromsearch'] = $keyword;

        $render_arr['getindex'] = $resultarr['settings']['curr_page'] + $resultarr['settings']['next_page'];

        // print_r($render_arr);
        if ($this->input->is_ajax_request() && $_REQUEST['isfrom'] == 'loadmore') {
            if ($render_arr['no_results']) {
                $return_array["posts_data"] = ''; // No data to show
            } else {
                $return_array["posts_data"] = $this->parser->parse("browseuserprofile_inner.tpl", $render_arr, true);
            }
            $return_array["cr_pg"] = $resultarr['settings']['curr_page'];
            $return_array["nx_pg"] = $resultarr['settings']['next_page'];
            echo json_encode($return_array);
            exit;
        } else {
            if ($render_arr['no_results']) {
                echo 'No results found';
            } else {
                echo $this->parser->parse("browseuserprofile_inner.tpl", $render_arr, true);
            }
            exit;
        }
    }

    public function videosearch()
    {
        $pageindex = $this->input->post('pageindex');
        $keyword = $this->input->post('keyword');

        // Search for profiles
        $profileResults = $this->general->getbrowseprofiles(1, $pageindex, $keyword);

        // Search for posts
        $this->db->from('post');
        $this->db->select('*');
        $this->db->like('tPostText', $keyword);
        $this->db->or_like('tPostTextEmoji', $keyword);
        $postQuery = $this->db->get();
        $postResults = $postQuery->result_array();

        // // Merge profile and post results
        // $resultarr['data'] = array_merge($profileResults['data'], $postResults);
        // $resultarr['settings'] = $profileResults['settings']; // Assuming settings are similar

        // $this->skip_template_view();

        // // Check if data is null or empty
        // if (empty($resultarr['data'])) {
        //     $render_arr['browseprofile'] = array();
        //     $render_arr['no_results'] = true;
        // } else {
        //     $render_arr['browseprofile'] = $resultarr['data'];
        //     $render_arr['no_results'] = false;
        // }

        // $render_arr['currentpage'] = $resultarr['settings']['curr_page'];
        // $render_arr['nextpage'] = $resultarr['settings']['next_page'];
        // $render_arr['prevpage'] = $resultarr['settings']['prev_page'];
        // $render_arr['isfromsearch'] = $keyword;

        // $render_arr['getindex'] = $resultarr['settings']['curr_page'] + $resultarr['settings']['next_page'];

        // if ($render_arr['no_results']) {
        //     $return_array["posts_data"] = '';
        // } else {
        //     $return_array["posts_data"] = $this->parser->parse("browseuserprofile_inner.tpl", $render_arr, true);
        // }
        // $return_array["cr_pg"] = $resultarr['settings']['curr_page'];
        // $return_array["nx_pg"] = $resultarr['settings']['next_page'];
        // echo json_encode($return_array);
        // exit;

        $response = array(
            'success' => 'Success',
            'message' => 'Ready to perform next step',
            'pageindex' => $pageindex,
            'keyword' => $keyword,
            'resultarr' => $postResults,
        );

        echo json_encode($response);
        exit;
    }


    /**
     * notification_count
     *
     * Notifications count
     *
     * @return json Notification count
     * @throws Exception
     */
    public function notification_count()
    {
        //echo "4";exit;
        $return_array = array();
        try {
            $notification_count = 0;
            $user_id = $this->session->userdata('iUserId');
            if ($user_id <= 0) {
                throw new Exception("Session logged out");
            }
            $api_resp = $this->cit_api_model->callAPI('notification_count', array("user_id" => $user_id));
            //pr($api_resp,1);
            if (intval($api_resp['data'][0]['notify_count']) > 0) {
                $notification_count = $api_resp['data'][0]['notify_count'];
            }
            $return_array['status'] = "Success";
            $return_array['notification_count'] = $notification_count;
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
        }
        echo json_encode($return_array);
        exit;
    }


    function accountactivation() {}

    public function checkfileupload()
    {
        error_reporting(E_ALL);
        if ($_POST) {
            pr($_FILES);
            exit;
        }

        $view_file = "samplefileupload";
        $this->loadView($view_file);
    }

    public function post_query_script()
    {

        $sql = "select tPostText,iPostId from post_bk_aug";
        $mail_data_obj = $this->db->query($sql);
        $resarr = is_object($mail_data_obj) ? $mail_data_obj->result_array() : array();


        for ($i = 0; $i < count($resarr); $i++) {
            $sql1 = "select tPostText,iPostId from post where iPostId = '" . $resarr[$i]['iPostId'] . "' and tPostText = ''";
            $data_obj = $this->db->query($sql1);
            $resarr2 = is_object($data_obj) ? $data_obj->result_array() : array();

            if (is_array($resarr2) && count($resarr2) > 0) {
                $update1 = "update post set tPostText = '" . addslashes($resarr[$i]['tPostText']) . "', tPostTextEmoji = '" . addslashes($resarr[$i]['tPostText']) . "' where tPostText = '' and iPostId = '" . $resarr[$i]['iPostId'] . "'";
                echo $update1;
                echo '<hr>';
                $id = $this->db->query($update1);
            }
        }
        echo 1;
        exit;
    }

    public function test_smtp()
    {
        $email_vars = array();
        $email_vars['NAME'] = 'Nandini Santoki';
        $email_vars['vEmail'] = $_GET['to'];
        $email_vars['EMAIL'] = 'nandini1@gmail.com';
        $email_vars['COMMENT'] = 'test smtp email';
        $response = $this->general->sendMail($email_vars, 'CONTACT_US');

        var_dump($response);
        exit;
    }

    public function regenerate_firebase_token()
    {

        require_once($this->config->item('third_party') . "firebase/vendor/autoload.php");
        $serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-c4e95-firebase-adminsdk-8bf7i-647da9b09e.json');
        //$serviceAccount = ServiceAccount::fromJsonFile($this->config->item('third_party') . 'firebase/zoebook-pp-firebase-adminsdk-li2bz-be8e7e89a6.json');

        $this->firebase = (new Factory)
            ->withServiceAccount($serviceAccount)
            ->create();
        $arr['user_id'] = $record["u_user_id"];
        $additionalClaims = ['username' => $record["u_name"], 'email' => $record["u_email"], 'user_id' => $arr['user_id']];
        $customToken = $this->firebase->getAuth()->createCustomToken($arr['user_id'], $additionalClaims);

        $this->session->set_userdata("firebase_token", (string)$customToken);

        echo $this->session->userdata("firebase_token");
        exit;
    }
}
