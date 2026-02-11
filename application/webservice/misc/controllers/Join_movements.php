<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Join Movements Controller
 *
 * @category webservice
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Join Movements
 *
 * @class Join_movements.php
 *
 * @path application\webservice\misc\controllers\Join_movements.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 10.08.2022
 */

class Join_movements extends Cit_Controller
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
            "query_4",
            "join_delete_movement",
            "leave_update_movement",
            "get_moment_joint_info",
            "movement_owner_details",
            "join_insert_movement",
            "get_active_record",
            "get_users_details",
            "privet_movement_con",
            "notification_user",
            "get_private_movements",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->model('join_movements_model');
        $this->load->model("misc/movement_users_model");
        $this->load->model("post/movements_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_join_movements method is used to validate api input params.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_join_movements($request_arr = array())
    {
        $valid_arr = array(
            "movements_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "movements_id_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "join_movements");

        return $valid_res;
    }

    /**
     * start_join_movements method is used to initiate api execution flow.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_join_movements($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_join_movements($request_arr);
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

            $input_params = $this->query_4($input_params);

            $condition_res = $this->condition_for_success($input_params);
            if ($condition_res["success"])
            {

                $condition_res = $this->condition_for_admin_status($input_params);
                if ($condition_res["success"])
                {

                    $condition_res = $this->condition_visibility_status($input_params);
                    if ($condition_res["success"])
                    {

                        $output_response = $this->movement_users_finish_success_5($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $condition_res = $this->condition_active_status($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->join_delete_movement($input_params);

                            $output_response = $this->movement_users_finish_success_1($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $input_params = $this->leave_update_movement($input_params);

                            $input_params = $this->get_moment_joint_info($input_params);

                            $output_response = $this->movement_users_finish_success_2($input_params);
                            return $output_response;
                        }
                    }
                }

                else
                {

                    $output_response = $this->movement_users_finish_success($input_params);
                    return $output_response;
                }
            }

            else
            {

                $input_params = $this->movement_owner_details($input_params);

                $condition_res = $this->condition_for_public_visibility($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->join_insert_movement($input_params);

                    $input_params = $this->get_active_record($input_params);

                    $output_response = $this->movement_users_finish_success_3($input_params);
                    return $output_response;
                }

                else
                {

                    $input_params = $this->get_users_details($input_params);

                    $input_params = $this->privet_movement_con($input_params);

                    $input_params = $this->notification_user($input_params);

                    $condition_res = $this->condition_for_private($input_params);
                    if ($condition_res["success"])
                    {

                        $condition_res = $this->condition_for_device_token($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->push_notification($input_params);
                        }

                        $input_params = $this->get_private_movements($input_params);

                        $output_response = $this->movement_users_finish_success_6($input_params);
                        return $output_response;
                    }

                    else
                    {

                        $output_response = $this->movement_users_finish_success_4($input_params);
                        return $output_response;
                    }
                }
            }
        }
        catch(Exception $e)
        {
            $message = $e->getMessage();
        }
        return $output_response;
    }

    /**
     * query_4 method is used to process query block.
     * @created Rohit Patidar | 09.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function query_4($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->query_4($movements_id, $user_id);
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
        $input_params["query_4"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_success method is used to process conditions.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_success($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["query_4"]) ? 0 : 1);
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
     * condition_for_admin_status method is used to process conditions.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_admin_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["mu_admin_status"];
            $cc_ro_0 = "Yes";

            $cc_fr_0 = ($cc_lo_0 != $cc_ro_0) ? TRUE : FALSE;
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
     * condition_visibility_status method is used to process conditions.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_visibility_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["m_visibility"];
            $cc_ro_0 = "Private";

            $cc_fr_0 = ($cc_lo_0 == $cc_ro_0) ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["mu_status"];
            $cc_ro_1 = "Pending";

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
            if (!$cc_fr_1)
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
     * movement_users_finish_success_5 method is used to process finish flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_5($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success_5",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * condition_active_status method is used to process conditions.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_active_status($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["mu_status"];
            $cc_ro_0 = "Active";

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
     * join_delete_movement method is used to process query block.
     * @created Alpesh Patel | 10.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function join_delete_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $this->block_result = $this->movement_users_model->join_delete_movement($user_id, $movements_id);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["join_delete_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 14.09.2021
     * @modified Rohit Patidar | 27.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * leave_update_movement method is used to process query block.
     * @created Alpesh Patel | 10.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function leave_update_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["movements_id"]))
            {
                $where_arr["movements_id"] = $input_params["movements_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $where_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["movements_id"]))
            {
                $params_arr["movements_id"] = $input_params["movements_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_estatus"] = "Active";
            $params_arr["_dupdateddate"] = "NOW()";
            $this->block_result = $this->movement_users_model->leave_update_movement($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["leave_update_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_moment_joint_info method is used to process query block.
     * @created Rohit Patidar | 13.09.2021
     * @modified Rohit Patidar | 13.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_moment_joint_info($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $mu_movement_id = isset($input_params["mu_movement_id"]) ? $input_params["mu_movement_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->get_moment_joint_info($mu_movement_id, $user_id);
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
        $input_params["get_moment_joint_info"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_2 method is used to process finish flow.
     * @created Alpesh Patel | 10.09.2021
     * @modified Rohit Patidar | 14.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_2($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_2",
        );
        $output_fields = array(
            'mu_status_1',
            'mu_user_id_1',
            'mu_movement_id_1',
        );
        $output_keys = array(
            'get_moment_joint_info',
        );
        $ouput_aliases = array(
            "mu_status_1" => "status",
            "mu_user_id_1" => "user_id",
            "mu_movement_id_1" => "movement_id",
        );
        $output_objects = array(
            "get_moment_joint_info",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["output_objects"] = $output_objects;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success method is used to process finish flow.
     * @created Alpesh Patel | 10.09.2021
     * @modified Alpesh Patel | 10.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_owner_details method is used to process query block.
     * @created Rohit Patidar | 17.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function movement_owner_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $this->block_result = $this->movements_model->movement_owner_details($movements_id);
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
        $input_params["movement_owner_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_public_visibility method is used to process conditions.
     * @created Rohit Patidar | 16.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_public_visibility($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["m_visibility_1"];
            $cc_ro_0 = "Public";

            $cc_in_0 = (is_array($cc_ro_0)) ? $cc_ro_0 : explode(",", $cc_ro_0);
            $cc_fr_0 = (in_array($cc_lo_0, $cc_in_0)) ? TRUE : FALSE;
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
     * join_insert_movement method is used to process query block.
     * @created Alpesh Patel | 10.09.2021
     * @modified Rohit Patidar | 23.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function join_insert_movement($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["movements_id"]))
            {
                $params_arr["movements_id"] = $input_params["movements_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $params_arr["_estatus"] = "Active";
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dupdateddate"] = "NOW()";
            $params_arr["_eadminstatus"] = "No";
            $this->block_result = $this->movement_users_model->join_insert_movement($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["join_insert_movement"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * get_active_record method is used to process query block.
     * @created Rohit Patidar | 14.09.2021
     * @modified Rohit Patidar | 14.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_active_record($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $movements_id = isset($input_params["movements_id"]) ? $input_params["movements_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->movement_users_model->get_active_record($movements_id, $user_id);
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
        $input_params["get_active_record"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_3 method is used to process finish flow.
     * @created Rohit Patidar | 14.09.2021
     * @modified Rohit Patidar | 07.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_3($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_3",
        );
        $output_fields = array(
            'mu_status_3',
            'mu_movement_id_3',
            'mu_user_id_3',
        );
        $output_keys = array(
            'get_active_record',
        );
        $ouput_aliases = array(
            "mu_status_3" => "status",
            "mu_movement_id_3" => "movement_id",
            "mu_user_id_3" => "user_id",
        );
        $output_objects = array(
            "get_active_record",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["output_objects"] = $output_objects;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * get_users_details method is used to process query block.
     * @created Rohit Patidar | 17.09.2021
     * @modified Rohit Patidar | 22.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_users_details($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $m_movement_name = isset($input_params["m_movement_name"]) ? $input_params["m_movement_name"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_users_details($m_movement_name, $user_id);
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
        $input_params["get_users_details"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * privet_movement_con method is used to process query block.
     * @created Rohit Patidar | 16.09.2021
     * @modified Rohit Patidar | 20.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function privet_movement_con($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            $params_arr["_estatus"] = "Pending";
            $params_arr["_dupdateddate"] = "Now()";
            if (isset($input_params["movements_id"]))
            {
                $params_arr["movements_id"] = $input_params["movements_id"];
            }
            $params_arr["_daddeddate"] = "now()";
            $params_arr["_eadminstatus"] = "No";
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            $this->block_result = $this->movement_users_model->privet_movement_con($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["privet_movement_con"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * notification_user method is used to process query block.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function notification_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["u_users_id_1"]))
            {
                $params_arr["u_users_id_1"] = $input_params["u_users_id_1"];
            }
            if (isset($input_params["notification_text"]))
            {
                $params_arr["notification_text"] = $input_params["notification_text"];
            }
            $params_arr["_etype"] = "MovementFollower";
            if (isset($input_params["m_movements_id"]))
            {
                $params_arr["m_movements_id"] = $input_params["m_movements_id"];
            }
            if (isset($input_params["uu_users_id"]))
            {
                $params_arr["uu_users_id"] = $input_params["uu_users_id"];
            }
            $params_arr["_eisread"] = "No";
            $params_arr["_vcode"] = "MR";
            $params_arr["_dtaddeddate"] = "now()";
            $params_arr["_ipostcommentid"] = "0";
            $params_arr["_itokboxsessionid"] = "0";
            $params_arr["_iuserfollowerid"] = "0";
            $params_arr["_ipostid"] = "0";
            $this->block_result = $this->user_notifications_model->notification_user($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["notification_user"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition_for_private method is used to process conditions.
     * @created Rohit Patidar | 20.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_private($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["privet_movement_con"]) ? 0 : 1);
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
     * condition_for_device_token method is used to process conditions.
     * @created Rohit Patidar | 21.09.2021
     * @modified Jay Rajput | 09.08.2022
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition_for_device_token($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["u_device_token_1"];

            $cc_fr_0 = (!is_null($cc_lo_0) && !empty($cc_lo_0) && trim($cc_lo_0) != "") ? TRUE : FALSE;
            if (!$cc_fr_0)
            {
                throw new Exception("Some conditions does not match.");
            }
            $cc_lo_1 = $input_params["u_notification_pref"];
            $cc_ro_1 = 1;

            $cc_fr_1 = ($cc_lo_1 == $cc_ro_1) ? TRUE : FALSE;
            if (!$cc_fr_1)
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
     * push_notification method is used to process mobile push notification.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function push_notification($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["u_device_token_1"];
            $code = "MR";
            $sound = "";
            $badge = $input_params["notification_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#notification_text# ";
            $push_msg = $this->general->getReplacedInputParams($push_msg, $input_params);
            $send_mode = "runtime";

            $send_arr = array();
            $send_arr['device_id'] = $device_id;
            $send_arr['code'] = $code;
            $send_arr['sound'] = $sound;
            $send_arr['badge'] = intval($badge);
            $send_arr['silent'] = $silent;
            $send_arr['title'] = $title;
            $send_arr['message'] = $push_msg;
            $send_arr['variables'] = json_encode($send_vars);
            $send_arr['send_mode'] = $send_mode;
            $uni_id = $this->general->insertPushNotification($send_arr);
            if (!$uni_id)
            {
                throw new Exception('Failure in insertion of push notification batch entry.');
            }

            $success = 1;
            $message = "Push notification send succesfully.";
        }
        catch(Exception $e)
        {
            $success = 0;
            $message = $e->getMessage();
        }
        $this->block_result["success"] = $success;
        $this->block_result["message"] = $message;
        $input_params["push_notification"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * get_private_movements method is used to process query block.
     * @created Rohit Patidar | 21.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_private_movements($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $insert_id1 = isset($input_params["insert_id1"]) ? $input_params["insert_id1"] : "";
            $this->block_result = $this->movement_users_model->get_private_movements($insert_id1);
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
        $input_params["get_private_movements"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * movement_users_finish_success_6 method is used to process finish flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 22.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_6($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "movement_users_finish_success_6",
        );
        $output_fields = array(
            'mu_movement_id_4',
            'mu_user_id_4',
            'mu_status_4',
        );
        $output_keys = array(
            'get_private_movements',
        );
        $ouput_aliases = array(
            "mu_movement_id_4" => "movement_id",
            "mu_user_id_4" => "user_id",
            "mu_status_4" => "status",
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["output_alias"] = $ouput_aliases;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * movement_users_finish_success_4 method is used to process finish flow.
     * @created Rohit Patidar | 20.09.2021
     * @modified Rohit Patidar | 21.09.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function movement_users_finish_success_4($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "movement_users_finish_success_4",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "join_movements";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
