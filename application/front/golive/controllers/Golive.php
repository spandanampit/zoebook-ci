<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Golive Controller
 *
 * @category front
 *
 * @package Go live
 *
 * @subpackage controllers
 *
 * @module Golive
 *
 * @class Golive.php
 *
 * @path application\front\golive\controllers\Golive.php
 *
 * @version 4.0
 *
 * @author CIT Dev Team
 *
 * @since 03.30.2020
 */
class Golive extends Cit_Controller
{

    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cit_api_model');
    }

    /**
     * languages method is used to set language preferences.
     */
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
            'follow',
            'unfollow',
            "share",
            "share_on_my_timeline",
            'liked',
            'block_user_list',
            'go_live_with_zoebook',
            'live_text',
            'movement_name_menu'

        ];

        $lang = [];
        foreach ($langKeys as $key) {
            $lang[$key] = $this->lang->line($key);
        }

        $this->smarty->assign($lang);
    }


    /**
     * index method is used to initialize index function.
     */
    public function index()
    {
        $this->assign_language();
        $user = $this->session->userdata();
        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to join live streaming.");
            redirect($this->config->item("site_url"));
        }
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $user['vName'],
            'iUserId' => $user_id,
        );
        $data = [
            'userinfo' => $userinfo,
        ];
        $this->smarty->assign($data);
    }

    public function start()
    {
        $user_id = $this->session->userdata('iUserId');
        $this->assign_language();
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to join live streaming.");
            redirect($this->config->item("site_url"));
        }
        try {
            $preview_thumb = $this->input->post('preview_thumb');
            $params['post_text'] = $this->input->post('post_text');
            $params['user_id'] = $user_id;
            $api_resp = $this->cit_api_model->callAPI('start_live_stream', $params);
            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($api_resp['settings']['message']);
            }
            $postdata = $api_resp['data'];
            $image_parts = explode(";base64,", $preview_thumb);
            $image_base64 = base64_decode($image_parts[1]);
            $filename = "screenshot_" . $postdata['post_id'] . '.jpeg';
            $thumbnail_path = $this->config->item('upload_path') . 'thumbnail/';
            $file = $thumbnail_path . $filename;

            file_put_contents($file, $image_base64);
            if (trim($filename) != "") {
                $thumb_data = array(
                    "vVideoThumbnail" => $filename
                );
                $this->db->where("iPostId", $postdata['post_id']);
                $this->db->update("post", $thumb_data);
            }

            redirect($this->config->item("site_url") . "golive-join-" . $postdata['post_id'] . ".html");
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->config->item("site_url") . 'golive-start.html');
        }
    }

    public function join($post_id = 0)
    {
        $user = $this->session->userdata();
        $this->assign_language();

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to join live streaming.");
            redirect($this->config->item("site_url"));
        }
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $user['vName'],
            'iUserId' => $user_id,
        );
        $data = [
            'userinfo' => $userinfo,
        ];
        $this->smarty->assign($data);
        try {
            if (isset($post_id) && $post_id > 0) {

                $params = array();
                $params['post_id'] = $post_id;
                $params['user_id'] = $user_id;
                $api_resp = $this->cit_api_model->callAPI('post_detail', $params);

                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    $this->smarty->assign('message', "Live Stream Ended");
                    $this->loadView('stream_end');
                }
                $postdata = $api_resp['data'];

                if ($postdata['post_type'] == 'LiveNow' && $postdata['get_tokbox_detail'][0]['ts_status'] == 'Inprogress') {
                    $params = array();
                    $params['user_id'] = $user_id;
                    $params['tokbox_session_id'] = $postdata['get_tokbox_detail'][0]['ts_tokbox_session_id'];
                    // echo $params['user_id'] . '<br>';
                    // echo $params['tokbox_session_id'];
                    // die;
                    $api_resp = $this->cit_api_model->callAPI('join_live_stream', $params);
                    // print_r($api_resp);
                    // die;
                    if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                        $this->smarty->assign('message', $api_resp['settings']['message']);
                        $this->loadView('stream_end');
                    }
                    $join_live_stream_res = $api_resp['data'];

                    if (array_key_exists(0, $api_resp['data'])) {
                        $join_live_stream_res = $api_resp['data'][0];
                    }


                    $start_date_time_stamp = strtotime($postdata['get_tokbox_detail'][0]['ts_start_date_time']);

                    $render_arr = array(
                        'get_post_details' => $postdata,
                        'token' => $join_live_stream_res['tokbox_token'],
                        'session_id' => $postdata['get_tokbox_detail'][0]['ts_session_id'],
                        'tokbox_session_id' => $postdata['get_tokbox_detail'][0]['ts_tokbox_session_id'],
                        'start_date_time' => ($start_date_time_stamp * 1000),
                    );
                    print_r($render_arr);
                    // die;

                    $this->smarty->assign($render_arr);
                    if ($postdata['posted_user_id'] == $user_id) {
                        $this->loadView('publishing');
                    } else {
                        $this->loadView('streaming');
                    }
                } else {
                    $this->smarty->assign('message', "Live Stream Ended");
                    $this->loadView('stream_end');
                }
            }
        } catch (Exception $e) {
            $this->smarty->assign('message', "Live Stream Ended");
            $this->loadView('stream_end');
        }
    }

    public function end_stream()
    {
        $user_id = $this->session->userdata('iUserId');
        $this->assign_language();

        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to join live streaming.");
            redirect($this->config->item("site_url"));
        }
        $params = array();
        $params['tokbox_session_id'] = $this->input->post('tokbox_session_id');
        $params['user_id'] = $user_id;
        $params['ws_debug'] = 1;
        $api_resp = $this->cit_api_model->callAPI('end_live_stream', $params);
        $api_resp['last_api_call'] = 'end_live_stream';
        if ($this->input->post('is_share') == 'Yes') {
            $params = array();
            $params['tokbox_session_id'] = $this->input->post('tokbox_session_id');
            $params['user_id'] = $user_id;
            $params['ws_debug'] = 1;
            $old_api_resp = $api_resp;
            $api_resp = $this->cit_api_model->callAPI('share_live_video_post', $params);
            $api_resp['last_api_call'] = 'share_live_video_post';
            $api_resp['end_live_stream'] = $old_api_resp;
        }
        echo json_encode($api_resp);
        exit;
    }

    public function start_archive()
    {
        $user_id = $this->session->userdata('iUserId');
        $params = array();
        $params['user_id'] = $user_id;
        $params['tokbox_session_id'] = $this->input->post('tokbox_session_id');
        $api_resp = $this->cit_api_model->callAPI('start_live_archive', $params);
        echo json_encode($api_resp);
        exit;
    }
}
