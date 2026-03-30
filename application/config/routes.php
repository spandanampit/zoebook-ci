<?php
defined('BASEPATH') || exit('No direct script access allowed');

/*
  | -------------------------------------------------------------------------
  | URI ROUTING
  | -------------------------------------------------------------------------
  | This file lets you re-map URI requests to specific controller functions.
  |
  | Typically there is a one-to-one relationship between a URL string
  | and its corresponding controller class/method. The segments in a
  | URL normally follow this pattern:
  |
  |	example.com/class/method/id/
  |
  | In some instances, however, you may want to remap this relationship
  | so that a different class/function is called than the one
  | corresponding to the URL.
  |
  | Please see the user guide for complete details:
  |
  |	https://codeigniter.com/user_guide/general/routing.html
  |
  | -------------------------------------------------------------------------
  | RESERVED ROUTES
  | -------------------------------------------------------------------------
  |
  | There are three reserved routes:
  |
  |	$route['default_controller'] = 'welcome';
  |
  | This route indicates which controller class should be loaded if the
  | URI contains no data. In the above example, the "welcome" class
  | would be loaded.
  |
  |	$route['404_override'] = 'errors/page_missing';
  |
  | This route will tell the Router which controller/method to use if those
  | provided in the URL cannot be matched to a valid route.
  |
  |	$route['translate_uri_dashes'] = FALSE;
  |
  | This is not exactly a route, but allows you to automatically route
  | controller and method names that contain dashes. '-' isn't a valid
  | class or method name character, so it requires translation.
  | When you set this option to TRUE, it will replace ALL dashes in the
  | controller and method URI segments.
  |
  | Examples:	my-controller/index	-> my_controller/index
  |		my-controller/my-method	-> my_controller/my_method
 */
// $route['default_controller'] = "content/content/index";
$route['default_controller'] = "content/content/homepage";
$route['home-page.html'] = "content/content/homepage";
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
$route['admin'] = "dashboard/dashboard/sitemap";
$route['admin/(:any)'] = "$1";

$route['user.html'] = "user/user/index";
$route['index.html'] = "content/content/index";
$route['signup.html'] = "user/user/register";
$route['profile.html'] = "user/user/profile";
$route['login.html'] = "user/user/login";
$route['logout.html'] = "user/user/logout";
$route['dashboard.html'] = "user/user/dashboard";
$route['forgot-password.html'] = "user/user/forgotpassword";
$route['forgotme.html'] = "user/user/forgotme";
$route['error.html'] = "content/content/error";
$route['captcha.html'] = "content/content/captcha";

//about
$route['about-user.html'] = "content/content/about";
$route['about-form.html'] = "content/content/aboutform";
$route['addEditAboutUser'] = "content/content/addEditAboutUser";
$route['addUserPage'] = "content/content/addUserPage";

$route['activationurl-([a-zA-Z0-9]+).html'] = "user/user/accountactivation/$1";

$route['contactus.html'] = "content/content/contactus";
// new created route
$route['aboutus.html'] = "content/content/aboutus";
$route['termsconditions.html'] = "content/content/termsconditions";
$route['signup.html'] = "user/user/signup";
$route['homepage.html'] = "content/content/homepage";
// For Playlist
$route['playlist.html'] = "content/content/playlist";
// $route['playlist/(:any).html'] = "content/content/playlist/$1";
$route['playlist'] = "content/content/addToPlaylist";
// For set session
$route['setUsertTimezone'] = "content/content/setUserTimezone";
$route['playlistshare.html'] = 'content/content/playlistshare';
$route['playlist-share'] = "content/content/playlist-share";
$route['remove-post'] = "content/content/removePlaylistPost";
$route['playlist-like'] = "content/content/playlistLike";
// playlist End
$route['watchvideo.html'] = "content/content/watchvideo";
$route['privacypolicy.html'] = "content/content/privacypolicy";
$route['getMorePlaylist'] = "home/home/getMorePlaylist";
// For test Email 
$route['other-email'] = "content/content/otherEmail";

