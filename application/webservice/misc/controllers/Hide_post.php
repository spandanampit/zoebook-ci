<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Hide post Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Hide post
 *
 * @class Hide_post.php
 *
 * @path application\webservice\misc\controllers\Hide_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Hide_post extends Cit_Controller
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
            "select_post_report_abuse",
            "remove_hide_post",
            "add_hide_post",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('hide_post_model');
        $this->load->model("post/post_report_abuse_model");
    }

    /**
     * rules_hide_post method is used to validate api input params.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_hide_post($request_arr = array())
    {
        $valid_arr = array(
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "Type" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "Type_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "hide_post");

        return $valid_res;
    }

    /**
     * start_hide_post method is used to initiate api execution flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_hide_post($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_hide_post($request_arr);
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

            $input_params = $this->select_post_report_abuse($input_params);

            $condition_res = $this->condition_for_type($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_for_select_post_abuse($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->remove_hide_post($input_params);

                    $condition_res = $this->condition_for_remove_hide_post($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->success1($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->failure1($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->failure2($input_params);
                    return $output_response;
                }
            }

            else
            {

                $condition_res = $this->condition_for_post_success($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->success3($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->add_hide_post($input_params);

                    $condition_res = $this->condition_for_hide_add_post($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->success($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->failure($input_params);
                        return $output_response;
                    }
                }
            }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * select_post_report_abuse method is used to process query block.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function select_post_report_abuse($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_report_abuse_model->select_post_report_abuse($user_id, $post_id);
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
        $input_params["select_post_report_abuse"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_type method is used to process conditions.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_type($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["Type"];
            $cc_ro_0 = "Show";

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
     * condition_for_select_post_abuse method is used to process conditions.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_select_post_abuse($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["select_post_report_abuse"]) ? 0 : 1);
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
     * remove_hide_post method is used to process query block.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function remove_hide_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $pra_post_report_abuse_id = isset($input_params["pra_post_report_abuse_id"]) ? $input_params["pra_post_report_abuse_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_report_abuse_model->remove_hide_post($pra_post_report_abuse_id, $post_id, $user_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["remove_hide_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_remove_hide_post method is used to process conditions.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_remove_hide_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["remove_hide_post"]) ? 0 : 1);
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
     * success1 method is used to process finish flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success1",
        );
        $output_fields = array(
            'pra_post_report_abuse_id',
            'pra_post_id',
            'pra_reported_by',
            'affected_rows',
        );
        $output_keys = array(
            'select_post_report_abuse',
            'remove_hide_post',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * failure1 method is used to process finish flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failure1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "failure1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * failure2 method is used to process finish flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failure2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "failure2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * condition_for_post_success method is used to process conditions.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_post_success($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["select_post_report_abuse"]) ? 0 : 1);
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
     * success3 method is used to process finish flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success3",
        );
        $output_fields = array(
            'pra_post_report_abuse_id',
        );
        $output_keys = array(
            'select_post_report_abuse',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * add_hide_post method is used to process query block.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function add_hide_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_etype"] = "HidePost";
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_daddeddate"] = "NOW();";
            $params_arr["_dmodifieddate"] = "NOW();";
            $params_arr["_estatus"] = "Approved";
            $this->block_result = $this->post_report_abuse_model->add_hide_post($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["add_hide_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_hide_add_post method is used to process conditions.
     * @created Rohit Patidar | 15.06.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_hide_add_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["add_hide_post"]) ? 0 : 1);
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
     * success method is used to process finish flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success",
        );
        $output_fields = array(
            'pra_post_id',
            'pra_reported_by',
            'insert_id',
        );
        $output_keys = array(
            'select_post_report_abuse',
            'add_hide_post',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * failure method is used to process finish flow.
     * @created Rohit Patidar | 15.06.2021
     * @modified Rohit Patidar | 15.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "hide_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
