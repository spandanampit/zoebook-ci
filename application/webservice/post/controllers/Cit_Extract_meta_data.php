<?php

   
/**
 * Description of Extract meta data Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Extract meta data
 *
 * @class Cit_Extract_meta_data.php
 *
 * @path application\webservice\post\controllers\Cit_Extract_meta_data.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 12.12.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}
 
Class Cit_Extract_meta_data extends Extract_meta_data {
        public function __construct()
{
    parent::__construct();
    
//     ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
}

public function read_og_tags_as_json($url){


    $ch = curl_init();

    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
    $fake_user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040803 Firefox/0.9.3';
    curl_setopt($ch, CURLOPT_USERAGENT, $fake_user_agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $HTML_DOCUMENT = curl_exec($ch);
    curl_close($ch);

    $doc = new DOMDocument();
    $doc->loadHTML($HTML_DOCUMENT);

    // fecth <title>
    $res['title'] = $doc->getElementsByTagName('title')->item(0)->nodeValue;

    // fetch og:tags
    foreach( $doc->getElementsByTagName('meta') as $m ){

          // if had property
          if( $m->getAttribute('property') ){

              $prop = $m->getAttribute('property');

              // here search only og:tags
              if( preg_match("/og:/i", $prop) ){

                  // get results on an array -> nice for templating
                  $res['og_tags'][$m->getAttribute('property')]  = $m->getAttribute('content');
              }

          }
          // end if had property

          // fetch <meta name="description" ... >
          if( $m->getAttribute('name') == 'description' ){

            $res['description'] = $m->getAttribute('content');

          }


    }
    // end foreach

    return $res;

    // render JSON
    //echo json_encode($res, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

}

public function extracttags_from_url($url) {
  $tags = array();
  
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_HEADER, 0);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
  $fake_user_agent = 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7) Gecko/20040803 Firefox/0.9.3';
  curl_setopt($ch, CURLOPT_USERAGENT, $fake_user_agent);

  $contents = curl_exec($ch);
  curl_close($ch);

  if (empty($contents)) {
    return $tags;
  }

  if (preg_match_all('/<meta([^>]+)content="([^>]+)>/', $contents, $matches)) {
    $doc = new DOMDocument();
    $doc->loadHTML('<?xml encoding="utf-8" ?>' . implode($matches[0]));
    $tags = array();
    foreach($doc->getElementsByTagName('meta') as $metaTag) {
      if($metaTag->getAttribute('name') != "") {
        $tags[$metaTag->getAttribute('name')] = $metaTag->getAttribute('content');
      }
      elseif ($metaTag->getAttribute('property') != "") {
        $tags[$metaTag->getAttribute('property')] = $metaTag->getAttribute('content');
      }
    }
  }

  return $tags;
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
        if(empty($url[2][0])){
            $link_match = "http://".trim($link_match);
        }
         
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
             #pr($link_match,1);
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
    } else {
       
        $fetcheddata = $this->read_og_tags_as_json($link_match);
        
        $post_meta_title = $fetcheddata['title'];
        $post_meta_image = $fetcheddata['og_tags']['og:image'];
       
        if(trim($post_meta_title) != "" && trim($post_meta_image) != ""){
             #pr($post_meta_image,1);
            $post_metadata = array(
                "link" => $link_match,
                "title" => $post_meta_title,
                "image" => $post_meta_image,
                "text" => $this->linkify($post_text)//preg_replace($regex, "<a target='_blank' href='" . $link_match . "'>" . $link_match . "</a> ", $post_text)
            );
             
            $josn_postmetadata = json_encode($post_metadata);
            $is_meta = "Yes";  
        }
    }
    $return_arr[0]['json_post_metadata'] = $josn_postmetadata;
    $return_arr[0]['post_id'] = $post_id;
    $return_arr[0]['is_meta'] = $is_meta;
   
    return $return_arr;

}
 public function linkify($value, $protocols = array('http', 'mail'), array $attributes = array())
    {
        // Link attributes
        $attr = '';
        foreach ($attributes as $key => $val) {
            $attr .= ' ' . $key . '="' . htmlentities($val) . '"';
        }
        
        $links = array();
        
        // Extract existing links and tags
        $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
        
        // Extract text links for each protocol
        
        foreach ((array)$protocols as $protocol) {
            switch ($protocol) {
                case 'http':
                case 'https':   
                $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { 
                    if ($match[1]) {
                     $protocol = $match[1]; 
                     $link = $match[2] ?: $match[3]; 
                     return '<' . array_push($links, "<a $attr href=\'$protocol://$link\'>$link</a>") . '>';      
                    }
                    
                }, $value); 
                break;
                case 'mail': 
                $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\'mailto:{$match[1]}\'>{$match[1]}</a>") . '>'; }, $value);
                break;
                case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\'https://twitter.com/' . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . '\'>{$match[0]}</a>") . '>'; }, $value);
                break;
                default:        
                    $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\'$protocol://{$match[1]}\'>{$match[1]}</a>") . '>'; }, $value);
                break;
            }
        }
        
        // Insert all link
        return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
    }
}
