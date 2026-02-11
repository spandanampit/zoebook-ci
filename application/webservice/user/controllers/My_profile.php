<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of My Profile Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module My Profile
 *
 * @class My_profile.php
 *
 * @path application\webservice\user\controllers\My_profile.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.11.2022
 */

class My_profile extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
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
            "get_my_profile",
            "get_user_profile",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('my_profile_model');
        $this->load->model("user/users_model");
    }

    /**
     * rules_my_profile method is used to validate api input params.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 01.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_my_profile($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "my_profile");

        return $valid_res;
    }

    /**
     * start_my_profile method is used to initiate api execution flow.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 01.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_my_profile($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_my_profile($request_arr);
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

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->get_my_profile($input_params);

                $condition_res = $this->condition_2($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->users_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->users_finish_success($input_params);
                    return $output_response;
                }
            }

            else
            {

                $input_params = $this->get_user_profile($input_params);

                $condition_res = $this->condition_1($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->user_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->user_failure($input_params);
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
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["profile_user_id"];

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
     * get_my_profile method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 01.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_my_profile($input_params = array())
    {

        $this->block_result = array();
        try
        {
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_my_profile($user_id);
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

                    $data = $data_arr["u_my_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_my_profile_image"] = $data;

                    $data = $data_arr["u_cover_photo"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "cover_photo";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_photo"] = $data;

                    $data = $data_arr["u_my_profile_image_firebase"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["width"] = "100";
                    $image_arr["height"] = "100";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_my_profile_image_firebase"] = $data;

                    $data = $data_arr["coverphoto_type"];
                    if (method_exists($this->general, "getTypefromextention"))
                    {
                        $data = $this->general->getTypefromextention($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["coverphoto_type"] = $data;

                    $data = $data_arr["u_cover_video"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "covervideo_thumbnail";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_video"] = $data;

                    $data = $data_arr["is_block_1"];
                    if (method_exists($this, "getUserBlock"))
                    {
                        $data = $this->getUserBlock($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_block_1"] = $data;

                    $data = $data_arr["u_cv_height_2"];
                    if (method_exists($this, "getHeight"))
                    {
                        $data = $this->getHeight($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["u_cv_height_2"] = $data;

                    $data = $data_arr["u_cv_width_2"];
                    if (method_exists($this, "getWidth"))
                    {
                        $data = $this->getWidth($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["u_cv_width_2"] = $data;

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
        $input_params["get_my_profile"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_my_profile"]) ? 0 : 1);
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
     * users_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 03.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_success",
        );
        $output_fields = array(
            'u_my_id',
            'u_my_name',
            'u_my_profile_image',
            'my_follower_count',
            'my_following_count',
            'my_post_count',
            'u_my_email',
            'u_my_phone',
            'u_notification_pref',
            'u_privacy',
            'u_cover_photo',
            'u_my_profile_image_firebase',
            'coverphoto_type',
            'u_cover_video',
            'is_block_1',
            'u_cv_height_2',
            'u_cv_width_2',
        );
        $output_keys = array(
            'get_my_profile',
        );
        $ouput_aliases = array(
            "u_my_id" => "u_users_id",
            "u_my_name" => "u_name",
            "u_my_profile_image" => "u_profile_image",
            "my_follower_count" => "follower_count",
            "my_following_count" => "following_count",
            "my_post_count" => "post_count",
            "u_my_email" => "u_email",
            "u_my_phone" => "u_phone",
            "u_my_profile_image_firebase" => "u_profile_image_firebase",
            "u_cover_video" => "cover_videoimage",
            "is_block_1" => "is_block",
            "u_cv_height_2" => "u_cv_height",
            "u_cv_width_2" => "u_cv_width",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "my_profile";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "my_profile";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_user_profile method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 01.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_profile($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $profile_user_id = isset($input_params["profile_user_id"]) ? $input_params["profile_user_id"] : "";
            $this->block_result = $this->users_model->get_user_profile($user_id, $profile_user_id);
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

                    $data = $data_arr["u_cover_photo_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "cover_photo";
                    $data = $this->general->get_image_aws($image_arr);
                    $result_arr[$data_key]["u_cover_photo_1"] = $data;

                    $data = $data_arr["is_follwing"];
                    if (method_exists($this, "checkUserFollowing"))
                    {
                        $data = $this->checkUserFollowing($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_follwing"] = $data;

                    $data = $data_arr["u_profile_image_firebase"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["width"] = "100";
                    $image_arr["height"] = "100";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_firebase"] = $data;

                    $data = $data_arr["coverphoto_type_1"];
                    if (method_exists($this->general, "getTypefromextention"))
                    {
                        $data = $this->general->getTypefromextention($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["coverphoto_type_1"] = $data;

                    $data = $data_arr["u_cover_video_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "covervideo_thumbnail";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_video_1"] = $data;

                    $data = $data_arr["is_block"];
                    if (method_exists($this, "getUserBlock"))
                    {
                        $data = $this->getUserBlock($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_block"] = $data;

                    $data = $data_arr["is_block_me"];
                    if (method_exists($this, "getUserBlockMe"))
                    {
                        $data = $this->getUserBlockMe($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["is_block_me"] = $data;

                    $data = $data_arr["u_cv_width_1"];
                    if (method_exists($this, "getWidthTo"))
                    {
                        $data = $this->getWidthTo($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["u_cv_width_1"] = $data;

                    $data = $data_arr["u_cv_height_1"];
                    if (method_exists($this, "getHeightTo"))
                    {
                        $data = $this->getHeightTo($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["u_cv_height_1"] = $data;

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
        $input_params["get_user_profile"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_user_profile"]) ? 0 : 1);
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
     * user_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 03.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "user_success",
        );
        $output_fields = array(
            'u_users_id',
            'u_name',
            'u_profile_image',
            'is_follwing',
            'follower_count',
            'following_count',
            'post_count',
            'u_email',
            'u_phone',
            'pending_request_id',
            'u_notification_pref_1',
            'u_privacy_1',
            'u_cover_photo_1',
            'u_profile_image_firebase',
            'coverphoto_type_1',
            'u_cover_video_1',
            'is_block',
            'is_block_me',
            'u_cv_width_1',
            'u_cv_height_1',
        );
        $output_keys = array(
            'get_user_profile',
        );
        $ouput_aliases = array(
            "u_notification_pref_1" => "u_notification_pref",
            "u_privacy_1" => "u_privacy",
            "u_cover_photo_1" => "u_cover_photo",
            "coverphoto_type_1" => "coverphoto_type",
            "u_cover_video_1" => "cover_videoimage",
            "u_cv_width_1" => "u_cv_width",
            "u_cv_height_1" => "u_cv_height",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "my_profile";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_failure method is used to process finish flow.
     * @created Vamsi Ippe | 11.09.2018
     * @modified Vamsi Ippe | 11.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "my_profile";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
