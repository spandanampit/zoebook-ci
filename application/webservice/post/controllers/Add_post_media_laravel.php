<?php
/*
**This API will be used to add media to a post 
**The media can be an image or a video
**This API will handle store data in the database from laravel server
*/

defined('BASEPATH') || exit('No direct script access allowed');

class Add_post_media_laravel extends Cit_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('wsresponse');
        $this->load->library('cloudinarylib');
        $this->load->model('add_post_media_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_model");
    }

    public function insert_post_media()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        $rawInput = file_get_contents('php://input');
        $json = json_decode($rawInput, true);

        if (is_array($json)) {
            $postId = $json['post_id'] ?? null;
            $user_id = $json['user_id'] ?? null;
            $uploadedFile = $json['upload_file'] ?? null;
            $file_type = $json['file_type'] ?? null;
            $video_thumbnail = $json['video_thumbnail'] ?? null;
            $width = $json['width'] ?? null;
            $height = $json['height'] ?? null;
        } else {
            // fallback to form-data
            $postId = $this->input->get_post('post_id');
            $user_id = $this->input->get_post('user_id');
            $uploadedFile = $this->input->get_post('upload_file');
            $file_type = $this->input->get_post('file_type');
            $video_thumbnail = $this->input->get_post('video_thumbnail');
            $width = $this->input->get_post('width');
            $height = $this->input->get_post('height');
        }

        if (!$postId || !$user_id) {
            $rawInput = file_get_contents('php://input');
            $json = json_decode($rawInput, true);


            if (is_array($json)) {
                $postId = $postId ?: ($json['post_id'] ?? null);
                $user_id = $user_id ?: ($json['user_id'] ?? null);
                $uploadedFile = $uploadedFile ?: ($json['upload_file'] ?? null);
                $file_type = $file_type ?: ($json['file_type'] ?? null);
                $video_thumbnail = $video_thumbnail ?: ($json['video_thumbnail'] ?? null);
                $width = $width ?: ($json['width'] ?? null);
                $height = $height ?: ($json['height'] ?? null);
            }
        }

        if (empty($postId) || empty($user_id) || empty($uploadedFile) || empty($file_type)) {
            $this->output->set_status_header(400);
            echo json_encode([
                "code" => "invalid_request",
                "message" => "Missing required parameters"
            ]);
            return;
        }

        $params_arr = [
            "post_id" => $postId,
            "user_id" => $user_id,
            "upload_file" => $uploadedFile,
            "file_type" => $file_type,
            "_daddeddate" => "NOW()",
            "_dmodifieddate" => "NOW()",
            "_estatus" => "Active"
        ];

        if (!empty($video_thumbnail)) {
            $params_arr["video_thumbnail"] = $video_thumbnail;
        }

        if (!empty($width)) {
            $params_arr["width"] = $width;
        }

        if (!empty($height)) {
            $params_arr["height"] = $height;
        }

        $insert_data = $this->post_media_model->insert_post_media($params_arr);
        if (!$insert_data) {
            $this->output->set_status_header(500);
            echo json_encode([
                "code" => "error",
                "message" => "Failed to insert post media"
            ]);
            return;
        }

        echo json_encode([
            'code' => 'success',
            'message' => 'Post media inserted successfully',
            'data' => $params_arr
        ]);
    }

    public function getCloudinaryVideos()
    {
        header('Content-Type: application/json');

        try {
            $token = $this->input->get_request_header('Authorization');
            $validToken = '1234567890';

            if (!$token || $token !== 'Bearer ' . $validToken) {
                echo json_encode([
                    'success' => 0,
                    'message' => 'Unauthorized: Invalid or missing token'
                ]);
                return;
            }

            $page = (int)$this->input->get('page');
            $limit = (int)$this->input->get('limit');
            $after_migration = $this->input->get('after_migration') ?? null;

            if ($limit <= 0) $limit = 20;
            if ($page <= 0) $page = 1;

            $offset = ($page - 1) * $limit;

            $this->db->select('iPostMediaId, vCloudinary, iPostId, iUserId, vSourceType, eMediaType');
            $this->db->from('post_media');
            if ($after_migration) {
                $this->db->where('vSourceType', 'aws');
            } else {
                $this->db->where('vSourceType', 'cld');
            }
            $this->db->where('vCloudinary IS NOT NULL', null, false);
            $this->db->limit($limit, $offset);
            $query = $this->db->get();
            $results = $query->result();

            $total = $this->db->count_all_results();

            echo json_encode([
                'success' => 1,
                'message' => 'Data fetched successfully',
                'page' => $page,
                'limit' => $limit,
                'total' => $total,
                'total_pages' => ceil($total / $limit),
                'data' => $results
            ]);
        } catch (Exception $e) {
            echo json_encode([
                'success' => 0,
                'message' => 'Error fetching data: ' . $e->getMessage()
            ]);
        }
    }



    public function updateDbCldMigration()
    {
        header('Content-Type: application/json');
        try {
            $token = $this->input->get_request_header('Authorization');
            $validToken = '1234567890';

            if (!$token || $token !== 'Bearer ' . $validToken) {
                echo json_encode([
                    'success' => 0,
                    'message' => 'Unauthorized: Invalid or missing token'
                ]);
                return;
            }

            $postId = $this->input->get_post('post_id');
            $mediaId = $this->input->get_post('media_id');
            $userId = $this->input->get_post('user_id');
            $uploadedFile = $this->input->get_post('upload_file');
            $fileType = $this->input->get_post('file_type');
            $cloudinaryUrl = $this->input->get_post('cloudinary_url');
            $videoThumbnail = $this->input->get_post('video_thumbnail');
            $width = $this->input->get_post('width');
            $height = $this->input->get_post('height');

            if (empty($mediaId) || empty($userId) || empty($postId)) {
                echo json_encode([
                    'success' => 0,
                    'message' => 'media_id, user_id and post_id are required for update'
                ]);
                return;
            }

            $updateData = [];

            if (!empty($postId)) $updateData['iPostId'] = $postId;
            if (!empty($userId)) $updateData['iUserId'] = $userId;
            if (!empty($uploadedFile)) $updateData['vUploadFile'] = $uploadedFile;
            if (!empty($cloudinaryUrl)) $updateData['vCloudinary'] = $cloudinaryUrl;
            if (!empty($fileType)) $updateData['eMediaType'] = $fileType;
            if (!empty($videoThumbnail)) $updateData['vVideoThumbnail'] = $videoThumbnail;
            if (!empty($width)) $updateData['vMWidth'] = $width;
            if (!empty($height)) $updateData['vMHeight'] = $height;
            $updateData['vSourceType'] = 'aws';

            $updateData['dModifiedDate'] = date('Y-m-d H:i:s');

            $this->db->where('iPostMediaId', $mediaId);
            $this->db->where('iUserId', $userId);
            $this->db->where('iPostId', $postId);
            $updated = $this->db->update('post_media', $updateData);

            if ($updated) {
                echo json_encode([
                    'success' => 1,
                    'message' => 'Post media updated successfully',
                    'updated_data' => $updateData
                ]);
            } else {
                echo json_encode([
                    'success' => 0,
                    'message' => 'Failed to update post media'
                ]);
            }
        } catch (Exception $e) {
            echo json_encode([
                'success' => 0,
                'message' => $e->getMessage()
            ]);
        }
    }


    public function insert_post()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        try {
            $user_id = $this->getInput('user_id');
            $post_type = $this->getInput('post_type');
            $post_text = $this->getInput('post_text');
            $visibility = $this->getInput('visibility');
            $post_text_emoji = $this->getInput('post_text_emoji');
            $movement_id = $this->getInput('movement_id');

            if (empty($user_id)) {
                throw new Exception("User ID is required");
            }

            if (empty($post_type)) {
                throw new Exception("Post type is required");
            }

            if (empty($post_text)) {
                throw new Exception("Post text cannot be empty");
            }

            if (empty($visibility)) {
                throw new Exception("Visibility is required");
            }

            $params_arr = array(
                "user_id" => (int)$user_id,
                "post_type" => trim($post_type),
                "post_text" => trim($post_text),
                "visibility" => trim($visibility),
                "post_text_emoji" => $post_text_emoji,
                "movements_id" => $movement_id,

                "_edraft" => "No",
                "_estatus" => "Active",
                "_daddeddate" => "NOW()",
                "_dmodifieddate" => "NOW()"
            );

            // 🔹 Call model
            $response = $this->post_model->insert_post($params_arr);

            if (!$response) {
                throw new Exception("Post insertion failed");
            }


        } catch (Exception $e) {
            $response = [
                "success" => 0,
                "message" => $e->getMessage()
            ];
        }

        echo json_encode($response);
    }

    private function getInput($key)
    {
        static $json = null;

        if ($json === null) {
            $raw = file_get_contents('php://input');
            $json = json_decode($raw, true);
        }

        if (is_array($json) && array_key_exists($key, $json)) {
            return $json[$key];
        }

        return $this->input->get_post($key);
    }



    public function addToPlaylist_post()
    {
        header('Content-Type: application/json');
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        // Read raw JSON
        $rawInput = file_get_contents('php://input');
        $json = json_decode($rawInput, true);

        if (is_array($json)) {
            $postId  = $json['post_id'] ?? null;
            $user_id = $json['user_id'] ?? null;
        } else {
            // fallback to form-data
            $postId  = $this->input->get_post('post_id');
            $user_id = $this->input->get_post('user_id');
        }

        // Debug (optional, remove later)
        // echo json_encode(['debug' => [$postId, $user_id]]); exit;

        if (!$user_id) {
            echo json_encode([
                "success" => false,
                "message" => "User not authenticated"
            ]);
            return;
        }

        if (!$postId) {
            echo json_encode([
                "success" => false,
                "message" => "Missing post_id"
            ]);
            return;
        }

        $this->load->model('Playlist_model');

        $playlist = $this->Playlist_model->get_playlists_by_userId($user_id);

        if (!empty($playlist)) {
            $playlist_id = $playlist[0]['id'];
        } else {
            $data = [
                'user_id'    => $user_id,
                'name'       => 'My Playlist',
                'created_at' => date('Y-m-d H:i:s')
            ];

            $playlist_id = $this->Playlist_model->insert_playlist($data);

            if (!$playlist_id) {
                echo json_encode([
                    "success" => false,
                    "message" => "Failed to create playlist"
                ]);
                return;
            }
        }

        // Prevent duplicate
        $exists = $this->db->get_where('playlist_posts', [
            'playlist_id' => $playlist_id,
            'post_id'     => $postId
        ])->row();

        if ($exists) {
            echo json_encode([
                "success" => true,
                "message" => "Already added"
            ]);
            return;
        }

        $success = $this->Playlist_model->insert_playlist_post([
            'playlist_id' => $playlist_id,
            'post_id'     => $postId,
        ]);

        echo json_encode([
            "success" => $success,
            "message" => $success 
                ? "Added to playlist" 
                : "Insert failed"
        ]);
    }
}
