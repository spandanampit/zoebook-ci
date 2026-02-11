<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Update viral post to public Controller
 *
 * @category notification
 *
 * @package misc
 *
 * @subpackage controllers
 *
 * @module Update viral post to public
 *
 * @class Update_viral_post_to_public.php
 *
 * @path application\notifications\misc\controllers\Update_viral_post_to_public.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 08.05.2019
 */

class Update_viral_post_to_public extends Cit_Controller
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
            "update_viral_post",
        );
        $this->block_result = array();

        $this->load->library('notifyresponse');
        $this->load->model('update_viral_post_to_public_model');
        $this->load->model("post/post_model");
    }

    /**
     * start_update_viral_post_to_public method is used to initiate api execution flow.
     * @created Vamsi Ippe | 02.05.2019
     * @modified Vamsi Ippe | 08.05.2019
     * @param array $request_arr request_arr array is used for api input.
     * @return array $output_response returns output response of API.
     */
    public function start_update_viral_post_to_public($request_arr = array())
    {
        try
        {
            $output_response = array();
            $input_params = $request_arr;
            $output_array = array();

            $input_params = $this->update_viral_post($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->finish_success($input_params);
                return $output_response;
            }

            else
            {

                $output_response = $this->post_finish_success($input_params);
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
     * update_viral_post method is used to process query block.
     * @created Vamsi Ippe | 02.05.2019
     * @modified Vamsi Ippe | 08.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_viral_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            $params_arr["_evisibility"] = "Public";
            $this->block_result = $this->post_model->update_viral_post($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_viral_post"] = $this->block_result["data"];
        $input_params = $this->notifyresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Vamsi Ippe | 02.05.2019
     * @modified Vamsi Ippe | 02.05.2019
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["affected_rows"];
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
     * finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 02.05.2019
     * @modified Vamsi Ippe | 02.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "Status updated succesfully",
        );
        $output_fields = array(
            'affected_rows',
        );
        $output_keys = array(
            'update_viral_post',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_viral_post_to_public";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $responce_arr = $this->notifyresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 02.05.2019
     * @modified Vamsi Ippe | 02.05.2019
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "No posts expired.",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "update_viral_post_to_public";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $responce_arr = $this->notifyresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
