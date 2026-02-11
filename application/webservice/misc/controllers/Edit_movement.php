<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Edit movement Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Edit movement
 *
 * @class Edit_movement.php
 *
 * @path application\webservice\misc\controllers\Edit_movement.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.08.2022
 */

class Edit_movement extends Cit_Controller
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
            "movements_exits",
            "update_movements",
            "update_movement_users",
            "user_notification_query_block",
            "delete_form_movement_image",
        );
        $this->multiple_keys = array(
            "get_movement_image",
            "delete_media_from_folder_block",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('edit_movement_model');
        $this->load->model("post/movements_model");
        $this->load->model("misc/movement_users_model");
        $this->load->model("user/user_notifications_model");
        $this->load->model("post/movement_images_model");
    }

    /**
     * rules_edit_movement method is used to validate api input params.
     * @created Rohit Patidar | 06.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_edit_movement($request_arr = array())
    {
        $valid_arr = array(
            "movements_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movements_id_required",
                )
            ),
            "movement_name" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movement_name_required",
                )
            ),
            "theme" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "theme_required",
                )
            ),
            "user_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "user_id_required",
                )
            ),
            "visibility" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "visibility_required",
                )
            )
        );
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "edit_movement");

        return $valid_res;
    }

    /**
     * start_edit_movement method is used to initiate api execution flow.
     * @created Rohit Patidar | 06.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_edit_movement($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_edit_movement($request_arr);
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

            $input_params = $this->movements_exits($input_params);

            $condition_res = $this->condition_for_moment_exists($input_params);
            if ($condition_res["success"])
            {

                $input_params = $this->update_movements($input_params);

                $condition_res = $this->condition_for_updating_moments($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->check_condition_visibility($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->update_movement_users($input_params);

                        $input_params = $this->user_notification_query_block($input_params);
                    }

                    $condition_res = $this->condition_for_moment_image($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->get_movement_image($input_params);

                        $condition_res = $this->condition_for_get_moment_images($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->delete_media_from_folder_block($input_params);

                            $input_params = $this->delete_form_movement_image($input_params);

                            $output_response = $this->movements_finish_success_2($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $output_response = $this->movements_finish_success_4($input_params);
                            return $output_response;
                        }
                    }

                    else
                    {

                        $output_response = $this->movements_finish_success_3($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->movements_finish_success_1($input_params);
                    return $output_response;
                }
            }

            else
            {

                $output_response = $this->movements_finish_success($input_params);
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
     * movements_exits method is used to process query block.
     * @created Rohit Patidar | 08.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function movements_exits($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movements_model->movements_exits($movements_id, $user_id);
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
        $input_params["movements_exits"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_moment_exists method is used to process conditions.
     * @created Rohit Patidar | 08.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_moment_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["movements_exits"]) ? 0 : 1);
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
     * update_movements method is used to process query block.
     * @created Rohit Patidar | 08.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_movements($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["movements_id"]))
            {
                $where_arr["movements_id"] = $input_params["movements_id"];
            }
            if (isset($input_params["movement_name"]))
            {
                $params_arr["movement_name"] = $input_params["movement_name"];
            }
            if (isset($input_params["description"]))
            {
                $params_arr["description"] = $input_params["description"];
            }
            if (isset($input_params["theme"]))
            {
                $params_arr["theme"] = $input_params["theme"];
            }
            if (isset($input_params["visibility"]))
            {
                $params_arr["visibility"] = $input_params["visibility"];
            }
            $params_arr["_dmodifieddate"] = "now()";
            $this->block_result = $this->movements_model->update_movements($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_movements"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_updating_moments method is used to process conditions.
     * @created Rohit Patidar | 08.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_updating_moments($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["update_movements"]) ? 0 : 1);
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
     * check_condition_visibility method is used to process conditions.
     * @created Alpesh Patel | 24.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function check_condition_visibility($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["update_movements"]) ? 0 : 1);
            $cc_ro_0 = 1;

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["m_visibility"];
            $cc_ro_1 = "Private";

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
            if (!$cc_fr_1)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_2 = $input_params["visibility"];
            $cc_ro_2 = "Public";

            $cc_fr_2 = ($cc_lo_2 == $cc_ro_2) ? TRUE : FALSE;
            if (!$cc_fr_2)
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
     * update_movement_users method is used to process query block.
     * @created Alpesh Patel | 24.09.2021
     * @modified Rohit Patidar | 24.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_movement_users($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["movements_id"]))
            {
                $where_arr["movements_id"] = $input_params["movements_id"];
            }
            $params_arr["_estatus"] = "Active";
            $params_arr["_dupdateddate"] = "NOW()";
            $this->block_result = $this->movement_users_model->update_movement_users($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_movement_users"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * user_notification_query_block method is used to process query block.
     * @created Alpesh Patel | 24.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function user_notification_query_block($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["movements_id"]))
            {
                $where_arr["movements_id"] = $input_params["movements_id"];
            }
            $params_arr["_emovementreadstatus"] = "Yes";
            $this->block_result = $this->user_notifications_model->user_notification_query_block($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["user_notification_query_block"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_moment_image method is used to process conditions.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_moment_image($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["movement_image_id"];

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
     * get_movement_image method is used to process query block.
     * @created Rohit Patidar | 09.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_movement_image($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movement_image_id = isset($input_params["movement_image_id"]) ? $input_params["movement_image_id"] : "";
            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $this->block_result = $this->movement_images_model->get_movement_image($movement_image_id, $movements_id);
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
        $input_params["get_movement_image"] = $this->block_result["data"];

        return $input_params;
    }

    /**
     * condition_for_get_moment_images method is used to process conditions.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_get_moment_images($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["get_movement_image"]) ? 0 : 1);
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
     * delete_media_from_folder_block method is used to process custom function.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_media_from_folder_block($input_params = array())
    {
        if (!method_exists($this, "delete_media_from_folder"))
        {
            $result_arr["data"] = array();
        }
        else
        {
            $result_arr["data"] = $this->delete_media_from_folder($input_params);
        }
        $format_arr = $result_arr;

        $format_arr = $this->wsresponse->assignFunctionResponse($format_arr);
        $input_params["delete_media_from_folder_block"] = $format_arr;

        $input_params = $this->wsresponse->assignSingleRecord($input_params, $format_arr);
        return $input_params;
    }

    /**
     * delete_form_movement_image method is used to process query block.
     * @created Rohit Patidar | 09.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function delete_form_movement_image($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $movement_image_id = isset($input_params["movement_image_id"]) ? $input_params["movement_image_id"] : "";
            $this->block_result = $this->movement_images_model->delete_form_movement_image($movements_id, $movement_image_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["delete_form_movement_image"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movements_finish_success_2 method is used to process finish flow.
     * @created Rohit Patidar | 08.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success_2",
        );
        $output_fields = array(
            'm_movements_id',
        );
        $output_keys = array(
            'movements_exits',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_movement";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success_4 method is used to process finish flow.
     * @created Rohit Patidar | 09.09.2021
     * @modified Rohit Patidar | 01.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_success_4",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_movement";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 01.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movements_finish_success_3",
        );
        $output_fields = array(
            'm_movements_id',
        );
        $output_keys = array(
            'movements_exits',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_movement";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 08.09.2021
     * @modified Rohit Patidar | 09.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_movement";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movements_finish_success method is used to process finish flow.
     * @created Rohit Patidar | 08.09.2021
     * @modified Rohit Patidar | 08.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movements_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movements_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "edit_movement";
        $func_array["function"]["single_keys"] = $this->single_keys;
        $func_array["function"]["multiple_keys"] = $this->multiple_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
