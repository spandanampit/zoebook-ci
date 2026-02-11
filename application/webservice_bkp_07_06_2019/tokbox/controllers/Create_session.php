<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Create Session Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Create Session
 *
 * @class Create_session.php
 *
 * @path application\webservice\tokbox\controllers\Create_session.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.09.2018
 */

class Create_session extends Cit_Controller
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
            "insert_live_sessions",
        );
        $this->multiple_keys = array(
            "func_create_tokbox_session",
            "func_send_notification",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('create_session_model');
        $this->load->model("post/post_model");
    }

    /**
     * rules_create_session method is used to validate api input params.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_create_session($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "create_session");

        return $valid_res;
    }

    /**
     * start_create_session method is used to initiate api execution flow.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_create_session($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_create_session($request_arr);
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

            $input_params = $this->func_create_tokbox_session($input_params);

            $condition_res = $this->cond_check_tokbox_session($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->insert_live_sessions($input_params);

                $input_params = $this->func_send_notification($input_params);

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
     * @modified Vamsi Ippe | 25.09.2018
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
     * insert_live_sessions method is used to process query block.
     * @created Vamsi Ippe | 24.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_live_sessions($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_eposttype"] = "Live";
            if (isset($input_params["session_id"]))
            {
                $params_arr["session_id"] = $input_params["session_id"];
            }
            $params_arr["_evisibility"] = "Public";
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            $this->block_result = $this->post_model->insert_live_sessions($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_live_sessions"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * func_send_notification method is used to process custom function.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_send_notification($input_params = array())
    {

        $this->load->module("post/send_post_notification");
        $api_params = array();
        if (array_key_exists("user_id", $input_params))
        {
            $api_params["user_id"] = $input_params["user_id"];
        }
        if (array_key_exists("insert_id", $input_params))
        {
            $api_params["post_id"] = $input_params["insert_id"];
        }
        $maping_arr = array();
        $result_arr = $this->send_post_notification->start_send_post_notification($api_params, TRUE);
        $result_keys = is_array($result_arr) ? array_keys($result_arr) : array();
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
        $input_params["func_send_notification"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
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
            'session_id',
            'insert_id',
            'check_user_followers',
            'ins_follwer_notification',
            'device_token',
            'follower_users_id',
            'notification_id',
            'custom_function_success',
            'custom_function_message',
        );
        $output_keys = array(
            'insert_live_sessions',
            'func_send_notification',
        );
        $ouput_aliases = array(
            "insert_id" => "post_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "create_session";
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

        $func_array["function"]["name"] = "create_session";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
