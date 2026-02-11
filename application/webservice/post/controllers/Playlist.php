<?php
/**
* Top Playlist API Service For Mobile Application 
*/
defined('BASEPATH') || exit('No direct script access allowed');

class Playlist extends Cit_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Playlist_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function add_post() {
        
        $postId = $this->input->get_post('post_id');
        $user_id = $this->input->get_post('user_id');
        $user_name = $this->input->get_post('user_name');

        if (!$user_id || !$user_name) {
                $this->output->set_status_header(400);
                echo json_encode(array("message" => "Missing user_id and user_name parameter"));
                return;
        } else {
                if ($postId) {
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
                                'name' => $user_name,
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
                    echo json_encode(array("message" => "Missing post_id parameter"));
                }
        }
    }

    public function get_my_playlist() {
        $user_id = $this->input->get_post('user_id');
        if (!$user_id) {
                $this->output->set_status_header(400);
                echo json_encode(array("message" => "Missing user_id parameter"));
                return;
        } else {
                $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);
                if (!empty($playlist)) {
                    $playlist_id = $playlist[0]['id'];
                } else {
                    echo json_encode(array("message" => "Playlist not found"));
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
                                $media['full_thumbnail_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_post_video/' . $media['iUserId'] . '/' . $media['vVideoThumbnail'];
                            }

                            if(!$this->isValidUrl($media['full_thumbnail_url'])) {
                                
                                if(!$this->isValidVideoUrl($media['full_video_url'])) {
                                        continue;
                                }
                                
                                try {
                                        $thumbname = 'thumb_' . $post_id . '_' . time() . '.jpg';
                                        $file_name = $thumbname;
                                        
                                        $thumbnail_url = $this->createThumbnail($media['full_video_url'], $media['iUserId'], $file_name);
                                        if ($thumbnail_url) {
                                            $this->updateThumbnailDb($post_id, $file_name);
                                        }
                                        sleep(2);
                                } catch (Exception $e) {
                                        $response['errors'][] = "Error processing video for post_id: " . $post_id . " - " . $e->getMessage();
                                        continue;
                                }
                            }


                            $media['post_details'] = $post_details;
                    }

                    $playlist_posts = array_merge($playlist_posts, $post_media);
                }
        }

        $response = array(
                "success" => true,
                "data" => $playlist_posts
        );
        echo json_encode($response);
    }


    public function get_top_playlist() {
        $page_index = $this->input->get_post('page_index');
        $user_id = $this->input->get_post('user_id');
        if (!$page_index) {
                $page_index = 1;
        }
        $top_playlists = $this->Playlist_model->top_playlist_bkp($page_index);
        echo json_encode($top_playlists);
    }

    public function remove_post() {
        $postId = $this->input->get_post('post_id');
        $user_id = $this->input->get_post('user_id');
    
        if (!$user_id || !$postId) {
            $this->output->set_status_header(400);
            echo json_encode(array("message" => "Missing user_id or post_id parameter"));
            return;
        }
    
        $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);
    
        if (count($playlist) > 0) {
            $playlist_id = $playlist[0]['id'];
            $success = $this->Playlist_model->remove_playlist_post($postId,$playlist_id);
    
            $message = $success ? "Video removed from playlist successfully!" : "Error removing video from playlist.";
            echo json_encode(array(
                "success" => $success,
                "message" => $message
            ));
        } else {
            $this->output->set_status_header(404);
            echo json_encode(array("message" => "Playlist not found for user."));
        }
    }


    // public function isValidUrl($url) {
    //       $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv'];
    //       $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
    
    //       if (isset($pathInfo['extension']) && in_array(strtolower($pathInfo['extension']), $videoExtensions)) {
    //           return false;
    //       }
    
    //       $headers = @get_headers($url);
    //       return $headers && strpos($headers[0], '200') !== false;
    // }

    public function isValidUrl($url) {
        // Validate URL format
        if (empty($url) || !filter_var($url, FILTER_VALIDATE_URL)) {
            log_message('debug', 'Invalid URL format: ' . $url);
            return false;
        }
    
        // Define allowed image extensions for thumbnails
        $imageExtensions = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
        $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
    
        // Check if the URL has an image extension
        if (!isset($pathInfo['extension']) || !in_array(strtolower($pathInfo['extension']), $imageExtensions)) {
            log_message('debug', 'URL does not have a valid image extension: ' . $url);
            return false;
        }
    
        $parsedUrl = parse_url($url);
        $trustedDomains = ['d1ap1pbk3mm4im.cloudfront.net'];
        if (isset($parsedUrl['host']) && in_array($parsedUrl['host'], $trustedDomains)) {
            log_message('debug', 'Trusted domain, skipping HTTP check: ' . $url);
            return true;
        }
    
        // Cache results to avoid repeated checks
        static $urlCache = [];
        if (isset($urlCache[$url])) {
            log_message('debug', 'Cache hit for URL: ' . $url);
            return $urlCache[$url];
        }
    
        // Perform HTTP check with timeout
        $context = stream_context_create([
            'http' => [
                'method' => 'HEAD',
                'timeout' => 2, // Set a 2-second timeout
            ]
        ]);
        $headers = @get_headers($url, 0, $context);
        $isValid = $headers && strpos($headers[0], '200') !== false;
        $urlCache[$url] = $isValid;
    
        log_message('debug', 'URL check result for ' . $url . ': ' . ($isValid ? 'Valid' : 'Invalid'));
        return $isValid;
    }

    public function createThumbnail($video_url, $user_id, $file_name) {
        $temp_video_path = sys_get_temp_dir() . '/' . uniqid('video_') . '.mp4';
        $thumb_file_path = sys_get_temp_dir() . '/' . uniqid('thumb_') . '.jpg';
    
        file_put_contents($temp_video_path, file_get_contents($video_url));
    
        $cmd = "ffmpeg -i " . escapeshellarg($temp_video_path) . " -ss 00:00:02.000 -vframes 1 " . escapeshellarg($thumb_file_path);
        shell_exec($cmd);
    
        $file_path = "compress_post_video/" . trim($user_id);
        $file_tmp_path = $thumb_file_path;
    
        $thumbnail_url = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
    
        @unlink($temp_video_path);
        @unlink($thumb_file_path);
    
        return $thumbnail_url->get('ObjectURL');
    }

    public function updateThumbnailDb($post_id, $file_name) {
        $this->db->where('iPostId', $post_id);
        $this->db->update('post_media', [
            'vVideoThumbnail' => $file_name
        ]);
    }

    public function isValidVideoUrl($url) {
        $headers = @get_headers($url, 1); // Use 1 to get headers as an associative array
    
        if ($headers && isset($headers[0]) && strpos($headers[0], '200') !== false) {
            if (isset($headers['Content-Type'])) {
                $contentType = is_array($headers['Content-Type']) ? $headers['Content-Type'][0] : $headers['Content-Type'];
    
                if (strpos($contentType, 'video/') === 0) {
                    return true;
                }
            }
        }
    
        return false;
    }
    
}