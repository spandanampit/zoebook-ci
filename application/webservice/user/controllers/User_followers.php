<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Followers Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module User Followers
 *
 * @class User_followers.php
 *
 * @path application\webservice\user\controllers\User_followers.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class User_followers extends Cit_Controller
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
            "get_my_followers",
            "fetch_is_follwing_v1",
            "fetch_follower_count_v1",
            "fetch_following_count_v1",
            "get_post_count_v1",
            "final_friends_list",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('user_followers_ext_model');
        $this->load->model("user/user_followers_model");
        $this->load->model("post/post_model");
    }

    /**
     * rules_user_followers method is used to validate api input params.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_user_followers($request_arr = array())
    {
        $valid_arr = array(
            "profile_user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "profile_user_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "user_followers");

        return $valid_res;
    }

    /**
     * start_user_followers method is used to initiate api execution flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_user_followers($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_user_followers($request_arr);
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

            $condition_res = $this->condition_momenet_id_not_empty($input_params);
            if ($condition_res["success"])
            {


            }

            else
            {

                $input_params = $this->variable_assign_moment_id($input_params);
            }

            $input_params = $this->get_my_followers($input_params);

            $input_params = $this->get_search_ids($input_params);

            $input_params = $this->fetch_is_follwing_v1($input_params);

            $input_params = $this->fetch_follower_count_v1($input_params);

            $input_params = $this->fetch_following_count_v1($input_params);

            $input_params = $this->get_post_count_v1($input_params);

            $input_params = $this->final_friends_list($input_params);

            $condition_res = $this->condition_get_my_followers($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->user_followers_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->user_followers_finish_success_1($input_params);
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
     * condition_momenet_id_not_empty method is used to process conditions.
     * @created Rohit Patidar | 06.10.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_momenet_id_not_empty($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["movement_id"];

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
     * variable_assign_moment_id method is used to process simple variables.
     * @created Rohit Patidar | 06.10.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function variable_assign_moment_id($input_params = array())
    {

        $input_params["movement_id"] = "0";
        $_temp_single_arr["movement_id"] = $input_params["movement_id"];
        return $input_params;
    }

    /**
     * get_my_followers method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_my_followers($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_id = isset($input_params["movement_id"]) ? $input_params["movement_id"] : "";
            $profile_user_id = isset($input_params["profile_user_id"]) ? $input_params["profile_user_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $search_text = isset($input_params["search_text"]) ? $input_params["search_text"] : "";
            $this->block_result = $this->user_followers_model->get_my_followers($movement_id, $profile_user_id, $user_id, $search_text);
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

                    $data = $data_arr["custom_field_7"];
                    if (method_exists($this->general, "getJoinMovement"))
                    {
                        $data = $this->general->getJoinMovement($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["custom_field_7"] = $data;

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
        $input_params["get_my_followers"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_search_ids method is used to process custom function.
     * @created CIT Dev Team
     * @modified Jay Rajput | 03.08.2022
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
     * fetch_is_follwing_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_is_follwing_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->user_followers_model->fetch_is_follwing_v1($search_ids, $user_id);
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
        $input_params["fetch_is_follwing_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * fetch_follower_count_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_follower_count_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $this->block_result = $this->user_followers_model->fetch_follower_count_v1($search_ids);
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
        $input_params["fetch_follower_count_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * fetch_following_count_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function fetch_following_count_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $this->block_result = $this->user_followers_model->fetch_following_count_v1($search_ids);
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
        $input_params["fetch_following_count_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * get_post_count_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified  | 14.10.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_count_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $search_ids = isset($input_params["search_ids"]) ? $input_params["search_ids"] : "";
            $this->block_result = $this->post_model->get_post_count_v1($search_ids);
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
        $input_params["get_post_count_v1"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * final_friends_list method is used to process custom function.
     * @created CIT Dev Team
     * @modified  | 14.10.2019
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
     * condition_get_my_followers method is used to process conditions.
     * @created CIT Dev Team
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_get_my_followers($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_my_followers"]) ? 0 : 1);
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
     * user_followers_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "user_followers_finish_success",
        );
        $output_fields = array(
            'uf_user_follower_id',
            'uf_status',
            'u_name',
            'u_email',
            'u_profile_image',
            'follower_count',
            'following_count',
            'post_count',
            'u_users_id',
            'is_following',
            'pending_request_id',
            'custom_field_7',
        );
        $output_keys = array(
            'get_my_followers',
        );
        $ouput_aliases = array(
            "custom_field_7" => "is_movement_join",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_followers";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_followers_finish_success_1 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_followers_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_followers_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_followers";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
