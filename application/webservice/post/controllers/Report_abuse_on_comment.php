<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Report abuse on comment Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Report abuse on comment
 *
 * @class Report_abuse_on_comment.php
 *
 * @path application\webservice\post\controllers\Report_abuse_on_comment.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Report_abuse_on_comment extends Cit_Controller
{
    public $settings_params;
    public $output_params;
    public $single_keys;
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
            "insert_abuse_on_comment",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('report_abuse_on_comment_model');
        $this->load->model("post/post_report_abuse_model");
    }

    /**
     * rules_report_abuse_on_comment method is used to validate api input params.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 22.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_report_abuse_on_comment($request_arr = array())
    {
        $valid_arr = array(
            "post_comment_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_comment_id_required",
                )
            ),
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "type" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "type_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "report_abuse_on_comment");

        return $valid_res;
    }

    /**
     * start_report_abuse_on_comment method is used to initiate api execution flow.
     * @created Vamsi Ippe | 20.09.2018
     * @modified Jay Rajput | 22.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_report_abuse_on_comment($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_report_abuse_on_comment($request_arr);
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

            $input_params = $this->insert_abuse_on_comment($input_params);

            $condition_res = $this->condition_for_abusment($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->post_report_abuse_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->post_report_abuse_finish_failure($input_params);
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
     * insert_abuse_on_comment method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 28.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_abuse_on_comment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_ereporton"] = "Comment";
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Pending";
            if (isset($input_params["report_notes"]))
            {
                $params_arr["report_notes"] = $input_params["report_notes"];
            }
            if (isset($input_params["post_comment_id"]))
            {
                $params_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            if (isset($input_params["type"]))
            {
                $params_arr["type"] = $input_params["type"];
            }
            $this->block_result = $this->post_report_abuse_model->insert_abuse_on_comment($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_abuse_on_comment"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_abusment method is used to process conditions.
     * @created CIT Dev Team
     * @modified Jay Rajput | 22.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_abusment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_abuse_on_comment"]) ? 0 : 1);
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
     * post_report_abuse_finish_success method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Pavan  | 23.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_report_abuse_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_report_abuse_finish_success",
        );
        $output_fields = array(
            'insert_id',
        );
        $output_keys = array(
            'insert_abuse_on_comment',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "report_abuse_on_comment";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_report_abuse_finish_failure method is used to process finish flow.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 20.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_report_abuse_finish_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_report_abuse_finish_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "report_abuse_on_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
