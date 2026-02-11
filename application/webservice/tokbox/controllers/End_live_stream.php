<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of End Live Stream Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module End Live Stream
 *
 * @class End_live_stream.php
 *
 * @path application\webservice\tokbox\controllers\End_live_stream.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.04.2020
 */

class End_live_stream extends Cit_Controller
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
            "check_user_stream_exist",
            "update_stream_status",
            "update_stream_subs_status",
            "remove_follower_notification",
            "make_post_inactive",
        );
        $this->multiple_keys = array(
            "func_stop_tokbox_archive",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('end_live_stream_model');
        $this->load->model("tokbox/tokbox_session_model");
        $this->load->model("tokbox/tokbox_session_subscriber_model");
        $this->load->model("user/user_notifications_model");
        $this->load->model("post/post_model");
    }

    /**
     * rules_end_live_stream method is used to validate api input params.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 10.04.2020
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_end_live_stream($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "end_live_stream");

        return $valid_res;
    }

    /**
     * start_end_live_stream method is used to initiate api execution flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 10.04.2020
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_end_live_stream($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_end_live_stream($request_arr);
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

            $input_params = $this->check_user_stream_exist($input_params);

            $condition_res = $this->cond_check_stream_exists($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_check_ended($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->cond_check_archive_status($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->func_stop_tokbox_archive($input_params);

                        $condition_res = $this->condition($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->update_stream_status($input_params);

                            $input_params = $this->update_stream_subs_status($input_params);

                            $input_params = $this->remove_follower_notification($input_params);

                            $input_params = $this->make_post_inactive($input_params);

                            $output_response = $this->tokbox_session_finish_success_2($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $output_response = $this->tokbox_session_finish_success_4($input_params);
                            return $output_response;
                        }
                    }

                    else
                    {

                        $output_response = $this->tokbox_session_finish_success_3($input_params);
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
     * check_user_stream_exist method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_user_stream_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $tokbox_session_id = isset($input_params["tokbox_session_id"]) ? $input_params["tokbox_session_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->tokbox_session_model->check_user_stream_exist($tokbox_session_id, $user_id);
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
        $input_params["check_user_stream_exist"] = $this->block_result["data"];
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

            $cc_lo_0 = (empty($input_params["check_user_stream_exist"]) ? 0 : 1);
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

            $cc_lo_0 = $input_params["ts_status"];
            $cc_ro_0 = "Inprogress";

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
     * cond_check_archive_status method is used to process conditions.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_archive_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["ts_archive_status"];
            $cc_ro_0 = "started";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;

            $cc_lo_1 = $input_params["ts_archive_status"];
            $cc_ro_1 = "paused";

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
     * func_stop_tokbox_archive method is used to process custom function.
     * end live stream & stop archive
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_stop_tokbox_archive($input_params = array())
    {
        if (!method_exists($this, "stop_tokbox_archive"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->stop_tokbox_archive($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_stop_tokbox_archive"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["archive_status"];
            $cc_ro_0 = "stopped";

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
     * update_stream_status method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_stream_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_tokbox_session_id"]))
            {
                $where_arr["ts_tokbox_session_id"] = $input_params["ts_tokbox_session_id"];
            }
            $params_arr["_dtenddatetime"] = "NOW()";
            $params_arr["_estatus"] = "Ended";
            $params_arr["_earchivestatus"] = "stopped";
            $this->block_result = $this->tokbox_session_model->update_stream_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_stream_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_stream_subs_status method is used to process query block.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_stream_subs_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_tokbox_session_id"]))
            {
                $where_arr["ts_tokbox_session_id"] = $input_params["ts_tokbox_session_id"];
            }
            $params_arr["_estatus"] = "Inactive";
            $params_arr["_dtleavedatetime"] = "now()";
            $this->block_result = $this->tokbox_session_subscriber_model->update_stream_subs_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_stream_subs_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * remove_follower_notification method is used to process query block.
     * @created Vamsi Ippe | 02.11.2018
     * @modified Vamsi Ippe | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function remove_follower_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $tokbox_session_id = isset($input_params["tokbox_session_id"]) ? $input_params["tokbox_session_id"] : "";
            $this->block_result = $this->user_notifications_model->remove_follower_notification($tokbox_session_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["remove_follower_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * make_post_inactive method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 10.04.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function make_post_inactive($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["ts_post_id"]))
            {
                $where_arr["ts_post_id"] = $input_params["ts_post_id"];
            }
            $params_arr["_estatus"] = "Inactive";
            $params_arr["_dmodifieddate"] = "NOW()";
            $this->block_result = $this->post_model->make_post_inactive($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["make_post_inactive"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
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
            "success" => "1",
            "message" => "tokbox_session_finish_success_2",
        );
        $output_fields = array(
            'ts_tokbox_session_id',
            'ts_post_id',
            'tokbox_live_session_id',
            'ts_status',
            'ts_archive_id',
            'ts_archive_status',
        );
        $output_keys = array(
            'check_user_stream_exist',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "end_live_stream";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success_4 method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "tokbox_session_finish_success_4",
        );
        $output_fields = array(
            'ts_tokbox_session_id',
            'ts_post_id',
            'tokbox_live_session_id',
            'ts_status',
            'ts_archive_id',
            'ts_archive_status',
            'archive_status',
        );
        $output_keys = array(
            'check_user_stream_exist',
            'func_stop_tokbox_archive',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "end_live_stream";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * tokbox_session_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 12.10.2018
     * @modified Vamsi Ippe | 12.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function tokbox_session_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "tokbox_session_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "end_live_stream";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
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
        $output_fields = array(
            'ts_tokbox_session_id',
            'ts_post_id',
        );
        $output_keys = array(
            'check_user_stream_exist',
        );
        $ouput_aliases = array(
            "check_user_stream_exist" => "stream_detail",
            "ts_tokbox_session_id" => "tokbox_session_id",
            "ts_post_id" => "post_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "end_live_stream";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
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

        $func_array["function"]["name"] = "end_live_stream";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
