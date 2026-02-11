<?php

defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Home Controller
 *
 * @category front
 *
 * @package home
 *
 * @subpackage controllers
 *
 * @module Home
 *
 * @class Home.php
 *
 * @path application\front\home\controllers\Home.php
 *
 * @version 4.0
 *
 * @author CIT Dev Team
 *
 * @since 03.26.2020
 */
class Home extends Cit_Controller
{

    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->load->model('cit_api_model');
        $this->load->library('cit_general');
        $this->load->library('cloudinarylib');
        $this->load->model('Playlist_model');
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
            'movement_name_menu',
            'block_user_list',
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
        $this->load->model('Playlist_model');
        $this->assign_language();

        try {
            $user_id = $this->session->userdata('iUserId');

            if (!$user_id) {
                $this->session->set_flashdata('failure', "Please log in first to view posts.");
                redirect($this->config->item("site_url"));
            }
             //----------changes--------------//
            $notification_api = $this->cit_api_model->callAPI('user_notifications_list', array("user_id" => $user_id));
            // $notifications = array();
            // if (is_array($notification_api['data']) && count($notification_api['data']) > 0) {
            //       $notifications = array_filter($notification_api['data'], function ($notification) {
            //             return isset($notification['is_read']) && $notification['is_read'] === 'YES';
            //       });
            // }

            $notifications = array();
            if (is_array($notification_api['data']) && count($notification_api['data']) > 0) {
                  $notifications = $notification_api['data'];
            }

            $block_users_api = $this->cit_api_model->callAPI('blocked_user_list', array("user_id" => $user_id));
            $block_users = array();
            if (is_array($block_users_api['data']) && count($block_users_api['data']) > 0) {
                $block_users = $block_users_api['data'];
            }
            $this->smarty->assign('blockuser', $block_users);
            $this->smarty->assign('notifications', $notifications);
            $this->smarty->assign('total_notification', count($notifications));

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;
            $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
            
            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($api_resp['settings']['message']);
            }

            $logged_userdata = $api_resp['data'][0];
            $userdata = $this->session->userdata();

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;

            $userinfo = array(
                // 'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
                'u_profile_image' => $logged_userdata['u_profile_image'],
                'u_name' => $userdata['vName'],
                'u_userid' => $userdata['iUsersId'],
            );
            $this->smarty->assign('userinfo', $userinfo);
            $this->smarty->assign('pl_userId', $user_id);
            $this->smarty->assign('profile_type', 'current_profile');

