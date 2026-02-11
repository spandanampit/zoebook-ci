<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update Impression Count Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Update Impression Count
 *
 * @class Update_impression_count.php
 *
 * @path application\webservice\post\controllers\Update_impression_count.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Update_impression_count extends Cit_Controller
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
            "check_post_viral",
            "check_impression_record_exists",
            "inser_impression",
            "update_post_impression_count",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('update_impression_count_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_impression_model");
        $this->load->model("wscustom/wscustom_model");
    }

    /**
     * rules_update_impression_count method is used to validate api input params.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_update_impression_count($request_arr = array())
    {
        $valid_arr = array(
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "update_impression_count");

        return $valid_res;
    }

    /**
     * start_update_impression_count method is used to initiate api execution flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_update_impression_count($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_update_impression_count($request_arr);
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

            $input_params = $this->check_post_viral($input_params);

            $condition_res = $this->condition_post_exists($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->cond_user_check($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->check_impression_record_exists($input_params);

                    $condition_res = $this->cond_check_exists($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->inser_impression($input_params);
                    }

                    else
                    {

                        $output_response = $this->post_impression_finish_success($input_params);
                        return $output_response;
                    }
                }

                $input_params = $this->update_post_impression_count($input_params);

                $output_response = $this->finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->post_finish_success($input_params);
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
     * check_post_viral method is used to process query block.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 09.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_viral($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->check_post_viral($post_id);
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
        $input_params["check_post_viral"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_post_exists method is used to process conditions.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_viral"]) ? 0 : 1);
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
     * cond_user_check method is used to process conditions.
     * @created Vamsi Ippe | 25.06.2020
     * @modified Vamsi Ippe | 25.06.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_user_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = 0;

            $cc_fr_0 = ($cc_lo_0 > $cc_ro_0) ? TRUE : FALSE;
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
     * check_impression_record_exists method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_impression_record_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_impression_model->check_impression_record_exists($post_id, $user_id);
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
        $input_params["check_impression_record_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_exists method is used to process conditions.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 29.10.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_impression_record_exists"]) ? 0 : 1);
            $cc_ro_0 = 0;

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
     * inser_impression method is used to process query block.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function inser_impression($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $this->block_result = $this->post_impression_model->inser_impression($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["inser_impression"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * post_impression_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 09.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_impression_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_impression_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_impression_count";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * update_post_impression_count method is used to process query block.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_impression_count($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->wscustom_model->update_post_impression_count($input_params);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_impression_count"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Jay Rajput | 21.07.2022
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
            'p_impression_count',
        );
        $output_keys = array(
            'check_post_viral',
        );
        $ouput_aliases = array(
            "p_impression_count" => "impression_count",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_impression_count";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 24.04.2019
     * @modified Vamsi Ippe | 24.04.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_impression_count";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
