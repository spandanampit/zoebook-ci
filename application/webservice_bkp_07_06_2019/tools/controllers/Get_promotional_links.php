<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Get Promotional Links Controller
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage controllers
 *
 * @module Get Promotional Links
 *
 * @class Get_promotional_links.php
 *
 * @path application\webservice\tools\controllers\Get_promotional_links.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 04.10.2018
 */

class Get_promotional_links extends Cit_Controller
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
            "promotional_links",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('get_promotional_links_model');
        $this->load->model("tools/setting_model");
    }

    /**
     * rules_get_promotional_links method is used to validate api input params.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_get_promotional_links($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "get_promotional_links");

        return $valid_res;
    }

    /**
     * start_get_promotional_links method is used to initiate api execution flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_get_promotional_links($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_get_promotional_links($request_arr);
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

            $input_params = $this->promotional_links($input_params);

            $output_response = $this->success($input_params);
            return $output_response;
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * promotional_links method is used to process query block.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function promotional_links($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->setting_model->promotional_links();
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
        $input_params["promotional_links"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * success method is used to process finish flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
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
            'play_store_link',
            'app_store_link',
            'facebook_link',
            'google_plus_link',
        );
        $output_keys = array(
            'promotional_links',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "get_promotional_links";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
