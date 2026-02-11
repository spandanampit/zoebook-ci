<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Remove Notification Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Remove Notification
 *
 * @class Remove_notification.php
 *
 * @path application\webservice\user\controllers\Remove_notification.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Remove_notification extends Cit_Controller
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
            "remove_notification",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('remove_notification_model');
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_remove_notification method is used to validate api input params.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_remove_notification($request_arr = array())
    {
        $valid_arr = array(
            "notification_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "notification_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "remove_notification");

        return $valid_res;
    }

    /**
     * start_remove_notification method is used to initiate api execution flow.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_remove_notification($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_remove_notification($request_arr);
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

            $input_params = $this->remove_notification($input_params);

            $condition_res = $this->condition_for_remove_notification($input_params);
            if ($condition_res["success"])
            {

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
     * remove_notification method is used to process query block.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function remove_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $notification_id = isset($input_params["notification_id"]) ? $input_params["notification_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->user_notifications_model->remove_notification($notification_id, $user_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["remove_notification"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_remove_notification method is used to process conditions.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_remove_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["remove_notification"]) ? 0 : 1);
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
     * user_notifications_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Vamsi Ippe | 25.10.2018
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
            'affected_rows',
        );
        $output_keys = array(
            'remove_notification',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "remove_notification";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * user_notifications_finish_success_1 method is used to process finish flow.
     * @created Vamsi Ippe | 25.10.2018
     * @modified Vamsi Ippe | 25.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function user_notifications_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "user_notifications_finish_success_1",
        );
        $output_fields = array(
            'affected_rows',
        );
        $output_keys = array(
            'remove_notification',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "remove_notification";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
