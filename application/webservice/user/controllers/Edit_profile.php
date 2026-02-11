<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Edit Profile Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Edit Profile
 *
 * @class Edit_profile.php
 *
 * @path application\webservice\user\controllers\Edit_profile.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 01.11.2022
 */

class Edit_profile extends Cit_Controller
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
            "check_email_dup",
            "update_user_details",
            "get_profile_details",
            "update_user_detail",
            "get_profile_data",
        );
        $this->multiple_keys = array(
            "custom_file_height_width",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('edit_profile_model');
        $this->load->model("user/users_model");
    }

    /**
     * rules_edit_profile method is used to validate api input params.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 01.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_edit_profile($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "edit_profile");

        return $valid_res;
    }

    /**
     * start_edit_profile method is used to initiate api execution flow.
     * @created Bhagya Rachana | 10.09.2018
     * @modified Jay Rajput | 01.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_edit_profile($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_edit_profile($request_arr);
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

            $input_params = $this->custom_file_height_width($input_params);

            $condition_res = $this->email_is_not_empty($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->check_email_dup($input_params);

                $condition_res = $this->email_dup($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->users_email_dup_success($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->update_user_details($input_params);

                    $input_params = $this->get_profile_details($input_params);

                    $output_response = $this->update_success($input_params);
                    return $output_response;
                }
            }

            else
            {

                $input_params = $this->update_user_detail($input_params);

                $input_params = $this->get_profile_data($input_params);

                $output_response = $this->updated_success($input_params);
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
     * custom_file_height_width method is used to process custom function.
     * @created Rohit Patidar | 03.06.2021
     * @modified Jay Rajput | 01.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_file_height_width($input_params = array())
    {
        if (!method_exists($this->general, "getCvFileHieght"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->getCvFileHieght($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_file_height_width"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * email_is_not_empty method is used to process conditions.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 03.06.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function email_is_not_empty($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_email"];

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
     * check_email_dup method is used to process query block.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_email_dup($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_email = isset($input_params["user_email"]) ? $input_params["user_email"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->check_email_dup($user_email, $user_id);
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
        $input_params["check_email_dup"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * email_dup method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function email_dup($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_email_dup"]) ? 0 : 1);
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
     * users_email_dup_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Bhargav Narkedamilli | 26.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_email_dup_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_email_dup_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_profile";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * update_user_details method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 01.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($_FILES["profile_image"]["name"]) && isset($_FILES["profile_image"]["tmp_name"]))
            {
                $sent_file = $_FILES["profile_image"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["profile_image"]["ext"] = implode(',', $this->config->item('IMAGE_EXTENSION_ARR'));
                $images_arr["profile_image"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["profile_image"]["ext"], $_FILES["profile_image"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["profile_image"]["size"], $_FILES["profile_image"]["size"]))
                    {
                        $images_arr["profile_image"]["name"] = $file_name;
                    }
                }
            }
            if (isset($_FILES["cover_photo"]["name"]) && isset($_FILES["cover_photo"]["tmp_name"]))
            {
                $sent_file = $_FILES["cover_photo"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["cover_photo"]["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                $images_arr["cover_photo"]["size"] = "204800";
                if ($this->general->validateFileFormat($images_arr["cover_photo"]["ext"], $_FILES["cover_photo"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["cover_photo"]["size"], $_FILES["cover_photo"]["size"]))
                    {
                        $images_arr["cover_photo"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["user_name"]))
            {
                $params_arr["user_name"] = $input_params["user_name"];
            }
            if (isset($input_params["user_email"]))
            {
                $params_arr["user_email"] = $input_params["user_email"];
            }
            if (isset($input_params["user_phone"]))
            {
                $params_arr["user_phone"] = $input_params["user_phone"];
            }
            if (isset($images_arr["profile_image"]["name"]))
            {
                $params_arr["profile_image"] = $images_arr["profile_image"]["name"];
            }
            if (isset($input_params["about_me"]))
            {
                $params_arr["about_me"] = $input_params["about_me"];
            }
            $params_arr["_dtmodifieddate"] = "NOW()";
            if (isset($images_arr["cover_photo"]["name"]))
            {
                $params_arr["cover_photo"] = $images_arr["cover_photo"]["name"];
            }
            if (isset($input_params["height"]))
            {
                $params_arr["height"] = $input_params["height"];
            }
            if (isset($input_params["width"]))
            {
                $params_arr["width"] = $input_params["width"];
            }
            $params_arr["_vcovervideo"] = '{%REQUEST.covervideo_thumbnail%}';
            if (method_exists($this, "extractImagefromVideo"))
            {
                $params_arr["_vcovervideo"] = $this->extractImagefromVideo($params_arr["_vcovervideo"], $input_params);
            }
            $this->block_result = $this->users_model->update_user_details($params_arr, $where_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("updation failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["profile_image"]["name"]))
            {

                $file_path = "compress_profile_image";
                $file_name = $images_arr["profile_image"]["name"];
                $file_tmp_path = $_FILES["profile_image"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
            if (!empty($images_arr["cover_photo"]["name"]))
            {

                $file_path = "cover_photo";
                $file_name = $images_arr["cover_photo"]["name"];
                $file_tmp_path = $_FILES["cover_photo"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_profile_details method is used to process query block.
     * @created Vamsi Ippe | 11.01.2019
     * @modified Jay Rajput | 31.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_profile_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_profile_details($user_id);
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
                    $image_arr["width"] = "350";
                    $image_arr["height"] = "350";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $data = $data_arr["u_cover_photo"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "cover_photo";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_photo"] = $data;

                    $data = $data_arr["u_cover_video_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "covervideo_thumbnail";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_video_1"] = $data;

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
        $input_params["get_profile_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 03.08.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function update_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "update_success",
        );
        $output_fields = array(
            'u_users_id_1',
            'u_profile_image',
            'u_cover_video_1',
        );
        $output_keys = array(
            'get_profile_details',
        );
        $ouput_aliases = array(
            "get_profile_details" => "get_profile_data",
            "u_users_id_1" => "user_id",
            "u_profile_image" => "profile_image",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_profile";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * update_user_detail method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 01.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_detail($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($_FILES["profile_image"]["name"]) && isset($_FILES["profile_image"]["tmp_name"]))
            {
                $sent_file = $_FILES["profile_image"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["profile_image"]["ext"] = implode(',', $this->config->item('IMAGE_EXTENSION_ARR'));
                $images_arr["profile_image"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["profile_image"]["ext"], $_FILES["profile_image"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["profile_image"]["size"], $_FILES["profile_image"]["size"]))
                    {
                        $images_arr["profile_image"]["name"] = $file_name;
                    }
                }
            }
            if (isset($_FILES["cover_photo"]["name"]) && isset($_FILES["cover_photo"]["tmp_name"]))
            {
                $sent_file = $_FILES["cover_photo"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["cover_photo"]["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                $images_arr["cover_photo"]["size"] = "204800";
                if ($this->general->validateFileFormat($images_arr["cover_photo"]["ext"], $_FILES["cover_photo"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["cover_photo"]["size"], $_FILES["cover_photo"]["size"]))
                    {
                        $images_arr["cover_photo"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["user_name"]))
            {
                $params_arr["user_name"] = $input_params["user_name"];
            }
            if (isset($input_params["user_phone"]))
            {
                $params_arr["user_phone"] = $input_params["user_phone"];
            }
            if (isset($images_arr["profile_image"]["name"]))
            {
                $params_arr["profile_image"] = $images_arr["profile_image"]["name"];
            }
            if (isset($input_params["about_me"]))
            {
                $params_arr["about_me"] = $input_params["about_me"];
            }
            $params_arr["_dtmodifieddate"] = "NOW()";
            if (isset($images_arr["cover_photo"]["name"]))
            {
                $params_arr["cover_photo"] = $images_arr["cover_photo"]["name"];
            }
            if (isset($input_params["height"]))
            {
                $params_arr["height"] = $input_params["height"];
            }
            if (isset($input_params["width"]))
            {
                $params_arr["width"] = $input_params["width"];
            }
            $params_arr["_vcovervideo"] = '{%REQUEST.cover_video%}';
            if (method_exists($this, "extractImagefromVideo"))
            {
                $params_arr["_vcovervideo"] = $this->extractImagefromVideo($params_arr["_vcovervideo"], $input_params);
            }
            $this->block_result = $this->users_model->update_user_detail($params_arr, $where_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("updation failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["profile_image"]["name"]))
            {

                $file_path = "compress_profile_image";
                $file_name = $images_arr["profile_image"]["name"];
                $file_tmp_path = $_FILES["profile_image"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
            if (!empty($images_arr["cover_photo"]["name"]))
            {

                $file_path = "cover_photo";
                $file_name = $images_arr["cover_photo"]["name"];
                $file_tmp_path = $_FILES["cover_photo"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_detail"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_profile_data method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 31.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_profile_data($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_profile_data($user_id);
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

                    $data = $data_arr["u_profile_image_1"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["width"] = "350";
                    $image_arr["height"] = "350";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image_1"] = $data;

                    $data = $data_arr["u_cover_video"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "covervideo_thumbnail";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_video"] = $data;

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
        $input_params["get_profile_data"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * updated_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 03.08.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function updated_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "updated_success",
        );
        $output_fields = array(
            'u_users_id_1_1',
            'u_profile_image_1',
            'u_cover_video',
        );
        $output_keys = array(
            'get_profile_data',
        );
        $ouput_aliases = array(
            "u_users_id_1_1" => "user_id",
            "u_profile_image_1" => "u_profile_image",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_profile";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
