<?php
//Music APIs for Mobile Application
defined('BASEPATH') || exit('No direct script access allowed');

class Watch_video extends Cit_Controller {
        public function __construct()
    {
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_model");
        $this->load->model("post/playlist_model");
    }

    public function get_watch_video()
    { echo "hi";die;
        $user_id = $this->input->get_post('user_id');
        $is_ads_show = $this->input->get_post('is_ads_show');

        $params = array(
            "user_id" => $user_id,
            "is_ads_show" => $is_ads_show,
        );

        echo json_encode($params);die;
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
            'u_profile_image' => $logged_userdata['u_profile_image'],
            'u_name' => $userdata['vName'],
            'u_userid' => $userdata['iUsersId'],
        );
        $data = [
            'most_views_video' => $most_views_video,
            'userinfo' => $userinfo,
            'recent_videos' => $recent_videos,
            'vp_video' => $random_video,
        ];

        echo json_encode($data);
        die;
    }
}