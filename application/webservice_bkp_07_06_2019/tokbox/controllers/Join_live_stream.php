<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Join Live Stream Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Join Live Stream
 *
 * @class Join_live_stream.php
 *
 * @path application\webservice\tokbox\controllers\Join_live_stream.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.10.2018
 */

class Join_live_stream extends Cit_Controller
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
            "check_stream_exist",
            "check_user_already_joined",
            "insert_session_subscriber",
        );
        $this->multiple_keys = array(
            "func_generate_token",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('join_live_stream_model');
        $this->load->model("tokbox/tokbox_session_model");
        $this->load->model("tokbox/tokbox_session_subscriber_model");
    }

    /**
     * rules_join_live_stream method is used to validate api input params.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_join_live_stream($request_arr = array())
    {
        $valid_arr = array(
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            ),
            "tokbox_session_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "tokbox_session_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "join_live_stream");

        return $valid_res;
    }

    /**
     * start_join_live_stream method is used to initiate api execution flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_join_live_stream($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_join_live_stream($request_arr);
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

            $input_params = $this->check_stream_exist($input_params);

            $condition_res = $this->cond_check_stream_exists($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_check_ended($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->check_user_already_joined($input_params);

                    $condition_res = $this->cond_already_joined($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->func_generate_token($input_params);

                        $condition_res = $this->condition($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->insert_session_subscriber($input_params);

                            $output_response = $this->finish_success($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $output_response = $this->finish_success_1($input_params);
                            return $output_response;
                        }
                    }

                    else
                    {

                        $output_response = $this->tokbox_session_finish_success_2($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->tokbox_session_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->tokbox_session_finish_success($input_params);
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
     * check_stream_exist method is used to process query block.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_stream_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $tokbox_session_id = isset($input_params["tokbox_session_id"]) ? $input_params["tokbox_session_id"] : "";
            $this->block_result = $this->tokbox_session_model->check_stream_exist($tokbox_session_id);
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
        $input_params["check_stream_exist"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_stream_exists method is used to process conditions.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_stream_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_stream_exist"]) ? 0 : 1);
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
     * condition_check_ended method is used to process conditions.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_check_ended($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["ts_status"];
            $cc_ro_0 = "Ended";

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
     * check_user_already_joined method is used to process query block.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_user_already_joined($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $ts_tokbox_session_id = isset($input_params["ts_tokbox_session_id"]) ? $input_params["ts_tokbox_session_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->tokbox_session_subscriber_model->check_user_already_joined($ts_tokbox_session_id, $user_id);
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
        $input_params["check_user_already_joined"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_already_joined method is used to process conditions.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_already_joined($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_user_already_joined"]) ? 0 : 1);
            $cc_ro_0 = 0;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
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
     * func_generate_token method is used to process custom function.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_generate_token($input_params = array())
    {
        if (!method_exists($this, "generate_tokbox_token"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->generate_tokbox_token($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_generate_token"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["tokbox_token"];

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
     * insert_session_subscriber method is used to process query block.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_session_subscriber($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["ts_tokbox_session_id"]))
            {
                $params_arr["ts_tokbox_session_id"] = $input_params["ts_tokbox_session_id"];
            }
            if (isset($input_params["ts_post_id"]))
            {
                $params_arr["ts_post_id"] = $input_params["ts_post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_dtjoindatetime"] = "NOW()";
            $params_arr["_estatus"] = "Inprogress";
            if (isset($input_params["tokbox_token"]))
            {
                $params_arr["tokbox_token"] = $input_params["tokbox_token"];
            }
            $this->block_result = $this->tokbox_session_subscriber_model->insert_session_subscriber($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_session_subscriber"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "finish_success",
        );
        $output_fields = array(
            'tokbox_token',
            'tokbox_server_session_id',
        );
        $output_keys = array(
            'func_generate_token',
        );
        $ouput_aliases = array(
            "func_generate_token" => "generate_token",
            "tokbox_server_session_id" => "tokbox_session_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_live_stream";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_live_stream";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "tokbox_session_finish_success_2",
        );
        $output_fields = array(
            'tss_token',
            'ts_session_id',
        );
        $output_keys = array(
            'check_user_already_joined',
        );
        $ouput_aliases = array(
            "check_user_already_joined" => "generate_token",
            "tss_token" => "tokbox_token",
            "ts_session_id" => "tokbox_session_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_live_stream";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 08.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "2",
            "message" => "tokbox_session_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_live_stream";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "tokbox_session_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_live_stream";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
