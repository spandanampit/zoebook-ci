<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Application Version Status Controller
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage controllers
 *
 * @module Application Version Status
 *
 * @class Application_version_status.php
 *
 * @path application\webservice\tools\controllers\Application_version_status.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 12.10.2022
 */

class Application_version_status extends Cit_Controller
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
            "current_version",
            "user_detail",
            "make_device_token_null",
            "update_user_table",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('application_version_status_model');
        $this->load->model("misc/application_version_model");
        $this->load->model("user/users_model");
    }

    /**
     * rules_application_version_status method is used to validate api input params.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Jay Rajput | 12.10.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_application_version_status($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "application_version_status");

        return $valid_res;
    }

    /**
     * start_application_version_status method is used to initiate api execution flow.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Jay Rajput | 12.10.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_application_version_status($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_application_version_status($request_arr);
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

            $input_params = $this->current_version($input_params);

            $condition_res = $this->is_user_id_given($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->user_detail($input_params);

                $condition_res = $this->is_user_exist($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->is_device_token_not_empty($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->make_device_token_null($input_params);
                    }

                    $input_params = $this->update_user_table($input_params);

                    $output_response = $this->success1($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->unauthorised($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->success($input_params);
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
     * current_version method is used to process query block.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Jay Rajput | 08.09.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function current_version($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $version_number = isset($input_params["version_number"]) ? $input_params["version_number"] : "";
            $device_type = isset($input_params["device_type"]) ? $input_params["device_type"] : "";
            $this->block_result = $this->application_version_model->current_version($version_number, $device_type);
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
        $input_params["current_version"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * is_user_id_given method is used to process conditions.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 07.09.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_user_id_given($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];

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
     * user_detail method is used to process query block.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 08.09.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function user_detail($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->users_model->user_detail();
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
        $input_params["user_detail"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * is_user_exist method is used to process conditions.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 07.09.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_user_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id_db"];
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
     * is_device_token_not_empty method is used to process conditions.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 07.09.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function is_device_token_not_empty($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["device_token"];

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
     * make_device_token_null method is used to process query block.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 07.09.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function make_device_token_null($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["device_token"]))
            {
                $where_arr["device_token"] = $input_params["device_token"];
            }
            $params_arr["_vdevicetoken"] = "NULL";
            $this->block_result = $this->users_model->make_device_token_null($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["make_device_token_null"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_user_table method is used to process query block.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 08.09.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_user_table($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["version_number"]))
            {
                $params_arr["version_number"] = $input_params["version_number"];
            }
            $params_arr["_dlastlogin"] = "NOW()";
            if (isset($input_params["device_token"]))
            {
                $params_arr["device_token"] = $input_params["device_token"];
            }
            if (isset($input_params["other_info_json"]))
            {
                $params_arr["other_info_json"] = $input_params["other_info_json"];
            }
            $this->block_result = $this->users_model->update_user_table($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_user_table"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * success1 method is used to process finish flow.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Jay Rajput | 12.10.2022
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
            'version_name',
            'force_update',
            'version_number1',
            'device_type1',
            'date_added',
            'app_update_code',
            'force_logout',
        );
        $output_keys = array(
            'current_version',
            'user_detail',
        );
        $ouput_aliases = array(
            "version_number1" => "version_number",
            "device_type1" => "device_type",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "application_version_status";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * unauthorised method is used to process finish flow.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Jay Rajput | 12.10.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function unauthorised($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "unauthorised",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "application_version_status";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * success method is used to process finish flow.
     * @created Raj Kapuriya | 07.09.2022
     * @modified Raj Kapuriya | 07.09.2022
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
            'version_name',
            'force_update',
            'version_number1',
            'device_type1',
            'date_added',
            'app_update_code',
            'force_logout',
        );
        $output_keys = array(
            'current_version',
            'user_detail',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "application_version_status";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
