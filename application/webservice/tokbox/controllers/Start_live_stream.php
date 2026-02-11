<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Start Live Stream Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Start Live Stream
 *
 * @class Start_live_stream.php
 *
 * @path application\webservice\tokbox\controllers\Start_live_stream.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Start_live_stream extends Cit_Controller
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
            "insert_live_session_post",
            "insert_tokbox_session",
            "func_merge_arr",
        );
        $this->multiple_keys = array(
            "func_create_tokbox_session",
            "exist_generate_token",
            "exist_send_push_noitify",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('start_live_stream_model');
        $this->load->model("post/post_model");
        $this->load->model("tokbox/tokbox_session_model");
    }

    /**
     * rules_start_live_stream method is used to validate api input params.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_start_live_stream($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "start_live_stream");

        return $valid_res;
    }

    /**
     * start_start_live_stream method is used to initiate api execution flow.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_start_live_stream($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_start_live_stream($request_arr);
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

            $input_params = $this->func_create_tokbox_session($input_params);

            $condition_res = $this->cond_check_tokbox_session($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->insert_live_session_post($input_params);

                $input_params = $this->insert_tokbox_session($input_params);

                $input_params = $this->exist_generate_token($input_params);

                $input_params = $this->exist_send_push_noitify($input_params);

                $input_params = $this->func_merge_arr($input_params);

                $output_response = $this->post_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->post_finish_success_1($input_params);
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
     * func_create_tokbox_session method is used to process custom function.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_create_tokbox_session($input_params = array())
    {
        if (!method_exists($this, "create_tokbox_session"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->create_tokbox_session($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_create_tokbox_session"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * cond_check_tokbox_session method is used to process conditions.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_tokbox_session($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["session_id"];

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
     * insert_live_session_post method is used to process query block.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 10.06.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_live_session_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($_FILES["video_thumbnail"]["name"]) && isset($_FILES["video_thumbnail"]["tmp_name"]))
            {
                $sent_file = $_FILES["video_thumbnail"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["video_thumbnail"]["ext"] = "jpg,jpeg,png,gif";
                $images_arr["video_thumbnail"]["size"] = "10240";
                if ($this->general->validateFileFormat($images_arr["video_thumbnail"]["ext"], $_FILES["video_thumbnail"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["video_thumbnail"]["size"], $_FILES["video_thumbnail"]["size"]))
                    {
                        $images_arr["video_thumbnail"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_eposttype"] = "LiveNow";
            if (isset($input_params["post_text"]))
            {
                $params_arr["post_text"] = $input_params["post_text"];
            }
            $params_arr["_evisibility"] = "Public";
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            if (isset($images_arr["video_thumbnail"]["name"]))
            {
                $params_arr["video_thumbnail"] = $images_arr["video_thumbnail"]["name"];
            }
            $this->block_result = $this->post_model->insert_live_session_post($params_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("Insertion failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["video_thumbnail"]["name"]))
            {

                $dest_path = "thumbnail";
                $folder_name = $this->general->getImageNestedFolders($dest_path);
                $file_path = $upload_path.$folder_name.DS;
                $this->general->createUploadFolderIfNotExists($folder_name);
                $file_name = $images_arr["video_thumbnail"]["name"];
                $file_tmp_path = $_FILES["video_thumbnail"]["tmp_name"];
                $file_tmp_size = $_FILES["video_thumbnail"]["size"];
                $valid_extensions = $images_arr["video_thumbnail"]["ext"];
                $valid_max_size = $images_arr["video_thumbnail"]["size"];
                $upload_arr = $this->general->file_upload($file_path, $file_tmp_path, $file_name, $valid_extensions, $file_tmp_size, $valid_max_size);
                if ($upload_arr[0] == "")
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
        $input_params["insert_live_session_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * insert_tokbox_session method is used to process query block.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_tokbox_session($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["session_id"]))
            {
                $params_arr["session_id"] = $input_params["session_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_dtstartdatetime"] = "NOW()";
            $params_arr["_estatus"] = "Inprogress";
            $this->block_result = $this->tokbox_session_model->insert_tokbox_session($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_tokbox_session"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * exist_generate_token method is used to process custom function.
     * Token generation for created user
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function exist_generate_token($input_params = array())
    {

        $this->load->module("tokbox/join_live_stream");
        $api_params = array();
        if (array_key_exists("user_id", $input_params))
        {
            $api_params["user_id"] = $input_params["user_id"];
        }
        if (array_key_exists("tokbox_session_inserted_id", $input_params))
        {
            $api_params["tokbox_session_id"] = $input_params["tokbox_session_inserted_id"];
        }
        $maping_arr = array();
        $result_arr = $this->join_live_stream->start_join_live_stream($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["exist_generate_token_success"] = $result_arr["success"];
            $input_params["exist_generate_token_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["exist_generate_token_success"] = $result_arr["settings"]["success"];
            $input_params["exist_generate_token_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["exist_generate_token"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * exist_send_push_noitify method is used to process custom function.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function exist_send_push_noitify($input_params = array())
    {

        $this->load->module("post/send_post_notification");
        $api_params = array();
        if (array_key_exists("user_id", $input_params))
        {
            $api_params["user_id"] = $input_params["user_id"];
        }
        if (array_key_exists("post_id", $input_params))
        {
            $api_params["post_id"] = $input_params["post_id"];
        }
        if (array_key_exists("tokbox_session_inserted_id", $input_params))
        {
            $api_params["tokbox_session_id"] = $input_params["tokbox_session_inserted_id"];
        }
        if (array_key_exists("notification_type", $input_params))
        {
            $api_params["type"] = $input_params["notification_type"];
        }
        $maping_arr = array();
        $result_arr = $this->send_post_notification->start_send_post_notification($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["exist_send_push_noitify_success"] = $result_arr["success"];
            $input_params["exist_send_push_noitify_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["exist_send_push_noitify_success"] = $result_arr["settings"]["success"];
            $input_params["exist_send_push_noitify_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["exist_send_push_noitify"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * func_merge_arr method is used to process custom function.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 03.04.2020
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
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 03.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success",
        );
        $output_fields = array(
            'post_id',
            'final_tokbox_session_id',
            'final_tokbox_token',
            'final_tokbox_session_inserted_id',
            'final_post_id',
        );
        $output_keys = array(
            'insert_live_session_post',
            'func_merge_arr',
        );
        $ouput_aliases = array(
            "final_tokbox_session_id" => "tokbox_session_id",
            "final_tokbox_token" => "tokbox_token",
            "final_tokbox_session_inserted_id" => "tokbox_session_inserted_id",
            "final_post_id" => "post_id",
        );
        $output_objects = array(
            "insert_live_session_post",
            "func_merge_arr",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "start_live_stream";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["output_objects"] = $output_objects;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "start_live_stream";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
