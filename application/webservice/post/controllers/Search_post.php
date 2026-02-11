<?php

class Search_post extends Cit_Controller {
      public function __construct()
      {
            $this->load->model("post/post_model");
            $this->load->model("post/post_media_model");
            $this->load->model("user/users_model");
      }


      public function search_post() {
            $key_word = $this->input->get_post('keyword');
            
            if (empty($key_word)) {
                  $response = array(
                        'success' => 0,
                        'message' => 'Invalid or missing keyword.'
                  );
                  echo json_encode($response);
                  return;
            }
            
            $results = $this->post_model->search_post($key_word);
            
            $results_with_media = $this->search_post_media($results);
            
            
            echo json_encode($results_with_media);
      }
            
      public function search_post_media($data) {
            $modified_data = $data;
            
            foreach ($modified_data as &$d) { 
                  $post_id = $d['iPostId'];
            
                  $get_post_media = $this->post_media_model->search_post_media($post_id);
            
                  if (!empty($get_post_media) && isset($get_post_media[0]['file_url'])) {
                        $url_slug = $get_post_media[0]['file_url'];
                        $image_arr = array();
                        $image_arr["image_name"] = $url_slug;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $image_arr["pk"] = $get_post_media[0]["user_id"];
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
            
                        $full_url = $this->general->get_image_aws($image_arr);
            
                        $d["file_url"] = $full_url;
                  } else {
                        $d["file_url"] = null;
                  }
            }
            
            return $modified_data;
      }     
}