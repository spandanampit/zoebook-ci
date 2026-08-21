<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Comment On Post Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Comment On Post
 *
 * @class Comment_on_post.php
 *
 * @path application\webservice\post\controllers\Comment_on_post.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 26.10.2021
 */

class Comment_on_post extends Cit_Controller
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
            "check_post_exists",
            "check_comment_already_exists",
            "update_comment",
            "update_date_movement_post",
            "insert_comment",
            "update_movement_post_date",
            "get_commented_user_details",
            "insert_user_notify_commented",
            "insert_commented_notify",
            "get_post_media_info",
        );
        $this->multiple_keys = array(
            "get_all_commented_users",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->library('cloudinarylib');
        $this->load->model('comment_on_post_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_comment_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
        $this->load->model("post/post_media_model");
    }

    /**
     * rules_comment_on_post method is used to validate api input params.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 26.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_comment_on_post($request_arr = array())
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "comment_on_post");

        return $valid_res;
    }

    /**
     * start_comment_on_post method is used to initiate api execution flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 26.10.2021
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_comment_on_post($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_comment_on_post($request_arr);
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
            
            $input_params = $this->check_post_exists($input_params);
            
            $condition_res = $this->condition_2($input_params);
            
            if ($condition_res["success"])
            {

                $output_response = $this->post_finish_success_6($input_params);
                return $output_response;
            }

            else
            {
                $condition_res = $this->cond_check_post_exist($input_params);
                if ($condition_res["success"])
                {
                    
                    $condition_res = $this->check_input_media_id($input_params);
                    if ($condition_res["success"])
                    {
                        
                        $input_params = $this->var_final_post_media_id1($input_params);
                        
                    }
                    
                    else
                    {

                        $input_params = $this->get_post_media_info($input_params);

                        $condition_res = $this->check_post_media_info($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->var_final_post_media_id($input_params);
                        }

                        else
                        {

                            $output_response = $this->post_media_doesnt_exist($input_params);
                            return $output_response;
                        }
                    }

                    $condition_res = $this->cond_check_edit_add($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->check_comment_already_exists($input_params);

                        $condition_res = $this->condition_1($input_params);
                        if ($condition_res["success"])
                        {

                            $condition_res = $this->check_commented_user($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->update_comment($input_params);

                                $input_params = $this->update_date_movement_post($input_params);

                                $output_response = $this->post_finish_success_2($input_params);
                                return $output_response;
                            }

                            else
                            {

                                $output_response = $this->post_finish_success_4($input_params);
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
                        $input_params = $this->insert_comment($input_params);
                        
                        $condition_res = $this->cond_insert_succes($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->update_movement_post_date($input_params);

                            $condition_res = $this->check_posted_user($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->get_commented_user_details($input_params);

                                $input_params = $this->insert_user_notify_commented($input_params);

                                $condition_res = $this->cond_notify_pref_check($input_params);
                                if ($condition_res["success"])
                                {

                                    $input_params = $this->push_notification($input_params);
                                }

                                $output_response = $this->post_finish_success($input_params);
                                return $output_response;
                            }

                            else
                            {

                                $input_params = $this->get_all_commented_users($input_params);

                                $condition_res = $this->condition($input_params);
                                if ($condition_res["success"])
                                {

                                    $output_response = $this->post_finish_success_5($input_params);
                                    return $output_response;
                                }

                                else
                                {

                                    $input_params = $this->insert_commented_notify($input_params);

                                    $input_params = $this->start_loop($input_params);

                                    $output_response = $this->post_finish_success_1($input_params);
                                    return $output_response;
                                }
                            }
                        }

                        else
                        {

                            $output_response = $this->post_finish_failure($input_params);
                            return $output_response;
                        }
                    }
                }

                else
                {

                    $output_response = $this->post_check_failure($input_params);
                    return $output_response;
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
     * check_post_exists method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_model->check_post_exists($post_id, $user_id);
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
        $input_params["check_post_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_2 method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_2($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["m_status"];
            $cc_ro_0 = "Inactive";

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
     * post_finish_success_6 method is used to process finish flow.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_6($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_6",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * cond_check_post_exist method is used to process conditions.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_post_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_exists"]) ? 0 : 1);
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
     * check_input_media_id method is used to process conditions.
     * @created Pavan  | 02.11.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_input_media_id($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["post_media_id"];
            $cc_ro_0 = 0;

            $cc_fr_0 = ($cc_lo_0 <= $cc_ro_0) ? TRUE : FALSE;
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
     * var_final_post_media_id1 method is used to process simple variables.
     * @created Pavan  | 02.11.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function var_final_post_media_id1($input_params = array())
    {

        $input_params["var_ipostmedia_id"] = "0";
        $_temp_single_arr["var_ipostmedia_id"] = $input_params["var_ipostmedia_id"];
        return $input_params;
    }

    /**
     * get_post_media_info method is used to process query block.
     * @created CIT Dev Team
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_media_info($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_media_id = isset($input_params["post_media_id"]) ? $input_params["post_media_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_media_model->get_post_media_info($post_media_id, $post_id);
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
        $input_params["get_post_media_info"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_post_media_info method is used to process conditions.
     * @created CIT Dev Team
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_post_media_info($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_post_media_info"]) ? 0 : 1);
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
     * var_final_post_media_id method is used to process simple variables.
     * @created Pavan  | 02.11.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function var_final_post_media_id($input_params = array())
    {

        $input_params["var_ipostmedia_id"] = $input_params["post_media_id"];
        $_temp_single_arr["var_ipostmedia_id"] = $input_params["var_ipostmedia_id"];
        return $input_params;
    }

    /**
     * post_media_doesnt_exist method is used to process finish flow.
     * @created Pavan  | 02.11.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_doesnt_exist($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_doesnt_exist",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * cond_check_edit_add method is used to process conditions.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_edit_add($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["post_comment_id"];
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
     * check_comment_already_exists method is used to process query block.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_comment_already_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_comment_model->check_comment_already_exists($post_comment_id, $post_id);
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
        $input_params["check_comment_already_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_1 method is used to process conditions.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_comment_already_exists"]) ? 0 : 1);
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
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
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
     * update_comment method is used to process query block.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_comment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["post_comment_id"]))
            {
                $where_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            if (isset($input_params["post_id"]))
            {
                $where_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["comment"]))
            {
                $params_arr["comment"] = $input_params["comment"];
            }
            if (isset($images_arr["upload_file"]["name"]))
            {
                $params_arr["upload_file"] = $images_arr["upload_file"]["name"];
            }
            $params_arr["_dmodifieddate"] = "NOW()";
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["var_ipostmedia_id"]))
            {
                $params_arr["var_ipostmedia_id"] = $input_params["var_ipostmedia_id"];
            }
            $this->block_result = $this->post_comment_model->update_comment($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_comment"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_date_movement_post method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_date_movement_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["post_id"]))
            {
                $where_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_dmodifieddate"] = "now()";
            $this->block_result = $this->post_model->update_date_movement_post($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_date_movement_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * post_finish_success_2 method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_2",
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
            'check_post_exists',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success_4 method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_4",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
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
            "success" => "0",
            "message" => "post_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * insert_comment method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_comment($input_params = array())
    {   
        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($_FILES["upload_file"]["name"]) && isset($_FILES["upload_file"]["tmp_name"]))
            {
                $sent_file = $_FILES["upload_file"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["upload_file"]["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                $images_arr["upload_file"]["size"] = "100000";
                if ($this->general->validateFileFormat($images_arr["upload_file"]["ext"], $_FILES["upload_file"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["upload_file"]["size"], $_FILES["upload_file"]["size"]))
                    {
                        $images_arr["upload_file"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_iparentid"] = "'0'";
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["comment"]))
            {
                $params_arr["comment"] = $input_params["comment"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            if (isset($images_arr["upload_file"]["name"]))
            {
                $params_arr["upload_file"] = $images_arr["upload_file"]["name"];
            }
            if (isset($input_params["var_ipostmedia_id"]))
            {
                $params_arr["var_ipostmedia_id"] = $input_params["var_ipostmedia_id"];
            }

            if (!empty($images_arr["upload_file"]["name"]))
            {

                if (strpos($_FILES['upload_file']['type'], 'image') !== false) {
                    $file_tmp_path = $_FILES["upload_file"]["tmp_name"];
                    
                    $response_cloud = \Cloudinary\Uploader::upload($file_tmp_path);
                    if ($response_cloud)
                    {
                        $params_arr['response'] = $response_cloud;

                        $this->block_result = $this->post_comment_model->insert_comment($params_arr);
                        
                        if (!$this->block_result["success"])
                        {
                            throw new Exception("Insertion failed.");
                        }
                    }
                }elseif (strpos($_FILES['upload_file']['type'], 'video') !== false) {
                    
                    $name = str_replace(' ', '_', $_FILES['upload_file']['name']);
                    $tmp_name = $_FILES['upload_file']['tmp_name'];

                    $compress_file = $this->config->item('upload_path') . 'compress_video/'.$name;
                    $return_arr['compress_video_path']=$compress_file;
                    $input = $_FILES['upload_file']['tmp_name'];
                    $move = move_uploaded_file($input,$compress_file);

                    $name = $this->config->item('upload_path') . 'compress_video/'.$name;

                    $response = \Cloudinary\Uploader::upload($name, [
                        'resource_type' => 'video' ,
                        "upload_preset" => 'owa0qgdb',
                        'chunk_size' => 6000000000000000000]
                    );

                    if ($response)
                    {   
                        $params_arr['response'] = $response;

                        $this->block_result = $this->post_comment_model->insert_comment($params_arr);
                        if (!$this->block_result["success"])
                        {
                            throw new Exception("Insertion failed.");
                        }
                    }

                } 
                // $file_path = "post_media";
                // $folder_id = trim($data_arr[0]["iUserId"]);
                // $file_path = $file_path."/".$folder_id;
                // $file_name = $images_arr["upload_file"]["name"];
                // $file_tmp_path = $_FILES["upload_file"]["tmp_name"];
                // $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                // if (!$response)
                // {
                //     //file upload failed

                // }
            } else {
                
                $this->block_result = $this->post_comment_model->insert_comment($params_arr);
                if (!$this->block_result["success"])
                {
                    throw new Exception("Insertion failed.");
                }
                
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_comment"] = $this->block_result["data"];
        
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_insert_succes method is used to process conditions.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_insert_succes($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_comment"]) ? 0 : 1);
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
     * update_movement_post_date method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_movement_post_date($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["post_id"]))
            {
                $where_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_dmodifieddate"] = "now()";
            $this->block_result = $this->post_model->update_movement_post_date($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_movement_post_date"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_posted_user method is used to process conditions.
     * Check commented user  is not post user
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_posted_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["posted_by_user_id"];

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
     * get_commented_user_details method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_commented_user_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_commented_user_details($user_id);
            if (!$this->block_result["success"])
            {
                throw new Exception("No records found.");
            }
            $result_arr = $this->block_result["data"];
            if (is_array($result_arr) && count($result_arr) > 0)
            {
                $i = 0;
                foreach ($result_arr as $data_key => $data_arr)
                {

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["height"] = "50";
                    $image_arr["width"] = "50";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $i++;
                }
                $this->block_result["data"] = $result_arr;
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["get_commented_user_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * insert_user_notify_commented method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Pavan  | 02.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_user_notify_commented($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["posted_by_user_id"]))
            {
                $params_arr["posted_by_user_id"] = $input_params["posted_by_user_id"];
            }
            $params_arr["_vnotificationtext"] = "CONCAT('".$input_params["u_name"]."',' has commented on your post')";
            $params_arr["_etype"] = "Normal";
            $params_arr["_eisread"] = "No";
            $params_arr["_dtaddeddate"] = "NOW()";
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["comment_id"]))
            {
                $params_arr["comment_id"] = $input_params["comment_id"];
            }
            $params_arr["_vcode"] = "'COP'";
            if (isset($input_params["u_users_id"]))
            {
                $params_arr["u_users_id"] = $input_params["u_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_user_notify_commented($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_user_notify_commented"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_notify_pref_check method is used to process conditions.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_notify_pref_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_notification_pref"];
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
     * push_notification method is used to process mobile push notification.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["device_token"];
            $code = "COP";
            $sound = "";
            $badge = $input_params["u_profile_image"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "post_comment_id",
                    "value" => $input_params["comment_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#u_name# has commented on your post";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "runtime";

            $send_arr = array();
            $send_arr['device_id'] = $device_id;
            $send_arr['code'] = $code;
            $send_arr['sound'] = $sound;
            $send_arr['badge'] = intval($badge);
            $send_arr['silent'] = $silent;
            $send_arr['title'] = $title;
            $send_arr['message'] = $push_msg;
            $send_arr['variables'] = json_encode($send_vars);
            $send_arr['send_mode'] = $send_mode;
            $uni_id = $this->general->insertPushNotification($send_arr);
            if (!$uni_id)
            {
                throw new Exception('Failure in insertion of push notification batch entry.');
            }

            $success = 1;
            $message = "Push notification send succesfully.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        $input_params["push_notification"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
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
            'comment_id',
        );
        $output_keys = array(
            'insert_comment',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_all_commented_users method is used to process query block.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_all_commented_users($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $posted_by_user_id = isset($input_params["posted_by_user_id"]) ? $input_params["posted_by_user_id"] : "";
            $this->block_result = $this->post_comment_model->get_all_commented_users($post_id, $posted_by_user_id);
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
        $input_params["get_all_commented_users"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_all_commented_users"]) ? 0 : 1);
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
     * post_finish_success_5 method is used to process finish flow.
     * @created Vamsi Ippe | 01.01.2019
     * @modified Vamsi Ippe | 01.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_5($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_5",
        );
        $output_fields = array(
            'comment_id',
        );
        $output_keys = array(
            'insert_comment',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * insert_commented_notify method is used to process query block.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 11.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_commented_notify($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            $batch_params_arr = $input_params["get_all_commented_users"];
            if (!is_array($batch_params_arr) || count($batch_params_arr) == 0)
            {
                throw new Exception("Batch insert data not found.");
            }
            $tmp_input_params = $input_params;
            unset($tmp_input_params["get_all_commented_users"]);

            $batch_count = count($batch_params_arr);
            for ($i = 0; $i < $batch_count; $i++)
            {
                $batch_params = is_array($batch_params_arr[$i]) ? array_merge($tmp_input_params, $batch_params_arr[$i]) : $tmp_input_params;
                $batch_params["i"] = $i;

                $params_arr[$i]["commented_users_id"] = $batch_params["commented_users_id"];
                $params_arr[$i]["_vnotificationtext"] = "CONCAT('".$batch_params["posted_by_user_name"]."',\" has replied to the post in which you commented\")";
                $params_arr[$i]["_etype"] = "Post";
                $params_arr[$i]["_eisread"] = "No";
                $params_arr[$i]["_dtaddeddate"] = "NOW()";
                $params_arr[$i]["post_id"] = $batch_params["post_id"];
                $params_arr[$i]["comment_id"] = $batch_params["comment_id"];
                $params_arr[$i]["_vcode"] = "'COP'";
                $params_arr[$i]["posted_by_user_id"] = $batch_params["posted_by_user_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_commented_notify($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_commented_notify"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * start_loop method is used to process loop flow.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function start_loop($input_params = array())
    {
        $this->iterate_start_loop($input_params["get_all_commented_users"], $input_params);
        return $input_params;
    }

    /**
     * condition_user_notify_pref_check method is used to process conditions.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_user_notify_pref_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["commented_user_notification_pref"];
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
     * push_notification_commented_user method is used to process mobile push notification.
     * push_notification_commented_user if owner added a comment
     * @created Vamsi Ippe | 16.10.2018
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification_commented_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["commented_user_device_token"];
            $code = "COP";
            $sound = "";
            $badge = $input_params["comment_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "post_comment_id",
                    "value" => $input_params["comment_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#posted_by_user_name# has replied to the post in which you commented";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "runtime";

            $send_arr = array();
            $send_arr['device_id'] = $device_id;
            $send_arr['code'] = $code;
            $send_arr['sound'] = $sound;
            $send_arr['badge'] = intval($badge);
            $send_arr['silent'] = $silent;
            $send_arr['title'] = $title;
            $send_arr['message'] = $push_msg;
            $send_arr['variables'] = json_encode($send_vars);
            $send_arr['send_mode'] = $send_mode;
            $uni_id = $this->general->insertPushNotification($send_arr);
            if (!$uni_id)
            {
                throw new Exception('Failure in insertion of push notification batch entry.');
            }

            $success = 1;
            $message = "Push notification send succesfully.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        $input_params["push_notification_commented_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * post_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 17.10.2018
     * @modified Vamsi Ippe | 17.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success_1",
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
            'check_post_exists',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_failure method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_failure",
        );
        $output_fields = array(
            'p_post_id',
            'posted_by_user_id',
            'device_type',
            'device_token',
        );
        $output_keys = array(
            'check_post_exists',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_check_failure method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_check_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_check_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "comment_on_post";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * iterate_start_loop method is used to iterate loop.
     * @created Vamsi Ippe | 16.10.2018
     * @modified Vamsi Ippe | 16.10.2018
     * @param array $get_all_commented_users_lp_arr get_all_commented_users_lp_arr array to iterate loop.
     * @param array $input_params_addr $input_params_addr array to address original input params.
     */
    public function iterate_start_loop(&$get_all_commented_users_lp_arr = array(), &$input_params_addr = array())
    {

        $input_params_loc = $input_params_addr;
        $_loop_params_loc = $get_all_commented_users_lp_arr;
        $_lp_ini = 0;
        $_lp_end = count($_loop_params_loc);
        for ($i = $_lp_ini; $i < $_lp_end; $i += 1)
        {
            $get_all_commented_users_lp_pms = $input_params_loc;

            unset($get_all_commented_users_lp_pms["get_all_commented_users"]);
            if (is_array($_loop_params_loc[$i]))
            {
                $get_all_commented_users_lp_pms = $_loop_params_loc[$i]+$input_params_loc;
            }
            else
            {
                $get_all_commented_users_lp_pms["get_all_commented_users"] = $_loop_params_loc[$i];
                $_loop_params_loc[$i] = array();
                $_loop_params_loc[$i]["get_all_commented_users"] = $get_all_commented_users_lp_pms["get_all_commented_users"];
            }

            $get_all_commented_users_lp_pms["i"] = $i;
            $input_params = $get_all_commented_users_lp_pms;

            $condition_res = $this->condition_user_notify_pref_check($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->push_notification_commented_user($input_params);
            }

            $get_all_commented_users_lp_arr[$i] = $this->wsresponse->filterLoopParams($input_params, $_loop_params_loc[$i], $get_all_commented_users_lp_pms);
        }
    }
}
