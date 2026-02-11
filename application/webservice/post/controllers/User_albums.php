<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Albums Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module User Albums
 *
 * @class User_albums.php
 *
 * @path application\webservice\post\controllers\User_albums.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 14.10.2022
 */

class User_albums extends Cit_Controller
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
            "get_media_posts",
            "custom_media_ids",
            "get_media_post_media",
            "get_users_post",
            "custom_fetch_post_id",
            "get_user_media_post",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('user_albums_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_user_albums method is used to validate api input params.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Jay Rajput | 14.10.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_user_albums($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "user_albums");

        return $valid_res;
    }

    /**
     * start_user_albums method is used to initiate api execution flow.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Jay Rajput | 14.10.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_user_albums($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_user_albums($request_arr);
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

            $condition_res = $this->condition_for_checking_user($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->get_media_posts($input_params);

                $input_params = $this->custom_media_ids($input_params);

                $input_params = $this->get_media_post_media($input_params);

                $condition_res = $this->condition_check($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_finish_success_2($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->post_finish_success_3($input_params);
                    return $output_response;
                }
            }

            else
            {

                $input_params = $this->get_users_post($input_params);

                $input_params = $this->custom_fetch_post_id($input_params);

                $input_params = $this->get_user_media_post($input_params);

                $condition_res = $this->condition_get_user_posts($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->post_finish_success_1($input_params);
                    return $output_response;
                }
            }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * condition_for_checking_user method is used to process conditions.
     * @created Rohit Patidar | 10.06.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_checking_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["profile_user_id"];

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;

            $cc_lo_1 = $input_params["profile_user_id"];

            $cc_fr_1 = (is_null($cc_lo_1) || empty($cc_lo_1) || trim($cc_lo_1) == "") ? TRUE : FALSE;
            if (!($cc_fr_0 || $cc_fr_1))
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
     * get_media_posts method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 10.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_media_posts($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->post_model->get_media_posts($user_id, $page_index, $this->settings_params);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_media_posts"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * custom_media_ids method is used to process custom function.
     * @created Jay Rajput | 23.08.2022
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_media_ids($input_params = array())
    {
        if (!method_exists($this, "fetch_mm_ids"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->fetch_mm_ids($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_media_ids"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_media_post_media method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 14.10.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_media_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $mm_ids = isset($input_params["mm_ids"]) ? $input_params["mm_ids"] : "";
            $this->block_result = $this->post_media_model->get_media_post_media($user_id, $mm_ids);
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
                        $data = $data_arr["pm_upload_file"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_upload_file"] = $data;

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
                        if (method_exists($this, "get_display_image"))
                        {
                            $data = $this->get_display_image($data, $result_arr[$data_key], $i, $input_params);
                        }
                        $result_arr[$data_key]["display_image"] = $data;

                        $data = $data_arr["pm_upload_file_org"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["no_img"] = FALSE;
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_upload_file_org"] = $data;
                    } else {
                        $data = $data_arr['pm_cloudinary_url'];
                        $result_arr[$data_key]["pm_upload_file"] = $data;
                        $data = $data_arr['pm_cloudinary_url'];
                        $result_arr[$data_key]["display_image"] = $data;
                        $result_arr[$data_key]["pm_video_thumbnail"] = $data;
                        $result_arr[$data_key]["pm_upload_file_org"] = $data;
                        if ($result_arr[$data_key]["pm_media_type"] === 'Video') {
                            $result_arr[$data_key]["display_image"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            $result_arr[$data_key]["pm_video_thumbnail"] = preg_replace('/\.[^.]+$/', '.jpg', $result_arr[$data_key]["display_image"]);
                            
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
        $input_params["get_media_post_media"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_check method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_media_posts"]) ? 0 : 1);
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
     * post_finish_success_2 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Jay Rajput | 23.08.2022
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
            'p_post_id',
            'p_user_id',
            'p_post_type',
            'media_count',
            'p_status',
            'pm_post_id',
            'pm_post_media_id',
            'pm_media_type',
            'pm_user_id',
            'pm_upload_file',
            'pm_added_date',
            'pm_video_thumbnail',
            'display_image',
            'pm_views_count',
            'is_viewed',
            'pm_upload_file_org',
        );
        $output_keys = array(
            'get_media_posts',
            'get_media_post_media',
        );
        $ouput_aliases = array(
            "p_post_id" => "post_id",
            "p_user_id" => "posted_user_id",
            "p_post_type" => "post_type",
            "p_status" => "status",
            "pm_upload_file_org" => "upload_file_org",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_albums";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_3 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_3",
        );
        $output_fields = array(
            'p_post_id',
            'p_user_id',
            'p_post_type',
            'p_post_text',
            'p_added_date',
            'is_like',
            'comment_count',
        );
        $output_keys = array(
            'get_media_posts',
        );
        $ouput_aliases = array(
            "get_my_posts_v1" => "get_my_posts",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_albums";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_users_post method is used to process query block.
     * @created Rohit Patidar | 10.06.2021
     * @modified Alpesh Patel | 20.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_users_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $profile_user_id = isset($input_params["profile_user_id"]) ? $input_params["profile_user_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->post_model->get_users_post($profile_user_id, $user_id, $page_index, $this->settings_params);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_users_post"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * custom_fetch_post_id method is used to process custom function.
     * @created Jay Rajput | 23.08.2022
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_fetch_post_id($input_params = array())
    {
        if (!method_exists($this, "fetch_post_id"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->fetch_post_id($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_fetch_post_id"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_user_media_post method is used to process query block.
     * @created Rohit Patidar | 10.06.2021
     * @modified Jay Rajput | 14.10.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_media_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $p_ids = isset($input_params["p_ids"]) ? $input_params["p_ids"] : "";
            $this->block_result = $this->post_media_model->get_user_media_post($user_id, $p_ids);
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
                    if (method_exists($this, "get_display_image"))
                    {
                        $data = $this->get_display_image($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["display_image_1"] = $data;

                    $data = $data_arr["pm_upload_file_org_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id_1"] != "") ? $data_arr["pm_user_id_1"] : $input_params["pm_user_id_1"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file_org_1"] = $data;

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
        $input_params["get_user_media_post"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_get_user_posts method is used to process conditions.
     * @created Rohit Patidar | 10.06.2021
     * @modified Jay Rajput | 23.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_get_user_posts($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_users_post"]) ? 0 : 1);
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
     * post_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 10.06.2021
     * @modified Jay Rajput | 23.08.2022
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
            'p_post_id_1',
            'p_user_id_1',
            'p_post_type_1',
            'media_count_1',
            'p_status_1',
            'pm_post_media_id_1',
            'pm_post_id_1',
            'pm_media_type_1',
            'pm_user_id_1',
            'pm_upload_file_1',
            'pm_added_date_1',
            'pm_video_thumbnail_1',
            'display_image_1',
            'pm_views_count_1',
            'is_viewed_1',
            'pm_upload_file_org_1',
        );
        $output_keys = array(
            'get_users_post',
            'get_user_media_post',
        );
        $ouput_aliases = array(
            "p_post_id_1" => "post_id",
            "p_user_id_1" => "user_id",
            "p_post_type_1" => "post_type",
            "media_count_1" => "media_count",
            "p_status_1" => "status",
            "get_user_media_post" => "get_media_post_media",
            "pm_post_media_id_1" => "pm_post_media_id",
            "pm_post_id_1" => "pm_post_id",
            "pm_media_type_1" => "pm_media_type",
            "pm_user_id_1" => "pm_user_id",
            "pm_upload_file_1" => "pm_upload_file",
            "pm_added_date_1" => "pm_added_date",
            "pm_video_thumbnail_1" => "pm_video_thumbnail",
            "display_image_1" => "display_image",
            "pm_views_count_1" => "pm_views_count",
            "is_viewed_1" => "is_viewed",
            "pm_upload_file_org_1" => "upload_file_org",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_albums";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 10.06.2021
     * @modified Rohit Patidar | 10.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_albums";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
