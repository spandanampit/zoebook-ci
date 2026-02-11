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
class Home extends Cit_Controller {

    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct() {
        parent::__construct();
        $this->load->model('cit_api_model');
    }

    /**
     * index method is used to initialize index function.
     */
    public function index() {
        try {
            $user_id = $this->session->userdata('iUserId');

            if (!$user_id) {
                $this->session->set_flashdata('failure', "Please log in first to view posts.");
                redirect($this->config->item("site_url"));
            }

            $userdata = $this->session->userdata();

            $userinfo = array(
                'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
                'u_name' => $userdata['vName']
            );
            $this->smarty->assign('userinfo', $userinfo);

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
            //pr($posts_data,1);
            $render_arr['posts'] = $posts_data;
            $render_arr['cr_pg'] = $current_page;
            $render_arr['nx_pg'] = $next_page;
            $render_arr['posts_pgtype'] = "feed";
            $this->smarty->assign($render_arr);
        } catch (Exception $e) {
            $msg = $e->getMessage();
            $code = $e->getCode();
        }
    }

    public function getPosts($params) {
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
            }
        }
        if ($page_type == "viral") {
            unset($params['profile_user_id']);
            unset($params['is_feed']);
            $api_resp = $this->cit_api_model->callAPI("viral_post_list", $params);
        } else {
            if ($page_type == "my_profile") {
                $params['is_feed'] = 0;
            } else if ($page_type == "other_profile") {
                $params['profile_user_id'] = $this->input->get("other_user_id");
                $params['is_feed'] = 0;
            }
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
        $return_array["posts_data"] = $this->parser->parse("common/feed_list.tpl", $render_arr, true);
        $return_array["cr_pg"] = $current_page;
        $return_array["nx_pg"] = $next_page;
        echo json_encode($return_array);
        exit;
    }

    public function getStatistics($posts_data) {
        $user_id = $this->session->userdata('iUserId');
        for ($i = 0; $i < count($posts_data); $i++) {
            $post_item = $posts_data[$i];
            $post_type = $post_item["post_type"];
            $post_id = $post_item["post_id"];
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
                $comment_count = $postdetail_media['total_comments_count'];
                $is_like = $postdetail_media['is_liked'];
                //$comments_params = array_merge($comments_params, array('post_media_id' => $media_id));
            } else if ($post_type == "Share") {
                $post_metadata = $post_item['get_actual_post']["p_post_meta_data"];
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
            }
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

    /* HB-0129 : post detail page */

    public function post_detail($post_id = 0) {

        $user_id = $this->session->userdata('iUserId');
        $userdata = $this->session->userdata();
        $userinfo = array(
            'u_profile_image' => ($userdata['vProfileImage'] != '') ? $userdata['vProfileImage'] : ($userdata['userProfile']['picture']),
            'u_name' => $userdata['vName']
        );
        $this->smarty->assign('userinfo', $userinfo);

        if (!$user_id) {
            //$this->session->set_flashdata('failure', "Please log in to view post.");
            //redirect($this->config->item("site_url"));
            $user_id = 0;
        }
        try {
            if(trim($post_id) != ""){
                $post_id = $this->general->decryptDataMethod($post_id, "cit");//base64
            }
            if ($this->input->is_ajax_request()) {
                $inputparamarr = $this->input->get_post();
                $post_id = $inputparamarr['posted_postid'];
                $posted_mediaid = $inputparamarr['posted_mediaid'];
            }
            if (isset($post_id) && $post_id != '') {
                $params['post_id'] = $post_id;
                $params['user_id'] = $user_id;
                $api_resp = $this->cit_api_model->callAPI('post_detail', $params);

                //pr($api_resp);exit;

                if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                    throw new Exception($api_resp['settings']['message']);
                }

                $postdata = $api_resp['data'];
                $postmedia = $api_resp['data']['get_post_media'];

                $share_ogtitle = "Zoebook";
                $ogTitle = $postdata['post_text'];
                if(trim($ogTitle) != ""){
                    $ogtitle_arr = explode('\u', $ogTitle);
                    if(isset($ogtitle_arr[0]) && trim($ogtitle_arr[0]) != ""){
                        $share_ogtitle = $ogtitle_arr[0];
                    }                    
                }
                $ogUrl = $this->general->setdiplayposturl($post_id,$postdata['post_text']);
                $ogSiteName = $this->config->item('SITE_NAME');
                $ogImage = $postmedia[0]['display_image'];
                $ogType = "website";
                $ogDescription = $postdata['post_text'];
                $this->smarty->assign('ogTitle', trim($share_ogtitle));
                $this->smarty->assign('ogUrl', $ogUrl);
                $this->smarty->assign('ogSiteName', $ogSiteName);
                $this->smarty->assign('ogImage', $ogImage);
                $this->smarty->assign('ogType', $ogType);
                $this->smarty->assign('ogDescription', trim($share_ogtitle));


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
                    $api_resp_view = $this->cit_api_model->callAPI('update_impression_count', $params);
                }


                $api_resp2 = $this->cit_api_model->callAPI('comments_list', $params);
                $postcomment = $api_resp2['data'];

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
                    $params_other['page_index'] = 1;
                    $params_other['post_id'] = $post_id;
                    $params_other['user_id'] = $postdata['posted_user_id'];
                    $api_resp3 = $this->cit_api_model->callAPI('other_post', $params_other);
                    $otherpost = $api_resp3['data'];

                    $this->smarty->assign('islike', $islike);
                    $this->smarty->assign('viewcount', $viewcount);
                    $this->smarty->assign('likescount', $likescount);
                    $this->smarty->assign('commentcount', $commentcount);

                    $this->smarty->assign('mediaid', $mediaid);
                    $this->smarty->assign('postinfo', $postdata);
                    $this->smarty->assign('postmedia', $postmedia);
                    $this->smarty->assign('otherpost', $otherpost);
                    $this->smarty->assign('postcomment', $postcomment);
                }
            }
        } catch (Exception $e) {

            $var_msg = $e->getMessage();
            $this->smarty->assign('errormsg', $var_msg);
            //redirect();
        }
    }

    public function my_profile() {
        $render_arr['profile_type'] = "my_profile";

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to view profile.");
            redirect($this->config->item("site_url"));
        }
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

                /* get following list */
                $api_resp_following = $this->cit_api_model->callAPI('user_following', $params);

                $this->smarty->assign('userfollower', $api_resp_follower['data']);
                $this->smarty->assign('userfollowing', $api_resp_following['data']);
                $this->smarty->assign('userinfo', $userdata);

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
                $render_arr['posts_pgtype'] = "my_profile";
                $this->smarty->assign($render_arr);
            }
        } catch (Exception $e) {

            $var_msg = $e->getMessage();
            $this->smarty->assign('errormsg', $var_msg);
        }

        $this->smarty->assign($render_arr);
    }

    public function myprofile_action() {

        $user_id = $this->session->userdata('iUserId');
        if (!$user_id) {
            $this->session->set_flashdata('failure', "Please log in to view post.");
            redirect($this->config->item("site_url"));
        }
        try {
            $postArr = $this->input->get_post();  // $this->input->get_post()
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
            //pr($params);exit;
            $api_resp = $this->cit_api_model->callAPI('update_profile_cover', $params);

            if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
                throw new Exception($faiilurmsg);
            }
            $params1['user_id'] = $user_id;
            $params1['profile_user_id'] = $user_id;
            $api_resp1 = $this->cit_api_model->callAPI('my_profile', $params1);
            $record = $api_resp1['data'][0];
            $this->session->set_userdata("vName", $record["u_name"]);
            $this->session->set_userdata("vProfileImage", str_replace("&height=500&width=500","&height=100&width=100", $record["u_profile_image"]));
            
            $this->session->set_flashdata('success', $successmsg);
            redirect($this->url->make('home/home/my_profile'));
        } catch (Exception $e) {
            $var_msg = $e->getMessage();
            $this->session->set_flashdata('failure', $var_msg);
            redirect($this->url->make('home/home/my_profile'));
        }
    }

    public function user_profile($user_id = 0) {
        $render_arr['profile_type'] = "user_profile";

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
                $this->smarty->assign($render_arr);
            }
        } catch (Exception $e) {

            $var_msg = $e->getMessage();
            $this->smarty->assign('errormsg', $var_msg);
        }

        $this->smarty->assign($render_arr);
    }

    public function edit_profile_action() {

        try {
            $postArr = $this->input->get_post();

            $params['user_id'] = $this->session->userdata('iUserId');
            $params['user_name'] = $postArr['vEditName'];
            $params['user_phone'] = $postArr['vEditPhone'];
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

    public function changepassword_action() {

        try {
            $postArr = $this->input->get_post();

            $params['user_id'] = $this->session->userdata('iUserId');
            $params['old_password'] = $postArr['vOldPassword'];
            $params['new_password'] = $postArr['vNewPassword'];

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

    function unfollowuser_action() {
        $postArr = $this->input->get_post();

        $params['user_id'] = $postArr['userid'];
        $params['following_user_id'] = $postArr['followid'];
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

    public function followuser_action() {

        $postArr = $this->input->get_post();


        if ((isset($postArr['pendingrequestid_ar']) && $postArr['pendingrequestid_ar'] != '') && ($postArr['btnactval'] == 'Accepted' || $postArr['btnactval'] == 'Rejected')) {
            // cancel request
            $params['user_id'] = $postArr['userid'];
            $params['user_follow_request_id'] = $postArr['pendingrequestid_ar'];
            $params['status'] = $postArr['btnactval'];

            $api_resp = $this->cit_api_model->callAPI('follow_accept_reject_cancel', $params);
        } else if (isset($postArr['pendingrequestid']) && $postArr['pendingrequestid'] != '') {
            // cancel request
            $params['user_id'] = $postArr['userid'];
            $params['user_follow_request_id'] = $postArr['pendingrequestid'];
            $params['status'] = $postArr['btnactval'];

            $api_resp = $this->cit_api_model->callAPI('follow_accept_reject_cancel', $params);
        } else {
            $params['user_id'] = $postArr['userid'];
            $params['following_user_id'] = $postArr['followid'];

            $api_resp = $this->cit_api_model->callAPI('follow_request', $params);


            $params['user_id'] = $postArr['userid'];
            $params['profile_user_id'] = $postArr['followid'];
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

        $this->skip_template_view();

        echo json_encode($jsonarr);
        exit;
    }

    /**
     * add_post
     * Add post with media
     *
     * @return json api response
     * @throws Exception
     */
    public function add_post() {
        ini_set("memory_limit", "-1");
        ini_set('max_execution_time', 0); 
        ini_set('post_max_size', '500M'); 
        ini_set('upload_max_filesize', '500M'); 
        set_time_limit(0);
        /*if($_SERVER['REMOTE_ADDR'] == "122.183.43.40"){
            error_reporting(1);
            ini_set("display_errors", 1);
        }*/
        $return_array = array();
        try {
            $input_data = $this->input->post();
            $post_type = "Text";
            $post_media = $_FILES;


            if (trim($input_data['post_text']) == "" && count($post_media) == 0) {
                throw new Exception("Invalid data");
            }
            if (is_array($post_media) && !empty($post_media) && count($post_media) > 0) {
                $post_type = "Media";
            }
            $input_params = array(
                "user_id" => $this->session->userdata('iUserId'),
                "post_text" => trim($input_data['post_text']),//trim($input_data['post_text']), //added json_encode for emoji
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type
            );
            $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);
            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            $post_id = $api_resp["data"][0]['post_id'];
            if ($post_type == "Media") {
                $posted_media_count = count($post_media);
                $media_count_loop = 0;
                for ($i = 0; $i < count($post_media); $i++) {
                    $video_thumbnail = "";
                    $_FILES['upload_file'] = $_FILES[$i];
                    $media_count_loop = $media_count_loop + 1;
                    $media_type_arr = explode("/", $post_media[$i]['type']);
                    $media_type = $media_type_arr[0];
                    /*if ($media_type == "video") {
                        $thumbnail_path = $this->config->item('upload_path') . 'thumbnail/';
                        $this->general->createUploadFolderIfNotExists('thumbnail');
                        $tmp_name = $_FILES['upload_file']['tmp_name'];
                        $name = $_FILES['upload_file']['name'];
                        move_uploaded_file($tmp_name,$thumbnail_path.$name);
                        
                        $video = $thumbnail_path . escapeshellcmd($_FILES['upload_file']['name']);
                        $cmd = "ffmpeg -i $video 2>&1";
                        $second = 1;
                        //if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
                            //$total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
                            //$second = rand(1, ($total - 1));
                        //}
                        $userid = $this->session->userdata('iUserId');
                        $thumbname = $userid . time() .'.jpg';
                        $image  = $thumbnail_path . $thumbname;
                        $cmd = "ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
                        
                        exec($cmd, $output, $retval);
                        $thumb_file_path = $image;
                        if(file_exists($thumb_file_path)){
                            $file_path = "post_media";
                            $folder_id = trim($userid);
                            $file_path = $file_path."/".$folder_id;
                            $file_name = $thumbname;
                            $file_tmp_path = $thumb_file_path;
                            $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                            //if($response){
                                //$this->db->update($this->table_name." AS ".$this->table_alias, $data);
                            //}
                            $video_thumbnail = $thumbname;
                            unlink($thumbnail_path . $name);
                            unlink($thumb_file_path);
                        }
                    }*/
                    $media_input_params = array(
                        "post_id" => $post_id,
                        "user_id" => $this->session->userdata('iUserId'),
                        "file_type" => ucfirst($media_type),
                        "video_thumbnail" => "",
                        "is_completed" => ($media_count_loop == $posted_media_count) ? 1 : 0
                    );
                    $media_api_resp = $this->cit_api_model->callAPI("add_post_media", $media_input_params);
                    $media_id = $media_api_resp['data']['insert_post_media'][0]['media_id'];
                    /*if(trim($video_thumbnail) != ""){
                        $thumb_data = array(
                            "vVideoThumbnail" => $video_thumbnail
                        );
                        $this->db->where("iPostMediaId", $media_id);
                        $this->db->update("post_media", $thumb_data);
                    }*/
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

    /**
     * viral_posts
     */
    public function viral_posts() {
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
        //pr($posts_data,1);
        $render_arr['posts'] = $posts_data;
        $render_arr['cr_pg'] = $current_page;
        $render_arr['nx_pg'] = $next_page;
        $render_arr['posts_pgtype'] = "viral";
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
    public function like_post() {
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
            if($e->getMessage() == 'NOTLOGIN') {
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
    public function report_post() {
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
    public function delete_post() {
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
    public function comment_post() {
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
            if ($input_post['comment_mediaid'] != 0) {
                $params = array_merge($params, array('post_media_id' => $input_post['comment_mediaid']));
            }
            if ($input_post['postcomment_id'] != 0) {
                $params = array_merge($params, array('post_comment_id' => $input_post['postcomment_id'], 'reply_text' => trim($comment)));
            }
            if ($pagefrom == 'reply_comment') {
                $api_resp_reply = $this->cit_api_model->callAPI("reply_on_comment", $params);
                if ($api_resp_reply['settings']['success'] == 0) {
                    throw new Exception($api_resp_reply['settings']['message']);
                }

                $replylist['showpostreplyarr'] = $this->general->get_replylist_comment($input_post['postcomment_id'], $post_id);
                $return_array['status'] = "Success";
                $return_array['message'] = $api_resp['settings']['message'];
                $return_array['postdata'] = $this->parser->parse("common/common_replycomment.tpl", $replylist, true);
                echo json_encode($return_array);
                exit;
            } else {
                $api_resp = $this->cit_api_model->callAPI("comment_on_post", $params);
            }
            //pr($api_resp);exit;
            if ($api_resp['settings']['success'] == 0) {
                throw new Exception($api_resp['settings']['message']);
            }
            //pr($api_resp);exit;
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
            if (is_array($comments_data) && !empty($comments_data) && count($comments_data) > 0) {

                if ($pagefrom == 'postdetail') {
                    $render_arr['postcomment'] = $comments_data;
                    $comments = $this->parser->parse("common/common_postcomment.tpl", $render_arr, true);
                } else {
                    $render_arr['comments'] = $comments_data;
                    $comments = $this->parser->parse("common/comments.tpl", $render_arr, true);
                }
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

    /**
     * like_postcomment
     *
     * Like comment
     *
     * @throws Exception
     */
    public function like_postcomment() {
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
            if($e->getMessage() == 'NOTLOGIN') {
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
    public function share_post_mytimeline() {
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

    public function get_edit_post() {
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
                "post_text" => $post_data['post_text'],
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

    public function update_post() {
        $return_array = array();
        try {
            $input_data = $this->input->post();

            $post_type = $input_data['post_type'];
            $post_id = $input_data['edit_post_id'];
            $delete_media_id = $input_data['delete_media_id'];

            $post_media = $_FILES;

            if (trim($input_data['edit_post_text']) == "") {
                throw new Exception("Invalid data");
            }

            $input_params = array(
                "user_id" => $this->session->userdata('iUserId'),
                "post_text" => trim($input_data['edit_post_text']),
                "visibility" => $input_data['visibility'],
                "post_type" => $post_type,
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
                        $name = $_FILES['upload_file']['name'];
                        move_uploaded_file($tmp_name,$thumbnail_path.$name);
                        
                        $video = $thumbnail_path . escapeshellcmd($_FILES['upload_file']['name']);
                        $cmd = "ffmpeg -i $video 2>&1";
                        $second = 1;
                        /*if (preg_match('/Duration: ((\d+):(\d+):(\d+))/s', `$cmd`, $time)) {
                            $total = ($time[2] * 3600) + ($time[3] * 60) + $time[4];
                            $second = rand(1, ($total - 1));
                        }*/
                        $userid = $this->session->userdata('iUserId');
                        $thumbname = $userid . time() .'.jpg';
                        $image  = $thumbnail_path . $thumbname;
                        $cmd = "ffmpeg -i $video -deinterlace -an -ss $second -t 00:00:01 -r 1 -y -vcodec mjpeg -f mjpeg $image 2>&1";
                        
                        exec($cmd, $output, $retval);
                        $thumb_file_path = $image;
                        if(file_exists($thumb_file_path)){
                            $file_path = "post_media";
                            $folder_id = trim($userid);
                            $file_path = $file_path."/".$folder_id;
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
                    if(trim($video_thumbnail) != ""){
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

    /**
     * notifications
     *
     * Notifications
     *
     * @return string Notifications html
     * @throws Exception
     */
    public function notifications() {
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
     * respond_follow_request
     *
     * Accept/Reject follow request
     *
     * @throws Exception
     */
    public function respond_follow_request() {
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

    public function feed_comment_post() {
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
                $return_array['message'] = $api_resp['settings']['message'];
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

    public function feed_change_media() {
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
    public function delete_comment_post() {
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

    public function get_comments() {
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
            $comments_api_resp = $this->cit_api_model->callAPI("comments_list", $comments_params);
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

    public function getmyip() {
        $realip = $this->general->getHTTPRealIPAddr();
        return $realip;
    }

}