            $params = array(
                "user_id" => $user_id,
                "profile_user_id" => $user_id,
                "is_feed" => 1,
                "page_index" => 1,
            );
            $api_resp = $this->getPosts($params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $current_page = $api_resp['settings']['curr_page'];
            $next_page = $api_resp['settings']['next_page'];
            $posts_org_data = $api_resp['data'];

            $posts_data = $this->getStatistics($posts_org_data);

            $render_arr['posts'] = $posts_data;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "feed";
            foreach ($render_arr['posts'] as $key => &$value) {
                if ($value['post_type'] == 'Share') {
                    $actual_post_id = $value['actual_post_id'];
                    $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                }
            }
            unset($value);


            $this->smarty->assign($render_arr);

            $top_playlists = $this->Playlist_model->top_playlist();
            $data = [
                'playlist_post' => $top_playlists,
            ];

            $this->smarty->assign($data);

            $this->assign_language();
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $code = $e->getCode();
        }
    }


    public function getPosts($params)
    {
        if ($this->input->is_ajax_request()) {
            $user_id = $this->session->userdata('iUserId');
            $page_type = $this->input->get("page_type");
            $params = array(
                "user_id" => $user_id,
                "profile_user_id" => $user_id,
                "is_feed" => 1,
                "page_index" => $this->input->get("nxpg")
            );
        } else {
            if ($params['is_viral'] == "Yes") {
                $page_type = "viral";
            } else if ($params['is_HidePost'] == "Yes") {
                $page_type = "HidePost";
            }
        }
        if ($page_type == "viral") {
            unset($params['profile_user_id']);
            unset($params['is_feed']);
            $params['device_type'] = "web";

            $api_resp = $this->cit_api_model->callAPI("viral_post_list", $params);
            // $api_resp = $this->cit_api_model->callAPI("post_list", $params);

        } else if ($page_type == "HidePost") {
            // echo 'hidepost';
            unset($params['profile_user_id']);
            unset($params['is_feed']);
            $api_resp = $this->cit_api_model->callAPI("hide_post_list", $params);
        } else {
            // echo "my_profile";
            if ($page_type == "my_profile") {
                $params['is_feed'] = 0;
            } else if ($page_type == "other_profile") {
                $params['profile_user_id'] = $this->input->get("other_user_id");
                $params['is_feed'] = 0;
            }
            $params['device_type'] = "web";
            // pr($params,1);
            $api_resp = $this->cit_api_model->callAPI("post_list", $params);
        }
        /* if ($api_resp['settings']['success'] == 0) {
            throw new Exception($api_resp['settings']['message']);
        } */
        if (!$this->input->is_ajax_request()) {
            return $api_resp;
        }

        $current_page = $api_resp['settings']['curr_page'];
        $next_page = $api_resp['settings']['next_page'];
        $posts_org_data = $api_resp['data'];
        $posts_data = $this->getStatistics($posts_org_data);
        $render_arr['posts'] = $posts_data;
        $render_arr['posts_pgtype'] = $page_type;
        $this->skip_template_view();
        if ($page_type == "HidePost") {
            $return_array["posts_data"] = $this->parser->parse("common/hide_list.tpl", $render_arr, true);
        } else {
            $return_array["posts_data"] = $this->parser->parse("common/feed_list.tpl", $render_arr, true);
        }
        $return_array["cr_pg"] = $current_page;
        $return_array["nx_pg"] = $next_page;



        $response = array(
            'message' => 'success',
            'type' => 'post',
        );
        echo json_encode($response);
        exit;
    }

    public function getStatistics($posts_data)
    {
        $user_id = $this->session->userdata('iUserId');
        // die;
        for ($i = 0; $i < count($posts_data); $i++) {
            $post_item = $posts_data[$i];
            $post_type = $post_item["post_type"];
            if ($post_type == 'Share') {
                $post_id = $post_item["actual_post_id"];
            } else {
                $post_id = $post_item["post_id"];
            }
            // $post_id = $post_item["post_id"];
            $post_meta_data = array();
            /* $comments_params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
                ); */
            if ($post_type == "Media") {

                $postdetail_params['post_id'] = $post_id;
                $postdetail_params['user_id'] = $user_id;
                $postdetail_resp = $this->cit_api_model->callAPI('post_detail', $postdetail_params);

                $postdetail_media = $postdetail_resp['data']['get_post_media'][0];



                $media_id = $postdetail_media['post_media_id'];
                $likes_count = $postdetail_media['total_likes_count'];
                // $comment_count = $postdetail_media['total_comments_count'];
                $comment_count = $post_item['comment_count'];
                $is_like = $post_item['is_like'];


                //$comments_params = array_merge($comments_params, array('post_media_id' => $media_id));
                // echo "Media";
            } else if ($post_type == "Share") {
                $post_metadata = $post_item['get_actual_post']["p_post_meta_data"];
                // print_r($post_item['get_actual_post']);
                $post_meta_data = array();
                if (trim($post_metadata) != "") {
                    $post_metadata_arr = json_decode($post_metadata, true);
                    $post_meta_data = array(
                        "link" => $post_metadata_arr['link'],
                        "title" => $post_metadata_arr['title'],
                        "image" => $post_metadata_arr['image'],
                        "text" => $post_metadata_arr['text']
                    );
                }
                $likes_count = $post_item['get_actual_post']['p_likes_count'];
                $comment_count = $post_item['get_actual_post']['comment_count'];
                $is_like = $post_item['get_actual_post']['is_like'];
                // echo "Share";
            } else {
                if ($post_type == "Text") {
                    $post_metadata = $post_item["p_post_meta_data"];
                    $post_meta_data = array();
                    if (trim($post_metadata) != "") {
                        $post_metadata_arr = json_decode($post_metadata, true);
                        $post_meta_data = array(
                            "link" => $post_metadata_arr['link'],
                            "title" => $post_metadata_arr['title'],
                            "image" => $post_metadata_arr['image'],
                            "text" => $post_metadata_arr['text']
                        );
                    }
                }
                $likes_count = $post_item['likes_count'];
                $comment_count = $post_item['comment_count'];
                $is_like = $post_item['is_like'];
                // echo "Text";
            }


            // die;
            //$comments_api_resp = $this->cit_api_model->callAPI("comments_list", $comments_params);
            //$comments_data = $comments_api_resp['data'];
            $comments_data = array();
            $posts_data[$i]['statistics'] = array(
                "likes_count" => $likes_count,
                "comments_count" => $comment_count,
                "is_like" => $is_like,
                "comments" => $comments_data
            );
            $posts_data[$i]['post_metadata'] = $post_meta_data;
        }

        return $posts_data;
    }

    public function post_detail($post_id = 0)
    {

        $user_id = $this->session->userdata('iUserId');
        $userdata = $this->session->userdata();
        $pageType = $this->input->get('pageType');
        $userId = $this->input->get('userId');
        if (!$user_id) {
            //$this->session->set_flashdata('failure', "Please log in to view post.");
            //redirect($this->config->item("site_url"));
            $user_id = 0;
        }

        // $userinfo = array(
        //     'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
        //     'u_name' => $userdata['vName']
        // );

        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];
        // $userdata = $this->session->userdata();
        $userinfo = array(
            // 'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        );

        $this->smarty->assign('userinfo', $userinfo);
        if (!$user_id) {
            //$this->session->set_flashdata('failure', "Please log in to view post.");
            //redirect($this->config->item("site_url"));
            $user_id = 0;
        }
        $this->assign_language();

        try {
            if (trim($post_id) != "") {
                // $post_id = $this->general->decryptDataMethod($post_id, "base64"); //base64
            }

            $this->smarty->assign('mainpostid', $post_id);

            if ($this->input->is_ajax_request()) {
                $inputparamarr = $this->input->get_post();
                $post_id = $inputparamarr['posted_postid'];
                $posted_mediaid = $inputparamarr['posted_mediaid'];
            }
            if (isset($post_id) && $post_id != '') {
                $params['post_id'] = $post_id;
                $params['user_id'] = $user_id;
                $api_resp = $this->cit_api_model->callAPI('post_detail', $params);

            //     echo json_encode($api_resp);die;

                //pr($api_resp);exit;

                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception($api_resp['settings']['message']);
                }

                $postdata = $api_resp['data'];
                $postmedia = $api_resp['data']['get_post_media'];
                $params_f['user_id'] = $user_id;
                $params_f['profile_user_id'] = $postdata['posted_user_id'];
                $api_respf = $this->cit_api_model->callAPI('my_profile', $params_f);

                $record_f = $api_respf['data'][0];
                $this->smarty->assign('followerinfo', $record_f);

                $share_ogtitle = "Zoebook";
                $ogTitle = $postdata['post_text'];
                if (trim($ogTitle) != "") {
                    $ogtitle_arr = explode('\u', $ogTitle);
                    if (isset($ogtitle_arr[0]) && trim($ogtitle_arr[0]) != "") {
                        $share_ogtitle = $ogtitle_arr[0];
                    }
                }
                $ogUrl = $this->general->setdiplayposturl($post_id, $postdata['post_text']);
                // pr($postmedia[0],1);
                $meta_info['other'] = array();

                if ($postmedia[0]['pm_media_type'] == 'Video') {
                    $ogImage1 = $postmedia[0]['pm_video_thumbnail'];
                    // print_r($ogImage1);
                    $og_divide_url = explode("/", $ogImage1);
                    // $ogImage = "https://d1ap1pbk3mm4im.cloudfront.net/" . $og_divide_url[3] . '/' . $postmedia[0]['pm_user_id'] . '/' . $og_divide_url[4];
                    $ogImage = $ogImage1;
                    $ogType = "video.other";
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:video', "content" => $postmedia[0]['upload_file']);
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:video:secure_url', "content" => $postmedia[0]['upload_file']);
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:video:width', "content" => $postmedia[0]['pm_media_width']);
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:video:height', "content" => $postmedia[0]['pm_media_height']);
                } else {
                    $ogImage = $postmedia[0]['display_image'];
                    $ogType = "website";
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:image', "content" => $postmedia[0]['display_image']);
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:image:secure_url', "content" => $postmedia[0]['display_image']);
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:image:width', "content" => $postmedia[0]['pm_media_width']);
                    $meta_info['other'][] = array("key" => "property", "value" => 'og:image:height', "content" => $postmedia[0]['pm_media_height']);
                }

                $ogSiteName = $this->config->item('SITE_NAME');

                $ogDescription = $postdata['post_text'];
                $this->smarty->assign('ogTitle', trim($share_ogtitle));
                $this->smarty->assign('ogUrl', $ogUrl);
                $this->smarty->assign('ogSiteName', $ogSiteName);
                $this->smarty->assign('ogImage', $ogImage);
                $this->smarty->assign('ogType', $ogType);
                $this->smarty->assign('ogDescription', trim($share_ogtitle));
                $this->smarty->assign('meta_info', $meta_info);


                $mediaid = 0;
                $commentcount = $postdata['comment_count'];
                $likescount = $postdata['likes_count'];
                $viewcount = $postdata['impression_count'];
                $islike = $postdata['is_like'];

                if ($this->input->is_ajax_request() && $posted_mediaid != 0) {
                    $res_media_key = array_search($posted_mediaid, array_column($postmedia, 'post_media_id'), true);

                    $mediaid = $postmedia[$res_media_key]['post_media_id'];
                    $params['post_media_id'] = $postmedia[$res_media_key]['post_media_id'];

                    $commentcount = $postmedia[$res_media_key]['total_comments_count'];
                    $likescount = $postmedia[$res_media_key]['total_likes_count'];
                    $viewcount = $postmedia[$res_media_key]['pm_views_count'];
                    $islike = $postmedia[$res_media_key]['is_liked'];
                } else if (count($postmedia) > 0) {
                    $mediaid = $postmedia[0]['post_media_id'];
                    $params['post_media_id'] = $postmedia[0]['post_media_id'];

                    $commentcount = $postmedia[0]['total_comments_count'];
                    $likescount = $postmedia[0]['total_likes_count'];
                    $viewcount = $postmedia[0]['pm_views_count'];
                    $islike = $postmedia[0]['is_liked'];
                }

                if (($this->input->is_ajax_request() && $posted_mediaid != 0) || count($postmedia) > 0) {
                    /* increase impression count */
                    $paramsview['iPostMediaId'] = $mediaid;
                    $paramsview['user_id'] = $user_id;
                    $api_resp_view = $this->cit_api_model->callAPI('update_media_view_count', $paramsview);
                    /* end code */
                } else {
                    $paramsview['user_id'] = $user_id;
                    $api_resp_view = $this->cit_api_model->callAPI('update_impression_count', $params);
                }
                  //changes here

                $comment_api_resp1 = $this->cit_api_model->callAPI('comments_list', $params);
                $comments1 = isset($comment_api_resp1['data']) ? $comment_api_resp1['data'] : [];
                $params['post_media_id'] = 0;
                $comment_api_resp2 = $this->cit_api_model->callAPI('comments_list', $params);
                $comments2 = isset($comment_api_resp2['data']) ? $comment_api_resp2['data'] : [];
                $all_comments = array_merge($comments1, $comments2);

                $unique_comments = [];
                foreach ($all_comments as $comment) {
                  $unique_comments[$comment['post_comment_id']] = $comment;
                }

                usort($unique_comments, function ($a, $b) {
                    return $b['post_comment_id'] <=> $a['post_comment_id'];
                });

                $postcomment = $unique_comments;   


                if ($this->input->is_ajax_request()) {

                    $render_arr['postinfo'] = $postdata;
                    $render_arr['postcomment'] = $postcomment;
                    $render_arr['islike'] = $islike;
                    $render_arr['viewcount'] = $viewcount;
                    $render_arr['likescount'] = $likescount;
                    $render_arr['commentcount'] = $commentcount;
                    $render_arr['mediaid'] = $mediaid;
                    $return_array["post_data"] = $this->parser->parse("common/common_postdetail.tpl", $render_arr, true);
                    $return_array['status'] = "Success";

                    echo json_encode($return_array);
                    exit;
                } else {
                    /* display other post of the user */
                    if ($pageType == 'Profile') {
                        $params['is_feed'] = 1;
                        $params['profile_user_id'] = $postdata['posted_user_id'];
                        $params['user_id'] = $userId;
                        $api_resp_myProfile = $this->cit_api_model->callAPI('post_list', $params);

                        $otherpost = $api_resp_myProfile['data'];

                        $all_media = [];
                        foreach ($otherpost as $post) {
                              if (isset($post['get_post_media'][0]['pm_media_type'])) {
                                    if ($post['get_post_media'][0]['pm_media_type'] == 'Video') {
                                          $all_media[] = array(
                                          'is_following' => 0,
                                          'pending_request_id' => '',
                                          'um_mheight' => $post['get_post_media'][0]['media_height'] ?? null,
                                          'um_mwidth' => $post['get_post_media'][0]['media_width'] ?? null,
                                          'p_post_id' => $post['post_id'],
                                          'p_user_id' => $post['posted_user_id'],
                                          'p_post_type' => $post['post_type'],
                                          'p_post_text' => $post['post_text'],
                                          'p_added_date' => $post['added_date'],
                                          'is_like' => $post['is_like'],
                                          'u_name' => $post['user_name'],
                                          'u_profile_image' => $post['user_profile_image'],
                                          'p_status' => $post['status'],
                                          'p_actual_post_id' => $post['actual_post_id'],
                                          'ts_tokbox_session_id' => $post['tokbox_session_id'],
                                          'expire_date' => $post['expire_date'],
                                          'p_visibility' => $post['visibility'],
                                          'p_impression_count' => $post['impression_count'],
                                          'is_impressed' => $post['is_impressed'],
                                          'comment_count' => $post['comment_count'],
                                          'likes_count' => $post['likes_count'],
                                          'shared_count' => $post['shared_count'],
                                          'um_upload_file' => '',
                                          'um_media_type' => $post['get_post_media'][0]['pm_media_type'] ?? '',
                                          'views_count' => $post['get_post_media'][0]['pm_views_count'] ?? 0,
                                          'post_media_id' => $post['get_post_media'][0]['pm_post_media_id'] ?? null,
                                          'is_view' => $post['get_post_media'][0]['is_viewed'] ?? 0,
                                          'post_detail_url' => $post['post_detail_url'],
                                          'p_video_thumbnail' => $post['get_post_media'][0]['pm_video_thumbnail'] ?? $post['live_video_thumbnail'],
                                          'page_type' => 'profile',
                                          );
                                    }
                              }
                        }
                    } else {
                        $params_other['page_index'] = 1;
                        $params_other['post_id'] = $post_id;
                        $params_other['user_id'] = $postdata['posted_user_id'];
                        $params_other['viral_feed'] = 1;
                        $api_resp3 = $this->cit_api_model->callAPI('other_post', $params_other);
                        $all_media = $api_resp3['data'];
                    }

                    // echo json_encode($all_media);
                    // die;

                    $current_page = $api_resp3['settings']['curr_page'];
                    $next_page = $api_resp3['settings']['next_page'];

                    $this->smarty->assign('cr_pg', $current_page);
                    $this->smarty->assign('nx_pg', $next_page);

                    $this->smarty->assign('islike', $islike);
                    $this->smarty->assign('viewcount', $viewcount);
                    $this->smarty->assign('likescount', $likescount);
                    $this->smarty->assign('commentcount', $commentcount);

                    $this->smarty->assign('mediaid', $mediaid);
                    $this->smarty->assign('postinfo', $postdata);
                    $this->smarty->assign('postmedia', $postmedia);
                    $this->smarty->assign('otherpost', $all_media);
                    $this->smarty->assign('postcomment', $postcomment);
                }
            }
        } catch (Exception $e) {

            $var_msg = $e->getMessage();
            $this->smarty->assign('errormsg', $var_msg);
            //redirect();
        }
    }

    public function my_profile()
    {
      $this->assign_language();

        $render_arr['profile_type'] = "my_profile";

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to view profile.");
            redirect($this->config->item("site_url"));
        }

        $render_arr['posts_pgtype'] = "my_profile";
        $render_arr['new_page'] = "true";
        $this->smarty->assign($render_arr);

        try {
            if (isset($user_id) && $user_id != '') {

                $params['user_id'] = $user_id;
                $params['profile_user_id'] = $user_id;
                $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception($api_resp['settings']['message']);
                }

                $userdata = $api_resp['data'][0];

                $coverydimention = $this->general->getcoverphotodimention($userdata['u_users_id']);
                $this->smarty->assign('coverydimention', $coverydimention);

                $api_resp_follower = $this->cit_api_model->callAPI('user_followers', $params);

                $api_resp_following = $this->cit_api_model->callAPI('user_following', $params);

                $this->smarty->assign('userfollower', $api_resp_follower['data']);
                $this->smarty->assign('userfollowing', $api_resp_following['data']);
                $this->smarty->assign('userinfo', $userdata);
                $this->smarty->assign('pl_userId', $user_id);


                $posts_params = array(
                    "user_id" => $user_id,
                    "profile_user_id" => $user_id,
                    "is_feed" => 0,
                    "page_index" => 1,
                );
                $posts_api_resp = $this->getPosts($posts_params);

                if ($posts_api_resp['settings']['success'] == 0) {
                    throw new Exception($api_resp['settings']['message']);
                }
                $current_page = $posts_api_resp['settings']['curr_page'];
                $next_page = $posts_api_resp['settings']['next_page'];
                $posts_org_data = $posts_api_resp['data'];
                $posts_data = $this->getStatistics($posts_org_data);


                $render_arr['posts'] = $posts_data;
                $render_arr['cr_pg'] = $current_page;
                $render_arr['nx_pg'] = $next_page;
                $render_arr['new_page'] = "false";
                $render_arr['posts_pgtype'] = "my_profile";

                foreach ($render_arr['posts'] as $key => &$value) {
                    if ($value['post_type'] == 'Share') {
                        $actual_post_id = $value['actual_post_id'];
                        $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                    }
                }
                unset($value);
                $this->smarty->assign($render_arr);
            }
        } catch (Exception $e) {

            $var_msg = $e->getMessage();
            $this->smarty->assign('errormsg', $var_msg);
        }

        $this->smarty->assign($render_arr);
    }

    public function myprofile_action()
    {
        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to view post.");
            redirect($this->config->item("site_url"));
        }
        try {
            $postArr = $_REQUEST;
            $params = array();

            if ($postArr['selprofilepic'] == 'profilepic') {
                $successmsg = "Profile photo updated successfully";
                $faiilurmsg = "Error in updating profile photo !";
            } else {
                $params['cover_y_dimention'] = ($postArr['topcover'] == '') ? 0 : $postArr['topcover'];
                $successmsg = "Cover photo updated successfully";
                $faiilurmsg = "Error in updating cover photo !";
            }

            $params['user_id'] = $user_id;
            $api_resp = $this->cit_api_model->callAPI('update_profile_cover', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($faiilurmsg);
            }
            $params1['user_id'] = $user_id;
            $params1['profile_user_id'] = $user_id;
            $api_resp1 = $this->cit_api_model->callAPI('my_profile', $params1);
            $record = $api_resp1['data'][0];
            $this->session->set_userdata("vName", $record["u_name"]);
            $this->session->set_userdata("vProfileImage", str_replace("&height=500&width=500", "&height=100&width=100", $record["u_profile_image"]));
            $final_arr = array(
                'profileImage' => str_replace("&height=500&width=500", "&height=100&width=100", $record["u_profile_image"]),
            );

            $this->update_firebase_users($final_arr);
            $this->session->set_flashdata('success', $successmsg);
            redirect($this->url->make('home/home/my_profile'));
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->url->make('home/home/my_profile'));
        }
    }

    public function user_profile($user_id = 0)
    {
        $render_arr['profile_type'] = "user_profile";
        $this->assign_language();


        try {
            if (isset($user_id) && $user_id != '') {

                $params['user_id'] = $this->session->userdata('iUserId');
                $params['profile_user_id'] = $user_id;
                $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception("User Not Exits");
                }

                $userdata = $api_resp['data'][0];

                $coverydimention = $this->general->getcoverphotodimention($userdata['u_users_id']);
                $this->smarty->assign('coverydimention', $coverydimention);


                /* get follower list */
                //pr($userdata);exit;
                $api_resp_follower = $this->cit_api_model->callAPI('user_followers', $params);
                //pr($api_resp_follower);exit;

                /* get following list */
                $api_resp_following = $this->cit_api_model->callAPI('user_following', $params);
                //pr($api_resp_following);exit;

                $this->smarty->assign('userfollower', $api_resp_follower['data']);
                $this->smarty->assign('userfollowing', $api_resp_following['data']);

                /* check the status of follow request */
                $params['user_id'] = $this->session->userdata('iUserId');
                $api_resp2 = $this->cit_api_model->callAPI('my_follower_requests', $params);
                if (!empty($api_resp2['data']) && $api_resp2['settings']['success'] == 1) {
                    $myfollower_arr = $api_resp2['data'];
                    $followerid = array_column($myfollower_arr, 'u_users_id');
                }

                $acceptrejectfollow = 'no';
                $pendingrequestid = '';
                if (in_array($user_id, $followerid)) {
                    $acceptrejectfollow = 'yes';
                    $key1 = array_search($user_id, $followerid); // $key = 2;

                    $pendingrequestid = $myfollower_arr[$key1]['pending_request_id'];
                }

                  if(!$this->checkUserAboutPageExist($user_id)) {
                        $this->smarty->assign('aboutpageexist', false);
                  }

                  $this->smarty->assign('aboutpageexist', true);


                $this->smarty->assign('acceptrejectfollow', $acceptrejectfollow);
                $this->smarty->assign('userinfo', $userdata);
                $this->smarty->assign('getuserid', $this->session->userdata('iUserId'));
                $this->smarty->assign('followuserid', $user_id);
                $this->smarty->assign('pendingrequestid', $pendingrequestid);

                $posts_params = array(
                    "user_id" => $this->session->userdata('iUserId'),
                    "profile_user_id" => $user_id,
                    "is_feed" => 0,
                    "page_index" => 1,
                );
                $posts_api_resp = $this->getPosts($posts_params);


                /* if ($posts_api_resp['settings']['success'] == 0) {
                  throw new Exception($api_resp['settings']['message']);
                  } */
                $current_page = $posts_api_resp['settings']['curr_page'];
                $next_page = $posts_api_resp['settings']['next_page'];
                $posts_org_data = $posts_api_resp['data'];
                $posts_data = $this->getStatistics($posts_org_data);

                $render_arr['posts'] = $posts_data;
                $render_arr['cr_pg'] = $current_page;
                $render_arr['nx_pg'] = $next_page;
                $render_arr['other_user_id'] = $user_id;
                $render_arr['posts_pgtype'] = "other_profile";

                foreach ($render_arr['posts'] as $key => &$value) { // Use reference to modify the original array
                    if ($value['post_type'] == 'Share') {
                        $actual_post_id = $value['actual_post_id'];
                        $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                    }
                }
                unset($value);

                $this->smarty->assign($render_arr);
            }
        } catch (Exception $e) {

            $var_msg = $e->getMessage();
            $this->smarty->assign('errormsg', $var_msg);
        }
        $this->smarty->assign($render_arr);
    }

      public function checkUserAboutPageExist($user_id) {
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

    public function edit_profile_action()
    {
        try {
            // $postArr = $this->input->get_post();
            // echo "edit profile";
            $vEditName = $this->input->post('vEditName');
            $vEditPhone = $this->input->post('vEditPhone');
            $params['user_id'] = $this->session->userdata('iUserId');
            // $params['user_name'] = $postArr['vEditName'];
            // $params['user_phone'] = $postArr['vEditPhone'];
            $params['user_name'] = $vEditName;
            $params['user_phone'] = $vEditPhone;
            $api_resp = $this->cit_api_model->callAPI('edit_profile', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($api_resp['settings']['message']);
            }

            $this->session->set_flashdata('success', $api_resp['settings']['message']);
            redirect($this->url->make('home/home/my_profile'));
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->url->make('home/home/my_profile'));
        }
    }

    public function changepassword_action()
    {

        try {
            $vOldPassword =  $this->input->post('vOldPassword');
            $vNewPassword = $this->input->post('vNewPassword');
            // echo $vNewPassword;
            // die;
            $params['user_id'] = $this->session->userdata('iUserId');
            $params['old_password'] = $vOldPassword;
            $params['new_password'] = $vNewPassword;

            $api_resp = $this->cit_api_model->callAPI('change_password', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($api_resp['settings']['message']);
            }

            $this->session->set_flashdata('success', $api_resp['settings']['message']);
            redirect($this->url->make('home/home/my_profile'));
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->url->make('home/home/my_profile'));
        }
    }

    function unfollowuser_action()
    {
        // $postArr = $this->input->get_post();
        $user_id = $this->input->post('userid');
        $following_user_id = $this->input->post('followid');

        // $params['user_id'] = $postArr['userid'];
        // $params['following_user_id'] = $postArr['followid'];
        $params['user_id'] = $user_id;
        $params['following_user_id'] = $following_user_id;
        $api_resp = $this->cit_api_model->callAPI('unfollow_user', $params);

        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            $msg = $api_resp['settings']['message'];
            $success = 0;
            $color = 'red';
        }

        $msg = $api_resp['settings']['message'];
        $success = 1;
        $color = 'green';

        $jsonarr = array('dispmsg' => $msg, 'success' => $success, 'notecolor' => $color, 'pendingrequestid' => $userdata['pending_request_id']);

        $this->skip_template_view();

        echo json_encode($jsonarr);
        exit;
    }

    public function followuser_action()
    {
        $userid = $this->input->post('userid');
        $followid = $this->input->post('followid');
        $pendingrequestid = $this->input->get_post('pendingrequestid');
        $pendingrequestid_ar = $this->input->get_post('pendingrequestid_ar');
        $btnactval = $this->input->get_post('btnactval');


        if ((isset($pendingrequestid_ar) && $pendingrequestid_ar != '') && ($btnactval == 'Accepted' || $btnactval == 'Rejected')) {
            // cancel request
            $params['user_id'] = $userid;
            $params['user_follow_request_id'] = $pendingrequestid_ar;
            $params['status'] = $btnactval;

            $api_resp = $this->cit_api_model->callAPI('follow_accept_reject_cancel', $params);
        } elseif (isset($pendingrequestid) && $pendingrequestid != '') {
            // cancel request
            $params['user_id'] = $userid;
            $params['user_follow_request_id'] = $pendingrequestid;
            $params['status'] = $btnactval;

            $api_resp = $this->cit_api_model->callAPI('follow_accept_reject_cancel', $params);
        } else {
            $params['user_id'] = $userid;
            $params['following_user_id'] = $followid;

            $api_resp = $this->cit_api_model->callAPI('follow_request', $params);


            $params['user_id'] = $userid;
            $params['profile_user_id'] = $followid;
            $api_resp2 = $this->cit_api_model->callAPI('my_profile', $params);
            $userdata = $api_resp2['data'][0];
        }

        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            $msg = $api_resp['settings']['message'];
            $success = 0;
            $color = 'red';
        }

        $msg = $api_resp['settings']['message'];
        $success = 1;
        $color = 'green';


        $jsonarr = array('dispmsg' => $msg, 'success' => $success, 'notecolor' => $color, 'pendingrequestid' => $userdata['pending_request_id']);
        // print_r($jsonarr);
        $this->skip_template_view();

        echo json_encode($jsonarr);
        exit;
    }


    public function followUser()
    {
        $ajax_data = $this->input->post();
        $user_id = $this->session->userdata('iUserId');
        // print_r($ajax_data);
        $params = [
            'status' => $ajax_data['status'],
            'user_follow_request_id' => $ajax_data['follow_request_id'],
            'user_id' => $user_id,
        ];
        $follow_request_action = $this->cit_api_model->callAPI("follow_accept_reject_cancel", $params);
        header('Content-Type: application/json');
        $response = [
            'success' => 1,
            'message' => 'Follow request processed successfully',
            'user_id' => $user_id,
            'set_btn' => $ajax_data['status'],
        ];

        $this->skip_template_view();

        echo json_encode($response);
        exit();
    }


    /**
     * add_post
     * Add post with media
     *
     * @return json api response
     * @throws Exception
     */
    public function add_post_backup()
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');
        ini_set('post_max_size', '5000M');
        set_time_limit(0);

        $return_array = array();
        try {
                $input_data = $this->input->post();

                $post_type = "Text";
                $post_media = $_FILES;
                // print_r($post_media);
                if (trim($input_data['post_text']) == "" && count($post_media) == 0) {
                throw new Exception("Invalid data");
                }
                if (is_array($post_media) && !empty($post_media) && count($post_media) > 0) {
                $post_type = "Media";
                }
                $input_params = array(
                "user_id" => $this->session->userdata('iUserId'),
                "post_text" => trim(html_entity_decode($input_data['post_text'])),
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type,
                'post_text_emoji' => trim(html_entity_decode($input_data['post_text_emoji']))
                );

                $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);

                if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
                }

                function sanitizeFilename($filename)
                {
                $sanitized = preg_replace('/[^A-Za-z0-9.\-_ ]/', '', $filename);
                $sanitized = str_replace(' ', '_', $sanitized);
                return $sanitized;
                }

                $post_id = $api_resp["data"][0]['post_id'];
                if ($post_type == "Media") {
                $posted_media_count = count($post_media);
                $media_count_loop = 0;
                for ($i = 0; $i < count($post_media); $i++) {
                    $video_thumbnail = "";
                    $video_data = $_FILES['upload_file'];
                    $_FILES['upload_file'] = $_FILES[$i];

                    $originalName = $_FILES['upload_file']['name'];
                    $cleanName = sanitizeFilename($originalName);
                    $_FILES['upload_file']['name'] = $cleanName;

                    $media_count_loop = $media_count_loop + 1;
                    $media_type_arr = explode("/", $post_media[$i]['type']);
                    $media_type = $media_type_arr[0];
                    $video_path = $video_data['tmp_name'];
                    $media_input_params = array(
                            "post_id" => $post_id,
                            "user_id" => $this->session->userdata('iUserId'),
                            "file_type" => ucfirst($media_type),
                            "upload_file" => $_FILES['upload_file'],
                            "thumbnail_file" => $_FILES['thumbnail'],
                            "platform" => "web",
                            "is_completed" => ($media_count_loop == $posted_media_count) ? 1 : 0
                    );

                    //   print_r($media_input_params);die;
                    $media_api_resp = $this->cit_api_model->callAPI("add_post_media", $media_input_params);

                    $media_id = $media_api_resp['data']['insert_post_media'][0]['media_id'];
                }
                }

                $get_post_api_resp = $this->cit_api_model->callAPI("post_detail", array("post_id" => $post_id, "user_id" => $this->session->userdata('iUserId')));
                if ($get_post_api_resp['settings']['success'] == 0) {
                throw new Exception($get_post_api_resp['settings']['message']);
                }
                $new_post_data = $get_post_api_resp['data'];

                $render_post[0] = $new_post_data;

                if ($post_type == "Text") {
                $post_metadata = $new_post_data["p_post_meta_data"];
                $post_meta_data = array();
                if (trim($post_metadata) != "") {
                    $post_metadata_arr = json_decode($post_metadata, true);
                    $post_meta_data = array(
                            "link" => $post_metadata_arr['link'],
                            "title" => $post_metadata_arr['title'],
                            "image" => $post_metadata_arr['image'],
                            "text" => $post_metadata_arr['text']
                    );
                }
                }

                $render_post[0]['statistics'] = array(
                "likes_count" => 0,
                "comments_count" => 0,
                "is_like" => 0,
                "comments" => array()
                );
                $render_post[0]['post_metadata'] = $post_meta_data;

                $render_arr['posts'] = $render_post;
                $return_array['postid'] = $post_id;
                $render_arr['is_detail'] = "Yes";
                $return_array["post_data"] = $this->parser->parse("common/feed_list.tpl", $render_arr, true);
                $return_array['status'] = "Success";
        } catch (Exception $e) {
                $message = $e->getMessage();
                $return_array['status'] = "Failure";
                $return_array['message'] = $message;
        }

        echo json_encode($return_array);
        exit;
    }


    public function add_post_1_12()
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');
        ini_set('post_max_size', '5000M');
        set_time_limit(0);

        $return_array = array();
        try {
            $input_data = $this->input->post();

            $post_type = $input_data['post_type'] ?? "Text";
            $post_media = $_FILES;

            if (trim($input_data['post_text']) == "" && count($post_media) == 0) {
                throw new Exception("Invalid data");
            }

            if (is_array($post_media) && !empty($post_media) && count($post_media) > 0) {
                $post_type = "Media";
            }
            $input_params = array(
                "user_id" => $this->session->userdata('iUserId'),
                "post_text" => trim(html_entity_decode($input_data['post_text'])),
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type,
                'post_text_emoji' => trim(html_entity_decode($input_data['post_text_emoji']))
            );


            $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }

            function sanitizeFilename($filename)
            {
                $sanitized = preg_replace('/[^A-Za-z0-9.\-_ ]/', '', $filename);
                $sanitized = str_replace(' ', '_', $sanitized);
                return $sanitized;
            }

                $post_id = $api_resp["data"][0]['post_id'];
                if ($post_type == "Media") {
                    $file_paths = json_decode($input_data['file_paths'], true);
                    $file_types = json_decode($input_data['file_types'], true);
                    $posted_media_count = count($file_paths);

                    $media_count_loop = 0;
                    
                    for ($i = 0; $i < count($file_paths); $i++) {

                        $originalName = $_FILES['upload_file']['name'];
                        $cleanName = sanitizeFilename($originalName);
                        $_FILES['upload_file']['name'] = $cleanName;

                        $media_count_loop = $media_count_loop + 1;
                        $media_type_arr = explode("/", $post_media[$i]['type']);
                        $media_type = $media_type_arr[0];

                        $file_path = $file_paths[$i];
                        if (file_exists($file_path)) {
                            $type = mime_content_type($file_path);
                        } else {
                            $type = ''; 
                        }


                        $apiUrl = "https://media.zoebook.com/api/v1/laravel/add-post";

                        $media_input_params = array(
                            "post_id"        => $post_id,
                            "user_id"        => $this->session->userdata('iUserId'),
                            "file_type"      => $file_types[$i],
                            "platform"       => "web",
                            "is_completed"   => ($media_count_loop == $posted_media_count) ? 1 : 0,
                            "stored_path"    => $file_path
                        );



                        if (isset($_FILES['thumbnail'])) {
                            $media_input_params['thumbnail'] = new CURLFile(
                                $_FILES['thumbnail']['tmp_name'],
                                $_FILES['thumbnail']['type'],
                                $_FILES['thumbnail']['name']
                            );
                        }

                        $ch = curl_init();
                        curl_setopt($ch, CURLOPT_URL, $apiUrl);
                        curl_setopt($ch, CURLOPT_POST, true);
                        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

                        curl_setopt($ch, CURLOPT_HTTPHEADER, [
                            'Content-Type: multipart/form-data'
                        ]);

                        curl_setopt($ch, CURLOPT_POSTFIELDS, $media_input_params);

                        $response = curl_exec($ch);
                        curl_close($ch);
                    }
                }

            $get_post_api_resp = $this->cit_api_model->callAPI("post_detail", array("post_id" => $post_id, "user_id" => $this->session->userdata('iUserId')));
            if ($get_post_api_resp['settings']['success'] == 0) {
                throw new Exception($get_post_api_resp['settings']['message']);
            }
            $new_post_data = $get_post_api_resp['data'];

            $render_post[0] = $new_post_data;

            if ($post_type == "Text") {
                $post_metadata = $new_post_data["p_post_meta_data"];
                $post_meta_data = array();
                if (trim($post_metadata) != "") {
                    $post_metadata_arr = json_decode($post_metadata, true);
                    $post_meta_data = array(
                        "link" => $post_metadata_arr['link'],
                        "title" => $post_metadata_arr['title'],
                        "image" => $post_metadata_arr['image'],
                        "text" => $post_metadata_arr['text']
                    );
                }
            }

            $render_post[0]['statistics'] = array(
                "likes_count" => 0,
                "comments_count" => 0,
                "is_like" => 0,
                "comments" => array()
            );
            $render_post[0]['post_metadata'] = $post_meta_data;

            $render_arr['posts'] = $render_post;
            $return_array['postid'] = $post_id;
            $render_arr['is_detail'] = "Yes";
            // $return_array["post_data"] = $this->parser->parse("common/feed_list.tpl", $render_arr, true);
            $return_array['status'] = "Success";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $return_array['status'] = "Failure";
            $return_array['message'] = $message;
        }

        echo json_encode($return_array);
        exit;
    }

    public function add_post()
    {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', '0');
        ini_set('post_max_size', '5000M');
        set_time_limit(0);

        $return_array = array();
        try {
            $input_data = $this->input->post();
            $user_id = $this->session->userdata('iUserId');
            $post_type = $input_data['post_type'] ?? "Text";
            $post_media = $_FILES;

            if (trim($input_data['post_text']) == "" && count($post_media) == 0) {
                throw new Exception("Invalid data");
            }

            if (is_array($post_media) && !empty($post_media) && count($post_media) > 0) {
                $post_type = "Media";
            }
            $input_params = array(
                "user_id" => $user_id,
                "post_text" => trim(html_entity_decode($input_data['post_text'])),
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type,
                'post_text_emoji' => trim(html_entity_decode($input_data['post_text_emoji']))
            );


            $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }

            function sanitizeFilename($filename)
            {
                $sanitized = preg_replace('/[^A-Za-z0-9.\-_ ]/', '', $filename);
                $sanitized = str_replace(' ', '_', $sanitized);
                return $sanitized;
            }

            $post_id = $api_resp["data"][0]['post_id'];
            if ($post_type == "Media") {
                foreach ($post_media as $media) {
                    $tmp_file = $media["tmp_name"];
                    $name     = $media["name"];

                    $result = $this->uploadCompressedPostVideo(
                        $user_id,
                        $tmp_file,
                        $name
                    );

                    print_r($result);
                    $this->add_post_media_laravel->insert_post_media(
                        $post_id,
                        $user_id,
                        $result['s3_url'],
                        $result['file_type'],
                        'web',
                        1
                    );
                }

            }
            die;

            $get_post_api_resp = $this->cit_api_model->callAPI("post_detail", array("post_id" => $post_id, "user_id" => $this->session->userdata('iUserId')));
            if ($get_post_api_resp['settings']['success'] == 0) {
                throw new Exception($get_post_api_resp['settings']['message']);
            }
            $new_post_data = $get_post_api_resp['data'];

            $render_post[0] = $new_post_data;

            if ($post_type == "Text") {
                $post_metadata = $new_post_data["p_post_meta_data"];
                $post_meta_data = array();
                if (trim($post_metadata) != "") {
                    $post_metadata_arr = json_decode($post_metadata, true);
                    $post_meta_data = array(
                        "link" => $post_metadata_arr['link'],
                        "title" => $post_metadata_arr['title'],
                        "image" => $post_metadata_arr['image'],
                        "text" => $post_metadata_arr['text']
                    );
                }
            }

            $render_post[0]['statistics'] = array(
                "likes_count" => 0,
                "comments_count" => 0,
                "is_like" => 0,
                "comments" => array()
            );
            $render_post[0]['post_metadata'] = $post_meta_data;

            $render_arr['posts'] = $render_post;
            $return_array['postid'] = $post_id;
            $render_arr['is_detail'] = "Yes";
            // $return_array["post_data"] = $this->parser->parse("common/feed_list.tpl", $render_arr, true);
            $return_array['status'] = "Success";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $return_array['status'] = "Failure";
            $return_array['message'] = $message;
        }

        echo json_encode($return_array);
        exit;
    }

    /**
     * viral_posts
     */
      public function viral_posts()
      {
            if(!$this->session->userdata('firebase_token')) {
                  redirect($this->url->make('user/user/logout'));
            }

            $user_id = $this->session->userdata('iUserId');
            // echo $user_id;
            if (!$user_id) {
                  $this->session->set_flashdata('failure', "Please log in first to view posts.");
                  redirect($this->config->item("site_url"));
            }
            $user_timezone = $this->session->userdata('user_timezone');

            //----------changes--------------//
            $notification_api = $this->cit_api_model->callAPI('user_notifications_list', array("user_id" => $user_id));
            $notifications = array();
            if (is_array($notification_api['data']) && count($notification_api['data']) > 0) {
                  $notifications = array_filter($notification_api['data'], function ($notification) {
                        return isset($notification['is_read']) && $notification['is_read'] === 'No';
                  });
            }

            $block_users_api = $this->cit_api_model->callAPI('blocked_user_list', array("user_id" => $user_id));
            $block_users = array();
            if (is_array($block_users_api['data']) && count($block_users_api['data']) > 0) {
                  $block_users = $block_users_api['data'];
            }
            $this->smarty->assign('blockuser', $block_users);
            $this->smarty->assign('notifications', $notifications);
            $this->smarty->assign('total_notification', count($notifications));

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
                  // 'u_profile_image' => $userdata['vProfileImage'],
                  'u_profile_image' => $logged_userdata['u_profile_image'],
                  'u_name' => $userdata['vName']
            );
            $this->smarty->assign('userinfo', $userinfo);
            $this->smarty->assign('pl_userId', $user_id);
            $this->smarty->assign('profile_type', 'current_profile');
            $this->smarty->assign('user_timezone', $user_timezone);


            // $params = array(
            //       "user_id" => $user_id,
            //       "page_index" => 1,
            //       "profile_user_id" => $user_id,
            //       "is_feed" => 1,
            // );

              $params = array(
                  "user_id" => $user_id,
                  "page_index" => 1,
                  "is_viral" => "Yes"
              );

            $api_resp = $this->getPosts($params);
            /* if ($api_resp['settings']['success'] == 0) {
            throw new Exception($api_resp['settings']['message']);
            } */
            $current_page = $api_resp['settings']['curr_page'];
            $next_page = $api_resp['settings']['next_page'];
            $posts_org_data = $api_resp['data'];
            $posts_data = $this->getStatistics($posts_org_data);
            /* if($this->getmyip() == "201.17.0.1"){
            pr($posts_data,1);
            } */
            #pr($posts_data,1);
            $render_arr['posts'] = $posts_data;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "viral";
            
            $this->smarty->assign($render_arr);

            $this->assign_language();

            $top_playlists = $this->Playlist_model->top_playlist(2);
            // echo json_encode($top_playlists);die;

            $data = [
                  'playlist_post' => $top_playlists,
            ];
            $this->smarty->assign($data);
      }

    public function new_home_page()
    {

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in first to view posts.");
            redirect($this->config->item("site_url"));
        }

        $userdata = $this->session->userdata();

        $userinfo = array(
            'u_profile_image' => $userdata['vProfileImage'],
            'u_name' => $userdata['vName']
        );
        $this->smarty->assign('userinfo', $userinfo);

        $params = array(
            "user_id" => $user_id,
            "page_index" => 1,
            "is_viral" => "Yes"
        );
        $api_resp = $this->getPosts($params);

        /* if ($api_resp['settings']['success'] == 0) {
          throw new Exception($api_resp['settings']['message']);
          } */
        $current_page = $api_resp['settings']['curr_page'];
        $next_page = $api_resp['settings']['next_page'];
        $posts_org_data = $api_resp['data'];
        $posts_data = $this->getStatistics($posts_org_data);
        /* if($this->getmyip() == "201.17.0.1"){
          pr($posts_data,1);
          } */
        #pr($posts_data,1);
        $render_arr['posts'] = $posts_data;
        $render_arr['cr_pg'] = $current_page;
        $render_arr['nx_pg'] = $next_page;
        $render_arr['posts_pgtype'] = "viral";
        $this->smarty->assign($render_arr);
    }

    /**
     * hide_post_list
     */

    public function hide_posts()
    {

        $this->assign_language();

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in first to view posts.");
            redirect($this->config->item("site_url"));
        }

        // $userdata = $this->session->userdata();

        // $userinfo = array(
        //     'u_profile_image' => $userdata['vProfileImage'],
        //     'u_name' => $userdata['vName']
        // );

        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        #pr($api_resp,1);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];
        $userdata = $this->session->userdata();
        // print_r($userdata);
        $userinfo = array(
            // 'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        );

        $this->smarty->assign('userinfo', $userinfo);
        $this->smarty->assign('pl_userId', $user_id);
        $this->smarty->assign('profile_type', 'current_profile');


        $params = array(
            "user_id" => $user_id,
            "page_index" => 1,
            "is_HidePost" => "Yes"
        );

        //$api_resp = $this->getHidePosts($params);
        $api_resp = $this->getPosts($params);
        //pr($api_resp);die();
        /* if ($api_resp['settings']['success'] == 0) {
          throw new Exception($api_resp['settings']['message']);
          } */
        $current_page = $api_resp['settings']['curr_page'];
        $next_page = $api_resp['settings']['next_page'];
        $posts_org_data = $api_resp['data'];
        $posts_data = $this->getStatistics($posts_org_data);
        /* if($this->getmyip() == "201.17.0.1"){
          pr($posts_data,1);
          } */
        //pr($posts_data,1);
        $render_arr['posts'] = $posts_data;
        $render_arr['cr_pg'] = $current_page;
        $render_arr['nx_pg'] = $next_page;
        $render_arr['posts_pgtype'] = "HidePost";
        $this->smarty->assign($render_arr);
    }


    /**
     * like_post
     *
     * Like/Dislike post
     *
     * @return json response
     * @throws Exception
     */
    public function like_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("NOTLOGIN");
            }
            $input_post = $this->input->post();
            $like_status = $input_post['like_status'];
            $post_id = $input_post['post_id'];

            if ($input_post['mediaid'] != 0) {
                $params = array(
                    "media_id" => $input_post['mediaid'],
                    "user_id" => $this->session->userdata('iUserId'),
                    "status" => $like_status
                );
                $api_resp = $this->cit_api_model->callAPI("like_post_media", $params);
            } else {
                $params = array(
                    "post_id" => $post_id,
                    "user_id" => $this->session->userdata('iUserId'),
                    "status" => $like_status
                );
                $api_resp = $this->cit_api_model->callAPI("like_post", $params);
            }

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
        } catch (Exception $e) {
            if ($e->getMessage() == 'NOTLOGIN') {
                $return_array['status'] = "NotLogin";
                $return_array['message'] = 'Please login to proceed';
            } else {
                $return_array['status'] = "Failure";
                $return_array['message'] = $e->getMessage();
            }
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * report_post
     *
     * Report post
     *
     * @return json response
     * @throws Exception
     */
    public function report_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to like post.");
            }
            $input_post = $this->input->post();
            $report_post_id = $input_post['report_post_id'];
            $report_type = $input_post['eReprtType'];
            $report_notes = $input_post['report_notes'];

            $params = array(
                "post_id" => $report_post_id,
                "user_id" => $user_id,
                "report_notes" => trim($report_notes),
                "type" => $report_type
            );
            $api_resp = $this->cit_api_model->callAPI("report_abuse_on_post", $params);
            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
            $return_array['message'] = "Thanks for letting us know. Your feedback helps us when something is not right.";
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * delete_post
     *
     * Delete post
     *
     * @return json response
     * @throws Exception
     */
    public function delete_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to delete post.");
            }
            $input_post = $this->input->get();
            $post_id = $input_post['post_id'];

            $params = array(
                "post_id" => $post_id,
                "user_id" => $user_id
            );
            $api_resp = $this->cit_api_model->callAPI("delete_post", $params);
            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * comment_post
     *
     * Comment on post
     *
     * @return json response
     * @throws Exception
     */
    public function comment_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to comment post.");
            }
            $input_post = $this->input->post();
            $post_id = $input_post['comment_post_id'];
            $comment = $input_post['comment'];

            $pagefrom = $input_post['pagefrom'];

            $params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
                "comment" => trim($comment) //trim(json_encode($comment), '"')
            );
            if ($input_post['comment_mediaid'] > 0) {
                $params = array_merge($params, array('post_media_id' => $input_post['comment_mediaid']));
            }
            if ($input_post['postcomment_id'] > 0) {
                $params = array_merge($params, array('post_comment_id' => $input_post['postcomment_id'], 'reply_text' => trim($comment)));
            }
            if ($pagefrom == 'reply_comment') {
                $api_resp_reply = $this->cit_api_model->callAPI("reply_on_comment", $params);
                if ($api_resp_reply['settings']['success'] == 0) {
                    throw new Exception($api_resp_reply['settings']['message']);
                }

                $replylist['showpostreplyarr'] = $this->general->get_replylist_comment($input_post['postcomment_id'], $post_id);
                $return_array['status'] = "Success";
                $return_array['message'] = $api_resp_reply['settings']['message'];
                $return_array['postdata'] = $this->parser->parse("common/common_replycomment.tpl", $replylist, true);
                echo json_encode($return_array);
                exit;
            } else {
                $api_resp = $this->cit_api_model->callAPI("comment_on_post", $params);
            }
            
            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            
            $comment_id = $api_resp['data'][0]['comment_id'];
            $comments_params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
            );
            if ($input_post['comment_mediaid'] != 0) {
                $comments_params = array_merge($comments_params, array('post_media_id' => $input_post['comment_mediaid']));
            }
            $comments_api_resp = $this->cit_api_model->callAPI("comments_list", $comments_params);
            $comments_data = $comments_api_resp['data'];

            $comments = "";
            if(!$input_post['raw_data']) {
                if (is_array($comments_data) && !empty($comments_data) && count($comments_data) > 0) {

                    if ($pagefrom == 'postdetail') {
                        $render_arr['postcomment'] = $comments_data;
                        $comments = $this->parser->parse("common/common_postcomment.tpl", $render_arr, true);
                    } else {
                        $render_arr['comments'] = $comments_data;
                        $comments = $this->parser->parse("common/comments.tpl", $render_arr, true);
                    }
                }
            }
            $return_array['comments_data'] = $comments ? $comments : $comments_data;
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * like_postcomment
     *
     * Like comment
     *
     * @throws Exception
     */
    public function like_postcomment()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("NOTLOGIN");
            }
            $input_post = $this->input->post();
            $like_status = $input_post['like_status'];
            $post_id = $input_post['post_id'];
            $postcomment_id = $input_post['postcommentid'];

            $params = array(
                "post_comment_id" => $postcomment_id,
                "post_id" => $post_id,
                "user_id" => $this->session->userdata('iUserId'),
                "status" => $like_status
            );
            $api_resp = $this->cit_api_model->callAPI("like_comment", $params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
        } catch (Exception $e) {
            if ($e->getMessage() == 'NOTLOGIN') {
                $return_array['status'] = "NotLogin";
                $return_array['message'] = 'Please login to proceed';
            } else {
                $return_array['status'] = "Failure";
                $return_array['message'] = $e->getMessage();
            }
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * share_post_mytimeline
     *
     * Share post on my timeline
     */
    public function share_post_mytimeline()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to like post.");
            }
            $input_post = $this->input->post();

            $post_id = $input_post['share_post_id'];
            $share_post_text = $input_post['share_post_text'];

            $params = array(
                "share_text" => $share_post_text,
                "post_id" => $post_id,
                "user_id" => $user_id,
                "visibility" => "Public"
            );

            $api_resp = $this->cit_api_model->callAPI("share_post", $params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function get_edit_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to like post.");
            }
            $input_post = $this->input->get();

            $post_id = $input_post['post_id'];

            $params = array(
                "post_id" => $post_id,
                "user_id" => $user_id
            );

            $api_resp = $this->cit_api_model->callAPI("post_detail", $params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $post_data = $api_resp['data'];

            $detail_array = array(
                "post_id" => $post_data['post_id'],
                "visibility" => $post_data['visibility'],
                "post_text" => $post_data['post_text_emoji'],
                "post_type" => $post_data['post_type'],
                "media" => $post_data['get_post_media']
            );
            $return_array['data'] = $detail_array;
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function update_post()
    {
        $return_array = array();
        try {
            $input_data = $this->input->post();

            $post_type = $input_data['post_type'];
            $post_id = $input_data['edit_post_id'];
            $delete_media_id = $input_data['delete_media_id'];

            $from_detailpage = $input_data['edit_post_detailpage'];

            $post_media = $_FILES;

            if (trim($input_data['edit_post_text']) == "") {
                throw new Exception("Invalid data");
            }

            /*$input_params = array(
                "user_id" => $this->session->userdata('iUserId'),
                "post_text" => trim($input_data['edit_post_text']),
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type,
                "post_id" => $post_id
            );*/
            $input_params = array(
                "user_id" => $this->session->userdata('iUserId'),
                "post_text" => trim(html_entity_decode($input_data['edit_post_text'])), //trim($input_data['post_text']), //added json_encode for emoji
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type,
                'post_text_emoji' => trim(html_entity_decode($input_data['post_text_emoji'])),
                "post_id" => $post_id
            );
            $api_resp = $this->cit_api_model->callAPI("edit_post", $input_params);
            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            if (trim($delete_media_id) != "") {
                $del_input_params = array(
                    "post_id" => $post_id,
                    "post_media_id" => $delete_media_id,
                    "user_id" => $this->session->userdata('iUserId')
                );
                $this->cit_api_model->callAPI("delete_media", $del_input_params);
            }
            $posted_media_count = count($post_media);
            $comments_params = array(
                "post_id" => $post_id,
                "user_id" => $this->session->userdata('iUserId'),
            );
            if ($post_type == "Media" && $posted_media_count > 0) {
                $media_count_loop = 0;
                for ($i = 0; $i < $posted_media_count; $i++) {
                    $video_thumbnail = "";
                    $_FILES['upload_file'] = $_FILES[$i];
                    $media_count_loop = $media_count_loop + 1;
                    $media_type_arr = explode("/", $post_media[$i]['type']);
                    $media_type = $media_type_arr[0];

                    if ($media_type == "video") {
                        $thumbnail_path = $this->config->item('upload_path') . 'thumbnail/';
                        $this->general->createUploadFolderIfNotExists('thumbnail');
                        $tmp_name = $_FILES['upload_file']['tmp_name'];
                        $name = str_replace(' ', '_', $_FILES['upload_file']['name']);
                        move_uploaded_file($tmp_name, $thumbnail_path . $name);

                        $video = $thumbnail_path . escapeshellcmd($name);
                        $cmd = "ffmpeg -i $video 2>&1";
                        $second = 1;
                        /*if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
                            $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
                            $second = rand(1, ($total - 1));
                        }*/
                        $userid = $this->session->userdata('iUserId');
                        $thumbname = $userid . time() . '.jpg';
                        $image  = $thumbnail_path . $thumbname;
                        $cmd = "/usr/bin/ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";

                        exec($cmd, $output, $retval);
                        $thumb_file_path = $image;
                        if (file_exists($thumb_file_path)) {
                            $file_path = "post_media";
                            $folder_id = trim($userid);
                            $file_path = $file_path . "/" . $folder_id;
                            $file_name = $thumbname;
                            $file_tmp_path = $thumb_file_path;
                            $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                            /*if($response){
                                $this->db->update($this->table_name." AS ".$this->table_alias, $data);
                            }*/
                            $video_thumbnail = $thumbname;
                            unlink($thumbnail_path . $name);
                            unlink($thumb_file_path);
                        }
                    }

                    $media_input_params = array(
                        "post_id" => $post_id,
                        "user_id" => $this->session->userdata('iUserId'),
                        "file_type" => ucfirst($media_type),
                        "video_thumbnail" => "",
                        "is_completed" => ($media_count_loop == $posted_media_count) ? 1 : 0
                    );
                    $media_api_resp = $this->cit_api_model->callAPI("add_post_media", $media_input_params);
                    $media_id = $media_api_resp['data']['insert_post_media'][0]['media_id'];
                    if (trim($video_thumbnail) != "") {
                        $thumb_data = array(
                            "vVideoThumbnail" => $video_thumbnail
                        );
                        $this->db->where("iPostMediaId", $media_id);
                        $this->db->update("post_media", $thumb_data);
                    }
                }
            }
            $get_post_api_resp = $this->cit_api_model->callAPI("post_detail", array("post_id" => $post_id, "user_id" => $this->session->userdata('iUserId')));
            if ($get_post_api_resp['settings']['success'] == 0) {
                throw new Exception($get_post_api_resp['settings']['message']);
            }
            $new_post_data = $get_post_api_resp['data'];
            if (is_array($get_post_api_resp['data']['get_post_media'][0]) && $get_post_api_resp['data']['get_post_media'][0]['post_media_id'] > 0) {
                $media_id = $get_post_api_resp['data']['get_post_media'][0]['post_media_id'];
                $comments_params = array_merge($comments_params, array('post_media_id' => $media_id));
            }
            $comments_api_resp = $this->cit_api_model->callAPI("comments_list", $comments_params);
            $comments_data = $comments_api_resp['data'];
            $render_post[0] = $new_post_data;

            if ($post_type == "Text") {
                $post_metadata = $new_post_data["p_post_meta_data"];
                $post_meta_data = array();
                if (trim($post_metadata) != "") {
                    $post_metadata_arr = json_decode($post_metadata, true);
                    $post_meta_data = array(
                        "link" => $post_metadata_arr['link'],
                        "title" => $post_metadata_arr['title'],
                        "image" => $post_metadata_arr['image'],
                        "text" => $post_metadata_arr['text']
                    );
                }
            }

            $render_post[0]['statistics'] = array(
                "likes_count" => $get_post_api_resp['data']['get_post_media'][0]['total_likes_count'],
                "comments_count" => $get_post_api_resp['data']['get_post_media'][0]['total_comments_count'],
                "is_like" => $get_post_api_resp['data']['get_post_media'][0]['is_liked'],
                "comments" => $comments_data
            );
            $render_post[0]['post_metadata'] = $post_meta_data;

            $render_arr['posts'] = $render_post;
            $render_arr['is_detail'] = "Yes";
            if ($from_detailpage == '') {
                $return_array["post_data"] = $this->parser->parse("common/feed_list.tpl", $render_arr, true);
            } else {
                $detail_renderarr["postmedia"] = $get_post_api_resp['data']['get_post_media'];
                $return_array["post_media_data"] = $this->parser->parse("common/edit_media_reload.tpl", $detail_renderarr, true);
                $return_array["post_data"] = trim(html_entity_decode($input_data['edit_post_text']));
            }

            $return_array['status'] = "Success";
        } catch (Exception $e) {
            $message = $e->getMessage();
            $return_array['status'] = "Failure";
            $return_array['message'] = $message;
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * notifications
     *
     * Notifications
     *
     * @return string Notifications html
     * @throws Exception
     */
    public function notifications()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if ($user_id <= 0) {
                throw new Exception("Session logged out");
            }
            $api_resp = $this->cit_api_model->callAPI('user_notifications_list', array("user_id" => $user_id));
            $notifications = array();
            if (is_array($api_resp['data']) && count($api_resp['data']) > 0) {
                $notifications = $api_resp['data'];
            }
            $this->skip_template_view();
            $render_arr['notifications'] = $notifications;
            $notifications_html = $this->parser->parse("notifications.tpl", $render_arr, true);
            $return_array['status'] = "Success";
            $return_array['notifications'] = $notifications_html;
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
        }
        echo json_encode($return_array);
        exit;
    }
    /**
     * block users
     *
     *
     *
     * @return string block user html
     * @throws Exception
     */
    public function blocked_user_details()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (empty($user_id)) {
                throw new Exception("Session logged out");
            }

            $api_resp = $this->cit_api_model->callAPI('blocked_user_list', array("user_id" => $user_id));
            //pr($api_resp);die();
            $block_users = array();
            if (is_array($api_resp['data']) && count($api_resp['data']) > 0) {
                $block_users = $api_resp['data'];
            }

            $this->skip_template_view();
            $render_arr['block_users'] = $block_users;
            $block_user_html = $this->parser->parse("block_users.tpl", $render_arr, true);
            $return_array['status'] = "Success";
            $return_array['blockUsers'] = $block_user_html;
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * respond_follow_request
     *
     * Accept/Reject follow request
     *
     * @throws Exception
     */
    public function respond_follow_request()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to like post.");
            }
            $input_post = $this->input->post();
            $follow_request_id = $input_post['follow_request_id'];
            $status = $input_post['status']; //Accepted/Rejected

            $params = array(
                "user_follow_request_id" => $follow_request_id,
                "status" => $status,
                "user_id" => $user_id
            );
            $api_resp = $this->cit_api_model->callAPI("follow_accept_reject_cancel", $params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function feed_comment_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to comment post.");
            }
            $input_post = $this->input->post();
            $post_id = $input_post['comment_post_id'];
            $comment = $input_post['comment'];

            $pagefrom = $input_post['pagefrom'];

            $params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
                "comment" => trim($comment) //trim(json_encode($comment), '"')
            );
            if (intval($input_post['comment_mediaid']) > 0) {
                $params = array_merge($params, array('post_media_id' => $input_post['comment_mediaid']));
            }
            if (intval($input_post['postcomment_id']) > 0) {
                $params = array_merge($params, array('post_comment_id' => $input_post['postcomment_id'], 'reply_text' => trim($comment)));
            }


            if ($pagefrom == 'reply_comment') {
                $api_resp_reply = $this->cit_api_model->callAPI("reply_on_comment", $params);
                if ($api_resp_reply['settings']['success'] == 0) {
                    throw new Exception($api_resp_reply['settings']['message']);
                }

                $replylist['showpostreplyarr'] = $this->general->get_replylist_comment($input_post['postcomment_id'], $post_id);
                $return_array['status'] = "Success";
                $return_array['message'] = $api_resp_reply['settings']['message'];
                $return_array['postdata'] = $this->parser->parse("common/common_feed_replies.tpl", $replylist, true);
                echo json_encode($return_array);
                exit;
            } else {
                $api_resp = $this->cit_api_model->callAPI("comment_on_post", $params);
            }

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }

            $comments_params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
            );
            if ($input_post['comment_mediaid'] != 0) {
                $comments_params = array_merge($comments_params, array('post_media_id' => $input_post['comment_mediaid']));
            }
            $comments_api_resp = $this->cit_api_model->callAPI("comments_list", $comments_params);
            $comments_data = $comments_api_resp['data'];

            $comments = "";
            if (is_array($comments_data) && !empty($comments_data) && count($comments_data) > 0) {
                $render_arr['comments'] = $comments_data;
                $comments = $this->parser->parse("common/comments.tpl", $render_arr, true);
            }
            $return_array['comments_data'] = $comments;
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function feed_change_media()
    {
        $return_array = array();

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            throw new Exception("Please log in to view post");
        }

        try {
            $inputparamarr = $this->input->get_post();
            $post_id = $inputparamarr['posted_postid'];
            $posted_mediaid = $inputparamarr['posted_mediaid'];

            if (isset($post_id) && $post_id != '') {
                $params['post_id'] = $post_id;
                $params['user_id'] = $user_id;
                $api_resp = $this->cit_api_model->callAPI('post_detail', $params);

                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception($api_resp['settings']['message']);
                }

                $postdata = $api_resp['data'];
                $postmedia = $api_resp['data']['get_post_media'];

                $mediaid = 0;
                $commentcount = $postdata['comment_count'];
                $likescount = $postdata['likes_count'];
                $viewcount = $postdata['impression_count'];
                $islike = $postdata['is_like'];

                if ($posted_mediaid != 0) {
                    $res_media_key = array_search($posted_mediaid, array_column($postmedia, 'post_media_id'), true);

                    $mediaid = $postmedia[$res_media_key]['post_media_id'];
                    $params['post_media_id'] = $postmedia[$res_media_key]['post_media_id'];

                    $commentcount = $postmedia[$res_media_key]['total_comments_count'];
                    $likescount = $postmedia[$res_media_key]['total_likes_count'];
                    $viewcount = $postmedia[$res_media_key]['pm_views_count'];
                    $islike = $postmedia[$res_media_key]['is_liked'];
                } else if (count($postmedia) > 0) {
                    $mediaid = $postmedia[0]['post_media_id'];
                    $params['post_media_id'] = $postmedia[0]['post_media_id'];

                    $commentcount = $postmedia[0]['total_comments_count'];
                    $likescount = $postmedia[0]['total_likes_count'];
                    $viewcount = $postmedia[0]['pm_views_count'];
                    $islike = $postmedia[0]['is_liked'];
                }

                if ($posted_mediaid != 0 || count($postmedia) > 0) {
                    /* increase impression count */
                    $paramsview['iPostMediaId'] = $mediaid;
                    $paramsview['user_id'] = $user_id;
                    $api_resp_view = $this->cit_api_model->callAPI('update_media_view_count', $paramsview);
                    /* end code */
                } else {
                    $api_resp_view = $this->cit_api_model->callAPI('update_impression_count', $params);
                }

                $api_resp2 = $this->cit_api_model->callAPI('comments_list', $params);
                $postcomment = $api_resp2['data'];

                //$render_arr['postinfo'] = $postdata;
                //$render_arr['viewcount'] = $viewcount;

                $render_arr['postid'] = $post_id;
                $render_arr['mediaid'] = $mediaid;
                $render_arr['islike'] = $islike;
                $render_arr['likescount'] = $likescount;
                $render_arr['commentcount'] = $commentcount;
                $render_arr['isajax'] = "Yes";
                $return_array['feed_actions'] = $this->parser->parse("common/feed_actions.tpl", $render_arr, true);

                $render_comments_arr['comments'] = $postcomment;
                $return_array['comments'] = $this->parser->parse("common/comments.tpl", $render_comments_arr, true);

                $return_array['status'] = "Success";
            }
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $return_array['status'] = "Success";
            $return_array['message'] = $var_msg;
        }
        echo json_encode($return_array);
        exit;
    }

    /**
     * delete post comment
     *
     * @throws Exception
     */
    public function delete_comment_post()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to delete post comment.");
            }
            $input_post = $this->input->post();
            $post_id = $input_post['post_id'];
            $postcomment_id = $input_post['postcomment_id'];

            $params = array(
                "post_comment_id" => $postcomment_id,
                "post_id" => $post_id,
                "user_id" => $user_id
            );
            $api_resp = $this->cit_api_model->callAPI("delete_comment", $params);

            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $return_array['status'] = "Success";
            $return_array['message'] = $api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    //changes here
    public function get_comments()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to view comments.");
            }
            $input_post = $this->input->post();
            $post_id = $input_post['comment_post_id'];

            $comments_params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
            );
            if ($input_post['comment_mediaid'] != 0) {
                $comments_params = array_merge($comments_params, array('post_media_id' => $input_post['comment_mediaid']));
            }
            $comments_api_resp_1 = $this->cit_api_model->callAPI("comments_list", $comments_params);
            $comments1 = isset($comments_api_resp_1['data']) ? $comments_api_resp_1['data'] : [];

            $comments_params['post_media_id'] = 0;
            $comments_api_resp = $this->cit_api_model->callAPI("comments_list", $comments_params);
            $comments2 = isset($comments_api_resp['data']) ? $comments_api_resp['data'] : [];
            $all_comments = array_merge($comments1, $comments2);

            $unique_comments = [];
            foreach ($all_comments as $comment) {
                  $unique_comments[$comment['post_comment_id']] = $comment;
            }

            usort($unique_comments, function ($a, $b) {
                  return $b['post_comment_id'] <=> $a['post_comment_id'];
            });

            $comments_data = $unique_comments;

            $comments = "";
            if(!$input_post['raw_data']) {
                if (is_array($comments_data) && !empty($comments_data) && count($comments_data) > 0) {
                    $render_arr['comments'] = $comments_data;
                    $comments = $this->parser->parse("common/comments.tpl", $render_arr, true);
                }
            }
            // echo json_encode( $comments_data);die;
            $return_array['comments_data'] = $comments ? $comments : $comments_data;
            $return_array['status'] = "Success";
            $return_array['message'] = $comments_api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function getmyip()
    {
        $realip = $this->general->getHTTPRealIPAddr();
        return $realip;
    }

    public function getOtherPosts()
    {
        $user_id = $this->session->userdata('iUserId');

      //   $api_resp = $this->cit_api_model->callAPI("post_list", $params);
        $params_other['page_index'] = $this->input->get("nxpg");
        $params_other['post_id'] = $this->input->get("post_id");
        $params_other['user_id'] = $user_id;
        $params_other['viral_feed'] = 1;
        $api_resp = $this->cit_api_model->callAPI('other_post', $params_other);

        $current_page = $api_resp['settings']['curr_page'];
        $next_page = $api_resp['settings']['next_page'];
        $posts_org_data = $api_resp['data'];

        $render_arr['otherpost'] = $posts_org_data;

        $this->skip_template_view();

        $return_array["posts_data"] = $this->parser->parse("common/common_otherpost.tpl", $render_arr, true);
        $return_array["cr_pg"] = $current_page;
        $return_array["nx_pg"] = $next_page;

        echo json_encode($return_array);
        exit;
    }
    /**
     * block and unblock user
     *
     * @throws Exception
     */
    public function block_user()
    {
        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to Block.");
            }
            $input_post = $this->input->post();
            $block_user_id = $input_post['block_user_id'];

            $params = array(
                "block_by_user_id" => $user_id,
                "blocked_user_id" => $block_user_id,
            );
            $block_api = $this->cit_api_model->callAPI("upsert_block_user_list", $params);
            if ($block_api['settings']['success'] == '1') {
                $return_array['status'] = "success";
                $return_array['message'] = $block_api['settings']['message'];
                echo json_encode($return_array);
                exit;
            } else {
                $return_array['status'] = "failure";
                $return_array['message'] = "Error Occured!!";
                echo json_encode($return_array);
                exit;
            }
            $comments_data = $comments_api_resp['data'];

            $comments = "";
            if (is_array($comments_data) && !empty($comments_data) && count($comments_data) > 0) {
                $render_arr['comments'] = $comments_data;
                $comments = $this->parser->parse("common/comments.tpl", $render_arr, true);
            }
            $return_array['comments_data'] = $comments;
            $return_array['status'] = "Success";
            $return_array['message'] = $comments_api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function hide_post()
    {

        $return_array = array();
        try {
            $user_id = $this->session->userdata('iUserId');
            if (!$user_id) {
                throw new Exception("Please log in first to Block.");
            }
            $input_post = $this->input->post();
            $post_id = $input_post['post_id'];
            $post_action = $input_post['post_action'];

            $params = array(
                "post_id" => $post_id,
                "user_id" => $user_id,
                "Type" => $post_action,
            );
            //pr($params);die();
            $hide_post = $this->cit_api_model->callAPI("hide_post", $params);
            //pr($hide_post);die();     
            if ($hide_post['settings']['success'] == '1') {
                $return_array['status'] = "success";
                $return_array['message'] = $hide_post['settings']['message'];
                //pr($return_array);
                echo json_encode($return_array);
                exit;
            } else {
                $return_array['status'] = "failure";
                $return_array['message'] = "Error Occured!!";
                echo json_encode($return_array);
                exit;
            }
            $comments_data = $comments_api_resp['data'];

            $comments = "";
            if (is_array($comments_data) && !empty($comments_data) && count($comments_data) > 0) {
                $render_arr['comments'] = $comments_data;
                $comments = $this->parser->parse("common/comments.tpl", $render_arr, true);
            }
            $return_array['comments_data'] = $comments;
            $return_array['status'] = "Success";
            $return_array['message'] = $comments_api_resp['settings']['message'];
        } catch (Exception $e) {
            $return_array['status'] = "Failure";
            $return_array['message'] = $e->getMessage();
        }
        echo json_encode($return_array);
        exit;
    }

    public function update_firebase_users($final_arr = array())
    {

        echo 'Update firebase user';
        //Push Firebase
        $firebase_arr = array();
        $user_id = $this->session->userdata('iUserId');
        // print_r($final_arr);
        // echo $user_id;
        // print_r($this->load->library('firebase'));
        // die;
        $firebase_arr[$user_id] = $final_arr;

        $this->load->library('firebase');
        // $this->firebase->insert('users',$firebase_arr);
        if (stristr($_SERVER['REMOTE_ADDR'], '192.168') || $_SERVER['SERVER_NAME'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['SERVER_NAME'] == 'zoebook.projectspreview.net' || $_SERVER['HTTP_HOST'] == 'zoebook.projectspreview.net') {
            $node = "test/users";
        } else {
            $node = "users";
        }
        $contacts_new_ref = $this->firebase->get($node, $user_id);
        if ($contacts_new_ref) {
            // $contact_arr[$user_id] = '';
            $this->firebase->update($node . '/' . $user_id, $final_arr);
        }

        return true;
    }

      public function other_posts($params = array())
      {
            $user_id = $this->session->userdata('iUserId');
            $page_index = $this->input->get('page_index');
            $viral_feed = $this->input->get('viral_feed');
            $post_id    = $this->input->get('post_id');

            $params_other['page_index'] = $page_index;
            $params_other['post_id'] = $post_id;
            $params_other['user_id'] = $user_id;
            $params_other['viral_feed'] = $viral_feed;

            $api_resp3 = $this->cit_api_model->callAPI('other_post', $params_other);    
            $all_media = $api_resp3['data'];

            $response = [
                  'success' => 1,
                  'message' => 'continue',
                  'other_post' => $all_media,
            ];
            echo json_encode($response);
      }

      public function home_scrolled_posts($param = array())
      {
            $user_id = $this->session->userdata('iUserId');
            $page_index = $this->input->get('page_index');
            $params = array(
                  "user_id" => $user_id,
                  "profile_user_id" => $user_id,
                  "is_feed" => 1,
                  "page_index" => $page_index
            );
            $api_resp = $this->cit_api_model->callAPI("post_list", $params);

            $current_page = $api_resp['settings']['curr_page'];
            $next_page = $api_resp['settings']['next_page'];
            $posts_org_data = $api_resp['data'];
            $posts_data = $this->getStatistics($posts_org_data);

            $all_posts = [];
            foreach ($posts_data as $value) {
                  $post_id = $value['post_id'];
                  $params = [
                  'post_id' => $post_id,
                  'user_id' => $value['posted_user_id'],
                  ];
                  $comments = $this->cit_api_model->callAPI('comments_list', $params);

                  $value['statistics']['comments']  = $comments;

                  $all_posts[] = $value;
            }

            $render_arr['posts'] = $all_posts;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "my_profile";

            foreach ($render_arr['posts'] as $key => &$value) {
                  if ($value['post_type'] == 'Share') {
                  $actual_post_id = $value['actual_post_id'];
                  $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                  }
            }
            unset($value);

            $this->smarty->assign($render_arr);
            $top_playlists = $this->Playlist_model->top_playlist();
            $data = [
                  'playlist_post' => $top_playlists,
            ];
            $this->smarty->assign($data);

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;
            $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                  throw new Exception($api_resp['settings']['message']);
            }

            $logged_userdata = $api_resp['data'][0];
            $userdata = $this->session->userdata();

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;

            $userinfo = array(
                  'u_profile_image' => $logged_userdata['u_profile_image'],
                  'u_name' => $userdata['vName'],
                  'u_userid' => $userdata['iUsersId'],
            );

            $this->smarty->assign('userinfo', $userinfo);
            $this->smarty->assign('pl_userId', $user_id);
            $this->smarty->assign('profile_type', 'current_profile');

            $html_content = $this->smarty->fetch('common/home_scroll_feed.tpl');

            echo json_encode([
                  'success' => 1,
                  'html_content' => $html_content
            ]);
      }

      public function profile_posts($param = array())
      {
            $render_arr['profile_type'] = "my_profile";
            $user_id = $this->session->userdata('iUserId');
            $page_index = $this->input->get('page_index');
            $posts_params = array(
                  "user_id" => $user_id,
                  "profile_user_id" => $user_id,
                  "is_feed" => 0,
                  "page_index" => $page_index
            );

            $api_resp = $this->cit_api_model->callAPI("post_list", $posts_params);
            $current_page = $api_resp['settings']['curr_page'];
            $next_page = $api_resp['settings']['next_page'];
            $posts_org_data = $api_resp['data'];
            $posts_data = $this->getStatistics($posts_org_data);

            $all_posts = [];
            foreach ($posts_data as $value) {
                  $post_id = $value['post_id'];
                  $params = [
                  'post_id' => $post_id,
                  'user_id' => $value['posted_user_id'],
                  ];
                  $comments = $this->cit_api_model->callAPI('comments_list', $params);
                  $value['statistics']['comments']  = $comments;

                  $all_posts[] = $value;
            }


            $render_arr['posts'] = $all_posts;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "my_profile";

            foreach ($render_arr['posts'] as $key => &$value) {
                  if ($value['post_type'] == 'Share') {
                  $actual_post_id = $value['actual_post_id'];
                  $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                  }
            }
            unset($value);
            $this->smarty->assign($render_arr);
            $html_content = $this->smarty->fetch('common/profile_scroll_feed.tpl');

            echo json_encode([
                  'success' => 1,
                  'html_content' => $html_content
            ]);
      }

    public function post_detail_comments()
    {
        $user_id = $this->session->userdata('iUserId');
        $postId = $this->input->post('post_id');
        $comment = $this->input->post('comment');

        if (empty($postId)) {
            $response = [
                'status' => 'error',
                'message' => 'content required'
            ];
            echo json_encode($response);
            exit;
        }

        if ($comment) {
            $params = [
                'comment' => $comment,
                'post_id' => $postId,
                'user_id' => $user_id,
            ];
            $post_detail_comment = $this->cit_api_model->callAPI("comment_on_post", $params);
        }
        $param = [
            'post_id' => $postId,
            'user_id' => $user_id,
        ];
        $comments = $this->cit_api_model->callAPI('comments_list', $param);
        $postcomment = $comments['data'];

        echo json_encode([
            'success' => 1,
            'postcomment' => $postcomment
        ]);
        exit;
    }

      public function language()
      {
            $this->session->unset_userdata('language');
            $language = $this->input->post('language');
            $this->session->set_userdata('language', $language);

            echo json_encode(['status' => 'success']);
      }

      public function add_comment()
      {
            $user_id = $this->session->userdata('iUserId');
            $postId = $this->input->post('comment_post_id');
            $comment = $this->input->post('comment');
            $post_media_id = $this->input->post('post_media_id') ?? 0;

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
                  'post_media_id' => $post_media_id
            ];
            $playlistComment = $this->cit_api_model->callAPI("comment_on_post", $params);
            if ($playlistComment) {
                  $response = [
                  'status' => 'success',
                  "user_id" => $user_id,
                  "comment" => $comment,
                  "post_id" => $postId,
                  ];
            } else {
                  $response = [
                  'status' => 'error',
                  "user_id" => $user_id,
                  "comment" => $comment,
                  "post_id" => $postId,
                  ];
            }
            echo json_encode($response);
      }


      public function viral_post_scrolled_posts($param = array())
      {
            $user_id = $this->session->userdata('iUserId');
            $page_index = $this->input->get('page_index');
            $params = array(
                  "user_id" => $user_id,
                  "profile_user_id" => $user_id,
                  "is_feed" => 1,
                  "page_index" => $page_index
            );
            $api_resp = $this->cit_api_model->callAPI("post_list", $params);

            $current_page = $api_resp['settings']['curr_page'];
            $next_page = $api_resp['settings']['next_page'];
            $posts_org_data = $api_resp['data'];
            $posts_data = $this->getStatistics($posts_org_data);

            $all_posts = [];
            foreach ($posts_data as $value) {
                  $post_id = $value['post_id'];
                  $params = [
                  'post_id' => $post_id,
                  'user_id' => $value['posted_user_id'],
                  ];
                  $comments = $this->cit_api_model->callAPI('comments_list', $params);

                  $value['statistics']['comments']  = $comments;

                  $all_posts[] = $value;
            }

            $render_arr['posts'] = $all_posts;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "my_profile";

            foreach ($render_arr['posts'] as $key => &$value) {
                  if ($value['post_type'] == 'Share') {
                  $actual_post_id = $value['actual_post_id'];
                  $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                  }
            }
            unset($value);

            // Assign data to Smarty template

            $this->smarty->assign($render_arr);
            $top_playlists = $this->Playlist_model->top_playlist();
            $data = [
                  'playlist_post' => $top_playlists,
            ];
            $this->smarty->assign($data);

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;
            $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                  throw new Exception($api_resp['settings']['message']);
            }

            $logged_userdata = $api_resp['data'][0];
            $userdata = $this->session->userdata();

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;

            $userinfo = array(
                  'u_profile_image' => $logged_userdata['u_profile_image'],
                  'u_name' => $userdata['vName'],
                  'u_userid' => $userdata['iUsersId'],
            );

            $this->smarty->assign('userinfo', $userinfo);
            $this->smarty->assign('pl_userId', $user_id);
            $this->smarty->assign('profile_type', 'current_profile');

            $html_content = $this->smarty->fetch('common/home_scroll_feed.tpl');

            echo json_encode([
                  'success' => 1,
                  'html_content' => $html_content
            ]);
      }


      // public function getMorePlaylist() {
      //       ob_clean();
      //       $page_index = $this->input->post('pageIndex') ?: 1;
      //       $top_playlists = $this->Playlist_model->top_playlist($page_index);
      //       header('Content-Type: application/json');
      //       echo json_encode($top_playlists);
      //       exit;
      // }

      public function getMorePlaylist() {
            $page_index = $this->input->post('pageIndex');
            if (!$page_index) {
                  $page_index = 1;
            }
            $top_playlists = $this->Playlist_model->top_playlist($page_index);
            echo json_encode($top_playlists);
      }

      public function user_profile_posts_scroll_feed() {
            $user_id = $this->input->get('user_id');
            $page_index = $this->input->get('page_index');
            $posts_params = array(
                  "user_id" => $this->session->userdata('iUserId'),
                  "profile_user_id" => $user_id,
                  "is_feed" => 0,
                  "page_index" => $page_index,
            );
            $api_resp = $this->cit_api_model->callAPI('post_list', $posts_params);

            $current_page = $api_resp['settings']['curr_page'];
            $next_page = $api_resp['settings']['next_page'];
            $posts_org_data = $api_resp['data'];
            $posts_data = $this->getStatistics($posts_org_data);

            $all_posts = [];
            foreach ($posts_data as $value) {
                  $post_id = $value['post_id'];
                  $params = [
                  'post_id' => $post_id,
                  'user_id' => $value['posted_user_id'],
                  ];
                  $comments = $this->cit_api_model->callAPI('comments_list', $params);

                  $value['statistics']['comments']  = $comments;

                  $all_posts[] = $value;
            }

            $render_arr['posts'] = $all_posts;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "my_profile";

            foreach ($render_arr['posts'] as $key => &$value) {
                  if ($value['post_type'] == 'Share') {
                  $actual_post_id = $value['actual_post_id'];
                  $value['get_actual_post_media'] = $this->Playlist_model->get_share_post_media($actual_post_id);
                  }
            }
            unset($value);

            $this->smarty->assign($render_arr);
            $top_playlists = $this->Playlist_model->top_playlist();
            $data = [
                  'playlist_post' => $top_playlists,
            ];
            $this->smarty->assign($data);

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;
            $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                  throw new Exception($api_resp['settings']['message']);
            }

            $logged_userdata = $api_resp['data'][0];
            $userdata = $this->session->userdata();

            $params['user_id'] = $user_id;
            $params['profile_user_id'] = $user_id;

            $userinfo = array(
                  'u_profile_image' => $logged_userdata['u_profile_image'],
                  'u_name' => $userdata['vName'],
                  'u_userid' => $userdata['iUsersId'],
            );

            $this->smarty->assign('userinfo', $userinfo);
            $this->smarty->assign('pl_userId', $user_id);
            $this->smarty->assign('profile_type', 'current_profile');

            $html_content = $this->smarty->fetch('common/home_scroll_feed.tpl');

            echo json_encode([
                  'success' => 1,
                  'html_content' => $html_content
            ]);
      }


    public function checkPostUpload() {
        $input_data = $this->input->post();
        $post_id = $input_data['post_id'];
        $user_id = $this->session->userdata('iUserId');

        $max_attempts = 10;
        $exists = false;
        $file = null;
        $mediaType = null;

        for ($i = 0; $i < $max_attempts; $i++) {
            $query = $this->db->where([
                'iPostId' => $post_id,
                'iUserId' => $user_id,
                'eStatus' => 'active'
            ])->limit(1)->get('post_media');

            if ($query->num_rows() > 0) {
                $row = $query->row();
                $exists = true;
                $file = $row->vUploadFile;
                $mediaType = $row->eMediaType;
                break;
            }

            sleep(1);
        }

        echo json_encode([
            'status' => $exists,
            'file' => $file,
            'mediaType' => $mediaType,
            'userId' => $user_id
        ]);
    }


    public function uploadCompressedPostVideo($user_id, $temp_file, $original_name)
    {
        try {
            if (empty($user_id) || empty($temp_file) || empty($original_name)) {
                return false;
            }

            $folder_name = "compress_post_video/" . $user_id;

            $extension = pathinfo($original_name, PATHINFO_EXTENSION);
            $dimensions = $this->getVideoDimensions($temp_file);

            $timestamp = round(microtime(true) * 1000);

            $file_name = $timestamp . "." . $extension;

            $response = $this->general->uploadAWSData(
                $temp_file, 
                $folder_name, 
                $file_name
            );

            // Format URL
            if ($response && isset($response['ObjectURL'])) {
                return [
                    "success" => true,
                    "file_name" => $file_name,
                    "folder" => $folder_name,
                    "file_type" => $extension,
                    "width" => $dimensions['width'] ?? null,
                    "height" => $dimensions['height'] ?? null,
                    "s3_url" => $response["ObjectURL"],
                ];
            }

            return [
                "success" => false,
                "error" => "AWS upload failed"
            ];

        } catch (Exception $e) {
            return [
                "success" => false,
                "error" => $e->getMessage()
            ];
        }
    }


    private function getVideoDimensions($filePath)
    {
        $cmd = "ffprobe -v error -select_streams v:0 -show_entries stream=width,height 
                -of json \"$filePath\"";
        
        $output = shell_exec($cmd);
        $json = json_decode($output, true);

        if (isset($json['streams'][0]['width']) && isset($json['streams'][0]['height'])) {
            return [
                'width' => $json['streams'][0]['width'],
                'height' => $json['streams'][0]['height']
            ];
        }

        return false;
    }


    // For reels page
    public function reels() {
        $user_id = $this->session->userdata('iUserId');
        $userdata = $this->session->userdata();
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $logged_userdata = $api_resp['data'][0];

        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        );

        $this->smarty->assign('userinfo', $userinfo);
        if (!$user_id) {
            $user_id = 0;
        }

        $latestActivePostId = $this->get_last_post_id($user_id);
        $this->assign_language();

        $params_other['page_index'] = 1;
        $params_other['post_id'] = $latestActivePostId;
        $params_other['user_id'] = $user_id;
        $params_other['viral_feed'] = 1;

        $reelsData = $this->cit_api_model->callAPI("other_post", $params_other);
        $reels_data = [
            'reelsData' => $reelsData['data'],
        ];
        // echo json_encode($reels_data);die;
        $this->smarty->assign($reels_data);
    }

    public function get_more_reels() {
        $user_id = $this->session->userdata('iUserId');

        $params_other = [
            'page_index' => (int)$this->input->get('nxpg'),
            'post_id'    => (int)$this->input->get('post_id'),
            'user_id'    => $user_id,
            'viral_feed' => 1
        ];

        $api_resp = $this->cit_api_model->callAPI('other_post', $params_other);

        echo json_encode($api_resp['data'] ?? []);
        exit;
    }

    public function get_last_post_id($userId) 
    {
        $this->db->select('iPostId');
        $this->db->from('post');
        $this->db->where('iUserId', $userId);
        $this->db->where('ePostType ', 'media');
        $this->db->where('eStatus', 'Active');
        $this->db->order_by('iPostId', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();
            return $row->iPostId;
        }

        return null;
    }

}

