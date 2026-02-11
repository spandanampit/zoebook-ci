<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Comments List Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Comments List
 *
 * @class Comments_list.php
 *
 * @path application\webservice\post\controllers\Comments_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Comments_list extends Cit_Controller
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
            "check_post_exist",
            "get_post_comments_ids",
            "get_post_media_info_v1",
        );
        $this->multiple_keys = array(
            "get_comments",
            "get_count_comment_likes",
            "get_is_comment_like",
            "get_reply_count",
            "prepare_comments_list",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('comments_list_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_comment_model");
        $this->load->model("post/post_comment_like_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_comments_list method is used to validate api input params.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_comments_list($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "comments_list");

        return $valid_res;
    }

    /**
     * start_comments_list method is used to initiate api execution flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_comments_list($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_comments_list($request_arr);
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

            $input_params = $this->check_post_exist($input_params);

            $condition_res = $this->condition_for_post_exists($input_params);
            if ($condition_res["success"])
            {
                

                $condition_res = $this->check_input_media_id($input_params);
                
                if ($condition_res["success"])
                {

                    $input_params = $this->var_final_post_media_id1($input_params);
                    
                }

                else
                {
                    $input_params = $this->get_post_media_info_v1($input_params);

                    $condition_res = $this->check_post_media_info($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->var_final_post_media_id($input_params);
                    }

                    else
                    {

                        $output_response = $this->post_media_doesnt_exist($input_params);
                        return $output_response;
                    }
                }
                
                $input_params = $this->get_comments($input_params);
                $input_params = $this->get_post_comments_ids($input_params);
                
                $input_params = $this->get_count_comment_likes($input_params);
                
                $input_params = $this->get_is_comment_like($input_params);
                
                $input_params = $this->get_reply_count($input_params);
                // print_r($input_params);die;
                $input_params = $this->prepare_comments_list($input_params);

                $condition_res = $this->condition_for_checking_comments($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_finish_success_1($input_params);
                  $final_data = $this->createProfileImageUrl($output_response);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->post_finish_success_2($input_params);
                    return $output_response;
                }
               
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
     * check_post_exist method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->check_post_exist($post_id);
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
        $input_params["check_post_exist"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_post_exists method is used to process conditions.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_exist"]) ? 0 : 1);
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
     * check_input_media_id method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_input_media_id($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["post_media_id"];
            $cc_ro_0 = 0;

            $cc_fr_0 = ($cc_lo_0 <= $cc_ro_0) ? TRUE : FALSE;
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
     * var_final_post_media_id1 method is used to process simple variables.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function var_final_post_media_id1($input_params = array())
    {

        $input_params["var_ipostmedia_id"] = "0";
        $_temp_single_arr["var_ipostmedia_id"] = $input_params["var_ipostmedia_id"];
        return $input_params;
    }

    /**
     * get_post_media_info_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_media_info_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_media_id = isset($input_params["post_media_id"]) ? $input_params["post_media_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_media_model->get_post_media_info_v1($post_media_id, $post_id);
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
        $input_params["get_post_media_info_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_post_media_info method is used to process conditions.
     * @created CIT Dev Team
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_post_media_info($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_post_media_info_v1"]) ? 0 : 1);
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
     * var_final_post_media_id method is used to process simple variables.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function var_final_post_media_id($input_params = array())
    {

        $input_params["var_ipostmedia_id"] = $input_params["post_media_id"];
        $_temp_single_arr["var_ipostmedia_id"] = $input_params["var_ipostmedia_id"];
        return $input_params;
    }

    /**
     * post_media_doesnt_exist method is used to process finish flow.
     * @created Pavan  | 02.11.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_doesnt_exist($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_doesnt_exist",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comments_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_comments method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_comments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $var_ipostmedia_id = isset($input_params["var_ipostmedia_id"]) ? $input_params["var_ipostmedia_id"] : "";
            $this->block_result = $this->post_comment_model->get_comments($post_id, $var_ipostmedia_id);

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
                        $data = $data_arr["pc_added_date"];
                        if (method_exists($this->general, "dateTimeSystemFormat"))
                        {
                            $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                        }
                        $result_arr[$data_key]["pc_added_date"] = $data;

                        $data = $data_arr["u_profile_image"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $image_arr["width"] = "50";
                        $image_arr["height"] = "50";
                        $image_arr["color"] = "FFFFFF";
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_profile_image";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["u_profile_image"] = $data;
                        $result_arr[$data_key]["full_image_url"] = $data;

                        $data = $data_arr["pc_upload_file"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = "*";
                        $p_key = ($data_arr["pc_user_id"] != "") ? $data_arr["pc_user_id"] : $input_params["pc_user_id"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["color"] = "FFFFFF";
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_media";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pc_upload_file"] = $data;
                    } else {
                        $data = $data_arr['pc_cloudinary_url'];
                        $result_arr[$data_key]["pc_upload_file"] = $data;
                        $data = $data_arr['pc_cloudinary_url'];
                        $result_arr[$data_key]["display_image"] = $data;
                        $result_arr[$data_key]["pc_video_thumbnail"] = $data;
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
        $input_params["get_comments"] = $this->block_result["data"];
// print_r($input_params);die;
        return $input_params;
    }

    /**
     * get_post_comments_ids method is used to process custom function.
     * @created  | 14.10.2019
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_comments_ids($input_params = array())
    {
        if (!method_exists($this, "getPostCommentsIds"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->getPostCommentsIds($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["get_post_comments_ids"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * get_count_comment_likes method is used to process query block.
     * @created  | 14.10.2019
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_count_comment_likes($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $comments_ids = isset($input_params["comments_ids"]) ? $input_params["comments_ids"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_comment_like_model->get_count_comment_likes($comments_ids, $post_id);
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
        $input_params["get_count_comment_likes"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_is_comment_like method is used to process query block.
     * @created  | 14.10.2019
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_is_comment_like($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $comments_ids = isset($input_params["comments_ids"]) ? $input_params["comments_ids"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_comment_like_model->get_is_comment_like($comments_ids, $post_id, $user_id);
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
        $input_params["get_is_comment_like"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_reply_count method is used to process query block.
     * @created  | 14.10.2019
     * @modified Nandini Santoki | 27.10.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_reply_count($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $comments_ids = isset($input_params["comments_ids"]) ? $input_params["comments_ids"] : "";
            $this->block_result = $this->post_comment_model->get_reply_count($post_id, $comments_ids);
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
        $input_params["get_reply_count"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * prepare_comments_list method is used to process custom function.
     * @created  | 14.10.2019
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function prepare_comments_list($input_params = array())
    {
        if (!method_exists($this, "prepareCommentsList"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->prepareCommentsList($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["prepare_comments_list"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition_for_checking_comments method is used to process conditions.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_checking_comments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_comments"]) ? 0 : 1);
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
     * post_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 01.10.2018
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
            'pc_post_comment_id',
            'pc_post_id',
            'pc_comment',
            'pc_added_date',
            'user_name',
            'u_users_id',
            'u_profile_image',
            'profile_image_url',
            'count_comment_likes',
            'is_comment_like',
            'reply_count',
            'pc_upload_file',
        );
        $output_keys = array(
            'get_comments',
        );
        $ouput_aliases = array(
            "pc_post_comment_id" => "post_comment_id",
            "pc_post_id" => "post_id",
            "pc_comment" => "comment",
            "pc_added_date" => "added_date",
            "u_users_id" => "user_id",
            "u_profile_image" => "profile_image",
            "profile_image_url" => "profile_image_url",
            "pc_upload_file" => "upload_file",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comments_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comments_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
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

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comments_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

      public function createProfileImageUrl(&$input_params) {
            if (!isset($input_params['data']) || !is_array($input_params['data'])) {
                  return;
            }

            foreach ($input_params['data'] as &$d) {
                  if (!empty($d['profile_image'])) {
                        $image_name = $d['profile_image'];
                        $d['profile_image_url'] = 'https://d1ap1pbk3mm4im.cloudfront.net/compress_profile_image/' . $image_name;
                  } else {
                        $d['profile_image_url'] = null;
                  }
            }
      }

}
