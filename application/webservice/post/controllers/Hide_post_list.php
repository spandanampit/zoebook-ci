<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Hide post list Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Hide post list
 *
 * @class Hide_post_list.php
 *
 * @path application\webservice\post\controllers\Hide_post_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 19.10.2022
 */

class Hide_post_list extends Cit_Controller
{
    public $settings_params;
    public $output_params;
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
        $this->multiple_keys = array(
            "get_hide_post",
            "prepare_user_post_id_list",
            "get_user_post_comment_stats1",
            "get_user_post_like_stats1",
            "get_user_post_share_stats1",
            "assign_user_post_stats",
            "fetch_post_id",
            "get_user_post_media1",
            "add_ads_hide_post",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('hide_post_list_model');
        $this->load->model("post/post_report_abuse_model");
        $this->load->model("wscustom/wscustom_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_hide_post_list method is used to validate api input params.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 19.10.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_hide_post_list($request_arr = array())
    {
        $valid_arr = array(
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "hide_post_list");

        return $valid_res;
    }

    /**
     * start_hide_post_list method is used to initiate api execution flow.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 19.10.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_hide_post_list($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_hide_post_list($request_arr);
            if ($validation_res["success"] == "-5")
            {
                if ($inner_api === TRUE)
                {
                    return $validation_res;
                }
                else
                {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];

            $input_params = $this->get_hide_post($input_params);

            $condition_res = $this->condition_for_hide_post($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->prepare_user_post_id_list($input_params);

                $input_params = $this->get_user_post_comment_stats1($input_params);

                $input_params = $this->get_user_post_like_stats1($input_params);

                $input_params = $this->get_user_post_share_stats1($input_params);

                $input_params = $this->assign_user_post_stats($input_params);

                $input_params = $this->fetch_post_id($input_params);

                $input_params = $this->get_user_post_media1($input_params);

                $input_params = $this->add_ads_hide_post($input_params);

                $output_response = $this->success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->success_failure($input_params);
                return $output_response;
            }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * get_hide_post method is used to process query block.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 19.10.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_hide_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->post_report_abuse_model->get_hide_post($user_id, $page_index, $this->settings_params);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if (is_array($result_arr) && count($result_arr) > 0)
            {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr)
                {

                    $data = $data_arr["p_added_date"];
                    if (method_exists($this->general, "dateTimeSystemFormat"))
                    {
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

                    $data = $data_arr["p_video_thumbnail"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["FFFFFF"] != "") ? $data_arr["FFFFFF"] : $input_params["FFFFFF"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $dest_path = "thumbnail";
                    $image_arr["path"] = $this->general->getImageNestedFolders($dest_path);
                    $data = $this->general->get_image($image_arr);

                    $result_arr[$data_key]["p_video_thumbnail"] = $data;

                    $data = $data_arr["custom_field_6"];
                    if (method_exists($this, "post_detail_url"))
                    {
                        $data = $this->post_detail_url($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["custom_field_6"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_hide_post"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_hide_post method is used to process conditions.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_hide_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_hide_post"]) ? 0 : 1);
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $success = 1;
            $message = "Conditions matched.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        return $this->block_result;
    }

    /**
     * prepare_user_post_id_list method is used to process custom function.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function prepare_user_post_id_list($input_params = array())
    {
        if (!method_exists($this, "getUserPostIDList"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->getUserPostIDList($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["prepare_user_post_id_list"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_user_post_comment_stats1 method is used to process query block.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_post_comment_stats1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_stats_cond = isset($input_params["post_stats_cond"]) ? $input_params["post_stats_cond"] : "";
            $this->block_result = $this->wscustom_model->get_user_post_comment_stats1($post_stats_cond);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_user_post_comment_stats1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_user_post_like_stats1 method is used to process query block.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_post_like_stats1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_stats_cond = isset($input_params["post_stats_cond"]) ? $input_params["post_stats_cond"] : "";
            $this->block_result = $this->wscustom_model->get_user_post_like_stats1($post_stats_cond);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_user_post_like_stats1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_user_post_share_stats1 method is used to process query block.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_post_share_stats1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_stats_cond = isset($input_params["post_stats_cond"]) ? $input_params["post_stats_cond"] : "";
            $this->block_result = $this->wscustom_model->get_user_post_share_stats1($post_stats_cond);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_user_post_share_stats1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * assign_user_post_stats method is used to process custom function.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function assign_user_post_stats($input_params = array())
    {
        if (!method_exists($this, "assignUserPostStats"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->assignUserPostStats($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["assign_user_post_stats"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * fetch_post_id method is used to process custom function.
     * @created Jay Rajput | 26.08.2022
     * @modified Jay Rajput | 26.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_post_id($input_params = array())
    {
        if (!method_exists($this, "post_ids"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->post_ids($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["fetch_post_id"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_user_post_media1 method is used to process query block.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 11.10.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_post_media1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_media_model->get_user_post_media1($user_id, $post_id);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if (is_array($result_arr) && count($result_arr) > 0)
            {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr)
                {

                    $data = $data_arr["pm_upload_file_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file_1"] = $data;

                    $data = $data_arr["pm_added_date"];
                    if (method_exists($this->general, "getDateOnly"))
                    {
                        $data = $this->general->getDateOnly($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["pm_added_date"] = $data;

                    $data = $data_arr["pm_video_thumbnail"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_video_thumbnail"] = $data;

                    $data = $data_arr["display_image"];
                    if (method_exists($this, "get_display_image_others"))
                    {
                        $data = $this->get_display_image_others($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["display_image"] = $data;

                    $data = $data_arr["pm_upload_file_org"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file_org"] = $data;

                    $data = $data_arr["pm_video_thumbnail_org"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_video_thumbnail_org"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_user_post_media1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * add_ads_hide_post method is used to process custom function.
     * @created Rohit Patidar | 21.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function add_ads_hide_post($input_params = array())
    {
        if (!method_exists($this, "addAdsHidePost"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->addAdsHidePost($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["add_ads_hide_post"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * success method is used to process finish flow.
     * @created Rohit Patidar | 17.06.2021
     * @modified Jay Rajput | 26.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success",
        );
        $output_fields = array(
            'p_post_id',
            'p_user_id',
            'p_post_type',
            'p_post_text',
            'p_added_date',
            'expire_date',
            'u_name',
            'u_profile_image',
            'p_status',
            'p_actual_post_id',
            'p_visibility',
            'comment_count',
            'shared_count',
            'p_post_meta_data',
            'p_video_thumbnail',
            'p_post_text_emoji',
            'custom_field_6',
            'p_impression_count',
            'pl_post_like_id',
            'is_impressed',
            'pm_post_media_id',
            'pm_post_id',
            'pm_media_type',
            'pm_user_id',
            'pm_upload_file_1',
            'pm_added_date',
            'pm_video_thumbnail',
            'display_image',
            'pm_views_count',
            'is_viewed',
            'pm_upload_file_org',
            'pm_video_thumbnail_org',
            'media_like_count',
            'media_comment_count',
            'is_media_like',
            'pm_mheight',
            'pm_mwidth',
        );
        $output_keys = array(
            'get_hide_post',
            'get_user_post_media1',
        );
        $ouput_aliases = array(
            "p_post_id" => "post_id",
            "p_user_id" => "posted_user_id",
            "p_post_type" => "post_type",
            "p_post_text" => "post_text",
            "p_added_date" => "added_date",
            "u_name" => "user_name",
            "u_profile_image" => "user_profile_image",
            "p_status" => "status",
            "p_actual_post_id" => "actual_post_id",
            "p_visibility" => "visibility",
            "p_video_thumbnail" => "live_video_thumbnail",
            "p_post_text_emoji" => "post_text_emoji",
            "custom_field_6" => "post_detail_url",
            "p_impression_count" => "impression_count",
            "pl_post_like_id" => "likes_count",
            "get_user_post_media1" => "get_post_media",
            "pm_post_id" => "post_id",
            "pm_upload_file_1" => "pm_upload_file",
            "pm_upload_file_org" => "upload_file_org",
            "pm_video_thumbnail_org" => "video_thumbnail_org",
            "pm_mheight" => "media_height",
            "pm_mwidth" => "media_width",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * success_failure method is used to process finish flow.
     * @created Rohit Patidar | 17.06.2021
     * @modified Rohit Patidar | 17.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "success_failure",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post_list";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
