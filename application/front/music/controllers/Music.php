<?php

defined('BASEPATH') || exit('No direct script access allowed');

class Music extends Cit_Controller {

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

    public function index()
    {
        $this->assign_language();
        $music_posts = $this->getMusicPosts();
        $user_id = $this->session->userdata('iUserId');
        $userdata = $this->session->userdata();
        $params['user_id'] = $user_id;
        $params['profile_user_id'] = $user_id;
        $api_resp = $this->cit_api_model->callAPI('my_profile', $params);
        if (empty($api_resp['data']) && $api_resp['settings']['success'] != 1) {
            throw new Exception($api_resp['settings']['message']);
        }

        $top_playlists = $this->Playlist_model->top_playlist(1,15);
        $logged_userdata = $api_resp['data'][0];

        $userinfo = array(
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        );

        $musicArtists = $this->getUsers();
        $this->smarty->assign('musicArtists', $musicArtists);
        $this->smarty->assign('playlist_post', $top_playlists);
        $this->smarty->assign('userinfo', $userinfo);
        $this->smarty->assign('music_posts', $music_posts);
    }


    public function uploadMusic()
    {
        $this->assign_language();
        $user_id = $this->session->userdata('iUserId');
        if(empty($_FILES['music_file']) || empty($_FILES['music_thumbnail'])) {
            echo "Both audio file and thumbnail are required.<br>";
            return;
        }

        $title       = $this->input->post('title');
        $description = $this->input->post('description');
        $duration    = $this->input->post('duration');


        $basePath = 'music/' . $user_id . '/';

        $audioPath     = $basePath . 'audio/';
        $thumbnailPath = $basePath . 'thumbnail/';


        if (!empty($_FILES['music_file']['name'])) {

            $audioTmp  = $_FILES['music_file']['tmp_name'];
            $audioExt  = pathinfo($_FILES['music_file']['name'], PATHINFO_EXTENSION);

            $audioUUID = $this->generateUUIDv4();
            $audioName = $audioUUID . '.' . $audioExt;

            $audioUrl = $this->general->uploadAWSData(
                $audioTmp,
                $audioPath,
                $audioName
            );
        }


        if (!empty($_FILES['music_thumbnail']['name'])) {

            $thumbTmp  = $_FILES['music_thumbnail']['tmp_name'];
            $thumbExt  = pathinfo($_FILES['music_thumbnail']['name'], PATHINFO_EXTENSION);

            $thumbUUID = $this->generateUUIDv4();
            $thumbName = $thumbUUID . '.' . $thumbExt;

            $thumbUrl = $this->general->uploadAWSData(
                $thumbTmp,
                $thumbnailPath,
                $thumbName
            );
        }

        $audioUrl = $audioUrl->get('ObjectURL') ?? '';
        $thumbUrl = $thumbUrl->get('ObjectURL') ?? '';

        $input_params = array(
            "user_id" => $user_id,
            "post_text" => trim($description),
            "visibility" => 'public',
            "post_type" => 'Music',
            'post_text_emoji' => $description
        );

        $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);

        if ($api_resp['settings']['success'] == 0) {
            throw new Exception($api_resp['settings']['message']);
        }

        $post_id = $api_resp["data"][0]['post_id'];

        //music track details save
        $music_params = array(
            "iPostId" => $post_id,
            "iUserId" => $user_id,
            "vUploadFile" => $audioName,
            "vMusicThumbnail" => $thumbName,
            "eStatus" => 'Active',
            "vSourceType" => 'AWS',
            "title" => $title,
            "duration" => $duration,
        );

        $this->db->insert('music_tracks', $music_params);

        $response = [
            'post_id'       => $post_id,
            'audio_url'     => $audioUrl,
            'thumbnail_url' => $thumbUrl,
        ];

