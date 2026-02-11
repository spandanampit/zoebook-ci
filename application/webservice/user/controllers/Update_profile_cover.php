<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update Profile Cover Controller
 *
 * @category webservice
 *
 * @package user
 *
 * @subpackage controllers
 *
 * @module Update Profile Cover
 *
 * @class Update_profile_cover.php
 *
 * @path application\webservice\user\controllers\Update_profile_cover.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 31.08.2022
 */

class Update_profile_cover extends Cit_Controller
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
            "update_profile_cover",
        );
        $this->multiple_keys = array(
            "get_csv_height",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('update_profile_cover_model');
        $this->load->model("user/users_model");
    }

    /**
     * rules_update_profile_cover method is used to validate api input params.
     * @created Nandini Santoki | 31.03.2020
     * @modified Jay Rajput | 31.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_update_profile_cover($request_arr = array())
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

        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "update_profile_cover");
        return $valid_res;
    }

    /**
     * start_update_profile_cover method is used to initiate api execution flow.
     * @created Nandini Santoki | 31.03.2020
     * @modified Jay Rajput | 31.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_update_profile_cover($request_arr = array(), $inner_api = FALSE)
    {

        try
        {
            
            $validation_res = $this->rules_update_profile_cover($request_arr);
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

            $input_params = $this->get_csv_height($input_params);

            $input_params = $this->update_profile_cover($input_params);

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
     * get_csv_height method is used to process custom function.
     * @created Rohit Patidar | 03.06.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_csv_height($input_params = array())
    {
        if (!method_exists($this->general, "getCvFileHieght"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->getCvFileHieght($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["get_csv_height"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * update_profile_cover method is used to process query block.
     * @created Nandini Santoki | 31.03.2020
     * @modified Jay Rajput | 31.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_profile_cover($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($_FILES["cover_photo"]["name"]) && isset($_FILES["cover_photo"]["tmp_name"]))
            {
                $sent_file = $_FILES["cover_photo"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["cover_photo"]["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                $images_arr["cover_photo"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["cover_photo"]["ext"], $_FILES["cover_photo"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["cover_photo"]["size"], $_FILES["cover_photo"]["size"]))
                    {
                        $images_arr["cover_photo"]["name"] = $file_name;
                    }
                }
            }
            if (isset($_FILES["profile_image"]["name"]) && isset($_FILES["profile_image"]["tmp_name"]))
            {
                $sent_file = $_FILES["profile_image"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["profile_image"]["ext"] = "jpg,gif,jpeg,png";
                $images_arr["profile_image"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["profile_image"]["ext"], $_FILES["profile_image"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["profile_image"]["size"], $_FILES["profile_image"]["size"]))
                    {
                        $images_arr["profile_image"]["name"] = $file_name;
                    }
                }
            }
            if (isset($images_arr["cover_photo"]["name"]))
            {
                $params_arr["cover_photo"] = $images_arr["cover_photo"]["name"];
            }
            $params_arr["_dtmodifieddate"] = "NOW()";
            if (isset($images_arr["profile_image"]["name"]))
            {
                $params_arr["profile_image"] = $images_arr["profile_image"]["name"];
            }
            if (isset($input_params["cover_y_dimention"]))
            {
                $params_arr["cover_y_dimention"] = $input_params["cover_y_dimention"];
            }
            if (isset($input_params["height"]))
            {
                $params_arr["height"] = $input_params["height"];
            }
            if (isset($input_params["width"]))
            {
                $params_arr["width"] = $input_params["width"];
            }
            $this->block_result = $this->users_model->update_profile_cover($params_arr, $where_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("updation failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["cover_photo"]["name"]))
            {

                $file_path = "cover_photo";
                $file_name = $images_arr["cover_photo"]["name"];
                $file_tmp_path = $_FILES["cover_photo"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
            if (!empty($images_arr["profile_image"]["name"]))
            {

                $file_path = "compress_profile_image";
                $file_name = $images_arr["profile_image"]["name"];
                $file_tmp_path = $_FILES["profile_image"]["tmp_name"];
                $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                if (!$response)
                {
                    //file upload failed

                }
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_profile_cover"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);
        return $input_params;
    }

    /**
     * users_finish_success method is used to process finish flow.
     * @created Nandini Santoki | 31.03.2020
     * @modified Jay Rajput | 20.07.2022
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
            'affected_rows',
        );
        $output_keys = array(
            'update_profile_cover',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_profile_cover";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
