<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update movement follow count And Users Follow count Controller
 *
 * @category notification
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Update movement follow count And Users Follow count
 *
 * @class Update_movement_follow_count_and_users_follow_count.php
 *
 * @path application\notifications\user\controllers\Update_movement_follow_count_and_users_follow_count.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 25.04.2022
 */

class Update_movement_follow_count_and_users_follow_count extends Cit_Controller
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
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('notifyresponse');
        $this->load->model('update_movement_follow_count_and_users_follow_count_model');
    }

    /**
     * start_update_movement_follow_count_and_users_follow_count method is used to initiate api execution flow.
     * @created Rohit Patidar | 25.04.2022
     * @modified Rohit Patidar | 25.04.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $output_response returns output response of API.
     */
    public function start_update_movement_follow_count_and_users_follow_count($request_arr = array())
    {
        try
        {
            $output_response = array();
            $input_params = $request_arr;
            $output_array = array();

            $input_params = $this->custom_function($input_params);

            $output_response = $this->finish_success($input_params);
            return $output_response;
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * custom_function method is used to process custom function.
     * @created Rohit Patidar | 25.04.2022
     * @modified Rohit Patidar | 25.04.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
    {
        if (!method_exists($this, "AddedCustumQuery"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->AddedCustumQuery($input_params);
        }
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $result_arr["data"]);

        $input_params["custom_function"] = $this->notifyresponse->assignFunctionResponse($result_arr);

        return $input_params;
    }

    /**
     * finish_success method is used to process finish flow.
     * @created Rohit Patidar | 25.04.2022
     * @modified Rohit Patidar | 25.04.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "Success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_movement_follow_count_and_users_follow_count";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $responce_arr = $this->notifyresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
