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
        if ($this->input->get('phpinfo')) {
            echo phpinfo();
            exit;
        }
        if ($this->session->userdata('iUserId')) {
            redirect($this->url->make('home/home/viral_posts'));
        }


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

    public function aboutus()
    {
        // About us page
    }

    public function termsconditions()
    {
        // Terms & conditions page
    }
    public function privacypolicy()
    {
        // Privacy Policy Page
    }
    public function homepage()
    {
        // New Home page
        $user_id = $this->session->userdata('iUserId');
        if ($user_id) {
            redirect($this->config->item('site_url') . 'home.html');
        }
    }

    public function playlist()
    {
        $this->load->model('Playlist_model');
        $profile_type = $this->input->get('profile_type');
        if ($profile_type == 'user_profile') {
            $user_id = $this->input->get('user_id');
        } else {
            $user_id = $this->session->userdata('iUserId');
        }
        // $user_id = $this->session->userdata('iUserId');
        $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);
        if (!empty($playlist)) {
            $playlist_id = $playlist[0]['id'];
        } else {
            $this->session->set_flashdata('error', 'No playlist found for the given user.');
            redirect($_SERVER['HTTP_REFERER']); // Redirect back to the previous page
            return;
        }
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
        $playlist_id = isset($_GET['playlistId']) ? $_GET['playlistId'] : null;
        $userId = isset($_GET['userId']) ? $_GET['userId'] : null;
        $user = $this->Playlist_model->playlist_user($userId);
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

        $data = [
            'playlist_posts' => $playlist_posts,
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
        //$postArr  = $this->input->get_post();
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
            "display_lang" => $arg_lang,
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
        echo "calling";die;
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
        // $server_timezone = 'Asia/Kolkata';
        $this->session->set_userdata('user_timezone', $user_timezone);
        echo 'success';
        exit;
    }

    public function otherEmail()
    {
        $this->load->library('email');

        $this->email->from('letsampit@gmail.com', 'Your Name');
        $this->email->to('ankur2002saha@gmail.com');

        $this->email->subject('Email Test');
        $this->email->message('Testing the email class.');

        $this->email->send();

        if (!$this->email->send()) {
            show_error($this->email->print_debugger());
        } else {
            echo "Email sent successfully!";
        }
        die;
    }
}
