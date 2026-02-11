<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Replies List Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Replies List
 *
 * @class Replies_list.php
 *
 * @path application\webservice\post\controllers\Replies_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Replies_list extends Cit_Controller
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
            "check_commented_post_exists",
            "check_comment_exists",
        );
        $this->multiple_keys = array(
            "get_replies",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('replies_list_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_comment_model");
    }

    /**
     * rules_replies_list method is used to validate api input params.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 22.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_replies_list($request_arr = array())
    {
        $valid_arr = array(
            "post_comment_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_comment_id_required",
                )
            ),
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "replies_list");

        return $valid_res;
    }

    /**
     * start_replies_list method is used to initiate api execution flow.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 22.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_replies_list($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_replies_list($request_arr);
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

            $input_params = $this->check_commented_post_exists($input_params);

            $condition_res = $this->condition_for_check_comment($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->check_comment_exists($input_params);

                $condition_res = $this->cond_check_comment_exist($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->get_replies($input_params);

                    $condition_res = $this->condition_for_get_reply($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->post_finish_success_1($input_params);
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

                    $output_response = $this->post_finish_success_3($input_params);
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
     * check_commented_post_exists method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_commented_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->check_commented_post_exists($post_id);
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
        $input_params["check_commented_post_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_check_comment method is used to process conditions.
     * @created CIT Dev Team
     * @modified Jay Rajput | 22.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_check_comment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_commented_post_exists"]) ? 0 : 1);
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
     * check_comment_exists method is used to process query block.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_comment_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_comment_model->check_comment_exists($post_comment_id, $post_id);
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
        $input_params["check_comment_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_comment_exist method is used to process conditions.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_comment_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_comment_exists"]) ? 0 : 1);
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
     * get_replies method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 22.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_replies($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $this->block_result = $this->post_comment_model->get_replies($user_id, $post_id, $post_comment_id);
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

                        $data = $data_arr["pc_upload_file"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pc_user_id"] != "") ? $data_arr["pc_user_id"] : $input_params["pc_user_id"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["color"] = "FFFFFF";
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_media";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pc_upload_file"] = $data;
                    }else{
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
        $input_params["get_replies"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_get_reply method is used to process conditions.
     * @created CIT Dev Team
     * @modified Jay Rajput | 22.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_reply($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_replies"]) ? 0 : 1);
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
     * @created CIT Dev Team
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
            'count_reply_likes',
            'is_reply_like',
            'pc_parent_id',
            'pc_upload_file',
        );
        $output_keys = array(
            'get_replies',
        );
        $ouput_aliases = array(
            "pc_post_comment_id" => "reply_id",
            "pc_post_id" => "post_id",
            "pc_comment" => "comment",
            "pc_added_date" => "added_date",
            "u_users_id" => "user_id",
            "u_profile_image" => "profile_image",
            "pc_parent_id" => "post_comment_id",
            "pc_upload_file" => "upload_file",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "replies_list";
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
     * @created CIT Dev Team
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

        $func_array["function"]["name"] = "replies_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 24.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "replies_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.09.2018
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

        $func_array["function"]["name"] = "replies_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
