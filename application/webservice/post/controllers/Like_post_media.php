<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Like Post Media Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Like Post Media
 *
 * @class Like_post_media.php
 *
 * @path application\webservice\post\controllers\Like_post_media.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Like_post_media extends Cit_Controller
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
            "check_post_media",
            "get_post_detail_with_movement",
            "update_post_date_media_block",
            "update_post_media_likes",
            "insert_post_media_likes",
            "update_post_modified_date",
            "get_posted_user_details_v1",
            "get_liked_user_details_v1",
            "insert_liked_notification_v1",
        );
        $this->multiple_keys = array(
            "check_post_media_likes",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('like_post_media_model');
        $this->load->model("post/post_media_model");
        $this->load->model("post/post_model");
        $this->load->model("post/post_media_likes_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_like_post_media method is used to validate api input params.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_like_post_media($request_arr = array())
    {
        $valid_arr = array(
            "media_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "media_id_required",
                )
            ),
            "status" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "status_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "like_post_media");

        return $valid_res;
    }

    /**
     * start_like_post_media method is used to initiate api execution flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_like_post_media($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_like_post_media($request_arr);
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

            $input_params = $this->check_post_media($input_params);

            $input_params = $this->get_post_detail_with_movement($input_params);

            $condition_res = $this->condition_for_get_post_details($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_for_inactive($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->post_media_finish_success_4($input_params);
                    return $output_response;
                }

                else
                {
                    $condition_res = $this->check_post_media_condition($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->check_post_media_likes($input_params);

                        $condition_res = $this->post_media_likes_condition($input_params);
                        if ($condition_res["success"])
                        {

                            $condition_res = $this->condition_for_status($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->update_post_date_media_block($input_params);
                            }

                            $input_params = $this->update_post_media_likes($input_params);

                            $output_response = $this->post_media_finish_success($input_params);

                            //adding the changes here for like man
                            $this->post_model->update_modifieddate_forcefully((int)$input_params['pm_post_id']);

                            return $output_response;
                        }

                        else
                        {

                            $input_params = $this->insert_post_media_likes($input_params);

                            $input_params = $this->update_post_modified_date($input_params);

                            $input_params = $this->get_posted_user_details_v1($input_params);

                            $input_params = $this->get_liked_user_details_v1($input_params);

                            $condition_res = $this->is_not_same_user($input_params);


                            if ($condition_res["success"])
                            {

                                $input_params = $this->insert_liked_notification_v1($input_params);

                                $condition_res = $this->check_posted_user_notify_pref($input_params);
                                if ($condition_res["success"])
                                {

                                    $input_params = $this->push_notify_posted_user($input_params);
                                }

                                $output_response = $this->post_media_finish_success_2($input_params);
                                return $output_response;
                            }

                            else
                            {

                                $output_response = $this->success($input_params);
                                return $output_response;
                            }
                        }
                    }

                    else
                    {
                        $output_response = $this->post_media_finish_success_1($input_params);
                        return $output_response;
                    }
                }
            }

            else
            {

                $output_response = $this->post_media_finish_success_3($input_params);
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
     * check_post_media method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_media($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $media_id = isset($input_params["media_id"]) ? $input_params["media_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_media_model->check_post_media($media_id, $user_id);
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
        $input_params["check_post_media"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_post_detail_with_movement method is used to process query block.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_post_detail_with_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $pm_post_id = isset($input_params["pm_post_id"]) ? $input_params["pm_post_id"] : "";
            $this->block_result = $this->post_model->get_post_detail_with_movement($pm_post_id);
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
        $input_params["get_post_detail_with_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_get_post_details method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_post_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_post_detail_with_movement"]) ? 0 : 1);
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
     * condition_for_inactive method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_inactive($input_params = array())
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
     * post_media_finish_success_4 method is used to process finish flow.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success_4",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * check_post_media_condition method is used to process conditions.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Rohit Patidar | 14.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_post_media_condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_media"]) ? 0 : 1);
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
     * check_post_media_likes method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_post_media_likes($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $media_id = isset($input_params["media_id"]) ? $input_params["media_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_media_likes_model->check_post_media_likes($media_id, $user_id);
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
        $input_params["check_post_media_likes"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * post_media_likes_condition method is used to process conditions.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function post_media_likes_condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_post_media_likes"]) ? 0 : 1);
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
     * condition_for_status method is used to process conditions.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["status"];
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
     * update_post_date_media_block method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_date_media_block($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["pm_post_id"]))
            {
                $where_arr["pm_post_id"] = $input_params["pm_post_id"];
            }
            $params_arr["_tpostmetadata"] = "now()";
            $this->block_result = $this->post_model->update_post_date_media_block($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_date_media_block"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_post_media_likes method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_media_likes($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["media_id"]))
            {
                $where_arr["media_id"] = $input_params["media_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_dmodifieddate"] = "NOW()";
            if (isset($input_params["status"]))
            {
                $params_arr["status"] = $input_params["status"];
            }
            $this->block_result = $this->post_media_likes_model->update_post_media_likes($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_media_likes"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * post_media_finish_success method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Pavan  | 14.12.2018
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

        $func_array["function"]["name"] = "like_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * insert_post_media_likes method is used to process query block.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_post_media_likes($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["media_id"]))
            {
                $params_arr["media_id"] = $input_params["media_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_dmodifieddate"] = "NOW()";
            if (isset($input_params["status"]))
            {
                $params_arr["status"] = $input_params["status"];
            }
            $this->block_result = $this->post_media_likes_model->insert_post_media_likes($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_post_media_likes"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_post_modified_date method is used to process query block.
     * @created Rohit Patidar | 14.10.2021
     * @modified Rohit Patidar | 14.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_post_modified_date($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["pm_post_id"]))
            {
                $where_arr["pm_post_id"] = $input_params["pm_post_id"];
            }
            $params_arr["_dmodifieddate"] = "now()";
            $this->block_result = $this->post_model->update_post_modified_date($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_post_modified_date"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_posted_user_details_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 09.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_posted_user_details_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $media_id = isset($input_params["media_id"]) ? $input_params["media_id"] : "";
            $this->block_result = $this->post_media_model->get_posted_user_details_v1($media_id);
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
        $input_params["get_posted_user_details_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_liked_user_details_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 09.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_liked_user_details_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_liked_user_details_v1($user_id);
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
        $input_params["get_liked_user_details_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * is_not_same_user method is used to process conditions.
     * @created Mehul Prajapati | 11.03.2021
     * @modified Mehul Prajapati | 11.03.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_not_same_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["posted_users_id"];
            $cc_ro_0 = $input_params["liked_users_id"];

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
     * insert_liked_notification_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 09.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_liked_notification_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["posted_users_id"]))
            {
                $params_arr["posted_users_id"] = $input_params["posted_users_id"];
            }
            $params_arr["liked_name"] = "CONCAT('".$input_params["liked_name"]."',\" liked your post\")";
            $params_arr["_dtaddeddate"] = "NOW()";
            $params_arr["_etype"] = "Post";
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "'LOP'";
            if (isset($input_params["p_post_id"]))
            {
                $params_arr["p_post_id"] = $input_params["p_post_id"];
            }
            if (isset($input_params["liked_users_id"]))
            {
                $params_arr["liked_users_id"] = $input_params["liked_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_liked_notification_v1($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_liked_notification_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * check_posted_user_notify_pref method is used to process conditions.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 09.11.2020
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_posted_user_notify_pref($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["posted_notification_pref"];
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["posted_device_token"];

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
     * push_notify_posted_user method is used to process mobile push notification.
     * @created CIT Dev Team
     * @modified Nandini Santoki | 09.11.2020
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notify_posted_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["posted_device_token"];
            $code = "LOP";
            $sound = "";
            $badge = $input_params["media_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["p_post_id"],
                    "send" => "Yes",
                )
            );
            $push_msg = "#liked_name# liked your post";
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
        $input_params["push_notify_posted_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * post_media_finish_success_2 method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Pavan  | 14.12.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_media_finish_success_2",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * success method is used to process finish flow.
     * @created Mehul Prajapati | 11.03.2021
     * @modified Mehul Prajapati | 11.03.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success_1 method is used to process finish flow.
     * @created Anjaneyulu Gulla | 29.10.2018
     * @modified Anjaneyulu Gulla | 29.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_media_finish_success_1",
        );
        $output_fields = array(
            'pm_status',
        );
        $output_keys = array(
            'check_post_media',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post_media";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_media_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_media_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_media_finish_success_3",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "like_post_media";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
