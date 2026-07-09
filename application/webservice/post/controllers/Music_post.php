<?php
//Music APIs for Mobile Application
defined('BASEPATH') || exit('No direct script access allowed');

class Music_post extends Cit_Controller {
    public function __construct()
    {
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_model");
    }


    public function get_musics()
    {
        $user_id = $this->input->get_post('user_id');
        $post_id = $this->input->get_post('post_id');
        $page    = $this->input->get_post('page') ?? 1;
        $limit   = $this->input->get_post('limit') ?? 6;

        $data = $this->getMusicPosts($user_id, $post_id, $page, $limit);

        echo json_encode([
            'status' => true,
            'data'   => $data
        ]);
    }


    public function get_user_music()
    {
        $user_id = $this->input->get_post('user_id');
        $page    = $this->input->get_post('page') ?? 1;
        $limit   = $this->input->get_post('limit') ?? 6;

        $data = $this->getMusicPosts($user_id, null, $page, $limit);

        echo json_encode([
            'status' => true,
            'data'   => $data
        ]);

    }


    public function get_music_post()
    {
        $post_id = $this->input->get_post('post_id');
        $data = $this->getMusicPosts(null, $post_id);

        echo json_encode([
            'status' => true,
            'data'   => $data
        ]);
    }

    private function getMusicPosts($user_id = null, $post_id = null, $page = 1, $limit = 6)
    {
        $offset = ($page - 1) * $limit;

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

        if (!empty($user_id)) {
            $this->db->where('p.iUserId', $user_id);
        }

        if (!empty($post_id)) {
            $this->db->where('p.iPostId', $post_id);
        }

        $this->db->order_by('p.iPostId', 'DESC');
        $this->db->limit($limit, $offset);

        $posts = $this->db->get()->result_array();

        if (empty($posts)) {
            return [];
        }

        /*
        |------------------------------------------
        | Get Tracks
        |------------------------------------------
        */

        $post_ids = array_column($posts, 'iPostId');

        $this->db->where_in('iPostId', $post_ids);
        $this->db->where('eStatus', 'Active');
        $this->db->order_by('dAddedDate', 'DESC');

        $tracks = $this->db->get('music_tracks')->result_array();

        $trackMap = [];

        foreach ($tracks as $track) {

            if (!isset($trackMap[$track['iPostId']])) {

                $trackMap[$track['iPostId']] = [
                    'audio_url' => "https://s3.us-east-2.amazonaws.com/zoebook/music/{$track['iUserId']}/audio/{$track['vUploadFile']}",
                    'thumbnail_url' => "https://s3.us-east-2.amazonaws.com/zoebook/music/{$track['iUserId']}/thumbnail/{$track['vMusicThumbnail']}",
                    'status' => $track['eStatus'],
                    'title' => $track['title'],
                    'duration' => $track['duration']
                ];
            }
        }

        /*
        |------------------------------------------
        | Build Response
        |------------------------------------------
        */

        $response = [];

        foreach ($posts as $post) {

            $postId = $post['iPostId'];

            $post['user'] = [
                'id' => $post['user_id'],
                'name' => $post['vName'],
                'email' => $post['vEmail'],
                'avatar' => $post['vProfileImage']
                    ? "https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/{$post['vProfileImage']}"
                    : null,
                'cover' => $post['vCoverPhoto']
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


    public function get_users()
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

        if (empty($musicArtists)) {
            echo json_encode([]);
            return;
        }

        $userDetails = $this->db
            ->select('iUsersId, vName, vProfileImage')
            ->where_in('iUsersId', $musicArtists)
            ->get('users')
        ->result_array();

        echo json_encode([
            'status' => true,
            "data"   => $userDetails
        ]);
    }


    // Upload new music posts
    public function uploadMusic()
{
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
    header("Access-Control-Allow-Headers: Content-Type, Authorization");
    header("Content-Type: application/json"); // ← Always return JSON

    $this->assign_language();

    // Handle preflight
    if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
        http_response_code(200);
        exit();
    }

    $user_id = $this->input->get_post('user_id');

    // Validate required fields
    if (empty($user_id)) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'User ID is required']);
        return;
    }

    if (empty($_FILES['music_file']['name']) || empty($_FILES['music_thumbnail']['name'])) {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Both audio file and thumbnail are required']);
        return;
    }

    $title       = $this->input->get_post('title');
    $description = $this->input->get_post('description') ?? '';
    $duration    = $this->input->get_post('duration') ?? '';

    $basePath      = 'music/' . $user_id . '/';
    $audioPath     = $basePath . 'audio/';
    $thumbnailPath = $basePath . 'thumbnail/';

    $audioUrl = '';
    $thumbUrl = '';
    $audioName = '';
    $thumbName = '';

    // Upload audio
    try {
        $audioTmp  = $_FILES['music_file']['tmp_name'];
        $audioExt  = pathinfo($_FILES['music_file']['name'], PATHINFO_EXTENSION);
        $audioUUID = $this->generateUUIDv4();
        $audioName = $audioUUID . '.' . $audioExt;

        $audioResult = $this->general->uploadAWSData($audioTmp, $audioPath, $audioName);
        $audioUrl    = $audioResult->get('ObjectURL') ?? '';

        if (empty($audioUrl)) {
            throw new Exception('Audio file upload to AWS failed');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Audio upload failed: ' . $e->getMessage()]);
        return;
    }

    // Upload thumbnail
    try {
        $thumbTmp  = $_FILES['music_thumbnail']['tmp_name'];
        $thumbExt  = pathinfo($_FILES['music_thumbnail']['name'], PATHINFO_EXTENSION);
        $thumbUUID = $this->generateUUIDv4();
        $thumbName = $thumbUUID . '.' . $thumbExt;

        $thumbResult = $this->general->uploadAWSData($thumbTmp, $thumbnailPath, $thumbName);
        $thumbUrl    = $thumbResult->get('ObjectURL') ?? '';

        if (empty($thumbUrl)) {
            throw new Exception('Thumbnail upload to AWS failed');
        }
    } catch (Exception $e) {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Thumbnail upload failed: ' . $e->getMessage()]);
        return;
    }

    // Create post
    $input_params = [
        "iUserId"         => $user_id,
        "tPostText"       => trim($description),
        "eVisibility"      => 'public',
        "ePostType"       => 'Music',
        'tPostTextEmoji' => $description,
    ];

    // $api_resp = $this->cit_api_model->callAPI("add_post", $input_params);

    // if ($api_resp['settings']['success'] == 0) {
    //     http_response_code(500);
    //     echo json_encode(['success' => false, 'message' => $api_resp['settings']['message']]);
    //     return;
    // }

    $this->db->insert('post', $input_params);    

    $post_id = $this->db->insert_id(); 

    // Save music track
    $music_params = [
        "iPostId"          => $post_id,
        "iUserId"          => $user_id,
        "vUploadFile"      => $audioName,
        "vMusicThumbnail"  => $thumbName,
        "eStatus"          => 'Active',
        "vSourceType"      => 'AWS',
        "title"            => $title,
        "duration"         => $duration,
    ];

    $this->db->insert('music_tracks', $music_params);

    http_response_code(200);
    echo json_encode([
        'success'       => true,
        'post_id'       => $post_id,
        'audio_url'     => $audioUrl,
        'thumbnail_url' => $thumbUrl,
    ]);
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


    public function get_watch_video()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Content-Type: application/json");
        
        $user_id = $this->input->get_post('user_id');
        $is_ads_show = $this->input->get_post('is_ads_show');
        $page_index = $this->input->get_post('page_index');

        // Call viral_plus_media_list API using cURL
        $api_url = "https://zoebook.mydevfactory.com/WS/viral_plus_media_list";

        $postData = [
            'user_id'     => $user_id,
            'is_ads_show' => $is_ads_show,
            'page_index'  => $page_index
        ];

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($postData),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode([
                'status' => false,
                'message' => curl_error($ch)
            ]);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        $vp_posts = json_decode($response, true);
        
        if (empty($vp_posts['data'])) {
            echo json_encode([
                'status' => false,
                'message' => 'No data found'
            ]);
            return;
        }

        $vp_videos = [];
        $vp_plus_posts = [];

        foreach ($vp_posts['data'] as $value) {

            $post_id = $value['post_id'];
            $post_media = $this->get_post_media($post_id);
            $post_details = $this->get_post_by_id($post_id);

            // echo json_encode($post_media);die;
            
            $value['post_details'] = $post_details;
            $vp_plus_posts['data'][] = $value;

            if ($value['media_type'] == 'Video') {
                $vp_videos[] = $value;
            }

            foreach ($post_media as &$media) {

                if ($media['vSourceType'] == 'aws') {

                    $media['full_video_url'] =
                        'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' .
                        $media['iUserId'] . '/' . $media['vUploadFile'];

                    $media['full_thumbnail_url'] =
                        'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' .
                        $media['iUserId'] . '/' . $media['vVideoThumbnail'];

                } elseif ($media['vSourceType'] == 'cld') {

                    $media['full_video_url'] = $media['vCloudinary'];
                    $media['full_thumbnail_url'] = $media['vCloudinary'];
                }

                $media['post_details'] = $post_details;
            }

            $value['data'] = array_merge($vp_posts['data'], $post_media);
            
        }
        usort($vp_videos, function ($a, $b) {
            return $b['views_count'] - $a['views_count'];
        });

        $most_views_video = $vp_videos;

        usort($vp_videos, function ($a, $b) {
            return strtotime($b['added_date']) - strtotime($a['added_date']);
        });

        $recent_videos = $vp_videos;

        shuffle($vp_videos);

        $random_video = $vp_videos;

// echo json_encode($random_video);die;

        $params = [
            'user_id' => $user_id,
            'profile_user_id' => $user_id
        ];

        // Call my_profile API using cURL
        $api_url = "https://zoebook.mydevfactory.com/WS/my_profile";

        $ch = curl_init();

        curl_setopt_array($ch, [
            CURLOPT_URL => $api_url,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query($params),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_TIMEOUT => 30,
        ]);

        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            echo json_encode([
                'status' => false,
                'message' => curl_error($ch)
            ]);
            curl_close($ch);
            return;
        }

        curl_close($ch);

        $api_resp = json_decode($response, true);

        if (empty($api_resp['data']) && (!isset($api_resp['settings']['success']) || $api_resp['settings']['success'] != 1)) {
            throw new Exception(isset($api_resp['settings']['message']) ? $api_resp['settings']['message'] : 'Failed to retrieve profile data');
        }


        $logged_userdata = $api_resp['data'][0];
        $userdata = $this->session->userdata();

        $userinfo = [
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        ];

        $data = [
            'most_views_video' => $most_views_video,
            'userinfo' => $userinfo,
            'recent_videos' => $recent_videos,
            'vp_video' => $random_video,
        ];

        echo json_encode($data);
        die;
    }

    public function get_post_media($post_id) {
        $this->db->select('*'); 
        $this->db->from('post_media');
        $this->db->where('iPostId', $post_id);
        $query = $this->db->get();
        return $query->result_array();
    }

   public function get_post_by_id($post_id) {
        $this->db->select('*'); 
        $this->db->from('post');
        $this->db->where('iPostId', $post_id);
        $query = $this->db->get();
        return $query->result_array();
    }
}