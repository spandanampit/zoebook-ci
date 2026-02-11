<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update cover heigh width Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Update cover heigh width
 *
 * @class Update_cover_heigh_width.php
 *
 * @path application\webservice\misc\controllers\Update_cover_heigh_width.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Update_cover_heigh_width extends Cit_Controller
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
            "get_users_record",
            "custom_function",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('update_cover_heigh_width_model');
        $this->load->model("user/users_model");
    }

    /**
     * rules_update_cover_heigh_width method is used to validate api input params.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_update_cover_heigh_width($request_arr = array())
    {
        $valid_arr = array();
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "update_cover_heigh_width");

        return $valid_res;
    }

    /**
     * start_update_cover_heigh_width method is used to initiate api execution flow.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_update_cover_heigh_width($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_update_cover_heigh_width($request_arr);
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

            $input_params = $this->get_users_record($input_params);

            $input_params = $this->custom_function($input_params);

            $output_response = $this->users_finish_success($input_params);
            return $output_response;
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * get_users_record method is used to process query block.
     * @created Rohit Patidar | 11.06.2021
     * @modified Jay Rajput | 03.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_users_record($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $this->block_result = $this->users_model->get_users_record();
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
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

                    $data = $data_arr["u_cover_photo"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_cover_photo";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_photo"] = $data;

                    $data = $data_arr["u_cover_video"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "covervideo_thumbnail";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_cover_video"] = $data;

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
        $input_params["get_users_record"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * custom_function method is used to process custom function.
     * @created Rohit Patidar | 11.06.2021
     * @modified Rohit Patidar | 11.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function custom_function($input_params = array())
    {
        if (!method_exists($this->general, "updateCoverFIleHeight"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->updateCoverFIleHeight($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["custom_function"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 11.06.2021
     * @modified Rohit Patidar | 11.06.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "users_finish_success",
        );
        $output_fields = array(
            'u_users_id',
            'u_name',
            'u_email',
            'u_phone',
            'u_profile_image',
            'u_cover_photo',
            'u_cv_height',
            'u_cv_width',
            'u_cover_video',
        );
        $output_keys = array(
            'get_users_record',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_cover_heigh_width";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
