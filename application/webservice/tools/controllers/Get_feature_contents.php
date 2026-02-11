<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Get Feature Contents Controller
 *
 * @category webservice
 *
 * @package tools
 *
 * @subpackage controllers
 *
 * @module Get Feature Contents
 *
 * @class Get_feature_contents.php
 *
 * @path application\webservice\tools\controllers\Get_feature_contents.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 04.10.2018
 */

class Get_feature_contents extends Cit_Controller
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
            "feature_contents",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('get_feature_contents_model');
        $this->load->model("tools/feature_content_model");
    }

    /**
     * rules_get_feature_contents method is used to validate api input params.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Vamsi Ippe | 03.10.2018
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_get_feature_contents($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "get_feature_contents");

        return $valid_res;
    }

    /**
     * start_get_feature_contents method is used to initiate api execution flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Vamsi Ippe | 03.10.2018
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_get_feature_contents($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_get_feature_contents($request_arr);
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

            $input_params = $this->feature_contents($input_params);

            $condition_res = $this->data_found($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->failure($input_params);
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
     * feature_contents method is used to process query block.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function feature_contents($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->feature_content_model->feature_contents();
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

                    $data = $data_arr["feature_icon"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["height"] = "50";
                    $image_arr["width"] = "50";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["path"] = $this->general->getImageNestedFolders("promotional_screenshots");
                    $data = $this->general->get_image($image_arr);

                    $result_arr[$data_key]["feature_icon"] = $data;

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
        $input_params["feature_contents"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * data_found method is used to process conditions.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function data_found($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["feature_contents"]) ? 0 : 1);
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
            'feature_content_id',
            'feature_title',
            'feature_content',
            'feature_icon',
            'sequence',
        );
        $output_keys = array(
            'feature_contents',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "get_feature_contents";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * failure method is used to process finish flow.
     * @created Bhagya Rachana | 03.10.2018
     * @modified Bhagya Rachana | 03.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "get_feature_contents";
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
