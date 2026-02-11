<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Delete Media Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Delete Media
 *
 * @class Delete_media.php
 *
 * @path application\webservice\post\controllers\Delete_media.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 28.09.2018
 */

class Delete_media extends Cit_Controller
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
            "delete_media_individual",
        );
        $this->multiple_keys = array(
            "get_media",
            "func_delete_media_from_folder",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('delete_media_model');
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_delete_media method is used to validate api input params.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_delete_media($request_arr = array())
    {
        $valid_arr = array(
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "post_media_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_media_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "delete_media");
        $input_params = $valid_res['input_params'];
        if (!empty($input_params["post_media_id"]) && !is_array($input_params["post_media_id"]))
        {
            $input_params["post_media_id"] = explode(",", $input_params["post_media_id"]);
        }
        elseif (!is_array($input_params["post_media_id"]))
        {
            $input_params["post_media_id"] = array();
        }
        $valid_res['input_params'] = $input_params;
        return $valid_res;
    }

    /**
     * start_delete_media method is used to initiate api execution flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_delete_media($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_delete_media($request_arr);
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

            $input_params = $this->get_media($input_params);

            $condition_res = $this->cond_media_exists($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->func_delete_media_from_folder($input_params);

                $input_params = $this->delete_media_individual($input_params);

                $condition_res = $this->condition($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_media_finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->post_media_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->post_media_finish_success_2($input_params);
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
     * get_media method is used to process query block.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_media_id = isset($input_params["post_media_id"]) ? $input_params["post_media_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_media_model->get_media($post_media_id, $post_id, $user_id);
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
        $input_params["get_media"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * cond_media_exists method is used to process conditions.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_media_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_media"]) ? 0 : 1);
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
     * func_delete_media_from_folder method is used to process custom function.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function func_delete_media_from_folder($input_params = array())
    {
        if (!method_exists($this, "delete_media_from_folder"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->delete_media_from_folder($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["func_delete_media_from_folder"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * delete_media_individual method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_media_individual($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $post_media_id = isset($input_params["post_media_id"]) ? $input_params["post_media_id"] : "";
            $this->block_result = $this->post_media_model->delete_media_individual($post_id, $post_media_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_media_individual"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["delete_media_individual"]) ? 0 : 1);
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
     * post_media_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_media_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
