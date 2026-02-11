<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Add movement  image Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Add movement  image
 *
 * @class Add_movement_image.php
 *
 * @path application\webservice\post\controllers\Add_movement_image.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Add_movement_image extends Cit_Controller
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
            "get_movement",
            "insert_movement_image",
        );
        $this->multiple_keys = array(
            "get_moment_file_height_width",
            "get_movement_file",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('add_movement_image_model');
        $this->load->model("post/movements_model");
        $this->load->model("post/movement_images_model");
    }

    /**
     * rules_add_movement_image method is used to validate api input params.
     * @created Rohit Patidar | 06.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_add_movement_image($request_arr = array())
    {
        $valid_arr = array(
            "media_type" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "media_type_required",
                )
            ),
            "movements_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movements_id_required",
                )
            ),
            "platform" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "platform_required",
                )
            ),
            "upload_file" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "upload_file_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "add_movement_image");

        return $valid_res;
    }

    /**
     * start_add_movement_image method is used to initiate api execution flow.
     * @created Rohit Patidar | 06.09.2021
     * @modified Jay Rajput | 21.07.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_add_movement_image($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_add_movement_image($request_arr);
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

            $input_params = $this->get_movement($input_params);

            $condition_res = $this->condition_for_get_moment($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->get_moment_file_height_width($input_params);

                $input_params = $this->insert_movement_image($input_params);

                $input_params = $this->get_movement_file($input_params);

                $condition_res = $this->condition_for_checking_insert_moment($input_params);
                if ($condition_res["success"])
                {

                    $output_response = $this->movements_finish_success($input_params);
                    return $output_response;
                }

                else
                {

                    $output_response = $this->movements_finish_false_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->false_success($input_params);
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
     * get_movement method is used to process query block.
     * @created Rohit Patidar | 06.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movements_model->get_movement($movements_id, $user_id);
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
        $input_params["get_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_get_moment method is used to process conditions.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_moment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_movement"]) ? 0 : 1);
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
     * get_moment_file_height_width method is used to process custom function.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_moment_file_height_width($input_params = array())
    {
        if (!method_exists($this->general, "getMovementFileHeightWidth"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->general->getMovementFileHeightWidth($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["get_moment_file_height_width"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * insert_movement_image method is used to process query block.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_movement_image($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($_FILES["upload_file"]["name"]) && isset($_FILES["upload_file"]["tmp_name"]))
            {
                $sent_file = $_FILES["upload_file"]["name"];
            }
            else
            {
                $sent_file = "";
            }
            if (!empty($sent_file))
            {
                list($file_name, $ext) = $this->general->get_file_attributes($sent_file);
                $images_arr["upload_file"]["ext"] = "jpg,jpeg,png,gif";
                $images_arr["upload_file"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["upload_file"]["ext"], $_FILES["upload_file"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["upload_file"]["size"], $_FILES["upload_file"]["size"]))
                    {
                        $images_arr["upload_file"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["movements_id"]))
            {
                $params_arr["movements_id"] = $input_params["movements_id"];
            }
            if (isset($images_arr["upload_file"]["name"]))
            {
                $params_arr["upload_file"] = $images_arr["upload_file"]["name"];
            }
            if (isset($input_params["media_type"]))
            {
                $params_arr["media_type"] = $input_params["media_type"];
            }
            if (isset($input_params["video_tumbnail"]))
            {
                $params_arr["video_tumbnail"] = $input_params["video_tumbnail"];
            }
            if (isset($input_params["width"]))
            {
                $params_arr["width"] = $input_params["width"];
            }
            if (isset($input_params["height"]))
            {
                $params_arr["height"] = $input_params["height"];
            }
            $params_arr["_daddeddate"] = "now()";
            $params_arr["_dmodifieddate"] = "now()";
            $params_arr["_estatus"] = "Active";
            $this->block_result = $this->movement_images_model->insert_movement_image($params_arr);
            if (!$this->block_result["success"])
            {
                throw new Exception("Insertion failed.");
            }
            $data_arr = $this->block_result["array"];
            $upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["upload_file"]["name"]))
            {

                $file_path = "compress_movements_files";
                $folder_id = trim($data_arr[0]["iMovementsId"]);
                $file_path = $file_path."/".$folder_id;
                $file_name = $images_arr["upload_file"]["name"];
                $file_tmp_path = $_FILES["upload_file"]["tmp_name"];
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
        $input_params["insert_movement_image"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_movement_file method is used to process query block.
     * @created Rohit Patidar | 13.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_file($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $this->block_result = $this->movement_images_model->get_movement_file($movements_id);
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

                    $data = $data_arr["mi_upload_file"];
                    $image_arr = array();
                    $image_arr["image_name"] = $data;
                    $image_arr["ext"] = implode(",", $this->config->item("IMAGE_EXTENSION_ARR"));
                    $p_key = ($data_arr["mi_movements_id"] != "") ? $data_arr["mi_movements_id"] : $input_params["mi_movements_id"];
                    $image_arr["pk"] = $p_key;
                    $image_arr["no_img"] = FALSE;
                    $image_arr["path"] = "compress_movements_files";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["mi_upload_file"] = $data;

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
        $input_params["get_movement_file"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_checking_insert_moment method is used to process conditions.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_checking_insert_moment($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_movement_image"]) ? 0 : 1);
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
     * movements_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success",
        );
        $output_fields = array(
            'mi_movement_images_id',
            'mi_movements_id',
            'mi_media_type',
            'mi_upload_file',
        );
        $output_keys = array(
            'get_movement_file',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_movement_image";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_false_1 method is used to process finish flow.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_false_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_false_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_movement_image";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * false_success method is used to process finish flow.
     * @created Rohit Patidar | 07.09.2021
     * @modified Jay Rajput | 20.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function false_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "false_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "add_movement_image";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
