<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Generate Token Controller
 *
 * @category webservice
 *
 * @package tokbox
 *
 * @subpackage controllers
 *
 * @module Generate Token
 *
 * @class Genarate_token.php
 *
 * @path application\webservice\tokbox\controllers\Genarate_token.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.09.2018
 */

class Genarate_token extends Cit_Controller
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
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('genarate_token_model');
    }

    /**
     * rules_genarate_token method is used to validate api input params.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_genarate_token($request_arr = array())
    {
        $valid_arr = array(
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            ),
            "requested_user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "requested_user_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "genarate_token");

        return $valid_res;
    }

    /**
     * start_genarate_token method is used to initiate api execution flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_genarate_token($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_genarate_token($request_arr);
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

            $input_params = $this->custom_function($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->finish_success_1($input_params);
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
     * custom_function method is used to process custom function.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
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
        $input_params["custom_function"] = $format_arr;

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
     * finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 25.09.2018
     * @modified Vamsi Ippe | 25.09.2018
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
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "genarate_token";
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

        $func_array["function"]["name"] = "genarate_token";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
