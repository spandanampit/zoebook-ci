<?php
defined('BASEPATH') || exit('No direct script access allowed');

#####GENERATED_DEBUG_SETTINGS_START#####

$config["account_activation"] = array(
    "update_aactive" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("func_verified_failure_page", "func_verified_page")
    ),
    "func_verified_page" => array(
        "type" => "function",
        "next" => "users_finish_success"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "func_verified_failure_page" => array(
        "type" => "function",
        "next" => "users_finish_success_1"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["change_password"] = array(
    "old_and_new_password_check" => array(
        "type" => "condition",
        "next" => array("mod_customer_finish_success", "check_user_password")
    ),
    "check_user_password" => array(
        "type" => "query",
        "next" => "check_old_password"
    ),
    "check_old_password" => array(
        "type" => "condition",
        "next" => array("finish_customer_pwd_failure", "update_user_password")
    ),
    "update_user_password" => array(
        "type" => "query",
        "next" => "finish_customer_pwd_success"
    ),
    "finish_customer_pwd_success" => array(
        "type" => "finish"
    ),
    "finish_customer_pwd_failure" => array(
        "type" => "finish"
    ),
    "mod_customer_finish_success" => array(
        "type" => "finish"
    )
);
$config["check_existed_accounts"] = array(
    "users_exist" => array(
        "type" => "query",
        "next" => "found"
    ),
    "found" => array(
        "type" => "condition",
        "next" => array("users_finish_success_1", "users_finish_success")
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["country_list"] = array(
    "get_country_list" => array(
        "type" => "query",
        "next" => "is_country_list_exists"
    ),
    "is_country_list_exists" => array(
        "type" => "condition",
        "next" => array("finish_country_list_failure", "finish_country_list_success")
    ),
    "finish_country_list_success" => array(
        "type" => "finish"
    ),
    "finish_country_list_failure" => array(
        "type" => "finish"
    )
);
$config["country_with_states"] = array(
    "get_country_data" => array(
        "type" => "query",
        "next" => "is_country_data_exists"
    ),
    "is_country_data_exists" => array(
        "type" => "condition",
        "next" => array("finish_country_data_failure", "country_start_loop")
    ),
    "country_start_loop" => array(
        "type" => "startloop",
        "next" => "get_state_list",
        "end" => "country_end_loop",
        "loop" => array("get_country_data", "array")
    ),
    "get_state_list" => array(
        "type" => "query",
        "next" => "country_end_loop"
    ),
    "country_end_loop" => array(
        "type" => "endloop",
        "next" => "finish_country_data_success"
    ),
    "finish_country_data_success" => array(
        "type" => "finish"
    ),
    "finish_country_data_failure" => array(
        "type" => "finish"
    )
);
$config["device_token_update"] = array(
    "empty_devicetoken" => array(
        "type" => "query",
        "next" => "update_device_token"
    ),
    "update_device_token" => array(
        "type" => "query",
        "next" => "users_finish_success"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    )
);
$config["edit_profile"] = array(
    "email_is_not_empty" => array(
        "type" => "condition",
        "next" => array("update_user_detail", "check_email_dup")
    ),
    "check_email_dup" => array(
        "type" => "query",
        "next" => "email_dup"
    ),
    "email_dup" => array(
        "type" => "condition",
        "next" => array("update_user_details", "users_email_dup_success")
    ),
    "users_email_dup_success" => array(
        "type" => "finish"
    ),
    "update_user_details" => array(
        "type" => "query",
        "next" => "update_success"
    ),
    "update_success" => array(
        "type" => "finish"
    ),
    "update_user_detail" => array(
        "type" => "query",
        "next" => "updated_success"
    ),
    "updated_success" => array(
        "type" => "finish"
    )
);
$config["follow_accept_reject_cancel"] = array(
    "check_status" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_4", "condition_2")
    ),
    "condition_2" => array(
        "type" => "condition",
        "next" => array("update_follow_status", "user_followers_finish_success_2")
    ),
    "user_followers_finish_success_2" => array(
        "type" => "finish"
    ),
    "update_follow_status" => array(
        "type" => "query",
        "next" => "condition_1"
    ),
    "condition_1" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_1", "condition_check_accept")
    ),
    "condition_check_accept" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_3", "push_notification")
    ),
    "push_notification" => array(
        "type" => "pushnotify",
        "next" => "email_notification"
    ),
    "email_notification" => array(
        "type" => "notifyemail",
        "next" => "user_followers_finish_success"
    ),
    "user_followers_finish_success" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_3" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_1" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_4" => array(
        "type" => "finish"
    )
);
$config["follow_request"] = array(
    "check_req_exist_status" => array(
        "type" => "query",
        "next" => "condition_check_exist"
    ),
    "condition_check_exist" => array(
        "type" => "condition",
        "next" => array("condition_check_status", "query")
    ),
    "query" => array(
        "type" => "query",
        "next" => "get_user_details"
    ),
    "get_user_details" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("users_finish_success", "add_follow_request")
    ),
    "add_follow_request" => array(
        "type" => "query",
        "next" => "insert_user_notification"
    ),
    "insert_user_notification" => array(
        "type" => "query",
        "next" => "push_notification"
    ),
    "push_notification" => array(
        "type" => "pushnotify",
        "next" => "email_notification"
    ),
    "email_notification" => array(
        "type" => "notifyemail",
        "next" => "users_finish_success_1"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "condition_check_status" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_1", "user_followers_finish_success")
    ),
    "user_followers_finish_success" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["forgot_password"] = array(
    "get_customer_by_email_v1" => array(
        "type" => "query",
        "next" => "is_customer_exists"
    ),
    "is_customer_exists" => array(
        "type" => "condition",
        "next" => array("finish_customer_pwd_failure", "assign_random_password")
    ),
    "assign_random_password" => array(
        "type" => "variable",
        "next" => "is_password_generated"
    ),
    "is_password_generated" => array(
        "type" => "condition",
        "next" => array("finish_customer_pwd_generation", "change_customer_password_v1")
    ),
    "change_customer_password_v1" => array(
        "type" => "query",
        "next" => "forgot_password_email"
    ),
    "forgot_password_email" => array(
        "type" => "notifyemail",
        "next" => "finish_customer_pwd_success"
    ),
    "finish_customer_pwd_success" => array(
        "type" => "finish"
    ),
    "finish_customer_pwd_generation" => array(
        "type" => "finish"
    ),
    "finish_customer_pwd_failure" => array(
        "type" => "finish"
    )
);
$config["login"] = array(
    "get_fbid_google_id" => array(
        "type" => "query",
        "next" => "select_user"
    ),
    "select_user" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("users_finish_success_2", "condition_email_verify_check")
    ),
    "condition_email_verify_check" => array(
        "type" => "condition",
        "next" => array("finish_success", "condition_1")
    ),
    "condition_1" => array(
        "type" => "condition",
        "next" => array("users_finish_success_1", "update_dev_token")
    ),
    "update_dev_token" => array(
        "type" => "function",
        "next" => "update_user_lat_long"
    ),
    "update_user_lat_long" => array(
        "type" => "query",
        "next" => "users_finish_success"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    ),
    "finish_success" => array(
        "type" => "finish"
    ),
    "users_finish_success_2" => array(
        "type" => "finish"
    )
);
$config["my_follower_requests"] = array(
    "get_follower_requests" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_1", "user_followers_finish_success")
    ),
    "user_followers_finish_success" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["my_followers"] = array(
    "get_my_followers" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_1", "user_followers_finish_success")
    ),
    "user_followers_finish_success" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["my_following_requests"] = array(
    "get_follow_request" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_1", "user_followers_finish_success")
    ),
    "user_followers_finish_success" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["my_following_users"] = array(
    "get_following_users" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("user_followers_finish_success_1", "user_followers_finish_success")
    ),
    "user_followers_finish_success" => array(
        "type" => "finish"
    ),
    "user_followers_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["my_profile"] = array(
    "condition" => array(
        "type" => "condition",
        "next" => array("get_user_profile", "get_my_profile")
    ),
    "get_my_profile" => array(
        "type" => "query",
        "next" => "condition_2"
    ),
    "condition_2" => array(
        "type" => "condition",
        "next" => array("users_finish_success", "users_success")
    ),
    "users_success" => array(
        "type" => "finish"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "get_user_profile" => array(
        "type" => "query",
        "next" => "condition_1"
    ),
    "condition_1" => array(
        "type" => "condition",
        "next" => array("user_failure", "user_success")
    ),
    "user_success" => array(
        "type" => "finish"
    ),
    "user_failure" => array(
        "type" => "finish"
    )
);
$config["search_friends"] = array(
    "get_user_data" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("users_finish_success_1", "users_finish_success")
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    )
);
$config["signup"] = array(
    "email_empty" => array(
        "type" => "condition",
        "next" => array("users_finish_success_5", "email_duplicate_v1")
    ),
    "email_duplicate_v1" => array(
        "type" => "query",
        "next" => "email_exist"
    ),
    "email_exist" => array(
        "type" => "condition",
        "next" => array("insert_user", "email_dup_success")
    ),
    "email_dup_success" => array(
        "type" => "finish"
    ),
    "insert_user" => array(
        "type" => "query",
        "next" => "update_devic_token"
    ),
    "update_devic_token" => array(
        "type" => "function",
        "next" => "get_activate_url"
    ),
    "get_activate_url" => array(
        "type" => "query",
        "next" => "email_notification"
    ),
    "email_notification" => array(
        "type" => "notifyemail",
        "next" => "users_finish_success"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "users_finish_success_5" => array(
        "type" => "finish"
    )
);
$config["social_signup"] = array(
    "facebook_google_empty" => array(
        "type" => "condition",
        "next" => array("users_finish_success", "check_dup_fbid_google")
    ),
    "check_dup_fbid_google" => array(
        "type" => "query",
        "next" => "dup_fb_found"
    ),
    "dup_fb_found" => array(
        "type" => "condition",
        "next" => array("insert_social_user", "login_facebook_id")
    ),
    "login_facebook_id" => array(
        "type" => "function",
        "next" => "users_finish_success_2"
    ),
    "users_finish_success_2" => array(
        "type" => "finish"
    ),
    "insert_social_user" => array(
        "type" => "query",
        "next" => "exist_login"
    ),
    "exist_login" => array(
        "type" => "function",
        "next" => "users_finish_success_1"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    )
);
$config["static_pages"] = array(
    "get_data_of_pages" => array(
        "type" => "query",
        "next" => "data_found"
    ),
    "data_found" => array(
        "type" => "condition",
        "next" => array("failure", "mod_page_settings_finish_success")
    ),
    "mod_page_settings_finish_success" => array(
        "type" => "finish"
    ),
    "failure" => array(
        "type" => "finish"
    )
);
$config["unfollow_user"] = array(
    "get_follow_status" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("users_finish_success", "update_follow_request")
    ),
    "update_follow_request" => array(
        "type" => "query",
        "next" => "users_finish_success_1"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    ),
    "users_finish_success" => array(
        "type" => "finish"
    )
);
$config["update_user_location"] = array(
    "update_current_user_lat_long" => array(
        "type" => "query",
        "next" => "condition"
    ),
    "condition" => array(
        "type" => "condition",
        "next" => array("users_finish_success_1", "users_finish_success")
    ),
    "users_finish_success" => array(
        "type" => "finish"
    ),
    "users_finish_success_1" => array(
        "type" => "finish"
    )
);#####GENERATED_DEBUG_SETTINGS_END#####
/* End of file cit_wsdebugger.php */
/* Location: ./application/config/cit_wsdebugger.php */