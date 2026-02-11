<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Delete Post Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Delete Post
 *
 * @class Delete_post.php
 *
 * @path application\webservice\post\controllers\Delete_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.10.2021
 */

class Delete_post extends Cit_Controller
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
            "is_post_exist",
            "delete_post",
            "delete_shared_post",
        );
        $this->multiple_keys = array(
            "check_shares",
            "exist_delete_media",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('delete_post_model');
        $this->load->model("post/post_model");
    }

    /**
     * rules_delete_post method is used to validate api input params.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Rohit Patidar | 25.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_delete_post($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "delete_post");

        return $valid_res;
    }

    /**
     * start_delete_post method is used to initiate api execution flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Rohit Patidar | 25.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_delete_post($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_delete_post($request_arr);
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

            $input_params = $this->is_post_exist($input_params);

            $condition_res = $this->cond_post_exists($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->cond_user_check($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->delete_post($input_params);

                    $condition_res = $this->condition_check($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->check_shares($input_params);

                        $condition_res = $this->share_post_exists($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->delete_shared_post($input_params);
                        }

                        $condition_res = $this->condition_media_exist($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->exist_delete_media($input_params);
                        }

                        $output_response = $this->post_finish_success($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->post_finish_success_1($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->post_finish_success_3($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->post_finish_success_2($input_params);
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
     * is_post_exist method is used to process query block.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function is_post_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->is_post_exist($post_id);
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
        $input_params["is_post_exist"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_post_exists method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["is_post_exist"]) ? 0 : 1);
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
     * @created Vamsi Ippe | 27.09.2018
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_user_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["p_user_id"];
            $cc_ro_0 = $input_params["user_id"];

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;

            $cc_lo_1 = $input_params["m_user_id"];
            $cc_ro_1 = $input_params["user_id"];

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
     * delete_post method is used to process query block.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 22.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $p_user_id = isset($input_params["p_user_id"]) ? $input_params["p_user_id"] : "";
            $this->block_result = $this->post_model->delete_post($post_id, $p_user_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_check method is used to process conditions.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = 1;
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
     * check_shares method is used to process query block.
     * @created Vamsi Ippe | 04.01.2019
     * @modified Vamsi Ippe | 04.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_shares($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->check_shares($post_id);
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
        $input_params["check_shares"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * share_post_exists method is used to process conditions.
     * @created Vamsi Ippe | 04.01.2019
     * @modified Vamsi Ippe | 04.01.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function share_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_shares"]) ? 0 : 1);
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
     * delete_shared_post method is used to process query block.
     * @created Vamsi Ippe | 04.01.2019
     * @modified Vamsi Ippe | 04.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_shared_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_model->delete_shared_post($post_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_shared_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_media_exist method is used to process conditions.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_media_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["post_media_id_str"];

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
     * exist_delete_media method is used to process custom function.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Rohit Patidar | 22.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function exist_delete_media($input_params = array())
    {

        $this->load->module("post/delete_media");
        $api_params = array();
        if (array_key_exists("post_id", $input_params))
        {
            $api_params["post_id"] = $input_params["post_id"];
        }
        if (array_key_exists("post_media_id_str", $input_params))
        {
            $api_params["post_media_id"] = $input_params["post_media_id_str"];
        }
        if (array_key_exists("p_user_id", $input_params))
        {
            $api_params["user_id"] = $input_params["p_user_id"];
        }
        $maping_arr = array();
        $result_arr = $this->delete_media->start_delete_media($api_params, TRUE);
        if ($result_arr["success"] == "-5")
        {
            $input_params["exist_delete_media_success"] = $result_arr["success"];
            $input_params["exist_delete_media_message"] = $result_arr["message"];
            $result_arr["data"] = array();
        }
        else
        {
            $input_params["exist_delete_media_success"] = $result_arr["settings"]["success"];
            $input_params["exist_delete_media_message"] = $result_arr["settings"]["message"];
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr, $maping_arr);
        $input_params["exist_delete_media"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 15.10.2018
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
            'p_post_id',
            'p_user_id',
            'post_media_id_str',
            'follower_count',
            'following_count',
            'post_count',
        );
        $output_keys = array(
            'is_post_exist',
        );
        $ouput_aliases = array(
            "p_post_id" => "post_id",
            "p_user_id" => "user_id",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_post";
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
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
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

        $func_array["function"]["name"] = "delete_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_3 method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 27.09.2018
     * @modified Vamsi Ippe | 27.09.2018
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
        $output_array["settings"]["fields"] = array_merge($this->output_params, $output_fields);
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
