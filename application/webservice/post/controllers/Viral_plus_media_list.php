<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Viral Plus Media List Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Viral Plus Media List
 *
 * @class Viral_plus_media_list.php
 *
 * @path application\webservice\post\controllers\Viral_plus_media_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Viral_plus_media_list extends Cit_Controller
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
            "func_get_post_id",
            "get_viral_plus_media",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('viral_plus_media_list_model');
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_viral_plus_media_list method is used to validate api input params.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Jay Rajput | 10.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_viral_plus_media_list($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "viral_plus_media_list");

        return $valid_res;
    }

    /**
     * start_viral_plus_media_list method is used to initiate api execution flow.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Jay Rajput | 10.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_viral_plus_media_list($request_arr = array(), $inner_api = FALSE)
    {
        try {
            $validation_res = $this->rules_viral_plus_media_list($request_arr);
            if ($validation_res["success"] == "-5") {
                if ($inner_api === TRUE) {
                    return $validation_res;
                } else {
                    $this->wsresponse->sendValidationResponse($validation_res);
                }
            }
            $output_response = array();
            $input_params = $validation_res['input_params'];

            $input_params = $this->func_get_post_id($input_params);

            $condition_res = $this->cond_post_check($input_params);
            if ($condition_res["success"]) {

                $input_params = $this->get_viral_plus_media($input_params);

                $condition_res = $this->condition($input_params);
                if ($condition_res["success"]) {

                    $output_response = $this->post_media_finish_success_1($input_params);
                    return $output_response;
                } else {

                    $output_response = $this->post_media_finish_success($input_params);
                    return $output_response;
                }
            } else {

                $output_response = $this->post_media_finish_success_2($input_params);
                return $output_response;
            }
        } catch (Exception $e) {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * func_get_post_id method is used to process custom function.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Rohit Patidar | 27.04.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_get_post_id($input_params = array())
    {
        if (!method_exists($this, "get_viral_plus_post_id")) {
            $result_arr["data"] = array();
        } else {
            $result_arr["data"] = $this->get_viral_plus_post_id($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_get_post_id"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * cond_post_check method is used to process conditions.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Rohit Patidar | 27.04.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_post_check($input_params = array())
    {

        $this->block_result = array();
        try {

            $cc_lo_0 = $input_params["post_id_arr"];
            $cc_ro_0 = 0;

            $cc_fr_0 = (count($cc_lo_0) > $cc_ro_0) ? TRUE : FALSE;

            $cc_lo_1 = 1;
            $cc_ro_1 = 1;

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
            if (!($cc_fr_0 || $cc_fr_1)) {
                throw new Exception("Some conditions does not match.");
            }
            $success = 1;
            $message = "Conditions matched.";
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        return $this->block_result;
    }

    /**
     * get_viral_plus_media method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 10.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_viral_plus_media($input_params = array())
    {

        $this->block_result = array();
        try {

            $sql = isset($input_params["sql"]) ? $input_params["sql"] : "";
            $page_index = isset($input_params["page_index"]) ? $input_params["page_index"] : 1;

            $this->block_result = $this->post_media_model->get_viral_plus_media($sql, $page_index, $this->settings_params);
            if (!$this->block_result["success"]) {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if (is_array($result_arr) && count($result_arr) > 0) {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr) {
                    if ($data_arr['pm_post_source_type'] == 'aws') {
                        $data = $data_arr["pm_upload_file"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["color"] = "FFFFFF";
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_upload_file"] = $data;

                        $data = $data_arr["pm_added_date"];
                        if (method_exists($this->general, "getDateOnly")) {
                            $data = $this->general->getDateOnly($data, $result_arr[$data_key], $i, $input_params);
                        }
                        $result_arr[$data_key]["pm_added_date"] = $data;

                        $data = $data_arr["pm_video_thumbnail"];
                        $image_arr = array();
                        $image_arr["image_name"] = $data;
                        $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                        $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                        $image_arr["pk"] = $p_key;
                        $image_arr["color"] = "FFFFFF";
                        $image_arr["def_img"] = "Yes";
                        $image_arr["path"] = "compress_post_video";
                        $data = $this->general->get_image_aws($image_arr);

                        $result_arr[$data_key]["pm_video_thumbnail"] = $data;

                        $data = $data_arr["display_image"];
                        if (method_exists($this, "get_display_image")) {
                            $data = $this->get_display_image($data, $result_arr[$data_key], $i, $input_params);
                        }
                        $result_arr[$data_key]["display_image"] = $data;
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
        } catch (Exception $e) {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_viral_plus_media"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Vamsi Ippe | 07.04.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try {

            $cc_lo_0 = (empty($input_params["get_viral_plus_media"]) ? 0 : 1);
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0) {
                throw new Exception("Some conditions does not match.");
            }
            $success = 1;
            $message = "Conditions matched.";
        } catch (Exception $e) {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        return $this->block_result;
    }

    /**
     * post_media_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Vamsi Ippe | 07.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_media_finish_success_1",
        );
        $output_fields = array(
            'pm_post_id',
            'pm_post_media_id',
            'pm_media_type',
            'pm_user_id',
            'pm_upload_file',
            'pm_added_date',
            'pm_video_thumbnail',
            'display_image',
            'pm_views_count',
            'media_count',
        );
        $output_keys = array(
            'get_viral_plus_media',
        );
        $ouput_aliases = array(
            "pm_post_id" => "post_id",
            "pm_post_media_id" => "post_media_id",
            "pm_media_type" => "media_type",
            "pm_user_id" => "user_id",
            "pm_upload_file" => "upload_file",
            "pm_added_date" => "added_date",
            "pm_video_thumbnail" => "video_thumbnail",
            "pm_views_count" => "views_count",
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "viral_plus_media_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Vamsi Ippe | 07.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "viral_plus_media_list";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Vamsi Ippe | 07.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "viral_plus_media_list";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
