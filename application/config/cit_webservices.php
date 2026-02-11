<?php

defined('BASEPATH') OR exit('No direct script access allowed');

#####GENERATED_CONFIG_SETTINGS_START#####

$config["account_activation"] = array(
    "title" => "Account Activation",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["add_movement"] = array(
    "title" => "Add Movement",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "description",
        "movement_name",
        "theme",
        "user_id",
        "visibility"
    )
);
$config["add_movement_image"] = array(
    "title" => "Add movement  image",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_type",
        "movements_id",
        "platform",
        "upload_file",
        "user_id",
        "video_tumbnail"
    )
);
$config["add_post"] = array(
    "title" => "Add Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "movements_id",
        "post_text",
        "post_text_emoji",
        "post_type",
        "user_id",
        "visibility"
    )
);
$config["add_post_media"] = array(
    "title" => "Add Post Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "file_type",
        "is_completed",
        "platform",
        "post_id",
        "upload_file",
        "user_id",
        "video_thumbnail"
    )
);
$config["application_version_status"] = array(
    "title" => "Application Version Status",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "device_id",
        "device_token",
        "device_type",
        "other_info_json",
        "user_id",
        "version_number"
    )
);
$config["blocked_user_list"] = array(
    "title" => "blocked user list",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["change_password"] = array(
    "title" => "Change Password",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "new_password",
        "old_password",
        "user_id"
    )
);
$config["check_existed_accounts"] = array(
    "title" => "Check Existed Accounts",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "facebook_id",
        "google_id"
    )
);
$config["comment_liked_users"] = array(
    "title" => "Comment Liked Users",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    )
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
    )
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
    )
);
$config["comments_list"] = array(
    "title" => "Comments List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_media_id",
        "user_id"
    )
);
$config["contact_us_submit"] = array(
    "title" => "Contact Us Submit",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "email",
        "message_text",
        "name"
    )
);
$config["country_list"] = array(
    "title" => "Country List",
    "folder" => "tools",
    "method" => "BOTH",
    "params" => array(
    )
);
$config["country_with_states"] = array(
    "title" => "Country With States",
    "folder" => "tools",
    "method" => "BOTH",
    "params" => array(
        "country_id"
    )
);
$config["delete_account"] = array(
    "title" => "Delete Account",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["delete_comment"] = array(
    "title" => "Delete Comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    )
);
$config["delete_media"] = array(
    "title" => "Delete Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_media_id",
        "user_id"
    )
);
$config["delete_movement_cron_job"] = array(
    "title" => "Delete movement cron job",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
    )
);
$config["delete_post"] = array(
    "title" => "Delete Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    )
);
$config["delete_reply_comment"] = array(
    "title" => "Delete Reply comment",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    )
);
$config["device_token_update"] = array(
    "title" => "Device Token Update",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "device_type",
        "user_id"
    )
);
$config["edit_movement"] = array(
    "title" => "Edit movement",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "description",
        "movements_id",
        "movement_image_id",
        "movement_name",
        "theme",
        "user_id",
        "visibility"
    )
);
$config["edit_post"] = array(
    "title" => "Edit Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_text",
        "post_text_emoji",
        "post_type",
        "user_id",
        "visibility"
    )
);
$config["edit_profile"] = array(
    "title" => "Edit Profile",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "about_me",
        "covervideo_thumbnail",
        "cover_photo",
        "file_type",
        "platform",
        "profile_image",
        "user_email",
        "user_id",
        "user_name",
        "user_phone"
    )
);
$config["end_live_stream"] = array(
    "title" => "End Live Stream",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    )
);
$config["extract_meta_data"] = array(
    "title" => "Extract meta data",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_text"
    )
);
$config["follow_accept_reject_cancel"] = array(
    "title" => "Follow Accept Reject Cancel",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "status",
        "user_follow_request_id",
        "user_id"
    )
);
$config["follow_request"] = array(
    "title" => "Follow Request",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "following_user_id",
        "user_id"
    )
);
$config["forgot_password"] = array(
    "title" => "Forgot Password",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_email"
    )
);
$config["get_feature_contents"] = array(
    "title" => "Get Feature Contents",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
    )
);
$config["get_movement_follower_user"] = array(
    "title" => "Get movement followers user",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "follower_count",
        "movement_id",
        "user_id"
    )
);
$config["get_post_media_comments"] = array(
    "title" => "Get Post Media Comments",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_id"
    )
);
$config["get_post_media_likes"] = array(
    "title" => "Get Post Media Likes",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_id"
    )
);
$config["get_promotional_links"] = array(
    "title" => "Get Promotional Links",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
    )
);
$config["get_website_screenshots"] = array(
    "title" => "Get Website Screenshots",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "type"
    )
);
$config["get_mevements_token"] = array(
    "title" => "get_mevements_token",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["hide_post"] = array(
    "title" => "Hide post",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "Type",
        "user_id"
    )
);
$config["hide_post_list"] = array(
    "title" => "Hide post list",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "is_ads_show",
        "user_id"
    )
);
$config["join_live_stream"] = array(
    "title" => "Join Live Stream",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    )
);
$config["join_movements"] = array(
    "title" => "Join Movements",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "movements_id",
        "Type",
        "user_id"
    )
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
    )
);
$config["like_post"] = array(
    "title" => "Like Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "status",
        "user_id"
    )
);
$config["like_post_media"] = array(
    "title" => "Like Post Media",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "media_id",
        "status",
        "user_id"
    )
);
$config["list_liked_post_comment_user"] = array(
    "title" => "List Liked Post Comment User",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id_1",
        "user_id"
    )
);
$config["list_liked_post_media"] = array(
    "title" => "List Liked Post Media",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "media_id",
        "post_id_1",
        "user_id"
    )
);
$config["list_liked_post_user"] = array(
    "title" => "List Liked Post User",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "post_id_1",
        "user_id"
    )
);
$config["login"] = array(
    "title" => "Login",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "apple_id",
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
    )
);
$config["logout"] = array(
    "title" => "logout",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["movement_active_inactive"] = array(
    "title" => "Movement Active Inactive",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "movement_id",
        "status",
        "user_id"
    )
);
$config["movement_follower_remove"] = array(
    "title" => "Movement follower remove",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "admin_id",
        "movement_id",
        "user_id"
    )
);
$config["movement_insta_view"] = array(
    "title" => "Movement insta view",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["movement_invitation"] = array(
    "title" => "Movement invitation",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "invitee_user_id",
        "inviter_user_id",
        "movement_id"
    )
);
$config["movement_invitation_accept_reject"] = array(
    "title" => "Movement invitation accept reject",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "movement_id",
        "status",
        "user_id"
    )
);
$config["movements_details"] = array(
    "title" => "Movements Details",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "movements_id",
        "user_id"
    )
);
$config["movements_follower"] = array(
    "title" => "Movements follower",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "movements_id",
        "search_text",
        "user_id"
    )
);
$config["movements_post_list"] = array(
    "title" => "Movements post list",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "is_ads_show",
        "movement_id",
        "user_id"
    )
);
$config["my_follower_requests"] = array(
    "title" => "My Follower Requests",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["my_following_requests"] = array(
    "title" => "My Following Requests",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["my_movements"] = array(
    "title" => "My Movements",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["my_profile"] = array(
    "title" => "My Profile",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "profile_user_id",
        "user_id"
    )
);
$config["notification_count"] = array(
    "title" => "Notification Count",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["notification_preference_change"] = array(
    "title" => "Notification Preference Change",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "status",
        "user_id"
    )
);
$config["other_post"] = array(
    "title" => "Other Post",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "latitude",
        "longitude",
        "post_id",
        "user_id",
        "viral_feed"
    )
);
$config["popular_movements"] = array(
    "title" => "Popular movements",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["post_detail"] = array(
    "title" => "Post Detail",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    )
);
$config["post_liked_users"] = array(
    "title" => "Post Liked Users",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    )
);
$config["post_list"] = array(
    "title" => "Post List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "is_ads_show",
        "is_feed",
        "profile_user_id",
        "user_id"
    )
);
$config["privacy_preference_change"] = array(
    "title" => "Privacy Preference Change",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "status",
        "user_id"
    )
);
$config["private_movements_access_reject"] = array(
    "title" => "private movements access reject",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "movement_id",
        "status",
        "user_id"
    )
);
$config["remove_notification"] = array(
    "title" => "Remove Notification",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "notification_id",
        "user_id"
    )
);
$config["replies_list"] = array(
    "title" => "Replies List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_comment_id",
        "post_id",
        "user_id"
    )
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
    )
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
    )
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
    )
);
$config["resend_verification_email"] = array(
    "title" => "Resend Verification Email",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "email"
    )
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
    )
);
$config["search_movements"] = array(
    "title" => "Search movements",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "keyword",
        "user_id"
    )
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
    )
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
    )
);
$config["send_bulk_mail"] = array(
    "title" => "send_bulk_mail",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
    )
);
$config["send_movement_pushnotification"] = array(
    "title" => "Send_movement_pushnotification",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
        "movement_id",
        "post_id",
        "user_id"
    )
);
$config["share_live_video_post"] = array(
    "title" => "Share Live Video Post",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    )
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
    )
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
    )
);
$config["social_signup"] = array(
    "title" => "Social Signup",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "apple_id",
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
    )
);
$config["start_live_archive"] = array(
    "title" => "Start Live Archive",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "tokbox_session_id",
        "user_id"
    )
);
$config["start_live_stream"] = array(
    "title" => "Start Live Stream",
    "folder" => "tokbox",
    "method" => "GET_POST",
    "params" => array(
        "post_text",
        "user_id",
        "video_thumbnail"
    )
);
$config["static_pages"] = array(
    "title" => "Static Pages",
    "folder" => "tools",
    "method" => "GET_POST",
    "params" => array(
        "page_code"
    )
);
$config["suggestions"] = array(
    "title" => "Suggestions",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "user_id"
    )
);
$config["unfollow_user"] = array(
    "title" => "Unfollow User",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "following_user_id",
        "user_id"
    )
);
$config["update_cover_heigh_width"] = array(
    "title" => "Update cover heigh width",
    "folder" => "misc",
    "method" => "GET_POST",
    "params" => array(
    )
);
$config["update_impression_count"] = array(
    "title" => "Update Impression Count",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "user_id"
    )
);
$config["update_media_post_height_width"] = array(
    "title" => "Update media post height width",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
    )
);
$config["update_media_view_count"] = array(
    "title" => "Update Media View Count",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "iPostMediaId",
        "user_id"
    )
);
$config["update_profile_cover"] = array(
    "title" => "Update Profile Cover",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "cover_photo",
        "cover_y_dimention",
        "platform",
        "profile_image",
        "user_id"
    )
);
$config["update_user_location"] = array(
    "title" => "Update User Location",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "latitude",
        "longitude",
        "user_id"
    )
);
$config["upsert_block_user_list"] = array(
    "title" => "upsert_block_user_list",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "blocked_user_id",
        "block_by_user_id"
    )
);
$config["user_albums"] = array(
    "title" => "User Albums",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "profile_user_id",
        "user_id"
    )
);
$config["user_followers"] = array(
    "title" => "User Followers",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "movement_id",
        "profile_user_id",
        "search_text",
        "user_id"
    )
);
$config["user_following"] = array(
    "title" => "User Following",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "profile_user_id",
        "user_id"
    )
);
$config["user_notifications_list"] = array(
    "title" => "User Notifications list",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "user_id"
    )
);
$config["viral_plus_media_list"] = array(
    "title" => "Viral Plus Media List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "latitude",
        "longitude",
        "user_id"
    )
);
$config["viral_post_list"] = array(
    "title" => "Viral Post List",
    "folder" => "post",
    "method" => "GET_POST",
    "params" => array(
        "device_token",
        "is_ads_show",
        "latitude",
        "longitude",
        "user_id"
    )
);
$config["viral_post_notification"] = array(
    "title" => "viral post notification",
    "folder" => "user",
    "method" => "GET_POST",
    "params" => array(
        "post_id",
        "post_type",
        "user_id"
    )
);#####GENERATED_CONFIG_SETTINGS_END#####

/* End of file cit_webservices.php */
/* Location: ./application/config/cit_webservices.php */
    