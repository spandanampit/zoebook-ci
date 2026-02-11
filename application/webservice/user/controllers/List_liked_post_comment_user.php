<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of List Liked Post Comment User Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module List Liked Post Comment User
 *
 * @class List_liked_post_comment_user.php
 *
 * @path application\webservice\user\controllers\List_liked_post_comment_user.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class List_liked_post_comment_user extends Cit_Controller
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
            "get_search_ids",
        );
        $this->multiple_keys = array(
            "get_user_data_v1_v1",
            "fetch_is_follwing_v3_v1",
            "fetch_follower_count_v3_v1",
            "fetch_following_count_v3_v1",
            "get_post_count_v3_v1",
            "final_friends_list",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('list_liked_post_comment_user_model');
        $this->load->model("post/post_comment_like_model");
        $this->load->model("user/user_followers_model");
        $this->load->model("post/post_model");
    }

    /**
     * rules_list_liked_post_comment_user method is used to validate api input params.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Jay Rajput | 25.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_list_liked_post_comment_user($request_arr = array())
    {
        $valid_arr = array(
            "post_comment_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_comment_id_required",
                )
            ),
            "post_id_1" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_1_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "list_liked_post_comment_user");

        return $valid_res;
    }

    /**
     * start_list_liked_post_comment_user method is used to initiate api execution flow.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Jay Rajput | 25.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_list_liked_post_comment_user($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_list_liked_post_comment_user($request_arr);
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

            $input_params = $this->get_user_data_v1_v1($input_params);

            $input_params = $this->get_search_ids($input_params);

            $input_params = $this->fetch_is_follwing_v3_v1($input_params);

            $input_params = $this->fetch_follower_count_v3_v1($input_params);

            $input_params = $this->fetch_following_count_v3_v1($input_params);

            $input_params = $this->get_post_count_v3_v1($input_params);

            $input_params = $this->final_friends_list($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->users_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->users_finish_success_1($input_params);
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
     * get_user_data_v1_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 25.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_data_v1_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $latitude = isset($input_params["latitude"]) ? $input_params["latitude"] : "";
            $longitude = isset($input_params["longitude"]) ? $input_params["longitude"] : "";
            $post_id_1 = isset($input_params["post_id_1"]) ? $input_params["post_id_1"] : "";
            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;
            $this->block_result = $this->post_comment_like_model->get_user_data_v1_v1($latitude, $longitude, $post_id_1, $post_comment_id, $page_index, $this->settings_params);
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

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

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
        $input_params["get_user_data_v1_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_search_ids method is used to process custom function.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_search_ids($input_params = array())
    {
        if (!method_exists($this, "getSearchIds"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->getSearchIds($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["get_search_ids"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * fetch_is_follwing_v3_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_is_follwing_v3_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->user_followers_model->fetch_is_follwing_v3_v1($search_ids, $user_id);
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
        $input_params["fetch_is_follwing_v3_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * fetch_follower_count_v3_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_follower_count_v3_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $this->block_result = $this->user_followers_model->fetch_follower_count_v3_v1($search_ids);
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
        $input_params["fetch_follower_count_v3_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * fetch_following_count_v3_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_following_count_v3_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $this->block_result = $this->user_followers_model->fetch_following_count_v3_v1($search_ids);
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
        $input_params["fetch_following_count_v3_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_post_count_v3_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_count_v3_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $this->block_result = $this->post_model->get_post_count_v3_v1($search_ids);
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
        $input_params["get_post_count_v3_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * final_friends_list method is used to process custom function.
     * @created CIT Dev Team
     * @modified Jay Rajput | 25.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function final_friends_list($input_params = array())
    {
        if (!method_exists($this, "modifyDetails"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->modifyDetails($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["final_friends_list"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_user_data_v1_v1"]) ? 0 : 1);
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
     * users_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 07.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_finish_success",
        );
        $output_fields = array(
            'u_users_id',
            'u_name',
            'u_profile_image',
            'is_follwing',
            'follower_count',
            'following_count',
            'post_count',
            'pending_request_id',
            'distance_kms',
            'u_email',
            'pl_post_id',
            'pl_post_comment_id',
            'pl_post_id_1',
        );
        $output_keys = array(
            'get_user_data_v1_v1',
        );
        $ouput_aliases = array(
            "get_user_data_v1_v1" => "get_user_data",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "list_liked_post_comment_user";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success_1 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "list_liked_post_comment_user";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