        echo json_encode($response);
    }

    private function generateUUIDv4()
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    private function getMusicPosts($user_id = null, $post_id = null, $page = 1, $limit = 6)
    {
        $offset = ($page - 1) * $limit;

        /*
        |--------------------------------------------------------------------------
        | 🔥 Get Music Posts
        |--------------------------------------------------------------------------
        */

        $this->db->select("
            p.*,
            u.iUsersId AS user_id,
            u.vName,
            u.vEmail,
            u.vProfileImage,
            u.vCoverPhoto
        ");
        $this->db->from('post p');
        $this->db->join('users u', 'u.iUsersId = p.iUserId', 'left');

        $this->db->where('p.ePostType', 'Music');
        $this->db->where('p.eStatus', 'Active');

        if ($user_id) {
            $this->db->where('p.iUserId', $user_id);
        }

        if ($post_id) {
            $this->db->where('p.iPostId', $post_id);
        }

        $this->db->order_by('p.iPostId', 'DESC'); // optional but recommended
        $this->db->limit($limit, $offset);

        $posts = $this->db->get()->result_array();

        if (empty($posts)) {
            return [];
        }

        /*
        |--------------------------------------------------------------------------
        | 🔥 Get Latest Track Per Post
        |--------------------------------------------------------------------------
        */

        $post_ids = array_column($posts, 'iPostId');

        $this->db->reset_query();

        $this->db->where_in('iPostId', $post_ids);
        $this->db->where('eStatus', 'Active');
        $this->db->order_by('dAddedDate', 'DESC');

        $tracks = $this->db->get('music_tracks')->result_array();

        $trackMap = [];

        foreach ($tracks as $track) {
            // keep only newest track per post
            if (!isset($trackMap[$track['iPostId']])) {
                $trackMap[$track['iPostId']] = [
                    'audio_url'     => "https://s3.us-east-2.amazonaws.com/zoebook/music/{$track['iUserId']}/audio/{$track['vUploadFile']}",
                    'thumbnail_url' => "https://s3.us-east-2.amazonaws.com/zoebook/music/{$track['iUserId']}/thumbnail/{$track['vMusicThumbnail']}",
                    'status'        => $track['eStatus'],
                    'title'         => $track['title'],
                    'duration'      => $track['duration'],
                ];
            }
        }

        /*
        |--------------------------------------------------------------------------
        | 🔥 Build Final Response
        |--------------------------------------------------------------------------
        */

        $response = [];

        foreach ($posts as $post) {

            $postId = $post['iPostId'];

            $post['user'] = [
                'id'     => $post['user_id'],
                'name'   => $post['vName'],
                'email'  => $post['vEmail'],
                'avatar' => $post['vProfileImage']
                    ? "https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/{$post['vProfileImage']}"
                    : null,
                'cover'  => $post['vCoverPhoto']
                    ? "https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/{$post['vCoverPhoto']}"
                    : null
            ];

            unset(
                $post['user_id'],
                $post['vName'],
                $post['vEmail'],
                $post['vProfileImage'],
                $post['vCoverPhoto']
            );

            $post['music'] = $trackMap[$postId] ?? null;

            $response[] = $post;
        }

        return $response;
    }



    //This function will fetch those users who have uploaded songs.
    private function getUsers()
    {
        $users = $this->db
            ->select('iUserId')
            ->distinct()
            ->where('deleted', 0)
            ->where('eStatus', 'Active')
            ->get('music_tracks')
        ->result_array();

        $musicArtists = [];
        foreach ($users as $user) {
            $musicArtists[] = (int) $user['iUserId'];
        }

        // Safety check — avoid SQL error if empty
        if (empty($musicArtists)) {
            echo json_encode([]);
            return;
        }

        $userDetails = $this->db
            ->select('iUsersId, vName, vProfileImage')
            ->where_in('iUsersId', $musicArtists)
            ->get('users')
        ->result_array();

        return $userDetails;
    }

    //Music Details Page
    public function musicDetails() 
    {
        $this->assign_language();
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

        $postId = $this->input->get('postId');
        $musicPost = $this->getMusicPosts(null, $postId);

        $params['profile_user_id'] = $musicPost[0]['iUserId'];
        $musicUserDetails =  $this->cit_api_model->callAPI('my_profile', $params);
        $musicPost[0]['follower_count'] = $musicUserDetails['data'][0]['follower_count'];
        $musicPost[0]['following_count'] = $musicUserDetails['data'][0]['following_count'];

        $otherPosts = $this->getMusicPosts(null, null, 1, 8);
        
        $this->smarty->assign('userinfo', $userinfo);
        $this->smarty->assign('musicDetail', $musicPost);
        $this->smarty->assign('otherPosts', $otherPosts);
        $this->smarty->display('musicdetails.tpl');
    }


    public function getMorePosts()
    {
        $page = $this->input->post('page') ?? 1;
        $musicPosts = $this->getMusicPosts(null, null, $page, 6);
        echo json_encode($musicPosts ?? 'message: No more posts found');
    }


    public function details() {
        $this->assign_language();
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

        $postId = $this->input->get('postId');
        $musicPost = $this->getMusicPosts(null, $postId);

        $params['profile_user_id'] = $musicPost[0]['iUserId'];
        $musicUserDetails =  $this->cit_api_model->callAPI('my_profile', $params);
        $musicPost[0]['follower_count'] = $musicUserDetails['data'][0]['follower_count'];
        $musicPost[0]['following_count'] = $musicUserDetails['data'][0]['following_count'];

        $otherPosts = $this->getMusicPosts(null, null, 1, 8);
        
        $this->smarty->assign('userinfo', $userinfo);
        $this->smarty->assign('musicDetail', $musicPost);
        $this->smarty->assign('otherPosts', $otherPosts);
    }



    //Comments 
}