//instant search results
$route['search_peoples'] = "content/content/search_peoples";

// For Movement
$route['movements'] = 'movement/movement/index';
$route['addmovement.html'] = 'movement/movement/addmovement';
$route['savemovement'] = 'movement/movement/savemovement';
$route['mymovement.html'] = 'movement/movement/mymovement';
$route['editmovement.html'] = 'movement/movement/editmovement';
$route['updatemovement'] = 'movement/movement/updatemovement';
$route['popularmovement'] = 'movement/movement/popularmovement';
$route['movementjoin'] = 'movement/movement/movementjoin';
$route['join'] = 'movement/movement/join';
$route['leave'] = 'movement/movement/leave';
$route['invitefriends'] = 'movement/movement/invitefriends';
$route['invitemovement'] = 'movement/movement/invitemovement';
$route['inviteaction'] = 'movement/movement/inviteaction';
// $route['movementdetails'] = 'movement/movement/movementdetails';
$route['invite_request'] = 'movement/movement/invite_request';
$route['movementdetails'] = 'movement/movement/movementdetails';
$route['add_movement_post'] = 'movement/movement/add_post';
$route['edit_movement_post'] = 'movement/movement/edit_post';
$route['delete_movement_post'] = 'movement/movement/deletePost';
$route['deactivate'] = 'movement/movement/deactivate';


// Search Friends For Movement
$route['searchmovement'] = 'movement/movement/searchmovement';
$route['get_movement_posts'] = 'movement/movement/get_movement_posts';

// Actions for movement post
$route['like_post'] = 'movement/movement/like_post';
$route['movement_post_comment'] = 'movement/movement/comment';
$route['sharePost'] = 'movement/movement/sharePost';
$route['like_postcomment'] = 'movement/movement/like_postcomment';
$route['comments_reply'] = 'movement/movement/comments_reply';
$route['followRequest'] = 'movement/movement/followRequest';
// End Movement Section

// Fore Video Search
$route['videosearch'] = "user/user/videosearch";

// new created route end

$route['google_signup_action.html'] = 'user/user/googleplus_authentication';


$route['home.html'] = "home/home/index";
$route['viral-posts.html'] = "home/home/viral_posts";
$route['my-profile.html'] = "home/home/my_profile";
//$route['user-profile-([0-9]+)-([a-zA-Z0-9]+).html'] = "home/home/user_profile/$1/$2";
$route['user-profile-([0-9]+)-(:any).html'] = "home/home/user_profile/$1/$2";
//$route['post-detail-([0-9]+)-([a-zA-Z0-9]+).html'] = "home/home/post_detail/$1/$2";
$route['post-detail-(:any).html'] = "home/home/post_detail/$1";



//reels
$route['reels.html'] = "home/home/reels";

$route['music.html'] = "music/music/index";
$route['details.html'] = "music/music/details";
$route['musicdetails.html'] = "music/music/musicDetails";
$route['uploadMusic'] = "music/music/uploadMusic";
$route['getMorePosts'] = "music/music/getMorePosts";


//New ajax url 
$route['other_posts'] = "home/home/other_posts";
$route['home_scrolled_posts'] = "home/home/home_scrolled_posts";
$route['profile_posts'] = "home/home/profile_posts";
$route['post_detail_comments'] = "home/home/post_detail_comments";
$route['language'] = "home/home/language";
$route['add_comment'] = "home/home/add_comment";
$route['viral_post_scrolled_posts'] = "home/home/viral_post_scrolled_posts";
$route['user_profile_posts_scroll_feed'] = "home/home/user_profile_posts_scroll_feed";
$route['checkPostUpload'] = "home/home/checkPostUpload";

//content ajax 
$route['get_comments'] = "content/content/get_comments";
$route['add_comments'] = "content/content/add_comments";


// New Ajax Url
$route['follow-user'] = "home/home/followuser_action";
$route['unfollow-user'] = "home/home/unfollowuser_action";

// Follow Action's  Ajax Url
$route['followUser'] = "home/home/followUser";

