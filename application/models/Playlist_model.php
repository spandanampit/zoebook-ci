<?php

class Playlist_model extends CI_Model {

      public function __construct() {
      parent::__construct();
      // Load the database library if needed (optional)
      // $this->load->database();
      }

      // Define your model methods here
    public function insert_playlist($data) {
        $this->db->insert('playlists', $data);
        return $this->db->insert_id();
    }

    public function playlist_user($user_id) {
        $this->db->select('*'); 
        $this->db->from('users');
        $this->db->where('iUsersId', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }
      
    public function get_playlists_by_userId($user_id) {
        $this->db->select('*'); 
        $this->db->from('playlists');
        $this->db->where('user_id', $user_id);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function insert_playlist_post( $data) {
        $this->db->insert('playlist_posts', $data);
        return $this->db->affected_rows() > 0;
    }

    public function update_playlist_post($post_id, $data) {
        $this->db->where('post_id', $post_id);
        $this->db->update('playlist_posts', $data);
        return $this->db->affected_rows() > 0;
    }

    public function remove_playlist_post($post_id, $playlist_id) {
        $conditions = array(
            'post_id' => $post_id,
            'playlist_id' => $playlist_id
        );
        $this->db->where($conditions);
        return $this->db->delete('playlist_posts');
    }

    public function get_playlist_post($playlist_id) {
        $this->db->select('*'); 
        $this->db->from('playlist_posts');
        $this->db->where('playlist_id', $playlist_id);
        $this->db->order_by('post_id', 'DESC');
        $this->db->where('deleted_at', 0);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function top_playlist_bkp($page_index = 1) {
        $limit = 10;
        $offset = ($page_index - 1) * $limit;
    
        $this->db->select('*');
        $this->db->from('playlists');
        $this->db->limit($limit, $offset);
        $query = $this->db->get();
        $all_playlists = $query->result_array();
    
        if (empty($all_playlists)) {
            log_message('debug', 'No playlists found in top_playlist_bkp for page: ' . $page_index);
            return [
                'playlists' => [],
                'total_playlists' => 0
            ];
        }
    
        $this->db->from('playlists');
        $total_playlists = $this->db->count_all_results();
    
        $playlist_main = [];
    
        foreach ($all_playlists as $value) {
            $playlist_id = $value['id'];
            $playlist_user_id = $value['user_id'];
            $user_image = $this->getUserProfile($playlist_user_id);
            $value['user_profile_image'] = $user_image;
            
            $playlist_posts = $this->Playlist_model->get_playlist_post($playlist_id, 1);
    
            if (!empty($playlist_posts)) {
                $post_id = $playlist_posts[0]['post_id'];
                $post_details = $this->Playlist_model->get_post_by_id($post_id);
    
                    if (!empty($post_details)) {
                            $playlist_post_id = $post_details[0]['iPostId'];
        
                            $post_media = $this->Playlist_model->get_post_media($playlist_post_id);
        
                            $main_media = [];
        
                            foreach ($post_media as $media) {
                                if ($media['vSourceType'] == 'aws' ||$media['vSourceType'] == 'cld') {
                                        $media['full_video_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vUploadFile'];
                                        $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                                }
        
                                $main_media[] = $media;
                            }
        
                            $playlist_data = [
                                'playlist' => $value,
                                'post' => $post_details,
                                'media' => $main_media
                            ];
        
                            $playlist_main[] = $playlist_data;
                    } else {
                            log_message('debug', "No post details found for post_id: $post_id");
                    }
                } else {
                    log_message('debug', "No posts found for playlist_id: $playlist_id");
                }
        }
    
        return [
                'data' => $playlist_main,
                'total_playlists' => $total_playlists
        ];
    }

    public function top_playlist($page = 1, $limit = null) {
        $this->db->select('*');
        $this->db->from('playlists');
        $this->db->order_by('created_at', 'DESC');
        $this->db->order_by('updated_at', 'DESC');
        $query = $this->db->get();

        $all_playlists = $query->result_array();

        
        $playlist_main = [];
        $post_counter = 0;
        $limit = $limit ? $limit : 5;
        $start = ($page - 1) * $limit;

        foreach ($all_playlists as $value) {
            if ($post_counter >= $start + $limit) {
                break;
            }

            $playlist_user_id = $value['user_id'];
            $playlist_id = $value['id'];
            $playlist_posts = $this->Playlist_model->get_playlist_post($playlist_id);
            
            if (!empty($playlist_posts)) {
                $post_id = $playlist_posts[0]['post_id'];
                $post_details = $this->Playlist_model->get_post_by_id($post_id);

                foreach ($post_details as $playlist_post) {
                    if ($post_counter >= $start && $post_counter < $start + $limit) {
                        $playlist_post_id = $playlist_post['iPostId'];
                        $post_media = $this->Playlist_model->get_post_media($playlist_post_id);
                        $main_media = [];

                        foreach ($post_media as $media) {
                            $params['user_id'] = $playlist_user_id;
                            $params['profile_user_id'] = $playlist_user_id;
                            $api_resp = $this->cit_api_model->callAPI('my_profile', $params);

                            $logged_userdata = $api_resp['data'][0];
                            $media['u_name'] = $logged_userdata['u_name'];
                            $media['u_profile_image'] = $logged_userdata['u_profile_image'];

                            if ($media['vSourceType'] == 'aws') {
                                $media['full_video_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vUploadFile'];
                                $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                            } elseif ($media['vSourceType'] == 'cld') {
                                $media['full_video_url'] = $media['vCloudinary'];
                                $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                            }

                            $main_media[] = $media;
                        }

                        $playlist_post['post_media'] = $post_media;
                        $playlist_post['main_media'] = $main_media;
                        $playlist_post['playlist_id'] = $playlist_id;
                        $playlist_post['playlist_userId'] = $playlist_user_id;

                        $playlist_main[] = $playlist_post;
                    }

                    $post_counter++;
                    if ($post_counter >= $start + $limit) {
                        break; // Ensure we stop adding more once limit reached
                    }
                }
            }
        }

        return $playlist_main;
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

  // playlist comment section

  public function get_followers($user_id, $option) {
    $this->db->select('*'); 
    $this->db->from('user_followers');
    $this->db->where($option, $user_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function like_playlist($data) {
    $user_id = $data['user_id'];
    $playlist_id = $data['playlist_id'];
    $like_id = $data['like_id'];

    $this->db->select('*'); 
    $this->db->from('playlist_likes');
    $this->db->where('playlist_id', $playlist_id );
    $this->db->where('user_id', $user_id);
    $query = $this->db->get();
    $result = $query->result_array();

    if(count($result) > 0) {
      $this->db->set('like_id', $like_id);
      $this->db->where('user_id', $user_id);
      $this->db->where('playlist_id', $playlist_id);
      $this->db->update('playlist_likes');
      return $this->db->affected_rows() > 0;
    } else {
      $this->db->insert('playlist_likes', $data);
      return $this->db->affected_rows() > 0;
    }
  }

  public function get_playlist_likes($playlist_id, $like_id) {
    $this->db->select('*'); 
    $this->db->from('playlist_likes');
    $this->db->where('playlist_id', $playlist_id );
    $this->db->where('like_id', $like_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function get_share_post_media($post_id){
    $this->db->from('post_media AS pm');
    $this->db->select("pm.iPostId AS pm_post_id");
    $this->db->select("pm.iPostMediaId AS pm_post_media_id");
    $this->db->select("pm.eMediaType AS pm_media_type");
    $this->db->select("pm.iUserId AS pm_user_id");
    $this->db->select("pm.vUploadFile AS pm_upload_file");
    $this->db->select("pm.dAddedDate AS pm_added_date");
    $this->db->select("(".$this->db->escape("").") AS display_image", FALSE);
    $this->db->select("pm.iViewsCount AS pm_views_count_1");
    $this->db->select("(SELECT count(pmv.iPostMediaViewId) FROM post_media_view pmv WHERE pmv.iPostMediaId = pm.iPostMediaId AND pmv.iUserId = '".$user_id."') AS is_viewed_1", FALSE);
    $this->db->select("(pm.vUploadFile) AS pm_upload_file_org", FALSE);
    $this->db->select("(pm.vVideoThumbnail) AS pm_video_thumbnail_org", FALSE);
    $this->db->select("((SELECT COUNT(pml.iPostMediaLikesId) FROM post_media_likes pml left join users u on u.iUsersId = pml.iUserId and u.eStatus = 'Active' WHERE pml.iPostMediaId = pm.iPostMediaId AND pml.eStatus=1 )) AS media_like_count_2", FALSE);
    $this->db->select("((SELECT count(iPostCommentId) FROM post_comment WHERE iPostId = pm.iPostId AND iParentId = 0 AND eStatus = 'Active' AND iPostMediaId = pm.iPostMediaId)) AS media_comment_count_1", FALSE);
    $this->db->select("(SELECT count(iPostMediaLikesId) FROM post_media_likes  pml WHERE pml.iPostMediaId = pm.iPostMediaId AND pml.iUserId = '".$user_id."' AND pml.eStatus=1) AS is_media_like_1", FALSE);
    $this->db->select("pm.vMHeight AS pm_mheight_1");
    $this->db->select("pm.vMWidth AS pm_mwidth_1");
    $this->db->select("pm.vCloudinary As pm_vCloudinary");
    $this->db->select("pm.vSourceType AS pm_vSourceType");
    $this->db->where('iPostId', $post_id);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function getSearchPostThumbnail($post_id) {
    $this->db->select('*');
    $this->db->from('post_media');
    $this->db->where('iPostId', 142304);
    $query = $this->db->get();
    return $query->result_array();
  }

  public function decodedData($data) {
    // $post_data = json_decode($data);
    $post_data = 'hello';
    return $post_data;
  }

  public function getUserProfile($user_id) 
  {
      $this->load->model("user/users_model");
      $data = $this->users_model->get_my_profile($user_id);
      $profile_image = $data['data'][0]['u_my_profile_image'];
      $image_arr = array();
      $image_arr["image_name"] = $profile_image;
      $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
      $image_arr["def_img"] = "Yes";
      $image_arr["path"] = "compress_profile_image";
      $image = $this->general->get_image_aws($image_arr);
      return $image;
  }
}
