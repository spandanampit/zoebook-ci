<?php

   
/**
 * Description of Extract meta data Extended Controller
 * 
 * @module Extended Extract meta data
 * 
 * @class Cit_Extract_meta_data.php
 * 
 * @path application\webservice\post\controllers\Cit_Extract_meta_data.php
 * 
 * @author CIT Dev Team
 * 
 * @date 27.05.2020
 */        

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Extract_meta_data extends Extract_meta_data {
        public function __construct()
{
    parent::__construct();
}

public function extract_posts_metadata($input_params = array()){
    $post_text = $input_params['post_text'];
    $post_id = $input_params['post_id'];
    
    $regex = "@((https?://)?([-\\w]+\\.[-\\w\\.]+)+\\w(:\\d+)?(/([-\\w/_\\.]*(\\?\\S+)?)?)*)@";
    preg_match_all($regex, $post_text, $url);
    
    $link_match = $url[0][0];
    $post_metadata = array();
    $josn_postmetadata = "";
    ini_set('default_socket_timeout', 5);
    if (trim($link_match) != "") {
        /*$post_metadata_arr = get_meta_tags($link_match);
        if((trim($post_metadata_arr['title']) != "" || trim($post_metadata_arr['twitter:title']) != "") && (trim($post_metadata_arr['twitter:image']) != "" || trim($post_metadata_arr['twitter:image:src']) != "")){
            $post_meta_title = $post_metadata_arr['title'];
            $post_meta_image = $post_metadata_arr['twitter:image'];
            if(trim($post_meta_title) == ""){
                $post_meta_title = $post_metadata_arr['twitter:title'];
            }
            if(trim($post_meta_image) == ""){
                $post_meta_image = $post_metadata_arr['twitter:image:src'];
            }*/
            require APPPATH . 'libraries/OpenGraph.php';
            $graph = OpenGraph::fetch($link_match);
            if($graph){
                $post_meta_title = $graph->title;
                $post_meta_image = $graph->image;
                if(trim($post_meta_title) != "" && trim($post_meta_image) != ""){
                    $post_metadata = array(
                        "link" => $link_match,
                        "title" => $post_meta_title,
                        "image" => $post_meta_image,
                        "text" => preg_replace($regex, "<a target='_blank' href='" . $link_match . "'>" . $link_match . "</a> ", $post_text)
                    );    
                }
            }
        //}
        
    }
    $is_meta = "No";
    if(!empty($post_metadata) && count($post_metadata) > 0){
        // Now save json encode of $post_metadata in new column 'tPostMetaData'
        $josn_postmetadata = json_encode($post_metadata);
        $is_meta = "Yes";
    }
    $return_arr[0]['json_post_metadata'] = $josn_postmetadata;
    $return_arr[0]['post_id'] = $post_id;
    $return_arr[0]['is_meta'] = $is_meta;
    return $return_arr;

}
}