$route['chat.html'] = "content/content/chat";
$route['firebaseTokenGeneration'] = "user/user/regenerate_firebase_token";
$route['hidden-posts.html'] = "home/home/hide_posts";
//movements
$route['movement'] = 'content/content/index';
// webservices
$route['WS'] = "wsengine/wscontroller/listWSMethods";
$route['WS/(:any)'] = "wsengine/wscontroller/WSExecuter/$1";
$route['WS/(:any)/(:any)'] = "wsengine/wscontroller/WSExecuter/$1/$2";
$route['WS/execute'] = "rest/restcontroller/execute_notify_schedule";
$route['WS/image_resize'] = "rest/restcontroller/image_resize";
$route['WS/create_token'] = "rest/restcontroller/create_token";
$route['WS/inactive_token'] = "rest/restcontroller/inactive_token";
$route['WS/get_push_notification'] = "rest/restcontroller/get_push_notification";
$route['WS/regenerate_token'] = "wsengine/wscontroller/regenerateJWTToken";



//CRON 
$route['WS/clear_queries'] = 'others/Cron/clear_queries';
$route['WS/notifyInactiveUser'] = 'others/Cron/notifyInactiveUser';
$route['WS/playlist_thumbnail_generation'] = 'others/PlaylistCron/playlist_thumbnail_generation';
$route['WS/get_user_device_token'] = 'user/Get_users/getUserDeviceToken';

//Add post media for laravel
$route['WS/get_cloudinary_videos'] = 'post/add_post_media_laravel/getCloudinaryVideos';
$route['WS/update_db_cld_migration'] = 'post/add_post_media_laravel/updateDbCldMigration';
$route['WS/add_post_media_laravel'] = "post/add_post_media_laravel/insert_post_media";
// $route['WS/user_post_videos'] = "rest/restcontroller/user_post_videos";
$route['WS/user_post_videos'] = "post/post_list/user_post_videos";
$route['WS/web_post_list'] = "post/post_list_web/start_post_list";
$route['WS/random_reels'] = "post/other_post/random_reels";

$route['WS/insert_post'] = "post/add_post_media_laravel/insert_post";



//Playlist APIs
$route['WS/get_my_playlist'] = "post/playlist/get_my_playlist";
$route['WS/add_to_playlist'] = "post/playlist/add_post";
$route['WS/remove_post'] = "post/playlist/remove_post";
$route['WS/get_top_playlist'] = "post/playlist/get_top_playlist";

//search
$route['WS/search_post'] = "post/search_post/search_post";

$route['WS/get_musics'] = "post/music_post/get_musics";
$route['WS/get_user_music'] = "post/music_post/get_user_music";
$route['WS/get_music_post'] = "post/music_post/get_music_post";
$route['WS/get_users'] = "post/music_post/get_users";


// third-party login    
$route['WS/facebook/login'] = "wsengine/third_party/facebook";
$route['WS/twitter/login'] = "wsengine/third_party/twitter";
$route['WS/salesforce/login'] = "wsengine/third_party/salesforce";


// notifications
$route['NS'] = "nsengine/notifycontroller/listNSMethods";
$route['NS/(:any)'] = "nsengine/notifycontroller/notifyExecuter/$1";
$route['NS/execute'] = "nsengine/notifycontroller/executeNotifySchedule";
$route['NS/archive'] = "nsengine/archivecontroller/executeArchiveTables";

