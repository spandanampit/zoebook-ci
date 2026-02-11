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

        $this->load->library('session');
        $this->load->model('cit_api_model');
        $this->load->library('cit_general');

        $ogTitle = $this->config->item('META_TITLE');
        $ogUrl = $this->config->item('site_url');
        $ogSiteName = $this->config->item('SITE_NAME');
        $ogImage = $this->config->item('site_url') . 'public/images/front/logo.png';
        $ogType = "website";
        $ogDescription = $this->config->item('META_DESCRIPTION');
        $this->smarty->assign('ogTitle', trim($share_ogtitle));
        $this->smarty->assign('ogUrl', $ogUrl);
        $this->smarty->assign('ogSiteName', $ogSiteName);
        $this->smarty->assign('ogImage', $ogImage);
        $this->smarty->assign('ogType', $ogType);
        $this->smarty->assign('ogDescription', trim($ogDescription));
    }

    /**
     * index method is used to initialize index function.
     */
    public function index()
    {

        $this->assign_language();
        if ($this->input->get('phpinfo')) {
            echo phpinfo();
            exit;
        }
        if ($this->session->userdata('iUserId')) {
            redirect($this->url->make('home/home/viral_posts'));
        }

        //using it until we have a proper firebase token expiriration soulution
        $this->session->sess_destroy();


        $this->smarty->assign("islandinglcass", "yes");

        // Load facebook oauth library
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
            'movement_name_menu',
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
            'sign-up',
            'sign-in',
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
            'share',
            'add_comments',
            'block_user_list',
            'learn_more',
            'your_social',
            'media_solutions',
            'home_description',
            'reach_almost',
            'every_user_in',
            '48hours',
            'filter_available_on_the_mobile_application',
            'filter_description',
            'various_kind_of',
            'features',
            'features_description',
            'chat_with_friends',
            'watch_interesting_videos',
            'watching_post',
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
            'terms_desc',
            'using_our_services',
            'service_desc_one',
            'service_desc_two',
            'service_desc_three',
            'your_acc',
            'users_create_account',
            'user_desc',
            'privecy_copyright_protection_desc',
            'privecy_copyright_protection',
            'your_content_is_our_service',
            'your_content_is_our_service_desc',
            'modifying_and_terminating_our_services',
            'modifying_and_terminating_our_services_desc',
            'warranties_and_disclaimers_desc',
            'warranties_and_disclaimers',
            'liability_for_our_services',
            'liability_for_our_services_desc',
            'ability_to_accept_terms_of_service',
            'ability_to_accept_terms_of_service_desc',
            'about_these_terms',
            'about_these_terms_desc',
            'user_license_agreement',
            'user_license_agreement_desc_one',
            'user_license_agreement_desc_two',
            'user_license_agreement_desc_three',
            'user_license_agreement_desc_four',
            'user_license_agreement_desc_five',
            'introduction',
            'introduction_desc',
            'about_us_one',
            'about_us_two',
            'about_us_three',
            'its_almost_impossible',
            'not_to_make_it_happen_in',
            'only_48_hours',
            'zoebook_is_in_all_platforms',
            'zoebook_is_in_all_platforms_desc',
            'a_quick_post_moves',
            'the_world_upward',
            'the_world_upword_desc',
            'zoebook_is_everywhere',
            'zoebook_is_everywhere_desc',
            'goal',
            'app_downloads',
            'in_five_years',
            'goal_last_desc',
            'about_us_last_desc',
            'first_name',
            'last_name',
            'child_safety_and_privacy',
        ];

        $lang = [];
        foreach ($langKeys as $key) {
            $lang[$key] = $this->lang->line($key);
        }

        $this->smarty->assign($lang);
    }

    public function aboutus()
    {
        // About us page
        $this->assign_language();
    }

    public function termsconditions()
    {
        // Terms & conditions page
        $this->assign_language();
    }

    public function privacypolicy()
    {
        // Privacy Policy Page
        $this->assign_language();
    }


    public function homepage()
    {
        // New Home page
        $this->assign_language();
        $user_id = $this->session->userdata('iUserId');
        if ($user_id) {
            redirect($this->config->item('site_url') . 'home.html');
        }
    }

    public function playlist()
    {
        $this->assign_language();

        $this->load->model('Playlist_model');
        $profile_type = $this->input->get('profile_type');
        if ($profile_type == 'user_profile') {
            $user_id = $this->input->get('user_id');
        } else {
            $user_id = $this->session->userdata('iUserId');
        }

        $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);
        if (!empty($playlist)) {
            $playlist_id = $playlist[0]['id'];
        } else {
            $this->session->set_flashdata('error', 'No playlist found for the given user.');
            redirect($_SERVER['HTTP_REFERER']); // Redirect back to the previous page
            return;
        }
        $playlist_post = $this->Playlist_model->get_playlist_post($playlist_id);
        // echo json_encode($playlist_post);die;
        $playlist_posts = array();

        foreach ($playlist_post as $value) {
            $post_id = $value['post_id'];
            $post_media = $this->Playlist_model->get_post_media($post_id);
            $post_details = $this->Playlist_model->get_post_by_id($post_id);

            foreach ($post_media as &$media) {
                if ($media['vSourceType'] == 'aws') {
                    $media['full_video_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vUploadFile'];
                    $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                } elseif ($media['vSourceType'] == 'cld') {
                    $media['full_video_url'] = $media['vCloudinary'];
                    $media['full_thumbnail_url'] = $media['vCloudinary'];
                }
                $media['post_details'] = $post_details;
                // $media['playlist_details'] = $playlist;
            }

            $playlist_posts = array_merge($playlist_posts, $post_media);
        }

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
        );

        $likeCount = $this->Playlist_model->get_playlist_likes($playlist_id, 1);
        $unlikeCount = $this->Playlist_model->get_playlist_likes($playlist_id, 0);

        $data = [
            'playlist_posts' => $playlist_posts,
            'playlist_details' => $playlist,
            'userinfo' => $userinfo,
            'likeCount' => count($likeCount),
            'unlikeCount' => count($unlikeCount),
            'u_user_id' => $user_id,
        ];
        $this->smarty->assign($data);
    }


    public function addToPlaylist()
    {
        $postId = $this->input->post('postId');
        $user_id = $this->session->userdata('iUserId');

        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in first to view posts.");
            redirect($this->config->item("site_url"));
        } else {
            if ($postId) {
                $userdata = $this->session->userdata();
                $this->load->model('Playlist_model');

                $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);

                if (count($playlist) > 0) {
                    $data = [
                        'playlist_id' => $playlist[0]['id'],
                        'post_id' => $postId,
                    ];
                    $success = $this->Playlist_model->insert_playlist_post($data);
                } else {
                    $data = array(
                        'user_id' => $user_id,
                        'name' => $userdata['vName'],
                        'created_at' => date('Y-m-d H:i:s')
                    );
                    // Call the insert_playlist method on the model
                    $create_playlist = $this->Playlist_model->insert_playlist($data);
                    if ($create_playlist) {
                        $post_data = [
                            'playlist_id' => $create_playlist,
                            'post_id' => $postId,
                        ];
                        $success = $this->Playlist_model->insert_playlist_post($post_data);
                    } else {
                        $success = false;
                    }
                }

                $message = "";
                if ($success) {
                    $message = "Video added to playlist successfully!";
                } else {
                    $message = "Error adding video to playlist.";
                }

                $response = array(
                    "success" => $success,
                    "message" => $message
                );

                echo json_encode($response);
            } else {
                $this->output->set_status_header(400);
                echo json_encode(array("message" => "Missing postId parameter"));
            }
        }
    }

    public function removePlaylistPost()
    {

        $postId = $this->input->post('postId');
        $user_id = $this->session->userdata('iUserId');

        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in first to view posts.");
            redirect($this->config->item("site_url"));
        } else {
            if ($postId) {
                $userdata = $this->session->userdata();
                $this->load->model('Playlist_model');

                $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);

                if (count($playlist) > 0) {
                    $playlist_id = $playlist[0]['id'];
                    $data = ['deleted_at' => 0];
                    $success = $this->Playlist_model->remove_playlist_post($postId, $playlist_id);
                } else {
                    $success = false;
                }

                $message = "";
                if ($success) {
                    $message = "Video added to playlist successfully!";
                } else {
                    $message = "Error adding video to playlist.";
                }

                $response = array(
                    "success" => $success,
                    "message" => $message,
                    'playlist' => $playlist,
                );

                echo json_encode($response);
            } else {
                $this->output->set_status_header(400);
                echo json_encode(array("message" => "Missing postId parameter"));
            }
        }
    }

    public function playlistshare()
    {
        $this->load->model('Playlist_model');
        $this->assign_language();
        $playlistId = isset($_GET['playlistId']) ? $_GET['playlistId'] : null;
        $userId = isset($_GET['userId']) ? $_GET['userId'] : null;
        $playlist = $this->Playlist_model->get_playlists_by_userId($userId);
        if (!empty($playlist) && $playlistId > 0) {
            $playlist_id = $playlistId;
        } else {
            $this->session->set_flashdata('error', 'No playlist found for the given user.');
            redirect($_SERVER['HTTP_REFERER']); // Redirect back to the previous page
            return;
        }
        $user = $this->Playlist_model->playlist_user($userId);
        // print_r($user);
        // die;
        $playlist_post = $this->Playlist_model->get_playlist_post($playlist_id);
        $playlist_posts = array();

        foreach ($playlist_post as $value) {
            $post_id = $value['post_id'];
            $post_media = $this->Playlist_model->get_post_media($post_id);
            $post_details = $this->Playlist_model->get_post_by_id($post_id);

            foreach ($post_media as &$media) {
                if ($media['vSourceType'] == 'aws') {
                    $media['full_video_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vUploadFile'];
                    $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                } elseif ($media['vSourceType'] == 'cld') {
                    $media['full_video_url'] = $media['vCloudinary'];
                    $media['full_thumbnail_url'] = $media['vCloudinary'];
                }
                $media['post_details'] = $post_details;
                // $media['playlist_details'] = $playlist;
            }

            $playlist_posts = array_merge($playlist_posts, $post_media);
        }



        $followers = $this->Playlist_model->get_followers($userId, 'iFollowerId');
        $following = $this->Playlist_model->get_followers($userId, 'iUserId');
        // print_r($flowers);
        $user[0]['followers'] = count($followers);
        $user[0]['following'] = count($following);

        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => $userdata['vProfileImage'],
            'u_name' => $userdata['vName']
        );

        $params['user_id'] = $userId;
        $params['profile_user_id'] = $userId;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
        );

        $postedUserId = $user[0]['iUsersId'];
        $all_posts = [];
        foreach ($playlist_posts as $value) {
            $post_id = $value['iPostId'];
            $params = [
                'post_id' => $post_id,
                'user_id' => $postedUserId,
            ];
            $comments = $this->cit_api_model->callAPI('comments_list', $params);
            $value['statistics']['comments']  = $comments;

            $all_posts[] = $value;
        }

        $data = [
            'playlist_posts' => $all_posts,
            'user' => $user,
            'userinfo' => $userinfo,
        ];

        // print_r($data);
        $this->smarty->assign($data);
    }

    public function playlistLike()
    {
        $likeId = $this->input->post('likeId');
        $playlistId = $this->input->post('playlistId');
        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in first to view posts.");
            redirect($this->config->item("site_url"));
        } else {
            if ($likeId) {
                $userdata = $this->session->userdata();
                $this->load->model('Playlist_model');

                $data = [
                    'user_id' => $user_id,
                    'playlist_id' => $playlistId,
                    'like_id' => $likeId,
                ];
                $playlist_like = $this->Playlist_model->like_playlist($data);
                // $playlist_like = true;
                if ($playlist_like) {
                    // console . log('hello');
                    $newLikeCount = $this->Playlist_model->get_playlist_likes($playlistId, 1);
                    $unlikeCount = $this->Playlist_model->get_playlist_likes($playlistId, 2);
                    // echo json_encode(array('success' => true, 'newLikeCount' => count($newLikeCount), 'unlikeCount'=> count($unlikeCount), 'message'=> 'success'));
                    $response = array(
                        "success" => $playlist_like,
                        "message" => 'Playlist Like successfully',
                        "newLikeCount" => count($newLikeCount),
                        "unlikeCount" => count($unlikeCount),
                        "likeId" => $likeId,
                        "data" => $data['user_id'],
                    );
                } else {
                    $response = array(
                        "success" => $playlist_like,
                        "message" => 'Playlist Like Faield',
                    );
                }
                echo json_encode($response);
            } else {
                $this->output->set_status_header(400);
                echo json_encode(array("message" => "Missing postId parameter"));
            }
        }
    }

    public function watchvideo()
    {
        $this->assign_language();

        $user = $this->session->userdata('iUserId');
        if ($user == null) {
            $user_id = 1;
        } else {
            $user_id = $user;
        }

        $this->load->model('Playlist_model');
        $params = array(
            "user_id" => $user_id,
            "is_ads_show" => 1,
        );
        $vp_posts = $this->cit_api_model->callAPI("viral_plus_media_list", $params);

        $vp_videos = [];
        $vp_plus_posts = [];

        foreach ($vp_posts['data'] as $value) {

            $post_id = $value['post_id'];
            $viws = $value['views_count'];
            $post_media = $this->Playlist_model->get_post_media($post_id);
            $post_details = $this->Playlist_model->get_post_by_id($post_id);
            $value['post_details'] = $post_details;
            $vp_plus_posts['data'][] = $value;

            if ($value['media_type'] == 'Video') {
                $vp_videos[] = $value;
            }

            foreach ($post_media as &$media) {
                if ($media['vSourceType'] == 'aws') {
                    $media['full_video_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vUploadFile'];
                    $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                } elseif ($media['vSourceType'] == 'cld') {
                    $media['full_video_url'] = $media['vCloudinary'];
                    $media['full_thumbnail_url'] = $media['vCloudinary'];
                }
                $media['post_details'] = $post_details;
                // $media['playlist_details'] = $playlist;
            }
            $value['data'] = array_merge($vp_posts['data'], $post_media);
        }

        usort($vp_videos, function ($a, $b) {
            return $b['views_count'] - $a['views_count'];
        });
        $most_views_video = $vp_videos;

        usort($vp_videos, function ($a, $b) {
            $dateA = strtotime($a['added_date']);
            $dateB = strtotime($b['added_date']);
            return $dateB - $dateA;
        });
        $recent_videos = $vp_videos;

        shuffle($vp_videos);
        $random_video = $vp_videos;

        // $userdata = $this->session->userdata();
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
            // 'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        );
        // $userinfo = array(
        //     'u_profile_image' => $userdata['vProfileImage'],
        //     'u_name' => $userdata['vName']
        // );

        // print_r($most_views_video);
        // die;
        $data = [
            'most_views_video' => $most_views_video,
            'userinfo' => $userinfo,
            'recent_videos' => $recent_videos,
            'vp_video' => $random_video,
        ];
        $this->smarty->assign($data);
    }

    public function contactus()
    {
        $this->assign_language();
        $postArr  = $_POST;

        if ($postArr) {
            try {
                if (isset($_POST['g-recaptcha-response'])) {
                    $captcha = $_POST['g-recaptcha-response'];
                }
                if (!$captcha) {
                    throw new Exception("Please check the the captcha form.");
                }

                $secretKey = $this->config->item('GOOGLE_CAPTCHA_SECRET_KEY');
                $url =  'https://www.google.com/recaptcha/api/siteverify?secret=' . urlencode($secretKey) . '&response=' . urlencode($captcha);
                $response = file_get_contents($url);
                $responseKeys = json_decode($response, true);
                if ($responseKeys["success"]) {
                    $params = array();
                    $params['name'] = $postArr['vContactName'];
                    $params['email'] = $postArr['vContactEmail'];
                    $params['message_text'] = $postArr['vContactMessage'];
                    $api_resp = $this->cit_api_model->callAPI("contact_us_submit", $params);

                    if ($api_resp['settings']['success'] == '1') {
                        $this->session->set_flashdata('success', $api_resp['settings']['message']);
                    } else {
                        throw new Exception($api_resp['settings']['message']);
                    }

                    $redirect_url = $this->config->item('site_url') . "contactus.html";
                    redirect($redirect_url);
                } else {
                    throw new Exception("Invalid Request");
                }
            } catch (Exception $e) {
                $var_msg = $e->getMessage();
                $this->session->set_flashdata('failure', $var_msg);
                redirect($this->config->item("site_url") . "contactus.html");
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

    public function chat()
    {
        $render_arr = array();
        $render_arr['token'] = $this->session->userdata('firebase_token');
        $render_arr['username'] = $this->session->userdata('vName');
        $render_arr['email'] = $this->session->userdata('vEmail');
        $render_arr['profile_image'] = $this->session->userdata('vProfileImage');
        $render_arr['user_id'] = $this->session->userdata('iUserId');
        $this->smarty->assign($render_arr);
    }

    public function get_users()
    {
        $term = $this->input->post('term');
        $exclude_arr = $this->input->post('exclude');
        $params = array(
            'keyword' => $term,
            'user_id' => $this->session->userdata('iUserId'),
        );
        if (count($exclude_arr) > 0) {
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
        echo json_encode($final_arr);
        exit;
    }

    public function get_user_profile()
    {
        $params = array(
            'user_id' => $this->input->post('user_id'),
            'profile_user_id' => $this->input->post('profile_user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("my_profile", $params);
        $final_arr = array();
        if ($api_resp['settings']['success'] == '1') {
            $final_arr = $api_resp['data'];
        }
        echo json_encode($final_arr);
        exit;
    }

    public function set_follow_accept_reject_cancel()
    {
        $params = array(
            'user_follow_request_id' => $this->input->post('user_follow_request_id'),
            'status' => 'Deleted',
            'user_id' => $this->input->post('user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("follow_accept_reject_cancel", $params);
        echo json_encode($api_resp);
        exit;
    }

    public function follow_user()
    {
        $params = array(
            'following_user_id' => $this->input->post('following_user_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("follow_request", $params);
        echo json_encode($api_resp);
        exit;
    }

    public function unfollow_user()
    {
        $params = array(
            'following_user_id' => $this->input->post('following_user_id'),
            'user_id' => $this->input->post('user_id'),
        );
        $api_resp = $this->cit_api_model->callAPI("unfollow_user", $params);
        echo json_encode($api_resp);
        exit;
    }

    public function setUserTimezone()
    {
        $user_timezone = $this->input->post('timezoneval');
        $this->session->set_userdata('user_timezone', $user_timezone);
        exit;
    }

    public function otherEmail()
    {
        // Load the email library
        $this->load->library('email');

        // Define the SMTP configuration
        $config = array(
            // 'protocol' => 'smtp',
            'smtp_host' => 'smtp://sandbox.smtp.mailtrap.io',
            'smtp_port' => 465,
            'smtp_user' => '1e65f00aa246bc',
            'smtp_pass' => 'a25312f49bf57f',
            // 'charset'   => 'utf-8',
            // 'wordwrap'  => TRUE,
            // 'smtp_crypto' => 'ssl' // 'tls' or 'ssl'
        );

        // Initialize the email library with the SMTP configuration
        $this->email->initialize($config);

        // Set email parameters
        $this->email->from('info@zoebook.com', 'Zoebook');
        $this->email->to('provat.das@brainiuminfotech.com');
        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        // Send the email
        if (!$this->email->send()) {
            // Show error if email sending failed
            show_error($this->email->print_debugger());
        } else {
            // Success message
            echo "Email sent successfully!";
        }
    }

    public function get_comments($param = array())
    {
        $postId = $this->input->get('post_id');
        $user_id = $this->session->userdata('iUserId');

        $params = [
            'post_id' => $postId,
            'user_id' => $user_id,
        ];
        $comments = $this->cit_api_model->callAPI('comments_list', $params);
        echo json_encode($comments);
        exit;
    }

    public function add_comments()
    {
        $user_id = $this->session->userdata('iUserId');
        $postId = $this->input->post('post_id');
        $comment = $this->input->post('comment');

        if (empty($comment)) {
            $response = [
                'status' => 'error',
                'message' => 'content required'
            ];
            echo json_encode($response);
            exit;
        }

        $params = [
            'comment' => $comment,
            'post_id' => $postId,
            'user_id' => $user_id,
        ];
        $playlistComment = $this->cit_api_model->callAPI("comment_on_post", $params);
        if ($playlistComment) {
            $response = [
                'status' => 'success',
            ];
        } else {
            $response = [
                'status' => 'error',
            ];
        }
        echo json_encode($response);
    }

    public function search_peoples()
    {
        $user_id  = $this->session->userdata('iUserId');
        $keyword  = $this->input->get_post('keyword');
        $exclude  = $this->input->get_post('exclude');

        if (!$keyword) {
            $response = [
                'status' => 'error',
                'message' => 'keyword required'
            ];
            echo json_encode($response);
            exit;
        }

        $params = [
            'user_id' => $user_id,
            'keyword' => $keyword,
            'exclude' => $exclude
        ];

        $search_results = $this->cit_api_model->callAPI("search_friends", $params);

        $api_url = 'https://zoebook.mydevfactory.com/WS/search_post?keyword=' . urlencode($keyword);
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        $search_posts = json_decode(curl_exec($ch));

        if ($search_posts && !empty($search_posts)) {
            foreach ($search_posts as &$posts) {
                $posts->post_url = 'https://zoebook.mydevfactory.com/post-detail-' . $posts->iPostId . '.html';
            }
        }

        if ($search_results && !empty($search_results['data'])) {
            foreach ($search_results['data'] as &$user) {
                $user['profile_url'] = $this->general->setdiplayprofileurl($user['u_users_id'], $user['u_name']);
            }
        }

        if ($search_results) {
            $response = [
                'status' => 'success',
                'data' => $search_results,
                "posts" => $search_posts
            ];
        } else {
            $response = [
                'status' => 'success',
                'data' => ''
            ];
        }
        echo json_encode($response);
    }

    public function about()
    {
        $this->assign_language();
        $profile_type = $this->input->get('page_type');

        if ($profile_type == 'user_profile') {
            $user_id = $this->input->get('user_id');
        } else {
            $user_id = $this->session->userdata('iUserId');
        }

        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $userdata = $api_resp['data'][0];

        if (!$this->checkUserPageExist($user_id)) {
            redirect($this->url->make('content/content/aboutform'));
        }

        $data = $this->getAboutUserData($user_id);
        if (!empty($data[0]['eSliderImage'])) {
            $sliderImages = json_decode($data[0]['eSliderImage'], true);
            $defaultImage = "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070&auto=format&fit=crop";

            for ($i = 0; $i < 3; $i++) {
                if (!empty($sliderImages[$i])) {
                    $imagePath = "https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/{$user_id}/{$sliderImages[$i]}";
                } else {
                    $imagePath = $defaultImage;
                }
                $this->smarty->assign('sliderImage' . $i, $imagePath);
            }
        } else {
            $defaultImage = "https://images.unsplash.com/photo-1600585154340-be6161a56a0c?q=80&w=2070&auto=format&fit=crop";
            for ($i = 0; $i < 3; $i++) {
                $this->smarty->assign('sliderImage' . $i, $defaultImage);
            }
        }


        $about_data = [
            'page_data' => $data,
        ];

        $this->smarty->assign('userinfo', $userdata);
        $this->smarty->assign('pl_userId', $user_id);
        $this->smarty->assign($about_data);
        $this->smarty->assign('profiletype', $profile_type);
    }

    public function aboutform()
    {
        $this->assign_language();
        $form_type = $this->input->get('form-type');

        if ($form_type == 'edit') {
            $user_id = $this->input->get('user_id');
            $data = $this->getAboutUserData($user_id);

            $about_data = [
                'page_data' => $data,
            ];
            $this->smarty->assign($about_data);
        }
    }

    public function getAboutUserData($user_id)
    {
        $this->db->select('*');
        $this->db->from('about_user');
        $this->db->where('iUserId', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function editAboutUser()
    {
        $user_id = $this->session->userdata('iUserId');
        $data = $this->getAboutUserData($user_id);

        $about_data = [
            'page_data' => $data,
        ];

        $this->smarty->assign($about_data);
    }

    public function checkUserPageExist($user_id)
    {
        $this->db->select('*');
        $this->db->from('about_user');
        $this->db->where('iUserId', $user_id);

        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return true;
        } else {
            return false;
        }
    }


    public function  addUserPage()
    {
        $user_id = $this->session->userdata('iUserId');

        $data = array(
            'iUserId'              => $user_id,
            'userQuestion'         => $this->input->post('who_am_i_title', true),
            'userAnswer'           => $this->input->post('who_am_i_text', true),
            'importantPeopleTitle' => $this->input->post('important_people_title', true),
            'peopleOneTitle'       => $this->input->post('person_name_1', true),
            'peopleTwoTitle'       => $this->input->post('person_name_2', true),
            'peopleThreeTitle'     => $this->input->post('person_name_3', true),
            'peopleFourTitle'      => $this->input->post('person_name_4', true),
            'InstaUrl'             => $this->input->post('instagram_link', true),
            'ytUrl'                => $this->input->post('youtube_link', true),
            'fbUrl'                => $this->input->post('facebook_link', true),
            'xUrl'                 => $this->input->post('x_link', true),
            'linkedinUrl'          => $this->input->post('linkedin_link', true),
            'phoneNumber'          => $this->input->post('phone_number', true),
            'address'              => $this->input->post('address', true)
        );

        if ($_FILES != '') {
            for ($i = 1; $i <= 4; $i++) {
                $input_name = 'person_image_' . $i;
                $db_column  = 'people' . $this->numberToWord($i) . 'Image';
                $thumbnail_input_name = 'thumbnail-image-' . $i;

                if (isset($_FILES[$input_name]) && $_FILES[$input_name]['error'] === 0 && !empty($_FILES[$input_name]['tmp_name']) && !empty($_FILES[$input_name]['name'])) {
                    $tmp_path  = $_FILES[$input_name]['tmp_name'];
                    $file_name = time() . '_' . $_FILES[$input_name]['name'];
                    $aws_path  = "compress_post_video/" . trim($user_id);

                    $aws_result = $this->general->uploadAWSData($tmp_path, $aws_path, $file_name);

                    if ($aws_result && $aws_result->get('ObjectURL')) {
                        $data[$db_column] = $file_name;
                    }

                    @unlink($tmp_path);
                }
            }

            $thumbnails = [];
            for ($i = 1; $i <= 3; $i++) {
                $thumbnail_input_name = 'thumbnail-image-' . $i;

                if (isset($_FILES[$thumbnail_input_name]) && $_FILES[$thumbnail_input_name]['error'] === 0 && !empty($_FILES[$thumbnail_input_name]['tmp_name']) && !empty($_FILES[$thumbnail_input_name]['name'])) {
                    $tmp_path  = $_FILES[$thumbnail_input_name]['tmp_name'];
                    $file_name = time() . '_' . $_FILES[$thumbnail_input_name]['name'];
                    $aws_path  = "compress_post_video/" . trim($user_id);

                    $aws_result = $this->general->uploadAWSData($tmp_path, $aws_path, $file_name);

                    if ($aws_result && $aws_result->get('ObjectURL')) {
                        $thumbnails[] = $file_name;
                    }

                    @unlink($tmp_path);
                }
            }

            if (!empty($thumbnails)) {
                $data['eSliderImage'] = json_encode($thumbnails);
            }
        }

        $existing = $this->db->get_where('about_user', array('iUserId' => $user_id))->row();

        if ($existing) {
            $this->db->where('iUserId', $user_id);
            $this->db->update('about_user', $data);
        } else {
            $this->db->insert('about_user', $data);
        }

        redirect($this->url->make('content/content/about'));
    }

    public function numberToWord($num)
    {
        $words = [1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four'];
        return isset($words[$num]) ? $words[$num] : '';
    }
}
