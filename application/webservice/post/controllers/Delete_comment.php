<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Delete Comment Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Delete Comment
 *
 * @class Delete_comment.php
 *
 * @path application\webservice\post\controllers\Delete_comment.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Delete_comment extends Cit_Controller
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
            "check_post_exists_to_delete",
            "check_comment_exist_to_delete",
            "delete_comment",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('delete_comment_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_comment_model");
    }

    /**
     * rules_delete_comment method is used to validate api input params.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Jay Rajput | 08.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_delete_comment($request_arr = array())
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
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "delete_comment");

        return $valid_res;
    }

    /**
     * start_delete_comment method is used to initiate api execution flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Jay Rajput | 08.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_delete_comment($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_delete_comment($request_arr);
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

            $input_params = $this->check_post_exists_to_delete($input_params);

            $condition_res = $this->cond_check_post_exist($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->check_comment_exist_to_delete($input_params);

                $condition_res = $this->check_comment_exists($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->check_commented_user($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->delete_comment($input_params);

                        $output_response = $this->post_finish_success_3($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->post_finish_success_2($input_params);
                        return $output_response;
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
     * check_post_exists_to_delete method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_exists_to_delete($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->check_post_exists_to_delete($post_id);
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
        $input_params["check_post_exists_to_delete"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_post_exist method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_post_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_exists_to_delete"]) ? 0 : 1);
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
     * check_comment_exist_to_delete method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_comment_exist_to_delete($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_comment_model->check_comment_exist_to_delete($post_comment_id, $post_id);
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
        $input_params["check_comment_exist_to_delete"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_comment_exists method is used to process conditions.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_comment_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_comment_exist_to_delete"]) ? 0 : 1);
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
     * check_commented_user method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_commented_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["pc_user_id"];

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
     * delete_comment method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_comment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_comment_model->delete_comment($post_comment_id, $post_id, $user_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_comment"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * post_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_3",
        );
        $output_fields = array(
            'p_post_id',
            'posted_by_user_id',
            'device_type',
            'device_token',
            'user_notification_pref',
            'posted_by_user_name',
        );
        $output_keys = array(
            'check_post_exists_to_delete',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_comment";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
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
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
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

        $func_array["function"]["name"] = "delete_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
