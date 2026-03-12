<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Content Controller
 *
 * @category front
 *
 * @package movement
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

class Movement extends Cit_Controller
{

    private $firebase;
    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();

        $this->load->library('session');
        $this->load->model('cit_api_model');
        $this->load->library('cit_general');

        $ogTitle = $this->config->item('META_TITLE');
        $ogUrl = $this->config->item('site_url');
        $ogSiteName = $this->config->item('SITE_NAME');
        $ogImage = $this->config->item('site_url') . 'public/images/front/logo.png';
        $ogType = "website";
        $ogDescription = $this->config->item('META_DESCRIPTION');
        // $this->smarty->assign('ogTitle', trim($share_ogtitle));
        $this->smarty->assign('ogUrl', $ogUrl);
        $this->smarty->assign('ogSiteName', $ogSiteName);
        $this->smarty->assign('ogImage', $ogImage);
        $this->smarty->assign('ogType', $ogType);
        $this->smarty->assign('ogDescription', trim($ogDescription));
    }

    public function index()
    {
        redirect($this->url->make('movement/movement/popularmovement'));
    }

    /**
     * Language
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
            'suggested',
            'follow',
            'unfollow',
            'share',
            'liked',
            'views',
            'like',
            'likes',
            'wasLive',
            'live',
            'noPostAvailable',
            'related_videos',
            'reply',
            'press_enter_to_reply',
            'add_comment',
            'initiated_by_leader',
            'members',
            'leave',
            'join',
            'view_more',
            'popular_movements',
            'my_movements',
            'create_movement',
            'movement_name',
            'description',
            'goal_or_objective',
            'upload_cover_photo',
            'save',
            'editMovement',
            'upto_five_photo',
            'deactivateMovement',
            'share_movement',
            'copy_movement',
            'copy',
            'invite',
            'edit_post',
            'update',
            'post_not_found',
            'movement_name_menu',
            'friends_selected',
            'select_all',
            'invite_friends',
            'search_and_add_friends',
            'search_results',
            'add_friend'
        ];

        $lang = [];
        foreach ($langKeys as $key) {
            $lang[$key] = $this->lang->line($key);
        }

        $this->smarty->assign($lang);
    }

    public function addmovement()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'iUserId' => $user_id,
        );

        $data = [
            'userinfo' => $userinfo,
            'page_type' => 'movement',
        ];
        $this->smarty->assign($data);

        $this->assign_language();
    }

    public function savemovement()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        // Movement Details
        $movement_name = $this->input->post('movement_name');
        $movement_description = $this->input->post('movement_description');
        $movement_visibility = $this->input->post('movement_visibility');

        $params = [
            "description" => $movement_description,
            "movement_name" => $movement_name,
            "theme" => 'Light',
            "user_id" => $user_id,
            "visibility" => $movement_visibility
        ];
        $addmovement = $this->cit_api_model->callAPI("add_movement", $params);
        $movements_id = $addmovement['data'][0]['movement_id'];
        $file = $_FILES['upload_file'];
        $file_name = $file['name'];
        $fileType =  $file['type'];
        $typeParts = explode('/', $fileType);
        $mainType = $typeParts[0];
        $params = [
            'media_type' => $fileType,
            'movements_id' => $movements_id,
            'platform' => 'aws',
            'upload_file' => $file,
            'user_id' => $user_id,
            'video_tumbnail' => '',
        ];
        $addmovementimage = $this->cit_api_model->callAPI("add_movement_image", $params);
        redirect($this->url->make('movement/movement/mymovement'));
    }

    public function mymovement()
    {
        $userr = $this->session->userdata();
        $user_id = $userr['iUserId'];
        $vName = $userr['vName'];
        // $user_id = 1;
        $params = array(
            "user_id" => $user_id,
        );
        $mymovement = $this->cit_api_model->callAPI("my_movements", $params);
        

        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        /**
         * language
         */
        $this->assign_language();

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'iUserId' => $user_id,
        );
        $data = [
            'mymovement' => $mymovement['data'],
            'type' => 'mymovement',
            'userinfo' => $userinfo,
            'page_type' => 'movement',
        ];

        // echo "<pre>";
        // print_r($mymovement['data']);
        // echo "</pre>";
        // die;
        $this->smarty->assign($data);
    }

    public function editmovement()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        $movement_id = $this->input->get('movementId');
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        /**
         * language 
         */ $this->assign_language();

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'iUserId' => $user_id,
        );
        $params = [
            'movements_id' => $movement_id,
            'user_id' => $user_id,
        ];
        $movement_details = $this->cit_api_model->callAPI("movements_details", $params);
        // print_r($movement_details);
        $data = [
            'movement' => $movement_details['data'],
            'userinfo' => $user,
            'page_type' => 'movement',
            'userinfo' => $userinfo,
        ];
        $this->smarty->assign($data);
    }

    public function updatemovement()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        // Movement Details
        $movement_name = $this->input->post('movement_name');
        $movement_description = $this->input->post('movement_description');
        $movement_visibility = $this->input->post('movement_visibility');
        $movement_id = $this->input->post('movement_id');
        $movement_image_id = $this->input->post('movement_image_id');


        $params = [
            'description' => $movement_description,
            'movements_id' => $movement_id,
            'movement_image_id' => '',
            'movement_name' => $movement_name,
            'theme' => 'Light',
            'user_id' => $user_id,
            'visibility' => $movement_visibility,
        ];

        $update_movement = $this->cit_api_model->callAPI("edit_movement", $params);
        redirect($this->url->make('movement/movement/mymovement'));
    }

    // public function popularmovement()
    // {
    //     $user = $this->session->userdata();
    //     $user_id = $user['iUserId'];
    //     $params['user_id'] = $user_id;
    //     $params['profile_user_id'] = $user_id;
    //     $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
    //     #pr($api_resp,1);
    //     if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
    //         throw new Exception($api_resp['settings']['message']);
    //     }

    //     $logged_userdata = $api_resp['data'][0];

    //     $userdata = $this->session->userdata();
    //     $userinfo = array(
    //         'u_profile_image' => $logged_userdata['u_profile_image'],
    //         'u_name' => $userdata['vName'],
    //         'iUserId' => $user_id,
    //     );

    //     $params = [
    //         'user_id' => $user_id,
    //     ];
    //     $popular_movement = $this->cit_api_model->callAPI("popular_movements", $params);
    //     // print_r($popular_movement);
    //     $data = [
    //         'userinfo' => $userinfo,
    //         'popularmovement' => $popular_movement['data'],
    //         'page_type' => 'movement',
    //     ];
    //     $this->smarty->assign($data);
    // }


    public function deactivate()
    {
        echo "Deactivate Movement";
        $movement_id = $this->input->get('movement_id');
        echo $movement_id;
        $params = [
            'movement_id' => $movement_id,
            'status' => 'Inactive',
            'user_id' => $this->session->userdata('iUserId'),
        ];
        $deactivate_movement = $this->cit_api_model->callAPI("movement_active_inactive", $params);
        $data = [
            'iSysRecDeleted' => 1,
        ];
        $this->db->where('iMovementsId', $movement_id);
        $this->db->where('iUserId', $this->session->userdata('iUserId'));
        $this->db->update('movements', $data);
        redirect($this->url->make('movement/movement/mymovement'));
    }

    public function popularmovement()
    {
        $page_index = $this->input->post('page_index');
        $user_id = $this->session->userdata('iUserId');

        $params = [
            'user_id' => $user_id,
            'page_index' => $page_index,
        ];

        $this->assign_language();

        $popular_movement = $this->cit_api_model->callAPI("popular_movements", $params);

        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'iUserId' => $user_id,
        );
        $data = [
            'popularmovement' => $popular_movement['data'],
            'userinfo' => $userinfo,
            'page_type' => 'movement',
        ];
        if ($this->input->is_ajax_request()) {
            if (!empty($popular_movement['data'])) {
                $data['popularmovement'] = $popular_movement['data'];

                // echo "<pre>";
                // print_r($data['popularmovement']);
                // echo "</pre>";

                // Render the view for the new posts and send it back as HTML
                // $html = $this->smarty->fetch('application/front/movement/views/popularmovement.tpl', $data);

                $response = [
                    'success' => true,
                    'message' => 'Success',
                    'popularMovements' => $data,

                ];
                $this->skip_template_view();
                echo json_encode($response);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            $this->smarty->assign($data);
        }
    }


    public function movementjoin()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        $movement_id = $this->input->get('movement_id');
        $params = [
            'movements_id' => $movement_id,
            'user_id' => $user_id,
        ];
        $movement_details = $this->cit_api_model->callAPI("movements_details", $params);
        // print_r($movement_details);
        // die;
        if ($movement_details['data']['get_movements']['join_status'] == 'Active') {
            $url = $this->url->make('movement/movement/movementdetails') . '?movement_id=' . $movement_id . '&user_id=' . $user_id;
            redirect($url);
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
            'movement' => $movement_details['data'],
            'page_type' => 'movement',
        ];
        $this->smarty->assign($data);
    }

    public function join()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        $movement_id = $this->input->get('movement_id');
        $params = [
            'movements_id' => $movement_id,
            'type' => '',
            'user_id' => $user_id,
        ];
        $join_movement = $this->cit_api_model->callAPI("join_movements", $params);
        $url = $this->url->make('movement/movement/movementdetails') . '?movement_id=' . $movement_id . '&user_id=' . $user_id;
        redirect($url);
    }

    public function leave()
    {
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        $movement_id = $this->input->get('movement_id');
        // echo $user_id . '<br>';
        // echo $movement_id . '<br>';
        // die;
        // $params = [
        //     'eStatus' => 'Inactive',
        // ];
        $leave_params = [
            'movements_id' => $movement_id,
            'type' => '',
            'user_id' => $user_id,
        ];
        // echo "<pre>";
        // print_r($leave_params);
        // echo "</pre>";
        // die;
        $leave_movement = $this->cit_api_model->callAPI("join_movements", $leave_params);

        // $this->db->where('iMovementId', $movement_id);
        // $this->db->where('iUserId', $user_id);
        // $this->db->update('movement_users', $params);
        // return $this->db->affected_rows() > 0;   
        redirect($this->url->make('movement/movement/popularmovement'));
    }

    public function movementdetails()
    {
        $movement_id = $this->input->get('movement_id');
        $user_id = $this->input->get('user_id');
        $this->load->model('Playlist_model');
        // echo $this->session->userdata('iUserId');
        // die;

        $user = $this->session->userdata();

        /**
         * language
         */
        $this->assign_language();

        $params['user_id'] = $this->session->userdata('iUserId');
        $params['profile_user_id'] = $this->session->userdata('iUserId');
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $site_logged_userdata = $api_resp['data'][0];
        $login_userinfo = array(
            'u_profile_image' => $site_logged_userdata['u_profile_image'],
            'u_name' => $user['vName'],
            'iUserId' => $user_id,
        );
        $params = [
            'movements_id' => $movement_id,
            'user_id' => $user_id,
        ];
        $movement_details = $this->cit_api_model->callAPI("movements_details", $params);

        $post_params = [
            'is_ads_show' => '',
            'movement_id' => $movement_id,
            'user_id' => $user_id,
        ];
        $movement_post_list = $this->cit_api_model->callAPI("movements_post_list", $post_params);


        $movement_posts = [];
        foreach ($movement_post_list['data'] as $value) {
            $post_id = $value['post_id'];

            if(!empty($value['get_post_media'])) {
                  foreach($value['get_post_media'] as $post_media) {
                        $media_id = $post_media['pm_post_media_id'];
                  }
            } else {
                  $media_id = 0;
            }

            if ($value['post_type'] == 'Share') {
                $actual_post_id = $value['actual_post_id'];

                $movement_share_post = $this->Playlist_model->get_share_post_media($actual_post_id);
                $share_post = $this->Playlist_model->get_post_by_id($actual_post_id);
                $user_params['user_id'] = $share_post[0]['iUserId'];
                $user_params['profile_user_id'] = $share_post[0]['iUserId'];
                $api_resp = $this->cit_api_model->callAPI('my_profile', $user_params);
                #pr($api_resp,1);
                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception($api_resp['settings']['message']);
                }

                $logged_userdata = $api_resp['data'][0];
                $userinfo = array(
                    'u_profile_image' => $logged_userdata['u_profile_image'],
                    'u_name' => $logged_userdata['u_name'],
                    'iUserId' => $logged_userdata['u_users_id'],
                );
                $value['share_user_info'] = $userinfo;

                $value['get_post_media'] = $movement_share_post;
                $value['pm.post_text'] = $share_post[0]['tPostText'];
            }

            $this->db->select('*');
            $this->db->from('post_like');
            $this->db->where('iPostId', $post_id);
            $this->db->where('iUserId', $user_id);
            $this->db->where('iSysRecDeleted', 0);
            $query = $this->db->get();
            $movement_post_like = $query->result_array();

            $value['is_post_like'] = !empty($movement_post_like) ? 1 : 0;

            
            

            if($media_id != 0) {
                  $comments_params = [
                        'post_id' => $post_id,
                        'user_id' => $user_id,
                        'post_media_id' => $media_id
                  ];
                  $comments = $this->cit_api_model->callAPI("comments_list", $comments_params);
            } else {
                  $comments_params = [
                        'post_id' => $post_id,
                        'user_id' => $user_id,
                        ];
                  $comments = $this->cit_api_model->callAPI("comments_list", $comments_params);
            }

            // $comments = array_merge($main_comments_data, $other_comments_data);

            $comments_details = [];


            foreach ($comments['data'] as $comment) {
                $replyList_params = [
                    'post_comment_id' => $comment['post_comment_id'],
                    'post_id' => $comment['post_id'],
                    'user_id' => $this->session->userdata('iUserId'),
                ];

                $reply_list = $this->cit_api_model->callAPI("replies_list", $replyList_params);

                $comment['reply_details'] = !empty($reply_list['data']) ? $reply_list['data'] : [];

                $comments_details[] = $comment;
            }
            $value['comment_details'] = $comments_details;

            // echo json_encode($comments_details);die;
            $movement_posts[] = $value;
        }


        $this->db->select('*');
        $this->db->from('movement_users');
        $this->db->where('iMovementId', $movement_id);
        $this->db->where('eStatus', 'Active');
        $this->db->order_by('iMovementUsersId', 'DESC');
        $this->db->limit(10);
        $query = $this->db->get();
        $movement_followser_user = $query->result_array();

        $movement_follower_data = [];
        foreach ($movement_followser_user as $value) {
            $mvnt_flr_user_id = $value['iUserId'];
            $params['user_id'] = $mvnt_flr_user_id;
            $params['profile_user_id'] = $mvnt_flr_user_id;

            $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

            if (isset($api_resp['settings']['success']) && $api_resp['settings']['success'] == 1 && !empty($api_resp['data'])) {
                $logged_userdata = $api_resp['data'][0];
                $flr_userinfo = array(
                    'u_profile_image' => $logged_userdata['u_profile_image'],
                    'u_name' => $logged_userdata['u_name'],
                    'iUserId' => $mvnt_flr_user_id,
                );
                $value['user_details'] = $flr_userinfo;
                $movement_follower_data[] = $value;
            } else {
                continue;
            }
        }

        $data = [
            'userinfo' => $login_userinfo,
            'movement' => $movement_details['data'],
            'movements_post' => $movement_posts,
            'movement_id' => $movement_id,
            'movement_follower' => $movement_follower_data,
            'page_type' => 'movement',
            'page' => 'movementDetails',
        ];

      //   echo json_encode($data);die;

        // echo "<pre>";
        // print_r($data['movement_follower']);
        // echo "</pre>";
        // die;
        $this->smarty->assign($data);
    }

    // Add Post
    public function add_post()
    {
        // $this->load->library('upload');

        // ini_set("memory_limit", "-1");
        // ini_set('max_execution_time', '0');
        // ini_set('post_max_size', '5000M');
        // set_time_limit(0);
        // $input_data = $this->input->post();
        // // print_r($input_data);
        // // Make sure the fields are properly set
        // if (!isset($input_data['movement_post_text'])) {
        //     echo "movement_post_text is not set!";
        // }
        // if (!isset($input_data['post_text_emoji'])) {
        //     echo "post_text_emoji is not set!";
        // }

        // $post_type = "Text";
        // $post_media = $_FILES;
        // if (trim($input_data['post_text']) == "" && count($post_media) == 0) {
        //     throw new Exception("Invalid data");
        // }
        // if (is_array($post_media) && !empty($post_media) && count($post_media) > 0) {
        //     $post_type = "Media";
        // }

        // $input_params = array(
        //     "movements_id" => $input_data['movement_id'],
        //     "user_id" => $this->session->userdata('iUserId'),
        //     "post_text" => trim(html_entity_decode($input_data['movement_post_text'])), // Ensure this field exists
        //     "visibility" => 'Movement',
        //     "post_type" => $post_type,
        //     'post_text_emoji' => trim(html_entity_decode($input_data['movement_post_text'])) // Ensure this field exists
        // );

        // print_r($input_params); // Add this line to check if $input_params is properly populated
        // $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);
        // die;
        // if ($api_resp['settings']['success'] == 0) {
        //     throw new Exception($api_resp['settings']['message']);
        // }
        // $post_id = $api_resp["data"][0]['post_id'];
        // // echo $post_id;
        // // die;
        // // $post_id = 143187;
        // if ($post_type == "Media") {
        //     $posted_media_count = count($post_media);
        //     echo $posted_media_count;
        //     $media_count_loop = 0;

        //     for ($i = 0; $i < $posted_media_count; $i++) {
        //         $video_thumbnail = "";
        //         $video_data = [
        //             'name' => $_FILES['upload_file']['name'][$i],
        //             'type' => $_FILES['upload_file']['type'][$i],
        //             'tmp_name' => $_FILES['upload_file']['tmp_name'][$i],
        //             'error' => $_FILES['upload_file']['error'][$i],
        //             'size' => $_FILES['upload_file']['size'][$i]
        //         ];

        //         // Process each file individually
        //         $_FILES['upload_file'] = $video_data;


        //         $media_count_loop += 1;
        //         $media_type_arr = explode("/", $video_data['type']);
        //         $media_type = $media_type_arr[0];
        //         $video_path = $video_data['tmp_name'];

        //         $media_input_params = array(
        //             "post_id" => $post_id,
        //             "user_id" => $this->session->userdata('iUserId'),
        //             "file_type" => 'Image',
        //             "upload_file" => $_FILES['upload_file'],
        //             "platform" => "web",
        //             "is_completed" => ($media_count_loop == $posted_media_count) ? 1 : 0
        //         );
        //         $media_api_resp = $this->cit_api_model->callAPI("add_post_media", $media_input_params);
        //     }
        // }

        $this->load->library('upload');

        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');
        ini_set('post_max_size', '5000M');
        set_time_limit(0);

        $input_data = $this->input->post();
        $post_media = $_FILES;

        // Debugging: Check the input data and post media
        // print_r($input_data);
        // print_r($post_media);

        $post_type = "Text"; // Default post type

        // Check if the post contains text or media
        if (trim($input_data['movement_post_text']) == "" && count($post_media) == 0) {
            throw new Exception("Invalid data");
        }

        // If there is media uploaded, change post type to "Media"
        if (is_array($post_media) && !empty($post_media['upload_file']['name'][0])) {
            $post_type = "Media";
        }

        $input_params = array(
            "movements_id" => $input_data['movement_id'],
            "user_id" => $this->session->userdata('iUserId'),
            "post_text" => trim(html_entity_decode($input_data['movement_post_text'])),
            "visibility" => 'Movement',
            "post_type" => $post_type,
            'post_text_emoji' => trim(html_entity_decode($input_data['post_text_emoji']))
        );

        // Debugging: Print input params before API call
        // print_r($input_params);

        // Call the API to add the post
        $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);

        // Debugging: Check API response
        // print_r($api_resp);
        // die;

        if ($api_resp['settings']['success'] == 0) {
            throw new Exception($api_resp['settings']['message']);
        }

        $post_id = $api_resp["data"][0]['post_id'];

        if ($post_type == "Media") {
            $posted_media_count = count($post_media['upload_file']['name']);

            for ($i = 0; $i < $posted_media_count; $i++) {
                $video_thumbnail = "";

                $video_data = [
                    'name' => $post_media['upload_file']['name'][$i],
                    'type' => $post_media['upload_file']['type'][$i],
                    'tmp_name' => $post_media['upload_file']['tmp_name'][$i],
                    'error' => $post_media['upload_file']['error'][$i],
                    'size' => $post_media['upload_file']['size'][$i]
                ];

                $_FILES['upload_file'] = $video_data;

                $mime_type = $video_data['type'];  // No need to use $_FILES
                $file_type = explode('/', $mime_type)[0];

                $media_input_params = array(
                    "post_id" => $post_id,
                    "user_id" => $this->session->userdata('iUserId'),
                    "file_type" => $file_type,
                    "upload_file" => $_FILES['upload_file'],
                    "platform" => "web",
                    "is_completed" => ($i == $posted_media_count - 1) ? 1 : 0
                );

                print_r($media_input_params);
                $media_api_resp = $this->cit_api_model->callAPI("add_post_media", $media_input_params);
            }
        }


        // $url = $this->url->make('movement/movement/movementdetails') . '?movement_id=' . $input_data['movement_id'] . '&user_id=' . $this->session->userdata('iUserId');
        // redirect($url);
    }

    public function invitefriends()
    {

        $movement_id = $this->input->get('movementId');
        $user = $this->session->userdata();
        $user_id = $user['iUserId'];
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'iUserId' => $user_id,
        );

        /**
         * language feature
         */
        $this->assign_language();

        $input_params = [
            'profile_user_id' => $user_id,
            'user_id' => $user_id,
        ];

        $user_followers = $this->cit_api_model->callAPI("user_followers", $input_params);

        $friend_data = [];
        foreach ($user_followers['data'] as $value) {

            $follower_user_id = $value['uf_user_follower_id'];
            $follower_count = $value['follower_count'];
            $this->db->select('*');
            $this->db->from('movement_users');
            $this->db->where('iUserId', $follower_user_id);
            $this->db->where('iMovementId', $movement_id);
            $query = $this->db->get();
            $flower_user_data = $query->result_array();

            if ($flower_user_data[0]['eStatus'] == 'Active' && $flower_user_data[0]['eAdminStatus'] == 'No') {
                $value['movement_join_status'] = 1;
            } else {
                $value['movement_join_status'] = 0;
            }

            $friend_data[] = $value;
        }


        $data = [
            'userinfo' => $userinfo,
            'page_type' => 'movement',
            'friends' => $friend_data,
            'movementId' => $movement_id,
        ];
        $this->smarty->assign($data);
    }

    public function searchmovement()
    {
        $keyword = $this->input->post('keyword');
        $movementId = $this->input->post('movementId');
        $params = [
            "keyword" => $keyword,
            "user_id" => $this->session->userdata('iUserId'),
        ];
        $search_result = $this->cit_api_model->callAPI("search_friends", $params);

        $friend_data = [];
        foreach ($search_result['data'] as $value) {

            $follower_user_id = $value['u_users_id'];
            $follower_count = $value['follower_count'];
            $this->db->select('*');
            $this->db->from('movement_users');
            $this->db->where('iUserId', $follower_user_id);
            $this->db->where('iMovementId', $movementId);
            $query = $this->db->get();
            $flower_user_data = $query->result_array();

            if ($flower_user_data[0]['eStatus'] == 'Active' && $flower_user_data[0]['eAdminStatus'] == 'No') {
                $value['movement_join_status'] = 1;
            } else {
                $value['movement_join_status'] = 0;
            }

            $friend_data[] = $value;
        }
        // echo "<pre>";
        // print_r($friend_data);
        // echo "<pre>";

        $response = [
            'success' => 'Success',
            'message' => 'Success',
            'keyword' => $keyword,
            'search_result' => $friend_data,
        ];

        echo json_encode($response);
    }

    public function invitemovement()
    {
        $invite_data = $this->input->post();

        if (!is_array($invite_data['userIds'])) {
            $invite_data['userIds'] = [$invite_data['userIds']];
        }

        $user_id = $this->session->userdata('iUserId');
        // User Details
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }
        $logged_userdata = $api_resp['data'][0];
        $userdata = $this->session->userdata();
        $u_name = $userdata['vName'];

        // Movement Details
        $movement_params = [
            'movements_id' => $invite_data['movementId'],
            'user_id' => $user_id,
        ];
        $movement_details = $this->cit_api_model->callAPI("movements_details", $movement_params);
        $notification_details = [
            'user_name' => $u_name,
            'Movement_name' => $movement_details['data']['get_movements']['movement_name'],
        ];
        $message = '';
        $success = '';


      //   print_r($$invite_data['userIds']);die;
        foreach ($invite_data['userIds'] as $user) {
            $invitee_user_id = $user;

            $params = [
                "invitee_user_id" => $this->session->userdata('iUserId'),
                "inviter_user_id" => $invitee_user_id,
                "movement_id" => $invite_data['movementId'],
                "notification_details" => $notification_details,
            ];

            $invite_params = [
                "invitee_user_id" => $this->session->userdata('iUserId'),
                "inviter_user_id" => $invitee_user_id,
                "movement_id" => $invite_data['movementId'],
            ];

            $invite_notifucation = invite_movement($params);
            // $invite_notifucation =  $this->cit_api_model->callAPI("movement_invitation", $invite_params);

            if ($invite_notifucation) {
                $message = "Invite Sent Successfully";
                $success = 1;
            } else {
                $message = "Something Went Wrong! Please try again";
                $success = 0;
            }
        }

        $response = [
            'success' => $success,
            'message' => $message,
        ];

        echo json_encode($response);
    }

    public function like_post()
    {
        $input = $this->input->post();

        $params = [
            'post_id' => $input['post_id'],
            'status' => $input['status'],
            'user_id' => $this->session->userdata('iUserId'),
        ];

        $movement_post_like = $this->cit_api_model->callAPI("like_post", $params);
        $success = $movement_post_like ? 1 : 0;

        $response = [
            'success' => $success,
            'message' => 'function is working',
            'input' => $movement_post_like,
        ];
        echo json_encode($response);
    }

    public function like_postcomment()
    {
        $input_data = $this->input->post();
        $params = [
            'post_comment_id' => $input_data['postCommentId'],
            'post_id' => $input_data['postId'],
            'status' => 1,
            'user_id' => $this->session->userdata('iUserId'),
        ];
        $like_postComment = $this->cit_api_model->callAPI("like_comment", $params);
        $success = $like_postComment ? 1 : 0;
        $response = [
            'success' => $success,
            'message' => 'Acction is successfull',
            'response_data' => $input_data,
        ];

        echo json_encode($response);
    }

    public function comment()
    {
        $input = $this->input->post();

        $user_id = $this->session->userdata('iUserId');
        $params = [
            'comment' => $input['comment'],
            'post_id' => $input['post_id'],
            'upload_file' => $input['upload_file'],
            'user_id' => $user_id,
            'post_media_id' => $input['mediaId'],
        ];
        $movement_post_comment = $this->cit_api_model->callAPI("comment_on_post", $params);

        if($input['mediaId']) {
            $comments_params = [
                  'post_id' => $input['post_id'],
                  'post_media_id' => $input['mediaId'],
                  'user_id' => $user_id,
            ];
            $comments = $this->cit_api_model->callAPI("comments_list", $comments_params);
            $comments_data = $comments['data'];
        } else {
            $comments_params_two = [
                  'post_id' => $input['post_id'],
                  'user_id' => $user_id,
            ];
            $other_comments = $this->cit_api_model->callAPI("comments_list", $comments_params_two);
            $comments_data = $other_comments['data'];
        }

        $comments = $comments_data;
      
      //   $html_content = $this->parser->parse("common/display_comments.tpl", $comments, true);
        $this->smarty->assign('comments', $comments);
        $html_content = $this->smarty->fetch('common/display_comments.tpl');
        
        
        $response = [
            'success' => 1,
            'message' => 'Method create for comment is successfull',
            'comments' => $html_content,
            'post_id' => $input['post_id'],

        ];
        echo json_encode($response);
    }

    /**
     * share_post_mytimeline
     *
     * Share post on my timeline
     */

    public function sharePost()
    {
        $input = $this->input->post();
        $user_id = $this->session->userdata('iUserId');
        $params = [
            'post_id' => $input['post_id'],
            'share_text' => $input['movement_post_text'],
            'user_id' => $user_id,
            'visibility' => $input['visibility'],
        ];

        $movement_post_share = $this->cit_api_model->callAPI("share_post", $params);
        $insert_post_id = $movement_post_share['data'][0]['post_id'];
        $data = [
            'iMovementsId' => $input['movement_id'],
        ];
        $this->db->where('iPostId', $insert_post_id);
        $this->db->update('post', $data);
        $url = $this->url->make('movement/movement/movementdetails') . '?movement_id=' . $input['movement_id'] . '&user_id=' . $this->session->userdata('iUserId');
        redirect($url);
    }



    public function comments_reply()
    {

        $input_data = $this->input->post();

        $params = [
            'post_comment_id' => $input_data['post_comment_id'],
            'post_id' => $input_data['post_id'],
            'reply_text' => $input_data['reply_text'],
            'upload_file' => $input_data['upload_file'],
            'user_id' => $this->session->userdata('iUserId'),
        ];
        $comment_reply = $this->cit_api_model->callAPI("reply_on_comment", $params);
        if ($comment_reply) {
            $replyList_params = [
                'post_comment_id' => $input_data['post_comment_id'],
                'post_id' => $input_data['post_id'],
                'user_id' => $this->session->userdata('iUserId'),
            ];

            $reply_list = $this->cit_api_model->callAPI("replies_list", $replyList_params);
        }
        $response = [
            'success' => 1,
            'message' => 'Action is successfull',
            'input_data' => $input_data,
            'reply_comment' => $reply_list['data'],
        ];
        echo json_encode($response);
    }

    public function deletePost()
    {
        $input_data = $this->input->post();
        $post_id = $input_data['postId'];
        $delete_params = [
            'post_id' => $input_data['postId'],
            'user_id' => $this->session->userdata('iUserId'),
        ];
        $delete_post = $this->cit_api_model->callAPI("delete_post", $delete_params);
        $success = $delete_post ? 1 : 0;
        $response = [
            'success' => $success,
            'message' => 'Post Deleted Successfull',
            'input_data' => $input_data,
            'post_id' => $post_id,
        ];
        echo json_encode($response);
    }

    public function get_post()
    {
        $input_data = $this->input->post();
        $params = [
            'post_id' => $input_data['postId'],
            'user_id' => $this->session->userdata('iUserId'),
        ];

        $post_details = $this->cit_api_model->callAPI("post_detail", $params);

        $response = [
            'success' => 1,
            'message' => 'continue the work',
            'post_details' => $post_details['data'],
        ];
        echo json_encode($response);
    }

    public function edit_post()
    {
        $input = $this->input->post();
        $params = array(
            "post_id" => $input['post_id'],
            "post_text" => $input['movement_post_text'],
            "post_text_emoji" => $input['movement_post_text'],
            "post_type" => $input['post_type'],
            "user_id" => $this->session->userdata('iUserId'),
            "visibility" => $input['visibility']
        );
        $edit_post = $this->cit_api_model->callAPI("edit_post", $params);
        $url = $this->url->make('movement/movement/movementdetails') . '?movement_id=' . $input['movement_id'] . '&user_id=' . $this->session->userdata('iUserId');
        redirect($url);

    }


    /**
     * follow friends via movement
     */
      public function followRequest() {
            $input_data = $this->input->post();
            $user_id = $this->session->userdata('iUserId');
            $params = [
                  "invitee_user_id" => $input_data['user_id'],
                  'inviter_user_id' => $user_id,
                  "movement_id" => $input_data['movement_id']
            ];

            $follow_request = $this->cit_api_model->callAPI("movement_invitation",$params);

            if($follow_request) {
                  $response = [
                        'success' => 1,
                        'message' => 'Following request sent successfully !'
                  ];
            } else {
                  $response = [
                        'success' => 1,
                        'message' => 'Problem Found'
                  ];
            }

            echo json_encode($response);
      }



      public function get_movement_posts(){
            $user_id = $this->session->userdata('iUserId');
            if (empty($user_id)) {
                  echo json_encode(['success' => 0, 'message' => 'User ID is required.']);
                  return;
            }

            $movement_id = $this->input->get_post('movement_id');
            if (empty($movement_id)) {
                  echo json_encode(['success' => 0, 'message' => 'Movement ID is required.']);
                  return;
            }

            $page_index = $this->input->get_post('page_index') ?? 1;
            if (!is_numeric($page_index) || $page_index < 1) {
                  echo json_encode(['success' => 0, 'message' => 'Page index must be a positive number.']);
                  return;
            }

            $params = [
                  'movement_id' => $movement_id,
                  'user_id' => $user_id,
                  'page_index' => $page_index,
            ];
            $movement_details = $this->cit_api_model->callAPI("movements_post_list", $params);

            $movement_posts = [];
            foreach ($movement_details['data'] as $value) {
                  $post_id = $value['post_id'];

                  if(!empty($value['get_post_media'])) {
                        foreach($value['get_post_media'] as $post_media) {
                              $media_id = $post_media['pm_post_media_id'];
                        }
                  } else {
                        $media_id = 0;
                  }

                  if ($value['post_type'] == 'Share') {
                  $actual_post_id = $value['actual_post_id'];

                  $movement_share_post = $this->Playlist_model->get_share_post_media($actual_post_id);
                  $share_post = $this->Playlist_model->get_post_by_id($actual_post_id);
                  $user_params['user_id'] = $share_post[0]['iUserId'];
                  $user_params['profile_user_id'] = $share_post[0]['iUserId'];
                  $api_resp = $this->cit_api_model->callAPI('my_profile', $user_params);

                  if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                        throw new Exception($api_resp['settings']['message']);
                  }

                  $logged_userdata = $api_resp['data'][0];
                  $userinfo = array(
                        'u_profile_image' => $logged_userdata['u_profile_image'],
                        'u_name' => $logged_userdata['u_name'],
                        'iUserId' => $logged_userdata['u_users_id'],
                  );
                  $value['share_user_info'] = $userinfo;

                  $value['get_post_media'] = $movement_share_post;
                  $value['pm.post_text'] = $share_post[0]['tPostText'];
                  }

                  $this->db->select('*');
                  $this->db->from('post_like');
                  $this->db->where('iPostId', $post_id);
                  $this->db->where('iUserId', $user_id);
                  $this->db->where('iSysRecDeleted', 0);
                  $query = $this->db->get();
                  $movement_post_like = $query->result_array();

                  $value['is_post_like'] = !empty($movement_post_like) ? 1 : 0;


                  if($media_id != 0) {
                        $comments_params = [
                              'post_id' => $post_id,
                              'user_id' => $user_id,
                              'post_media_id' => $media_id
                        ];
                        $comments = $this->cit_api_model->callAPI("comments_list", $comments_params);
                  } else {
                        $comments_params = [
                              'post_id' => $post_id,
                              'user_id' => $user_id,
                              ];
                        $comments = $this->cit_api_model->callAPI("comments_list", $comments_params);
                  }

                  $comments_details = [];


                  foreach ($comments['data'] as $comment) {
                  $replyList_params = [
                        'post_comment_id' => $comment['post_comment_id'],
                        'post_id' => $comment['post_id'],
                        'user_id' => $this->session->userdata('iUserId'),
                  ];

                  $reply_list = $this->cit_api_model->callAPI("replies_list", $replyList_params);

                  $comment['reply_details'] = !empty($reply_list['data']) ? $reply_list['data'] : [];

                  $comments_details[] = $comment;
                  }
                  $value['comment_details'] = $comments_details;

                  $movement_posts[] = $value;
            }

            $this->smarty->assign('movements_post', $movement_posts);
            echo json_encode([
                  'success' => 1,
                  'message' => 'Posts fetched successfully.',
                  'html_content' => $this->smarty->fetch('common/movement_feedlist.tpl'),
            ]);
      }

    public function popularmovementVtwo()
    {
        $page_index = $this->input->post('page_index');
        $user_id = $this->session->userdata('iUserId');

        $params = [
            'user_id' => $user_id,
            'page_index' => $page_index,
        ];

        $this->assign_language();

        $popular_movement = $this->cit_api_model->callAPI("popular_movements", $params);

        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'iUserId' => $user_id,
        );
        $data = [
            'popularmovement' => $popular_movement['data'],
            'userinfo' => $userinfo,
            'page_type' => 'movement',
        ];
        if ($this->input->is_ajax_request()) {
            if (!empty($popular_movement['data'])) {
                $data['popularmovement'] = $popular_movement['data'];

                // echo "<pre>";
                // print_r($data['popularmovement']);
                // echo "</pre>";

                // Render the view for the new posts and send it back as HTML
                // $html = $this->smarty->fetch('application/front/movement/views/popularmovement.tpl', $data);

                $response = [
                    'success' => true,
                    'message' => 'Success',
                    'popularMovements' => $data,

                ];
                $this->skip_template_view();
                echo json_encode($response);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            $this->smarty->assign($data);
        }
    }

    public function reactMovement() {
        $user_id = $this->session->userdata('iUserId');

        $this->smarty->assign('user_id', $user_id);
        $this->smarty->assign('page_type', 'reactmovement');
        $this->smarty->display('reactmovement.tpl');
    }
}
