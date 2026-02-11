<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#####GENERATED_CONFIG_SETTINGS_START#####

$config["account_activation"] = array(
    "title" => "Account Activation",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["add_post"] = array(
    "title" => "Add Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_text",
        "post_type",
        "user_id",
        "visibility"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["add_post_media"] = array(
    "title" => "Add Post Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "file_type",
        "is_completed",
        "post_id",
        "upload_file",
        "user_id",
        "video_thumbnail"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["change_password"] = array(
    "title" => "Change Password",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "new_password",
        "old_password",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["check_existed_accounts"] = array(
    "title" => "Check Existed Accounts",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "facebook_id",
        "google_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["comment_liked_users"] = array(
    "title" => "Comment Liked Users",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["comment_on_post"] = array(
    "title" => "Comment On Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "comment",
        "post_comment_id",
        "post_id",
        "post_media_id",
        "upload_file",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["comment_post_media"] = array(
    "title" => "Comment Post Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "comment_text",
        "media_id",
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["comments_list"] = array(
    "title" => "Comments List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_media_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["contact_us_submit"] = array(
    "title" => "Contact Us Submit",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "email",
        "message_text",
        "name"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["country_list"] = array(
    "title" => "Country List",
    "folder" => "tools",
    "method" => "BOTH",
    "params" => array(
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["country_with_states"] = array(
    "title" => "Country With States",
    "folder" => "tools",
    "method" => "BOTH",
    "params" => array(
        "country_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["delete_comment"] = array(
    "title" => "Delete Comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["delete_media"] = array(
    "title" => "Delete Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_media_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["delete_post"] = array(
    "title" => "Delete Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["delete_reply_comment"] = array(
    "title" => "Delete Reply comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["device_token_update"] = array(
    "title" => "Device Token Update",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "device_type",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["edit_post"] = array(
    "title" => "Edit Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_text",
        "post_type",
        "user_id",
        "visibility"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["edit_profile"] = array(
    "title" => "Edit Profile",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "about_me",
        "profile_image",
        "user_email",
        "user_id",
        "user_name",
        "user_phone"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["end_live_stream"] = array(
    "title" => "End Live Stream",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["extract_meta_data"] = array(
    "title" => "Extract meta data",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_text"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["follow_accept_reject_cancel"] = array(
    "title" => "Follow Accept Reject Cancel",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "status",
        "user_follow_request_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["follow_request"] = array(
    "title" => "Follow Request",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "following_user_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["forgot_password"] = array(
    "title" => "Forgot Password",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_email"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["get_feature_contents"] = array(
    "title" => "Get Feature Contents",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["get_post_media_comments"] = array(
    "title" => "Get Post Media Comments",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["get_post_media_likes"] = array(
    "title" => "Get Post Media Likes",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["get_promotional_links"] = array(
    "title" => "Get Promotional Links",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["get_website_screenshots"] = array(
    "title" => "Get Website Screenshots",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "type"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["join_live_stream"] = array(
    "title" => "Join Live Stream",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["like_comment"] = array(
    "title" => "Like Comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "status",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["like_post"] = array(
    "title" => "Like Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "status",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["like_post_media"] = array(
    "title" => "Like Post Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_id",
        "status",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["list_liked_post_comment_user"] = array(
    "title" => "List Liked Post Comment User",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id_1",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["list_liked_post_media"] = array(
    "title" => "List Liked Post Media",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "media_id",
        "post_id_1",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["list_liked_post_user"] = array(
    "title" => "List Liked Post User",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "post_id_1",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["login"] = array(
    "title" => "Login",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "app_version",
        "device_name",
        "device_os",
        "device_token",
        "device_type",
        "facebook_id",
        "google_id",
        "latitude",
        "longitude",
        "password",
        "user_email"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["logout"] = array(
    "title" => "logout",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["my_follower_requests"] = array(
    "title" => "My Follower Requests",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["my_following_requests"] = array(
    "title" => "My Following Requests",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["my_profile"] = array(
    "title" => "My Profile",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "profile_user_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["notification_count"] = array(
    "title" => "Notification Count",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["notification_preference_change"] = array(
    "title" => "Notification Preference Change",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "status",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["other_post"] = array(
    "title" => "Other Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["post_detail"] = array(
    "title" => "Post Detail",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["post_liked_users"] = array(
    "title" => "Post Liked Users",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["post_list"] = array(
    "title" => "Post List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "is_feed",
        "profile_user_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["privacy_preference_change"] = array(
    "title" => "Privacy Preference Change",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "status",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["remove_notification"] = array(
    "title" => "Remove Notification",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "notification_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["replies_list"] = array(
    "title" => "Replies List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["reply_on_comment"] = array(
    "title" => "Reply on comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "reply_text",
        "upload_file",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["report_abuse_on_comment"] = array(
    "title" => "Report abuse on comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "report_notes",
        "type",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["report_abuse_on_post"] = array(
    "title" => "Report abuse on post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "report_notes",
        "type",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["resend_verification_email"] = array(
    "title" => "Resend Verification Email",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "email"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["search_friends"] = array(
    "title" => "Search Friends",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "exclude",
        "keyword",
        "latitude",
        "longitude",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["send_post_notification"] = array(
    "title" => "Send Post Notification",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "comment_id",
        "post_id",
        "tokbox_session_id",
        "type",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["send_push_notification"] = array(
    "title" => "Send Push Notification",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "message",
        "receiver_id",
        "sender_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["share_live_video_post"] = array(
    "title" => "Share Live Video Post",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["share_post"] = array(
    "title" => "Share Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "share_text",
        "user_id",
        "visibility"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["signup"] = array(
    "title" => "Signup",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "app_version",
        "ddob",
        "device_name",
        "device_os",
        "device_token",
        "device_type",
        "gender",
        "lattitude",
        "longitude",
        "mobile_num",
        "password",
        "profile_image",
        "user_email",
        "user_name"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["social_signup"] = array(
    "title" => "Social Signup",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "app_version",
        "device_name",
        "device_os",
        "device_token",
        "device_type",
        "facebook_id",
        "google_id",
        "lattitude",
        "longitude",
        "mobile_num",
        "password",
        "profile_image",
        "user_email",
        "user_name"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["start_live_archive"] = array(
    "title" => "Start Live Archive",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["start_live_stream"] = array(
    "title" => "Start Live Stream",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "post_text",
        "user_id",
        "video_thumbnail"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["static_pages"] = array(
    "title" => "Static Pages",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "page_code"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["suggestions"] = array(
    "title" => "Suggestions",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["unfollow_user"] = array(
    "title" => "Unfollow User",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "following_user_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["update_impression_count"] = array(
    "title" => "Update Impression Count",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["update_media_view_count"] = array(
    "title" => "Update Media View Count",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "iPostMediaId",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["update_profile_cover"] = array(
    "title" => "Update Profile Cover",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "cover_photo",
        "cover_y_dimention",
        "profile_image",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["update_user_location"] = array(
    "title" => "Update User Location",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "latitude",
        "longitude",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["user_albums"] = array(
    "title" => "User Albums",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["user_followers"] = array(
    "title" => "User Followers",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "profile_user_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["user_following"] = array(
    "title" => "User Following",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "profile_user_id",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["user_notifications_list"] = array(
    "title" => "User Notifications list",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["viral_plus_media_list"] = array(
    "title" => "Viral Plus Media List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);
$config["viral_post_list"] = array(
    "title" => "Viral Post List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "user_id"
    ),
    "token" => "",
    "payload" => array(
    ),
    "target" => ""
);#####GENERATED_CONFIG_SETTINGS_END#####

/* End of file cit_webservices.php */
/* Location: ./application/config/cit_webservices.php */
    