// CIT Parse APIs
//Parse users module
$route['PS'] = "psengine/pscontroller/viewPSConsole"; // API-Console
$route['PS/users'] = "users/users/users"; //GET-POST
$route['PS/users/me'] = "users/users/mine"; //GET
$route['PS/users/([a-zA-Z0-9]+)'] = "users/users/user/$1"; //GET-PUT-DELETE
$route['PS/login'] = "users/users/login"; //GET
$route['PS/logout'] = "users/users/logout"; //POST
$route['PS/requestPasswordReset'] = "users/users/req_pwd_reset"; //POST
//Parse session module
$route['PS/sessions'] = "sessions/sessions/sessions"; //GET-POST
$route['PS/sessions/me'] = "sessions/sessions/mine"; //GET-PUT
$route['PS/sessions/([a-zA-Z0-9]+)'] = "sessions/sessions/session/$1"; //GET-PUT-DELETE
//Parse inatllation module
$route['PS/installations'] = "installations/installations/installations"; //GET-POST
$route['PS/installations/([a-zA-Z0-9]+)'] = "installations/installations/installation/$1"; //GET-PUT-DELETE
//Parse roles module
$route['PS/roles'] = "roles/roles/roles"; //POST
$route['PS/roles/([a-zA-Z0-9]+)'] = "roles/roles/role/$1"; //GET-PUT-DELETE
//Parse files module
$route['PS/files/(:any)'] = "files/files/file/$1"; //GET-POST
//Parse push module
$route['PS/push'] = "push/push/push"; //POST
//Parse batch module
$route['PS/batch'] = "batch/batch/batch"; //POST
//Parse classes module
$route['PS/classes/([a-zA-Z0-9_]+)'] = "classes/classes/classes/$1"; //GET-POST
$route['PS/classes/([a-zA-Z0-9_]+)/([a-zA-Z0-9]+)'] = "classes/classes/class/$1/$2"; //GET-PUT-DELETE


//Test
$route['popularmovementvtwo'] = 'movement/movement/popularmovementvtwo';

//new created route react
$route['reactMovement'] = 'movement/movement/reactMovement';


//$route['content/(:any)'] = "content/content/staticpage/$1";
//$route['content/(:any)/(:any)'] = "content/content/staticpage/$1/$2";
$route['clear-cache.html'] = "content/content/clear_cache";
//$route['do-payment.html'] = "content/content/do_payment";
//$route['payment-response.html'] = "content/content/payment_response";
//$route['payment-notify.html'] = "content/content/payment_notify";
/**
 * Loading Some of the front routes file to specify custom key-values
 *
 */
require_once 'routes_custom.php';

require_once 'routes_front.php';

if (($this->uri->segments[1] == "WS" && $this->uri->segments[2] == "image_resize") ||
    ($this->uri->segments[1] == "error.html")
) {
    $GLOBALS['_DB_LIBRARY_NOT_REQ_'] = TRUE;
} else {
    // Database initialization

    $db = &CIT_DB();

    if ($db === FALSE) {
        //redirecting to installation page
        if (is_dir(FCPATH . "installer")) {
            $site_installer_url = (is_https() ? 'https' : 'http') . '://' . $_SERVER['HTTP_HOST'] . str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']) . 'installer/';
            header("Location:" . $site_installer_url);
            exit;
        } else {
            show_error('No database connection settings were found in the database config file.');
        }
    }

    if (!$db->conn_id) {
        header("Location:" . $this->config->item('site_url') . "error.html");
        exit;
    }

    $static_pages_obj = $db->select("vPageCode, vUrl, vPageTitle")->where('eStatus', 'Active')->get('mod_page_settings');
    $static_pages = is_object($static_pages_obj) ? $static_pages_obj->result_array() : array();
    foreach ($static_pages as $i => $route_arr) {
        $route[$route_arr['vUrl']] = "content/content/staticpage/" . $route_arr['vPageCode'];
    }
    // echo "<pre>";
    // print_r($route);
    // echo "</pre>";die;
    if ($this->config->item('is_admin') == 1) {
        $db->select("vName, vValue");
        $db->where("eStatus", 'Active');
        $db->where_in("vName", array('ADMIN_URL_ENCRYPTION', 'ADMIN_ENC_KEY'));
        $uri_enc_router = $db->select_assoc("mod_setting", "vName");
        $this->config->set_item("ADMIN_ENC_KEY", $uri_enc_router['ADMIN_ENC_KEY'][0]['vValue']);
        $this->config->set_item("ADMIN_URL_ENCRYPTION", $uri_enc_router['ADMIN_URL_ENCRYPTION'][0]['vValue']);
    }
}
