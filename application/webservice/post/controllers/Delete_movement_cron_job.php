<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Delete movement cron job Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Delete movement cron job
 *
 * @class Delete_movement_cron_job.php
 *
 * @path application\webservice\post\controllers\Delete_movement_cron_job.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Delete_movement_cron_job extends Cit_Controller
{
    public $settings_params;
    public $output_params;
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
        $this->multiple_keys = array(
            "delete_custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('delete_movement_cron_job_model');
    }

    /**
     * rules_delete_movement_cron_job method is used to validate api input params.
     * @created Rohit Patidar | 24.11.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_delete_movement_cron_job($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "delete_movement_cron_job");

        return $valid_res;
    }

    /**
     * start_delete_movement_cron_job method is used to initiate api execution flow.
     * @created Rohit Patidar | 24.11.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_delete_movement_cron_job($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_delete_movement_cron_job($request_arr);
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

            $input_params = $this->delete_custom_function($input_params);

            $output_response = $this->movements_finish_success($input_params);
            return $output_response;
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * delete_custom_function method is used to process custom function.
     * @created Rohit Patidar | 24.11.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_custom_function($input_params = array())
    {
        if (!method_exists($this, "DeleteDataPhysically"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->DeleteDataPhysically($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["delete_custom_function"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * movements_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 24.11.2021
     * @modified Rohit Patidar | 24.11.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "delete_movement_cron_job";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
