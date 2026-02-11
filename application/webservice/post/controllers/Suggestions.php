<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Suggestions Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Suggestions
 *
 * @class Suggestions.php
 *
 * @path application\webservice\post\controllers\Suggestions.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 09.11.2022
 */

class Suggestions extends Cit_Controller
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
            "get_user_suggestions",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('suggestions_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_suggestions method is used to validate api input params.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Jay Rajput | 09.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_suggestions($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "suggestions");

        return $valid_res;
    }

    /**
     * start_suggestions method is used to initiate api execution flow.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Jay Rajput | 09.11.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_suggestions($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_suggestions($request_arr);
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

            $input_params = $this->get_user_suggestions($input_params);

            $condition_res = $this->condition_for_suggestion($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->start_loop_user_media($input_params);

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
     * get_user_suggestions method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_user_suggestions($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_model->get_user_suggestions($user_id);
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

                    $data = $data_arr["p_added_date"];
                    if (method_exists($this->general, "dateTimeSystemFormat"))
                    {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["p_added_date"] = $data;

                    $data = $data_arr["user_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["width"] = "100";
                    $image_arr["height"] = "100";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["user_profile_image"] = $data;

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
        $input_params["get_user_suggestions"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_suggestion method is used to process conditions.
     * @created CIT Dev Team
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_suggestion($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_user_suggestions"]) ? 0 : 1);
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
     * start_loop_user_media method is used to process loop flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop_user_media($input_params = array())
    {
        $this->iterate_start_loop_user_media($input_params["get_user_suggestions"], $input_params);
        return $input_params;
    }

    /**
     * get_suggestions_media method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 09.11.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_suggestions_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $p_post_id = isset($input_params["p_post_id"]) ? $input_params["p_post_id"] : "";
            $this->block_result = $this->post_media_model->get_suggestions_media($p_post_id);
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
                    $image_arr["width"] = "500";
                    $image_arr["height"] = "300";
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_upload_file"] = $data;

                    $data = $data_arr["pm_video_thumbnail"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["width"] = "400";
                    $image_arr["height"] = "400";
                    $p_key = ($data_arr["pm_user_id"] != "") ? $data_arr["pm_user_id"] : $input_params["pm_user_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_post_video";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_video_thumbnail"] = $data;

                    $data = $data_arr["display_image"];
                    if (method_exists($this, "get_display_image_others"))
                    {
                        $data = $this->get_display_image_others($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["display_image"] = $data;

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
        $input_params["get_suggestions_media"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * func_merge_arr method is used to process custom function.
     * @created Vamsi Ippe | 07.04.2020
     * @modified Ashok Pidugu | 26.05.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_merge_arr($input_params = array())
    {
        if (!method_exists($this, "merge_arr"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->merge_arr($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_merge_arr"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Jay Rajput | 09.11.2022
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
            'p_post_id',
            'p_user_id',
            'p_post_type',
            'p_post_text',
            'p_added_date',
            'user_name',
            'user_profile_image',
            'p_status',
            'p_impression_count',
            'like_count',
            'final_display_image',
            'final_upload_file',
            'final_media_type',
            'final_views_count',
            'final_video_image',
            'get_suggestions_media',
            'pm_post_media_id',
            'pm_post_id',
            'pm_media_type',
            'pm_user_id',
            'pm_upload_file',
            'pm_video_thumbnail',
            'display_image',
            'pm_views_count',
        );
        $output_keys = array(
            'get_user_suggestions',
        );
        $ouput_aliases = array(
            "p_post_id" => "post_id",
            "p_user_id" => "user_id",
            "p_post_type" => "post_type",
            "p_post_text" => "post_text",
            "p_added_date" => "added_date",
            "p_status" => "status",
            "p_impression_count" => "impression_count",
        );
        $inner_keys = array(
            'get_suggestions_media',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "suggestions";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["inner_keys"] = $inner_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified ---
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

        $func_array["function"]["name"] = "suggestions";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * iterate_start_loop_user_media method is used to iterate loop.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.04.2020
     * @param array $get_user_suggestions_lp_arr get_user_suggestions_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop_user_media(&$get_user_suggestions_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $get_user_suggestions_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $get_user_suggestions_lp_pms = $input_params_loc;

            unset($get_user_suggestions_lp_pms["get_user_suggestions"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $get_user_suggestions_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $get_user_suggestions_lp_pms["get_user_suggestions"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["get_user_suggestions"] = $get_user_suggestions_lp_pms["get_user_suggestions"];
            }

            $get_user_suggestions_lp_pms["i"] = $i;
            $input_params = $get_user_suggestions_lp_pms;

            $input_params = $this->get_suggestions_media($input_params);

            $input_params = $this->func_merge_arr($input_params);

            $get_user_suggestions_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $get_user_suggestions_lp_pms);
        }
    }
}
