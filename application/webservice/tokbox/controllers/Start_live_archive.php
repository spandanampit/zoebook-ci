<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Start Live Archive Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Start Live Archive
 *
 * @class Start_live_archive.php
 *
 * @path application\webservice\tokbox\controllers\Start_live_archive.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Start_live_archive extends Cit_Controller
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
            "check_archive_stream_exist",
            "update_archive_status_started",
        );
        $this->multiple_keys = array(
            "func_start_archive",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('start_live_archive_model');
        $this->load->model("tokbox/tokbox_session_model");
    }

    /**
     * rules_start_live_archive method is used to validate api input params.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_start_live_archive($request_arr = array())
    {
        $valid_arr = array(
            "tokbox_session_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "tokbox_session_id_required",
                )
            ),
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "start_live_archive");

        return $valid_res;
    }

    /**
     * start_start_live_archive method is used to initiate api execution flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_start_live_archive($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_start_live_archive($request_arr);
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

            $input_params = $this->check_archive_stream_exist($input_params);

            $condition_res = $this->cond_check_stream_exists($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_check_ended($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->tokbox_session_finish_success_1($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->func_start_archive($input_params);

                    $condition_res = $this->condition_for_archieve_id($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->update_archive_status_started($input_params);

                        $output_response = $this->tokbox_session_finish_success_3($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->tokbox_session_finish_success_2($input_params);
                        return $output_response;
                    }
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
     * check_archive_stream_exist method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_archive_stream_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $tokbox_session_id = isset($input_params["tokbox_session_id"]) ? $input_params["tokbox_session_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->tokbox_session_model->check_archive_stream_exist($tokbox_session_id, $user_id);
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
        $input_params["check_archive_stream_exist"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_stream_exists method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_stream_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_archive_stream_exist"]) ? 0 : 1);
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
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_check_ended($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["ts_archive_status"];
            $cc_ro_0 = "started";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["ts_archive_id"];

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
     * tokbox_session_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "tokbox_session_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "start_live_archive";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * func_start_archive method is used to process custom function.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_start_archive($input_params = array())
    {
        if (!method_exists($this, "start_tokbox_archive"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->start_tokbox_archive($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_start_archive"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition_for_archieve_id method is used to process conditions.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_archieve_id($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["archive_id"];

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
     * update_archive_status_started method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_archive_status_started($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_tokbox_session_id"]))
            {
                $where_arr["ts_tokbox_session_id"] = $input_params["ts_tokbox_session_id"];
            }
            if (isset($input_params["archive_id"]))
            {
                $params_arr["archive_id"] = $input_params["archive_id"];
            }
            $params_arr["_earchivestatus"] = "started";
            $this->block_result = $this->tokbox_session_model->update_archive_status_started($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_archive_status_started"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * tokbox_session_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "tokbox_session_finish_success_3",
        );
        $output_fields = array(
            'archive_id',
        );
        $output_keys = array(
            'func_start_archive',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "start_live_archive";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "tokbox_session_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "start_live_archive";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
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

        $func_array["function"]["name"] = "start_live_archive";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
