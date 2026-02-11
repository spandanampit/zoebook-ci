<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Add Post Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Add Post
 *
 * @class Add_post.php
 *
 * @path application\webservice\post\controllers\Add_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 22.08.2022
 */

class Add_post extends Cit_Controller
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
            "check_user",
            "insert_post",
            "getviralpostcount",
        );
        $this->multiple_keys = array(
            "exist_extract_meta_data",
            "send_push_notification",
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('add_post_model');
        $this->load->model("user/users_model");
        $this->load->model("post/post_model");
    }

    /**
     * rules_add_post method is used to validate api input params.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 22.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_add_post($request_arr = array())
    {
        $valid_arr = array(
            "movements_id" => array(
                array(
                    "rule" => "digits",
                    "value" => TRUE,
                    "message" => "movements_id_digits",
                )
            ),
            "post_text" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_text_required",
                )
            ),
            "post_type" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_type_required",
                )
            ),
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            ),
            "visibility" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "visibility_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "add_post");

        return $valid_res;
    }

    /**
     * start_add_post method is used to initiate api execution flow.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 22.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_add_post($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_add_post($request_arr);
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

            $input_params = $this->check_user($input_params);

            $condition_res = $this->condition_check_user($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->notequaltoviral($input_params);
                if ($condition_res["success"])
                {


                }

                else
                {

                    $input_params = $this->getviralpostcount($input_params);

                    $condition_res = $this->condition_1($input_params);
                    if ($condition_res["success"])
                    {


                    }

                    else
                    {

                        $output_response = $this->users_finish_success_1($input_params);
                        return $output_response;
                    }
                }

                $input_params = $this->insert_post($input_params);

                $condition_res = $this->condition_for_insert_post($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->check_post_type($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->users_finish_post_inprogress($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $input_params = $this->exist_extract_meta_data($input_params);

                        $condition_res = $this->check_public_post($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->send_push_notification($input_params);

                            $output_response = $this->users_finish_success_2($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $condition_res = $this->movement_post($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->custom_function($input_params);

                                $output_response = $this->users_finish_success_3($input_params);
                                return $output_response;
                            }

                            else
                            {

                                $output_response = $this->private_post_finish($input_params);
                                return $output_response;
                            }
                        }
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

                $output_response = $this->users_finish_success($input_params);
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
     * check_user method is used to process query block.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 22.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->check_user($user_id);
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
                    $image_arr["width"] = "50";
                    $image_arr["height"] = "50";
                    $image_arr["color"] = "FFFFFF";
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
        $input_params["check_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_check_user method is used to process conditions.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 19.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_check_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_user"]) ? 0 : 1);
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
     * notequaltoviral method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Jay Rajput | 12.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function notequaltoviral($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["visibility"];
            $cc_ro_0 = "Viral";

            $cc_fr_0 = ($cc_lo_0 != $cc_ro_0) ? TRUE : FALSE;
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
     * getviralpostcount method is used to process query block.
     * @created Alpesh Patel | 16.09.2021
     * @modified Alpesh Patel | 17.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function getviralpostcount($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $VIRAL_POST_LIMIT = $this->config->item("VIRAL_POST_LIMIT");
            $VIRAL_POST_TIME_LIMIT = $this->config->item("VIRAL_POST_TIME_LIMIT");
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_model->getviralpostcount($VIRAL_POST_LIMIT, $VIRAL_POST_TIME_LIMIT, $user_id);
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

                    $data = $data_arr["difference_time"];
                    if (method_exists($this->general, "getTimeInString"))
                    {
                        $data = $this->general->getTimeInString($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["difference_time"] = $data;

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
        $input_params["getviralpostcount"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Alpesh Patel | 16.09.2021
     * @modified Alpesh Patel | 17.09.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["count_post"];
            $cc_ro_0 = $input_params["max_limit"];

            $cc_fr_0 = ($cc_lo_0 < $cc_ro_0) ? TRUE : FALSE;
            if (!($cc_fr_0))
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
     * users_finish_success_1 method is used to process finish flow.
     * @created Alpesh Patel | 16.09.2021
     * @modified Alpesh Patel | 17.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "users_finish_success_1",
        );
        $output_fields = array(
            'count_post',
            'max_limit',
            'difference_time',
            'p_added_date',
        );
        $output_keys = array(
            'getviralpostcount',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * insert_post method is used to process query block.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["post_type"]))
            {
                $params_arr["post_type"] = $input_params["post_type"];
            }
            if (isset($input_params["post_text"]))
            {
                $params_arr["post_text"] = $input_params["post_text"];
            }
            if (isset($input_params["visibility"]))
            {
                $params_arr["visibility"] = $input_params["visibility"];
            }
            $params_arr["_edraft"] = "No";
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = '{%REQUEST.%}';
            if (method_exists($this, "get_post_status"))
            {
                $params_arr["_estatus"] = $this->get_post_status($params_arr["_estatus"], $input_params);
            }
            if (isset($input_params["post_text_emoji"]))
            {
                $params_arr["post_text_emoji"] = $input_params["post_text_emoji"];
            }
            if (method_exists($this, "getPostTextEmoji"))
            {
                $params_arr["post_text_emoji"] = $this->getPostTextEmoji($params_arr["post_text_emoji"], $input_params);
            }
            if (isset($input_params["movements_id"]))
            {
                $params_arr["movements_id"] = $input_params["movements_id"];
            }
            $this->block_result = $this->post_model->insert_post($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_insert_post method is used to process conditions.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Jay Rajput | 22.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_insert_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_post"]) ? 0 : 1);
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
     * check_post_type method is used to process conditions.
     * If post is media then we are sending notification after upload complete
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_post_type($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["post_type"];
            $cc_ro_0 = "Image";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;

            $cc_lo_1 = $input_params["post_type"];
            $cc_ro_1 = "Video";

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;

            $cc_lo_2 = $input_params["post_type"];
            $cc_ro_2 = "Media";

            $cc_fr_2 = ($cc_lo_2 == $cc_ro_2) ? TRUE : FALSE;
            if (!($cc_fr_0 || $cc_fr_1 || $cc_fr_2))
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
     * users_finish_post_inprogress method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Alpesh Patel | 27.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_post_inprogress($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_finish_post_inprogress",
        );
        $output_fields = array(
            'insert_id_12',
        );
        $output_keys = array(
            'insert_post',
        );
        $ouput_aliases = array(
            "insert_id_12" => "post_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * exist_extract_meta_data method is used to process custom function.
     * @created Vamsi Ippe | 24.04.2020
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function exist_extract_meta_data($input_params = array())
    {

        $this->load->module("post/extract_meta_data");
        $api_params = array();
        if (array_key_exists("post_text", $input_params))
        {
            $api_params["post_text"] = $input_params["post_text"];
        }
        if (array_key_exists("insert_id_12", $input_params))
        {
            $api_params["post_id"] = $input_params["insert_id_12"];
        }
        $maping_arr = array();
        $result_arr = $this->extract_meta_data->start_extract_meta_data($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["exist_extract_meta_data_success"] = $result_arr["success"];
            $input_params["exist_extract_meta_data_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["exist_extract_meta_data_success"] = $result_arr["settings"]["success"];
            $input_params["exist_extract_meta_data_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["exist_extract_meta_data"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * check_public_post method is used to process conditions.
     * @created Pavan  | 17.01.2019
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_public_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["visibility"];
            $cc_ro_0 = "Public";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;

            $cc_lo_1 = $input_params["visibility"];
            $cc_ro_1 = "Viral";

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
            if (!($cc_fr_0 || $cc_fr_1))
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
     * @modified Rohit Patidar | 26.10.2021
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
        if (array_key_exists("insert_id_12", $input_params))
        {
            $api_params["post_id"] = $input_params["insert_id_12"];
        }
        if (array_key_exists("post_type", $input_params))
        {
            $api_params["type"] = $input_params["post_type"];
        }
        $maping_arr = array();
        $result_arr = $this->send_post_notification->start_send_post_notification($api_params, TRUE);
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
     * users_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 22.10.2021
     * @modified Alpesh Patel | 27.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_finish_success_2",
        );
        $output_fields = array(
            'insert_id_12',
        );
        $output_keys = array(
            'insert_post',
        );
        $ouput_aliases = array(
            "insert_id_12" => "post_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_post method is used to process conditions.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function movement_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["visibility"];
            $cc_ro_0 = "Movement";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["movements_id"];

            $cc_fr_1 = (!is_null($cc_lo_1) && !empty($cc_lo_1) && trim($cc_lo_1) != "") ? TRUE : FALSE;
            if (!$cc_fr_1)
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
     * custom_function method is used to process custom function.
     * @created Rohit Patidar | 22.10.2021
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
    {

        $this->load->module("misc/send_movement_pushnotification");
        $api_params = array();
        if (array_key_exists("insert_id_12", $input_params))
        {
            $api_params["post_id"] = $input_params["insert_id_12"];
        }
        if (array_key_exists("movements_id", $input_params))
        {
            $api_params["movement_id"] = $input_params["movements_id"];
        }
        if (array_key_exists("user_id", $input_params))
        {
            $api_params["user_id"] = $input_params["user_id"];
        }
        $maping_arr = array();
        $result_arr = $this->send_movement_pushnotification->start_send_movement_pushnotification($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["custom_function_success"] = $result_arr["success"];
            $input_params["custom_function_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["custom_function_success"] = $result_arr["settings"]["success"];
            $input_params["custom_function_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["custom_function"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * users_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 22.10.2021
     * @modified Alpesh Patel | 27.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_finish_success_3",
        );
        $output_fields = array(
            'insert_id_12',
        );
        $output_keys = array(
            'insert_post',
        );
        $ouput_aliases = array(
            "insert_id_12" => "post_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post";
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
     * @created Pavan  | 17.01.2019
     * @modified Alpesh Patel | 27.10.2021
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
            'insert_id_12',
        );
        $output_keys = array(
            'insert_post',
        );
        $ouput_aliases = array(
            "insert_id_12" => "post_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post";
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

        $func_array["function"]["name"] = "add_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 19.09.2018
     * @modified Vamsi Ippe | 19.09.2018
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
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
