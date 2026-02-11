<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Viral Post List Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Viral Post List
 *
 * @class Viral_post_list.php
 *
 * @path application\webservice\post\controllers\Viral_post_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 17.11.2022
 */

class Viral_post_list extends Cit_Controller
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
            "update_user_device_token",
            "update_user_latitude_longititude",
            "prepare_viral_post_id_list",
            "update_viral_post_user_visit_date",
        );
        $this->multiple_keys = array(
            "get_viral_posts",
            "get_viral_post_comment_stats",
            "get_viral_post_like_stats",
            "get_viral_post_share_stats",
            "assign_user_post_statistics",
            "fetch_viral_post_ids",
            "get_viral_post_media",
            "custom_add_ads",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('viral_post_list_model');
        $this->load->model("user/users_model");
        $this->load->model("post/post_model");
        $this->load->model("wscustom/wscustom_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_viral_post_list method is used to validate api input params.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 17.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_viral_post_list($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "viral_post_list");

        return $valid_res;
    }

    /**
     * start_viral_post_list method is used to initiate api execution flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 17.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_viral_post_list($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_viral_post_list($request_arr);
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

            $condition_res = $this->check_device_token_block($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->update_user_device_token($input_params);
            }

            $condition_res = $this->condition_for_lat_lng($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->update_user_latitude_longititude($input_params);
            }

            $input_params = $this->get_viral_posts($input_params);

            $condition_res = $this->condition_for_get_viral_post($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->prepare_viral_post_id_list($input_params);

                $input_params = $this->get_viral_post_comment_stats($input_params);

                $input_params = $this->get_viral_post_like_stats($input_params);

                $input_params = $this->get_viral_post_share_stats($input_params);

                $input_params = $this->assign_user_post_statistics($input_params);

                $input_params = $this->fetch_viral_post_ids($input_params);

                $input_params = $this->get_viral_post_media($input_params);

                $input_params = $this->update_viral_post_user_visit_date($input_params);

                $input_params = $this->custom_add_ads($input_params);

                $output_response = $this->post_finish_success_1($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->post_finish_success($input_params);
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
     * check_device_token_block method is used to process conditions.
     * @created Anjaneyulu Gulla | 18.03.2020
     * @modified Anjaneyulu Gulla | 18.03.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_device_token_block($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["device_token"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;
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
     * update_user_device_token method is used to process query block.
     * @created Anjaneyulu Gulla | 18.03.2020
     * @modified  | 18.03.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_device_token($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["device_token"]))
            {
                $params_arr["device_token"] = $input_params["device_token"];
            }
            $params_arr["_dtmodifieddate"] = "NOW()";
            $this->block_result = $this->users_model->update_user_device_token($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_device_token"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_lat_lng method is used to process conditions.
     * @created Rohit Patidar | 03.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_lat_lng($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["latitude"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["longitude"];

            $cc_fr_1 = (!is_null($cc_lo_1) && !empty($cc_lo_1) && trim($cc_lo_1) != "") ? TRUE : FALSE;
            if (!$cc_fr_1)
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
     * update_user_latitude_longititude method is used to process query block.
     * @created Rohit Patidar | 03.09.2021
     * @modified Rohit Patidar | 03.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_latitude_longititude($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["latitude"]))
            {
                $params_arr["latitude"] = $input_params["latitude"];
            }
            if (isset($input_params["longitude"]))
            {
                $params_arr["longitude"] = $input_params["longitude"];
            }
            $this->block_result = $this->users_model->update_user_latitude_longititude($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_latitude_longititude"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_viral_posts method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 17.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_viral_posts($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $latitude = isset($input_params["latitude"]) ? $input_params["latitude"] : "";
            $longitude = isset($input_params["longitude"]) ? $input_params["longitude"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $device = isset($input_params["device_type"]) ? $input_params['device_type'] : "";

            if($device == "web") {
                  $this->block_result = $this->post_model->get_web_viral_posts($latitude, $longitude, $user_id, $page_index, $this->settings_params);
            } else {
                  $this->block_result = $this->post_model->get_viral_posts($latitude, $longitude, $user_id, $page_index, $this->settings_params);
            }
            // print_r($this->block_result);
            // die;
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

                    $data = $data_arr["p_added_date_1"];
                    if (method_exists($this->general, "dateTimeSystemFormat"))
                    {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["p_added_date_1"] = $data;

                    $data = $data_arr["user_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["user_profile_image"] = $data;

                    $data = $data_arr["custom_field_8"];
                    if (method_exists($this, "post_detail_url"))
                    {
                        $data = $this->post_detail_url($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["custom_field_8"] = $data;

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
        $input_params["get_viral_posts"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_get_viral_post method is used to process conditions.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_viral_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_viral_posts"]) ? 0 : 1);
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
     * prepare_viral_post_id_list method is used to process custom function.
     * @created  | 06.09.2019
     * @modified  | 09.09.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function prepare_viral_post_id_list($input_params = array())
    {
        if (!method_exists($this, "getViralPostIDList"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->getViralPostIDList($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["prepare_viral_post_id_list"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_viral_post_comment_stats method is used to process query block.
     * @created  | 06.09.2019
     * @modified Nandini Santoki | 18.09.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_viral_post_comment_stats($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_stats_cond_1 = isset($input_params["post_stats_cond_1"]) ? $input_params["post_stats_cond_1"] : "";
            $this->block_result = $this->wscustom_model->get_viral_post_comment_stats($post_stats_cond_1);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_viral_post_comment_stats"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_viral_post_like_stats method is used to process query block.
     * @created  | 07.11.2019
     * @modified Rohit Patidar | 28.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_viral_post_like_stats($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_stats_cond_1 = isset($input_params["post_stats_cond_1"]) ? $input_params["post_stats_cond_1"] : "";
            $this->block_result = $this->wscustom_model->get_viral_post_like_stats($post_stats_cond_1);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_viral_post_like_stats"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_viral_post_share_stats method is used to process query block.
     * @created  | 07.11.2019
     * @modified Nandini Santoki | 18.09.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_viral_post_share_stats($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_stats_cond_1 = isset($input_params["post_stats_cond_1"]) ? $input_params["post_stats_cond_1"] : "";
            $this->block_result = $this->wscustom_model->get_viral_post_share_stats($post_stats_cond_1);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_viral_post_share_stats"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * assign_user_post_statistics method is used to process custom function.
     * @created  | 06.09.2019
     * @modified  | 06.09.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function assign_user_post_statistics($input_params = array())
    {
        if (!method_exists($this, "assignViralPostStats"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->assignViralPostStats($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["assign_user_post_statistics"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * fetch_viral_post_ids method is used to process custom function.
     * @created Jay Rajput | 09.08.2022
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_viral_post_ids($input_params = array())
    {
        if (!method_exists($this, "viral_post_ids"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->viral_post_ids($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["fetch_viral_post_ids"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_viral_post_media method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 14.10.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_viral_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $p_ids = isset($input_params["p_ids"]) ? $input_params["p_ids"] : "";
            $this->block_result = $this->post_media_model->get_viral_post_media($user_id, $p_ids);
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
                    if($data_arr['pm_post_source_type'] == 'aws') {
                        $data = $data_arr["pm_upload_file_1"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id_1"] != "") ? $data_arr["pm_user_id_1"] : $input_params["pm_user_id_1"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_upload_file_1"] = $data;

                        $data = $data_arr["pm_added_date_1"];
                        if (method_exists($this->general, "getDateOnly"))
                        {
                            $data = $this->general->getDateOnly($data, $result_arr[$data_key], $i, $input_params);
                        }
                        $result_arr[$data_key]["pm_added_date_1"] = $data;

                        $data = $data_arr["pm_video_thumbnail_1"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id_1"] != "") ? $data_arr["pm_user_id_1"] : $input_params["pm_user_id_1"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_video_thumbnail_1"] = $data;

                        $data = $data_arr["display_image_1"];
                        if (method_exists($this, "get_display_image_others"))
                        {
                            $data = $this->get_display_image_others($data, $result_arr[$data_key], $i, $input_params);
                        }
                        $result_arr[$data_key]["display_image_1"] = $data;

                        $data = $data_arr["pm_upload_file_org_1"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id_1"] != "") ? $data_arr["pm_user_id_1"] : $input_params["pm_user_id_1"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_upload_file_org_1"] = $data;

                        $data = $data_arr["pm_video_thumbnail_org_1"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id_1"] != "") ? $data_arr["pm_user_id_1"] : $input_params["pm_user_id_1"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_video_thumbnail_org_1"] = $data;
                    } else {
                        $data = $data_arr['pm_cloudinary_url'];
                        $result_arr[$data_key]["pm_upload_file_1"] = $data;
                        $data = $data_arr['pm_cloudinary_url'];
                        $result_arr[$data_key]["display_image"] = $data;
                        $result_arr[$data_key]["pm_video_thumbnail_1"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                        $result_arr[$data_key]["pm_video_thumbnail_2"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                        $result_arr[$data_key]["pm_video_thumbnail_3"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                        $result_arr[$data_key]["pm_upload_file_org_1"] = $data;
                        if ($result_arr[$data_key]["pm_media_type"] === 'Video') {
                            $result_arr[$data_key]["display_image"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_1"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_2"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_3"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            
                            $result_arr[$data_key]["pm_video_thumbnail_org_1"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_org_2"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_org_3"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);

                        } else {
                            $result_arr[$data_key]["pm_video_thumbnail_org_1"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_org_2"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail_org_3"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                        }
                    }
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
        $input_params["get_viral_post_media"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * update_viral_post_user_visit_date method is used to process query block.
     * @created Rohit Patidar | 11.05.2021
     * @modified Rohit Patidar | 11.05.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_viral_post_user_visit_date($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_dtvpupdatedate"] = "";
            if (method_exists($this, "getUserUpdateDate"))
            {
                $params_arr["_dtvpupdatedate"] = $this->getUserUpdateDate($params_arr["_dtvpupdatedate"], $input_params);
            }
            $this->block_result = $this->users_model->update_viral_post_user_visit_date($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_viral_post_user_visit_date"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * custom_add_ads method is used to process custom function.
     * @created Rohit Patidar | 05.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_add_ads($input_params = array())
    {
        if (!method_exists($this, "addAds"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->addAds($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_add_ads"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 10.08.2022
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
            'user_name',
            'user_profile_image',
            'p_status_1',
            'p_actual_post_id_1',
            'p_visibility_1',
            'ts_tokbox_session_id_1',
            'p_impression_count',
            'expire_date',
            'comment_count_1',
            'likes_count_1',
            'shared_count_1',
            'p_post_meta_data',
            'p_post_text_emoji',
            'custom_field_8',
            'distance_kms',
            'is_like_1',
            'is_impressed',
            'p_ids',
            'pm_post_media_id_1',
            'pm_post_id_1',
            'pm_media_type_1',
            'pm_user_id_1',
            'pm_upload_file_1',
            'pm_added_date_1',
            'pm_video_thumbnail_1',
            'display_image_1',
            'pm_views_count_3',
            'is_viewed',
            'pm_upload_file_org_1',
            'pm_video_thumbnail_org_1',
            'media_like_count',
            'media_comment_count',
            'is_media_like',
            'pm_mheight',
            'pm_mwidth',
        );
        $output_keys = array(
            'get_viral_posts',
            'assign_user_post_statistics',
            'fetch_viral_post_ids',
            'get_viral_post_media',
        );
        $ouput_aliases = array(
            "p_post_id_1" => "p_post_id",
            "p_user_id_1" => "p_user_id",
            "p_post_type_1" => "p_post_type",
            "p_status_1" => "p_status",
            "p_actual_post_id_1" => "p_actual_post_id",
            "p_visibility_1" => "p_visibility",
            "ts_tokbox_session_id_1" => "ts_tokbox_session_id",
            "comment_count_1" => "comment_count",
            "custom_field_8" => "custom_field",
            "is_like_1" => "is_like",
            "pm_post_media_id_1" => "pm_post_media_id",
            "pm_post_id_1" => "post_id",
            "pm_media_type_1" => "pm_media_type",
            "pm_user_id_1" => "pm_user_id",
            "pm_upload_file_1" => "pm_upload_file",
            "pm_added_date_1" => "pm_added_date",
            "pm_video_thumbnail_1" => "pm_video_thumbnail",
            "display_image_1" => "display_image",
            "pm_views_count_3" => "pm_views_count",
            "pm_upload_file_org_1" => "upload_file_org",
            "pm_video_thumbnail_org_1" => "video_thumbnail_org",
            "pm_mheight" => "media_height",
            "pm_mwidth" => "media_width",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "viral_post_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "viral_post_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
