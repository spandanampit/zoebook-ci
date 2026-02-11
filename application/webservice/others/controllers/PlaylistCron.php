<?php
/**
 * Cron Controller
 * This controller is intended for handling scheduled tasks related to playlists.If the playlist video hasn't proper thumbnail then it will be set a new thumbnail from the video.
 * It is designed to be run periodically by a cron job.
  * Currently, it does not implement any specific functionality.
  * 
  * @package    zoebook
  * @subpackage webservice
  * @category   others
  * @author     Provat Das
  * @license    http://www.gnu.org/licenses/gpl-3.0.html GNU General Public License v3.0
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class PlaylistCron extends Cit_Controller {
      public function __construct() {
            parent::__construct();
      }


      /**
       *  Get playlist videos
       *  This function is intended to retrieve videos from the topplaylist.
       */
      public function playlist_thumbnail_generation() {
            $page_index = $this->input->get_post('page_index') ?? 1;
            $display_data = $this->input->get_post('display_data') ?? 0;

            $api_url = "https://zoebook.com/WS/get_top_playlist?page_index=$page_index";
            $ch = curl_init();
        
            curl_setopt($ch, CURLOPT_URL, $api_url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            $playlist_posts = json_decode(curl_exec($ch));
            curl_close($ch);
        
            $response = [
                'status' => 'success',
                'message' => '',
                'processed' => 0,
                'errors' => []
            ];
        
            $top_playlist_videos = [];
        
            if (isset($playlist_posts->data) && is_array($playlist_posts->data)) {
                foreach ($playlist_posts->data as $entry) {
                    if (isset($entry->media) && is_array($entry->media)) {
                        foreach ($entry->media as $media) {
                            $video_url = $media->full_video_url ?? '';
                            $thumbnail_url = $media->full_thumbnail_url ?? '';
                            $post_id = $media->iPostId ?? '';
                            $user_id = $media->iUserId ?? '';
        
                            $top_playlist_videos[] = [
                                'post_id'       => $post_id,
                                'video_url'     => $video_url,
                                'thumbnail_url' => $thumbnail_url,
                                'user_id'       => $user_id
                            ];
                        }
                    }
                }
            }

            if($display_data == 1) {
                  echo json_encode($top_playlist_videos);
                  exit;
            }
        
            if (!empty($top_playlist_videos)) {
                foreach ($top_playlist_videos as $video) {
                    $thumbnail_url = $video['thumbnail_url'];
                    if ($this->isValidUrl($thumbnail_url)) {
                        continue;
                    }
                    try {
                        $thumbname = 'thumb_' . $video['post_id'] . '_' . time() . '.jpg';
                        $file_name = $thumbname;
                        echo $file_name . ' ' . $video['post_id'];
                        $thumbnail_url = $this->createThumbnail($video['video_url'], $video['user_id'], $file_name);
                        if ($thumbnail_url) {
                            $this->updateThumbnailDb($video['post_id'], $file_name);
                            $response['processed']++;
                        } else {
                            $response['errors'][] = "Thumbnail generation failed for post_id: " . $video['post_id'];
                        }
                        sleep(2);
                    } catch (Exception $e) {
                        $response['errors'][] = "Error processing video for post_id: " . $video['post_id'] . " - " . $e->getMessage();
                        continue;
                    }
                }
            } else {
                $response['message'] = 'No videos found in the playlist.';
            }
        
            if (!empty($response['errors'])) {
                $response['status'] = 'partial';
                if (empty($response['processed'])) {
                    $response['status'] = 'error';
                }
            } else {
                $response['message'] = 'All thumbnails processed successfully.';
            }
        
            echo json_encode($response);
      }
        

      public function isValidUrl($url) {
            $videoExtensions = ['mp4', 'mov', 'avi', 'mkv', 'webm', 'flv', 'wmv'];
            $pathInfo = pathinfo(parse_url($url, PHP_URL_PATH));
        
            if (isset($pathInfo['extension']) && in_array(strtolower($pathInfo['extension']), $videoExtensions)) {
                return false;
            }
        
            $headers = @get_headers($url);
            return $headers && strpos($headers[0], '200') !== false;
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
        
        
        
}