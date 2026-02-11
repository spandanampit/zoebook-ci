<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Other Post Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Other Post
 *
 * @class Other_post.php
 *
 * @path application\webservice\post\controllers\Other_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 14.04.2023
 */

class Other_post extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
    public $multiple_keys;
    public $block_result;

    /**
     * __construct method is used to set controller preferences while controller object initialization.
     */
    public function __construct()
    {
        parent::__construct();
        $this->settings_params = array();
        $this->output_params = array();
        $this->single_keys = array(
            "post_details",
        );
        $this->multiple_keys = array(
            "get_movement_releted_post",
            "moment_post_list",
            "get_movement_post_comment",
            "get_movement_post_like_status",
            "get_movement_post_share_status",
            "assign_moment_post",
            "get_other_post_user",
            "get_my_post_id_list",
            "get_post_comment_status",
            "get_post_like_status",
            "get_post_share_status",
            "assin_my_post",
            "get_random_post",
            "random_post_data",
            "get_randome_post_comment",
            "get_randome_post_like",
            "get_randome_post_share",
            "assign_random_post",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('other_post_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_likes_model");
        $this->load->model("wscustom/wscustom_model");
    }

    /**
     * rules_other_post method is used to validate api input params.
     * @created Vamsi Ippe | 03.04.2020
     * @modified Jay Rajput | 14.04.2023
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_other_post($request_arr = array())
    {
        $valid_arr = array(
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "other_post");

        return $valid_res;
    }

    /**
     * start_other_post method is used to initiate api execution flow.
     * @created Vamsi Ippe | 03.04.2020
     * @modified Jay Rajput | 14.04.2023
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_other_post($request_arr = array(), $inner_api = FALSE)
    {
        try {
            $validation_res = $this->rules_other_post($request_arr);
            if ($validation_res["success"] == "-5") {
                if ($inner_api === TRUE) {
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];

            $input_params = $this->post_details($input_params);

            $condition_res = $this->condition_for_moment_id($input_params);
            if ($condition_res["success"]) {

                $input_params = $this->get_movement_releted_post($input_params);

                $input_params = $this->moment_post_list($input_params);

                $input_params = $this->get_movement_post_comment($input_params);

                $input_params = $this->get_movement_post_like_status($input_params);

                $input_params = $this->get_movement_post_share_status($input_params);

                $input_params = $this->assign_moment_post($input_params);

                $output_response = $this->post_finish_success_2($input_params);
                return $output_response;
            } else {

                $condition_res = $this->viral_post_empty($input_params);
                if ($condition_res["success"]) {

                    $input_params = $this->get_other_post_user($input_params);

                    $input_params = $this->get_my_post_id_list($input_params);

                    $input_params = $this->get_post_comment_status($input_params);

                    $input_params = $this->get_post_like_status($input_params);

                    $input_params = $this->get_post_share_status($input_params);

                    $input_params = $this->assin_my_post($input_params);

                    $playlist_reels_ids = $this->getPlaylistPosts($request_arr['user_id']);

                    $output_response = $this->post_finish_success($input_params);

                    foreach ($output_response['data'] as &$reels) {
                        $id = $reels['p_post_id'];
                        $reels['is_top_playlist'] = in_array($id, $playlist_reels_ids) ? 1 : 0;
                    }

                    unset($reels);

                    return $output_response;
                } else {

                    $input_params = $this->get_random_post($input_params);


                    $input_params = $this->random_post_data($input_params);

                    //   echo json_encode($input_params);die;
                    $input_params = $this->get_randome_post_comment($input_params);

                    $input_params = $this->get_randome_post_like($input_params);

                    $input_params = $this->get_randome_post_share($input_params);

                    $input_params = $this->assign_random_post($input_params);

                    $playlist_reels_ids = $this->getPlaylistPosts($request_arr['user_id']);

                    $output_response = $this->post_finish_success_1($input_params);

                    foreach ($output_response['data'] as &$reels) {
                        $id = $reels['p_post_id'];
                        $reels['is_top_playlist'] = in_array($id, $playlist_reels_ids) ? 1 : 0;
                    }
                    unset($reels);
                    return $output_response;
                }
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * post_details method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function post_details($input_params = array())
    {

        $this->block_result = array();
        try {
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->post_details($post_id);
            if (!$this->block_result["success"]) {
                throw new Exception("No records found.");
            }
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["post_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_moment_id method is used to process conditions.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_moment_id($input_params = array())
    {

        $this->block_result = array();
        try {

            $cc_lo_0 = $input_params["p_movements_id"];
            $cc_ro_0 = 0;

            $cc_fr_0 = ($cc_lo_0 != $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0) {
                throw new Exception("Some conditions does not match.");
            }
            $success = 1;
            $message = "Conditions matched.";
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        return $this->block_result;
    }

    /**
     * get_movement_releted_post method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 17.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_releted_post($input_params = array())
    {

        $this->block_result = array();
        try {

            $params_arr = array();
            if (isset($input_params["user_id"])) {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["post_id"])) {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["p_movements_id"])) {
                $params_arr["p_movements_id"] = $input_params["p_movements_id"];
            }
            $this->block_result = $this->post_model->get_movement_releted_post($params_arr);
            if (!$this->block_result["success"]) {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if (is_array($result_arr) && count($result_arr) > 0) {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr) {

                    $data = $data_arr["p_added_date_2"];
                    if (method_exists($this->general, "dateTimeSystemFormat")) {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["p_added_date_2"] = $data;

                    $data = $data_arr["u_profile_image_2"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_2"] = $data;

                    $data = $data_arr["pm_upload_file"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id_2"] != "") ? $data_arr["p_user_id_2"] : $input_params["p_user_id_2"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file"] = $data;

                    $data = $data_arr["pm_video_thumbnail"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id_2"] != "") ? $data_arr["p_user_id_2"] : $input_params["p_user_id_2"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_video_thumbnail"] = $data;

                    $data = $data_arr["is_following_3"];
                    if (method_exists($this->general, "checkUserFollowing")) {
                        $data = $this->general->checkUserFollowing($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_following_3"] = $data;

                    $data = $data_arr["share_postdetail_url_3"];
                    if (method_exists($this->general, "setpostdetailurl")) {
                        $data = $this->general->setpostdetailurl($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["share_postdetail_url_3"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_movement_releted_post"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * moment_post_list method is used to process custom function.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function moment_post_list($input_params = array())
    {
        if (!method_exists($this->general, "getMovementPostIDList")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->general->getMovementPostIDList($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["moment_post_list"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_movement_post_comment method is used to process query block.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_post_comment($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_movement_cond = isset($input_params["post_movement_cond"]) ? $input_params["post_movement_cond"] : "";
            $this->block_result = $this->wscustom_model->get_movement_post_comment($post_movement_cond);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_movement_post_comment"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_movement_post_like_status method is used to process query block.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_post_like_status($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_media_cond = isset($input_params["post_media_cond"]) ? $input_params["post_media_cond"] : "";
            $this->block_result = $this->wscustom_model->get_movement_post_like_status($post_media_cond);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_movement_post_like_status"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_movement_post_share_status method is used to process query block.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_post_share_status($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_movement_cond = isset($input_params["post_movement_cond"]) ? $input_params["post_movement_cond"] : "";
            $this->block_result = $this->wscustom_model->get_movement_post_share_status($post_movement_cond);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_movement_post_share_status"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * assign_moment_post method is used to process custom function.
     * @created Rohit Patidar | 18.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function assign_moment_post($input_params = array())
    {
        if (!method_exists($this->general, "assignMovementPost")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->general->assignMovementPost($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["assign_moment_post"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_2",
        );
        $output_fields = array(
            'p_post_id_3',
            'p_actual_post_id_2',
            'p_user_id_2',
            'p_post_type_2',
            'p_post_text_2',
            'p_visibility_2',
            'p_impression_count_2',
            'p_added_date_2',
            'p_status_2',
            'u_name_2',
            'u_profile_image_2',
            'pm_post_media_id',
            'pm_media_type',
            'pm_upload_file',
            'pm_video_thumbnail',
            'pm_views_count',
            'pm_mheight',
            'pm_mwidth',
            'is_like_3',
            'expire_date_3',
            'is_impressed_3',
            'comment_count_3',
            'like_count_3',
            'shared_count_3',
            'is_viewed_3',
            'is_following_3',
            'share_postdetail_url_3',
            'pending_request_id_3',
            'ts_tokbox_session_id_3',
        );
        $output_keys = array(
            'get_movement_releted_post',
        );
        $ouput_aliases = array(
            "p_post_id_3" => "p_post_id",
            "p_actual_post_id_2" => "p_actual_post_id",
            "p_user_id_2" => "p_user_id",
            "p_post_type_2" => "p_post_type",
            "p_post_text_2" => "p_post_text",
            "p_visibility_2" => "p_visibility",
            "p_impression_count_2" => "p_impression_count",
            "p_added_date_2" => "p_added_date",
            "p_status_2" => "p_status",
            "u_name_2" => "u_name",
            "u_profile_image_2" => "u_profile_image",
            "pm_post_media_id" => "post_media_id",
            "pm_media_type" => "um_media_type",
            "pm_upload_file" => "um_upload_file",
            "pm_video_thumbnail" => "p_video_thumbnail",
            "pm_views_count" => "views_count",
            "pm_mheight" => "um_mheight",
            "pm_mwidth" => "um_mwidth",
            "is_like_3" => "is_like",
            "expire_date_3" => "expire_date",
            "is_impressed_3" => "is_impressed",
            "comment_count_3" => "comment_count",
            "like_count_3" => "like_count",
            "shared_count_3" => "shared_count",
            "is_viewed_3" => "is_viewed",
            "is_following_3" => "is_following",
            "share_postdetail_url_3" => "post_detail_url",
            "pending_request_id_3" => "pending_request_id",
            "ts_tokbox_session_id_3" => "ts_tokbox_session_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "other_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * viral_post_empty method is used to process conditions.
     * @created Nandini Santoki | 08.10.2020
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function viral_post_empty($input_params = array())
    {

        $this->block_result = array();
        try {

            $cc_lo_0 = $input_params["viral_feed"];

            $cc_fr_0 = (is_null($cc_lo_0) || empty($cc_lo_0) || trim($cc_lo_0) == "") ? TRUE : FALSE;
            if (!$cc_fr_0) {
                throw new Exception("Some conditions does not match.");
            }
            $success = 1;
            $message = "Conditions matched.";
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        return $this->block_result;
    }

    /**
     * get_other_post_user method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_other_post_user($input_params = array())
    {

        $this->block_result = array();
        try {

            $params_arr = array();
            if (isset($input_params["user_id"])) {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["post_id"])) {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["is_feed"])) {
                $params_arr["is_feed"] = $input_params["is_feed"];
            }
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->post_model->get_other_post_user($params_arr, $page_index, $this->settings_params);
            if (!$this->block_result["success"]) {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];

            foreach ($result_arr as $key => $arr) {
                $like_result = $this->post_media_likes_model->get_post_media_like_count($arr['post_media_id']);
                $like_count = isset($like_result['like_count']) ? $like_result['like_count'] : 0;
                $result_arr[$key]['likes_count'] = $like_count;
            }

            if (is_array($result_arr) && count($result_arr) > 0) {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr) {

                    $data = $data_arr["p_added_date"];
                    if (method_exists($this->general, "dateTimeSystemFormat")) {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["p_added_date"] = $data;

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $data = $data_arr["um_upload_file"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id"] != "") ? $data_arr["p_user_id"] : $input_params["p_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["um_upload_file"] = $data;

                    $data = $data_arr["is_following_1"];
                    if (method_exists($this->general, "checkUserFollowing")) {
                        $data = $this->general->checkUserFollowing($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_following_1"] = $data;

                    $data = $data_arr["share_postdetail_url_1"];
                    if (method_exists($this->general, "setpostdetailurl")) {
                        $data = $this->general->setpostdetailurl($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["share_postdetail_url_1"] = $data;

                    $data = $data_arr["um_video_thumbnail"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id"] != "") ? $data_arr["p_user_id"] : $input_params["p_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["um_video_thumbnail"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_other_post_user"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_my_post_id_list method is used to process custom function.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_my_post_id_list($input_params = array())
    {
        if (!method_exists($this->general, "getMyPostIDList")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->general->getMyPostIDList($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["get_my_post_id_list"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_post_comment_status method is used to process query block.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_comment_status($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_stats_cond = isset($input_params["post_stats_cond"]) ? $input_params["post_stats_cond"] : "";
            $this->block_result = $this->wscustom_model->get_post_comment_status($post_stats_cond);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_post_comment_status"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_post_like_status method is used to process query block.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_like_status($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_media_cond = isset($input_params["post_media_cond"]) ? $input_params["post_media_cond"] : "";
            $this->block_result = $this->wscustom_model->get_post_like_status($post_media_cond);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_post_like_status"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_post_share_status method is used to process query block.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_share_status($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_stats_cond = isset($input_params["post_stats_cond"]) ? $input_params["post_stats_cond"] : "";
            $this->block_result = $this->wscustom_model->get_post_share_status($post_stats_cond);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_post_share_status"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * assin_my_post method is used to process custom function.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function assin_my_post($input_params = array())
    {
        if (!method_exists($this->general, "assignMyPostStats")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->general->assignMyPostStats($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["assin_my_post"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Nandini Santoki | 03.04.2020
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success",
        );
        $output_fields = array(
            'p_post_id',
            'p_user_id',
            'p_post_type',
            'p_post_text',
            'p_added_date',
            'is_like',
            'u_name',
            'u_profile_image',
            'p_status',
            'p_actual_post_id',
            'ts_tokbox_session_id',
            'expire_date',
            'p_visibility',
            'p_impression_count',
            'is_impressed',
            'comment_count',
            'likes_count',
            'shared_count',
            'um_upload_file',
            'um_media_type',
            'post_media_id',
            'is_viewed',
            'views_count',
            'is_following_1',
            'share_postdetail_url_1',
            'um_video_thumbnail',
            'pending_request_id_1',
            'um_mheight_1',
            'um_mwidth_1',
        );
        $output_keys = array(
            'get_other_post_user',
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "other_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_random_post method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 14.04.2023
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_random_post($input_params = array())
    {

        $this->block_result = array();
        try {

            $params_arr = array();
            if (isset($input_params["user_id"])) {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["post_id"])) {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->post_model->get_random_post($params_arr, $page_index, $this->settings_params);
            if (!$this->block_result["success"]) {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            // usort($result_arr, function ($a, $b) {
            //     return strtotime($b['p_added_date_1']) - strtotime($a['p_added_date_1']);
            // });

            // print_r($result_arr);die;

            if (is_array($result_arr) && count($result_arr) > 0) {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr) {

                    $data = $data_arr["p_added_date_1"];
                    if (method_exists($this->general, "dateTimeSystemFormat")) {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["p_added_date_1"] = $data;

                    $data = $data_arr["u_profile_image_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_1"] = $data;

                    $data = $data_arr["um_upload_file_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id_1"] != "") ? $data_arr["p_user_id_1"] : $input_params["p_user_id_1"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["um_upload_file_1"] = $data;

                    $data = $data_arr["is_following"];
                    if (method_exists($this->general, "checkUserFollowing")) {
                        $data = $this->general->checkUserFollowing($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_following"] = $data;

                    $data = $data_arr["share_post_detail_url"];
                    if (method_exists($this->general, "setpostdetailurl")) {
                        $data = $this->general->setpostdetailurl($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["share_post_detail_url"] = $data;

                    $data = $data_arr["um_video_thumbnail_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id_1"] != "") ? $data_arr["p_user_id_1"] : $input_params["p_user_id_1"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["um_video_thumbnail_1"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_random_post"] = $this->block_result["data"];

        return $input_params;
    }


    public function get_random_reels($input_params = array())
    {

        $this->block_result = array();
        try {
            $params_arr = array();

            if (isset($input_params["user_id"])) {
                $params_arr["user_id"] = $input_params["user_id"];
            }

            if (isset($input_params["post_id"])) {
                $params_arr["post_id"] = $input_params["post_id"];
            }

            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;


            $this->block_result = $this->post_model->get_random_reels($params_arr, $page_index, $this->settings_params);
            // $this->block_result = $this->post_model->get_random_reels_old($params_arr, $page_index, $this->settings_params);

            if (!$this->block_result["success"]) {
                throw new Exception("No records found.");
            }

            $result_arr = $this->block_result["data"];
            // print_r($result_arr);die;

            foreach ($result_arr as $key => $arr) {
                $like_result = $this->post_media_likes_model->get_post_media_like_count($arr['post_media_id_1']);
                $like_count = isset($like_result['like_count']) ? $like_result['like_count'] : 0;
                $result_arr[$key]['likes_count_1'] = $like_count;
            }

            if (is_array($result_arr) && count($result_arr) > 0) {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr) {

                    $data = $data_arr["p_added_date_1"];
                    if (method_exists($this->general, "dateTimeSystemFormat")) {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["p_added_date_1"] = $data;

                    $data = $data_arr["u_profile_image_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_1"] = $data;

                    $data = $data_arr["um_upload_file_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id_1"] != "") ? $data_arr["p_user_id_1"] : $input_params["p_user_id_1"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["um_upload_file_1"] = $data;

                    $data = $data_arr["is_following"];
                    if (method_exists($this->general, "checkUserFollowing")) {
                        $data = $this->general->checkUserFollowing($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_following"] = $data;

                    $data = $data_arr["share_post_detail_url"];
                    if (method_exists($this->general, "setpostdetailurl")) {
                        $data = $this->general->setpostdetailurl($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["share_post_detail_url"] = $data;

                    $data = $data_arr["um_video_thumbnail_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["p_user_id_1"] != "") ? $data_arr["p_user_id_1"] : $input_params["p_user_id_1"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["um_video_thumbnail_1"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["settings"] = $this->block_result["settings"];
        $input_params["get_random_post"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * random_post_data method is used to process custom function.
     * @created Rohit Patidar | 14.06.2021
     * @modified Jay Rajput | 14.04.2023
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function random_post_data($input_params = array())
    {

        if (!method_exists($this->general, "getRandomePost")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->general->getRandomePost($input_params);
        }
        // print_r($this->general->getRandomePost($input_params));die;
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["random_post_data"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_randome_post_comment method is used to process query block.
     * @created Rohit Patidar | 14.06.2021
     * @modified Rohit Patidar | 14.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_randome_post_comment($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_stats_cond_1 = isset($input_params["post_stats_cond_1"]) ? $input_params["post_stats_cond_1"] : "";
            $this->block_result = $this->wscustom_model->get_randome_post_comment($post_stats_cond_1);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_randome_post_comment"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_randome_post_like method is used to process query block.
     * @created Rohit Patidar | 14.06.2021
     * @modified Rohit Patidar | 14.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_randome_post_like($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_media_cond_1 = isset($input_params["post_media_cond_1"]) ? $input_params["post_media_cond_1"] : "";
            $this->block_result = $this->wscustom_model->get_randome_post_like($post_media_cond_1);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_randome_post_like"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_randome_post_share method is used to process query block.
     * @created Rohit Patidar | 14.06.2021
     * @modified Rohit Patidar | 14.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_randome_post_share($input_params = array())
    {

        $this->block_result = array();
        try {

            $post_stats_cond_1 = isset($input_params["post_stats_cond_1"]) ? $input_params["post_stats_cond_1"] : "";
            $this->block_result = $this->wscustom_model->get_randome_post_share($post_stats_cond_1);
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_randome_post_share"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * assign_random_post method is used to process custom function.
     * @created Rohit Patidar | 14.06.2021
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function assign_random_post($input_params = array())
    {
        if (!method_exists($this->general, "assingRandomePost")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->general->assingRandomePost($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["assign_random_post"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Nandini Santoki | 08.10.2020
     * @modified Jay Rajput | 08.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_1",
        );
        $output_fields = array(
            'p_post_id_1',
            'p_user_id_1',
            'p_post_type_1',
            'p_post_text_1',
            'p_added_date_1',
            'is_like_1',
            'u_name_1',
            'u_profile_image_1',
            'p_status_1',
            'p_actual_post_id_1',
            'ts_tokbox_session_id_1',
            'expire_date_1',
            'p_visibility_1',
            'p_impression_count_1',
            'is_impressed_1',
            'comment_count_1',
            'likes_count_1',
            'shared_count_1',
            'um_upload_file_1',
            'um_media_type_1',
            'views_count_1',
            'post_media_id_1',
            'is_view_1',
            'is_following',
            'share_post_detail_url',
            'um_video_thumbnail_1',
            'pending_request_id',
            'um_mheight',
            'um_mwidth',
        );
        $output_keys = array(
            'get_random_post',
        );
        $ouput_aliases = array(
            "p_post_id_1" => "p_post_id",
            "p_user_id_1" => "p_user_id",
            "p_post_type_1" => "p_post_type",
            "p_post_text_1" => "p_post_text",
            "p_added_date_1" => "p_added_date",
            "is_like_1" => "is_like",
            "u_name_1" => "u_name",
            "u_profile_image_1" => "u_profile_image",
            "p_status_1" => "p_status",
            "p_actual_post_id_1" => "p_actual_post_id",
            "ts_tokbox_session_id_1" => "ts_tokbox_session_id",
            "expire_date_1" => "expire_date",
            "p_visibility_1" => "p_visibility",
            "p_impression_count_1" => "p_impression_count",
            "is_impressed_1" => "is_impressed",
            "comment_count_1" => "comment_count",
            "likes_count_1" => "likes_count",
            "shared_count_1" => "shared_count",
            "um_upload_file_1" => "um_upload_file",
            "um_media_type_1" => "um_media_type",
            "views_count_1" => "views_count",
            "post_media_id_1" => "post_media_id",
            "is_view_1" => "is_view",
            "share_post_detail_url" => "post_detail_url",
            "um_video_thumbnail_1" => "p_video_thumbnail",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "other_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }



    /**
     * random_reels method is used to process custom function.
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function random_reels()
    {
        $userId = $this->input->get_post('user_id');
        $page_index = $this->input->get_post('page_index');
        $is_reels = $this->input->get_post('is_reels');


        if (empty($userId)) {
            $this->wsresponse->sendValidationResponse(array(
                "success" => 0,
                "message" => "user_id is required"
            ));
            return;
        }

        if (!is_numeric($page_index) || $page_index <= 0) {
            $this->wsresponse->sendValidationResponse(array(
                "success" => 0,
                "message" => "page_index must be a positive number"
            ));
            return;
        }

        if (!in_array($is_reels, array("0", "1"))) {
            $this->wsresponse->sendValidationResponse(array(
                "success" => 0,
                "message" => "is_reels must be either 0 or 1"
            ));
            return;
        }

        // Fetch playlist posts from the API
        $api_url = "https://zoebook.mydevfactory.com/WS/get_my_playlist?user_id=$userId";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $playlist_posts = json_decode(curl_exec($ch));
        curl_close($ch);

        $post_ids = array();
        if (isset($playlist_posts->data) && !empty($playlist_posts->data)) {
            foreach ($playlist_posts->data as $posts) {
                $post_ids[] = $posts->iPostId;
            }
        }

        $params_arr['user_id'] = $userId;
        $params_arr['page_index'] = $page_index;
        $params_arr['is_reels'] = $is_reels;
        $params_arr['post_id'] = 1;

        $random_reels = $this->get_random_reels($params_arr);


        // $post_data = $this->random_post_data($random_reels);
        // $post_comments = $this->get_randome_post_comment($post_data);
        // $post_likes = $this->get_randome_post_like($post_comments);
        // $post_shares = $this->get_randome_post_share($post_likes);
        // $post_assigned = $this->assign_random_post($post_shares);
        // $output_response = $this->post_finish_success_1($post_assigned);


        $output_response = [];
        $output_response['settings']['count'] = $random_reels['settings']['count'];
        $output_response['settings']['user_id'] = $userId;
        $output_response['settings']['message'] = 'random reels fetched successfully';
        $output_response['settings']['per_page'] = $random_reels['settings']['per_page'];
        $output_response['settings']['curr_page'] = $random_reels['settings']['curr_page'];
        $output_response['settings']['prev_page'] = $random_reels['settings']['prev_page'];
        $output_response['settings']['next_page'] = $random_reels['settings']['next_page'];
        $output_response['settings']['page_index'] = $page_index;
        $output_response['settings']['is_reels'] = $is_reels;
        $output_response['settings']['success'] = '1';

        foreach ($random_reels['get_random_post'] as $posts) {
            $post_data = array(
                'is_following' => $posts['is_following'],
                'p_post_id' => $posts['p_post_id_1'],
                'p_user_id' => $posts['p_user_id_1'],
                'p_post_type' => $posts['p_post_type_1'],
                'p_post_text' => $posts['p_post_text_1'],
                'p_added_date' => $posts['p_added_date_1'],
                'is_like' => $posts['is_like_1'],
                'u_name' => $posts['u_name_1'],
                'u_profile_image' => $posts['u_profile_image_1'],
                'p_status' => $posts['p_status_1'],
                'p_actual_post_id' => $posts['p_actual_post_id_1'],
                'ts_tokbox_session_id' => $posts['ts_tokbox_session_id_1'],
                'expire_date' => $posts['expire_date_1'],
                'p_visibility' => $posts['p_visibility_1'],
                'p_impression_count' => $posts['p_impression_count_1'],
                'is_impressed' => $posts['is_impressed_1'],
                'comment_count' => $posts['comment_count_1'],
                'likes_count' => $posts['likes_count_1'],
                'shared_count' => $posts['shared_count_1'],
                'um_upload_file' => $posts['um_upload_file_1'],
                'um_media_type' => $posts['um_media_type_1'],
                'views_count' => $posts['views_count_1'],
                'post_media_id' => $posts['post_media_id_1'],
                'is_viewed' => $posts['is_viewed_1'],
                'post_detail_url' => $posts['share_post_detail_url'],
                'um_video_thumbnail' => $posts['um_video_thumbnail_1'],
                'um_mheight' => $posts['um_mheight'],
                'um_mwidth' => $posts['um_mwidth'],
            );

            // Assign field names only once
            if (empty($fields)) {
                $fields = array_keys($post_data);
            }

            $output_response['data'][] = $post_data;
        }

        $output_response['settings']['fields'] = $fields;


        foreach ($output_response['data'] as &$reels) {
            $id = $reels['p_post_id'];
            $reels['is_top_playlist'] = in_array($id, $post_ids) ? 1 : 0;
        }

        unset($reels);

        echo json_encode($output_response);
    }


    //TO GET PLAYIST POSTS
    private function getPlaylistPosts($userId)
    {
        $api_url = "https://zoebook.mydevfactory.com/WS/get_my_playlist?user_id=$userId";
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $api_url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $playlist_posts = json_decode(curl_exec($ch));
        curl_close($ch);

        $post_ids = array();
        if (isset($playlist_posts->data) && !empty($playlist_posts->data)) {
            foreach ($playlist_posts->data as $posts) {
                $post_ids[] = $posts->iPostId;
            }
        }

        return $post_ids;
    }
}
