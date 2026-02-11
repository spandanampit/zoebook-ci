<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update media post height width Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Update media post height width
 *
 * @class Update_media_post_height_width.php
 *
 * @path application\webservice\post\controllers\Update_media_post_height_width.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Update_media_post_height_width extends Cit_Controller
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
            "get_post_media_record",
            "custom_function_file_height_width",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('update_media_post_height_width_model');
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_update_media_post_height_width method is used to validate api input params.
     * @created Rohit Patidar | 09.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_update_media_post_height_width($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "update_media_post_height_width");

        return $valid_res;
    }

    /**
     * start_update_media_post_height_width method is used to initiate api execution flow.
     * @created Rohit Patidar | 09.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_update_media_post_height_width($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_update_media_post_height_width($request_arr);
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

            $input_params = $this->get_post_media_record($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->custom_function_file_height_width($input_params);

                $output_response = $this->post_media_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->post_media_finish_success_1($input_params);
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
     * get_post_media_record method is used to process query block.
     * @created Rohit Patidar | 09.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_media_record($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->post_media_model->get_post_media_record();
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

                    $data = $data_arr["pm_upload_file"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_post_media";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file"] = $data;

                    $data = $data_arr["pm_video_thumbnail"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_post_media";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_video_thumbnail"] = $data;

                    $data = $data_arr["pm_upload_file_org"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_post_media";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file_org"] = $data;

                    $data = $data_arr["pm_video_thumbnail_org"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_post_media";
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
        $input_params["get_post_media_record"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 09.06.2021
     * @modified Rohit Patidar | 09.06.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_post_media_record"]) ? 0 : 1);
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
     * custom_function_file_height_width method is used to process custom function.
     * @created Rohit Patidar | 09.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function_file_height_width($input_params = array())
    {
        if (!method_exists($this->general, "getUpdateFileHieght"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->getUpdateFileHieght($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_function_file_height_width"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_media_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 09.06.2021
     * @modified Rohit Patidar | 10.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_media_finish_success",
        );
        $output_fields = array(
            'pm_post_media_id',
            'pm_media_type',
            'pm_user_id',
            'pm_upload_file',
            'pm_video_thumbnail',
            'pm_upload_file_org',
            'pm_video_thumbnail_org',
        );
        $output_keys = array(
            'get_post_media_record',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_media_post_height_width";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 09.06.2021
     * @modified Rohit Patidar | 09.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_media_post_height_width";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
