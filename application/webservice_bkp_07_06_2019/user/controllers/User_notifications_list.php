<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of User Notifications list Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module User Notifications list
 *
 * @class User_notifications_list.php
 *
 * @path application\webservice\user\controllers\User_notifications_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 07.01.2019
 */

class User_notifications_list extends Cit_Controller
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
            "update_read_status",
        );
        $this->multiple_keys = array(
            "get_notifications",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('user_notifications_list_model');
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_user_notifications_list method is used to validate api input params.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_user_notifications_list($request_arr = array())
    {
        $valid_arr = array(
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "user_notifications_list");

        return $valid_res;
    }

    /**
     * start_user_notifications_list method is used to initiate api execution flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_user_notifications_list($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_user_notifications_list($request_arr);
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

            $input_params = $this->get_notifications($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->update_read_status($input_params);

                $output_response = $this->user_notifications_finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->user_notifications_finish_success_1($input_params);
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
     * get_notifications method is used to process query block.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 07.01.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_notifications($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->user_notifications_model->get_notifications($user_id);
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

                    $data = $data_arr["un_added_date"];
                    if (method_exists($this->general, "dateTimeSystemFormat"))
                    {
                        $data = $this->general->dateTimeSystemFormat($data, $result_arr[$data_key], $i, $input_params);
                    }
                    $result_arr[$data_key]["un_added_date"] = $data;

                    $data = $data_arr["u_profile_image"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["height"] = "250";
                    $image_arr["width"] = "250";
                    $image_arr["color"] = "FFFFFF";
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
        $input_params["get_notifications"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_notifications"]) ? 0 : 1);
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
     * update_read_status method is used to process query block.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_read_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_eisread"] = "Yes";
            $this->block_result = $this->user_notifications_model->update_read_status($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_read_status"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * user_notifications_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 05.11.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_notifications_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "user_notifications_finish_success",
        );
        $output_fields = array(
            'un_notification_text',
            'un_type',
            'un_user_follower_id',
            'un_added_date',
            'uf_status',
            'un_post_id',
            'un_post_comment_id',
            'un_tokbox_session_id',
            'un_code',
            'u_profile_image',
            'un_user_notifications_id',
            'un_is_read',
            'u_users_id',
            'un_user_id',
            'un_notifiy_user_id',
        );
        $output_keys = array(
            'get_notifications',
        );
        $ouput_aliases = array(
            "un_user_follower_id" => "pending_request_id",
            "un_post_id" => "post_id",
            "un_post_comment_id" => "post_comment_id",
            "un_tokbox_session_id" => "tokbox_session_id",
            "un_code" => "code",
            "u_profile_image" => "user_profile_image",
            "un_user_notifications_id" => "notification_id",
            "un_is_read" => "is_read",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_notifications_list";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_notifications_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 12.09.2018
     * @modified Vamsi Ippe | 12.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_notifications_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_notifications_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "user_notifications_list";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
