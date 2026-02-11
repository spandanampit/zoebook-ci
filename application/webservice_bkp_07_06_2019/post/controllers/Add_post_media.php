<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Add Post Media Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Add Post Media
 *
 * @class Add_post_media.php
 *
 * @path application\webservice\post\controllers\Add_post_media.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 17.01.2019
 */

class Add_post_media extends Cit_Controller
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
            "get_post",
            "insert_post_media",
            "update_post_status",
        );
        $this->multiple_keys = array(
            "send_push_notification",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('add_post_media_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_add_post_media method is used to validate api input params.
     * @created Vamsi Ippe | 19.09.2018
     * @modified  | 17.01.2019
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_add_post_media($request_arr = array())
    {
        $valid_arr = array(
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "upload_file" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "upload_file_required",
                )
            ),
            "file_type" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "file_type_required",
                )
            ),
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            ),
            "is_completed" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "is_completed_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "add_post_media");

        return $valid_res;
    }

    /**
     * start_add_post_media method is used to initiate api execution flow.
     * @created Vamsi Ippe | 19.09.2018
     * @modified  | 17.01.2019
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_add_post_media($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_add_post_media($request_arr);
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

            $input_params = $this->get_post($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->insert_post_media($input_params);

                $condition_res = $this->condition_ins_post_media($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->check_is_complete($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->update_post_status($input_params);

                        $condition_res = $this->condition_1($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->send_push_notification($input_params);

                            $output_response = $this->post_finish_success($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $output_response = $this->private_post_finish($input_params);
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

                    $output_response = $this->post_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->post_finish_success_2($input_params);
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
     * get_post method is used to process query block.
     * @created Vamsi Ippe | 19.09.2018
     * @modified  | 17.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_model->get_post($post_id, $user_id);
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
        $input_params["get_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 19.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_post"]) ? 0 : 1);
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
     * insert_post_media method is used to process query block.
     * @created Vamsi Ippe | 19.09.2018
     * @modified  | 17.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($_FILES["upload_file"]["name"]) && isset($_FILES["upload_file"]["tmp_name"]))
            {
                $sent_file = $_FILES["upload_file"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["upload_file"]["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp";
                $images_arr["upload_file"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["upload_file"]["ext"], $_FILES["upload_file"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["upload_file"]["size"], $_FILES["upload_file"]["size"]))
                    {
                        $images_arr["upload_file"]["name"] = $file_name;
                    }
                }
            }
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
                $images_arr["video_thumbnail"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["video_thumbnail"]["ext"], $_FILES["video_thumbnail"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["video_thumbnail"]["size"], $_FILES["video_thumbnail"]["size"]))
                    {
                        $images_arr["video_thumbnail"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($images_arr["upload_file"]["name"]))
            {
                $params_arr["upload_file"] = $images_arr["upload_file"]["name"];
            }
            if (isset($input_params["file_type"]))
            {
                $params_arr["file_type"] = $input_params["file_type"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            if (isset($images_arr["video_thumbnail"]["name"]))
            {
                $params_arr["video_thumbnail"] = $images_arr["video_thumbnail"]["name"];
            }
            $this->block_result = $this->post_media_model->insert_post_media($params_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("Insertion failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["upload_file"]["name"]))
            {

                $file_path = "post_media";
                $folder_id = trim($data_arr[0]["iUserId"]);
                $file_path = $file_path."/".$folder_id;
                $file_name = $images_arr["upload_file"]["name"];
                $file_tmp_path = $_FILES["upload_file"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
            if (!empty($images_arr["video_thumbnail"]["name"]))
            {

                $file_path = "post_media";
                $folder_id = trim($data_arr[0]["iUserId"]);
                $file_path = $file_path."/".$folder_id;
                $file_name = $images_arr["video_thumbnail"]["name"];
                $file_tmp_path = $_FILES["video_thumbnail"]["tmp_name"];
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
        $input_params["insert_post_media"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_ins_post_media method is used to process conditions.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 19.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_ins_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_post_media"]) ? 0 : 1);
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
     * check_is_complete method is used to process conditions.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_is_complete($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["is_completed"];
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
     * update_post_status method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["post_id"]))
            {
                $where_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_estatus"] = "Active";
            $this->block_result = $this->post_model->update_post_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created  | 17.01.2019
     * @modified  | 17.01.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["p_visibility"];
            $cc_ro_0 = "Public";

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
     * send_push_notification method is used to process custom function.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function send_push_notification($input_params = array())
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
        if (array_key_exists("p_post_type", $input_params))
        {
            $api_params["type"] = $input_params["p_post_type"];
        }
        $maping_arr = array();
        $result_arr = $this->send_post_notification->start_send_post_notification($api_params, TRUE);
        $result_keys = is_array($result_arr) ? array_keys($result_arr) : array();
        if ($result_arr["success"] == "-5")
        {
            $input_params["send_push_notification_success"] = $result_arr["success"];
            $input_params["send_push_notification_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["send_push_notification_success"] = $result_arr["settings"]["success"];
            $input_params["send_push_notification_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["send_push_notification"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 19.09.2018
     * @modified  | 17.01.2019
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
            'p_post_id',
            'p_user_id',
            'p_status',
            'p_post_type',
            'p_visibility',
            'insert_id',
            'check_user_followers',
            'ins_follwer_notification',
            'device_token',
            'follower_users_id',
            'notification_id',
            'send_push_notification_success',
            'send_push_notification_message',
        );
        $output_keys = array(
            'get_post',
            'insert_post_media',
            'send_push_notification',
        );
        $ouput_aliases = array(
            "insert_id" => "media_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * private_post_finish method is used to process finish flow.
     * @created  | 17.01.2019
     * @modified  | 17.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function private_post_finish($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "private_post_finish",
        );
        $output_fields = array(
            'p_post_id',
            'p_user_id',
            'p_status',
            'p_post_type',
            'p_visibility',
            'insert_id',
        );
        $output_keys = array(
            'get_post',
            'insert_post_media',
        );
        $ouput_aliases = array(
            "insert_id" => "media_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_3",
        );
        $output_fields = array(
            'p_post_id',
            'p_user_id',
            'p_status',
            'p_post_type',
            'insert_id',
        );
        $output_keys = array(
            'get_post',
            'insert_post_media',
        );
        $ouput_aliases = array(
            "insert_id" => "media_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 19.09.2018
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

        $func_array["function"]["name"] = "add_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 19.09.2018
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
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
