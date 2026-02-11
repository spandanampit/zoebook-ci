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
 * @since 10.01.2019
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
     * @modified Vamsi Ippe | 10.01.2019
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
     * @modified Vamsi Ippe | 10.01.2019
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
            $output_array = $func_array = array();

            $input_params = $this->get_media_posts($input_params);

            $input_params = $this->start_loop($input_params);

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
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
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
     * start_loop method is used to process loop flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop($input_params = array())
    {
        $this->iterate_start_loop($input_params["get_media_posts"], $input_params);
        return $input_params;
    }

    /**
     * get_media_post_media method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_media_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $p_post_id = isset($input_params["p_post_id"]) ? $input_params["p_post_id"] : "";
            $this->block_result = $this->post_media_model->get_media_post_media($p_post_id);
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
                    $image_arr["path"] = "post_media";
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
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["path"] = "post_media";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["pm_video_thumbnail"] = $data;

                    $data = $data_arr["display_image"];
                    if (method_exists($this, "get_display_image"))
                    {
                        $data = $this->get_display_image($data, $result_arr[$data_key], $i, $input_params);
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
        $input_params["get_media_post_media"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

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
     * @modified  | 26.09.2018
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
            'get_media_post_media',
            'pm_post_id',
            'pm_post_media_id',
            'pm_media_type',
            'pm_user_id',
            'pm_upload_file',
            'pm_added_date',
            'pm_video_thumbnail',
            'display_image',
        );
        $output_keys = array(
            'get_media_posts',
        );
        $ouput_aliases = array(
            "p_post_id" => "post_id",
            "p_user_id" => "posted_user_id",
            "p_post_type" => "post_type",
            "p_status" => "status",
        );
        $output_objects = array(
            "get_media_post_media",
        );
        $inner_keys = array(
            'get_media_post_media',
        );

        $output_array["settings"] = array_merge($this->settings_params, $setting_fields);
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_albums";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["inner_keys"] = $inner_keys;
        $func_array["function"]["output_objects"] = $output_objects;
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
     * iterate_start_loop method is used to iterate loop.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $get_media_posts_lp_arr get_media_posts_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop(&$get_media_posts_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $get_media_posts_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $get_media_posts_lp_pms = $input_params_loc;

            unset($get_media_posts_lp_pms["get_media_posts"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $get_media_posts_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $get_media_posts_lp_pms["get_media_posts"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["get_media_posts"] = $get_media_posts_lp_pms["get_media_posts"];
            }

            $get_media_posts_lp_pms["i"] = $i;
            $input_params = $get_media_posts_lp_pms;

            $input_params = $this->get_media_post_media($input_params);

            $get_media_posts_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $get_media_posts_lp_pms);
        }
    }
}
