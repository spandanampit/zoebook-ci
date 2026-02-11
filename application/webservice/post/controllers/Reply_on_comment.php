<?php
defined('BASEPATH') || exit('No direct script access allowed');

/**
 * Description of Reply on comment Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Reply on comment
 *
 * @class Reply_on_comment.php
 *
 * @path application\webservice\post\controllers\Reply_on_comment.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 16.08.2022
 */

class Reply_on_comment extends Cit_Controller
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
            "check_replied_post_exists",
            "check_replied_comment_exists",
            "insert_comment_reply",
            "get_commented_user_details_v1",
            "update_modifydate_movement_post",
            "insert_user_notify_commented_v1",
            "insert_user_notify_replied",
        );
        $this->block_result = array();

        $this->load->library('wsresponse');
        $this->load->library('cloudinarylib');
        $this->load->model('reply_on_comment_model');
        $this->load->model("post/post_model");
        $this->load->model("post/post_comment_model");
        $this->load->model("user/users_model");
        $this->load->model("user/user_notifications_model");
    }

    /**
     * rules_reply_on_comment method is used to validate api input params.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Jay Rajput | 16.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @return array $valid_res returns output response of API.
     */
    public function rules_reply_on_comment($request_arr = array())
    {
        $valid_arr = array(
            "post_comment_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_comment_id_required",
                )
            ),
            "post_id" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "post_id_required",
                )
            ),
            "reply_text" => array(
                array(
                    "rule" => "required",
                    "value" => TRUE,
                    "message" => "reply_text_required",
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
        $valid_res = $this->wsresponse->validateInputParams($valid_arr, $request_arr, "reply_on_comment");

        return $valid_res;
    }

    /**
     * start_reply_on_comment method is used to initiate api execution flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Jay Rajput | 16.08.2022
     * @param array $request_arr request_arr array is used for api input.
     * @param bool $inner_api inner_api flag is used to idetify whether it is inner api request or general request.
     * @return array $output_response returns output response of API.
     */
    public function start_reply_on_comment($request_arr = array(), $inner_api = FALSE)
    {
        try
        {
            $validation_res = $this->rules_reply_on_comment($request_arr);
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

            $input_params = $this->check_replied_post_exists($input_params);

            $condition_res = $this->condition($input_params);
            if ($condition_res["success"])
            {

                $output_response = $this->post_finish_success_1($input_params);
                return $output_response;
            }

            else
            {

                $condition_res = $this->cond_check_post_exist($input_params);
                if ($condition_res["success"])
                {

                    $input_params = $this->check_replied_comment_exists($input_params);

                    $condition_res = $this->cond_check_comment_exist($input_params);
                    if ($condition_res["success"])
                    {

                        $input_params = $this->insert_comment_reply($input_params);

                        $condition_res = $this->cond_insert_succes($input_params);
                        if ($condition_res["success"])
                        {

                            $input_params = $this->get_commented_user_details_v1($input_params);

                            $input_params = $this->update_modifydate_movement_post($input_params);

                            $condition_res = $this->cond_user_posted_user_check($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->insert_user_notify_commented_v1($input_params);

                                $condition_res = $this->cond_posted_notify_pref($input_params);
                                if ($condition_res["success"])
                                {

                                    $input_params = $this->notify_posted_user($input_params);
                                }
                            }

                            $condition_res = $this->cond_check_comment_user_id($input_params);
                            if ($condition_res["success"])
                            {

                                $input_params = $this->insert_user_notify_replied($input_params);

                                $condition_res = $this->cond_commented_user_notify_pref($input_params);
                                if ($condition_res["success"])
                                {

                                    $input_params = $this->notify_commented_user($input_params);
                                }
                            }

                            $output_response = $this->post_finish_success($input_params);
                            return $output_response;
                        }

                        else
                        {

                            $output_response = $this->reply_insert_failure($input_params);
                            return $output_response;
                        }
                    }

                    else
                    {

                        $output_response = $this->comment_check_failure($input_params);
                        return $output_response;
                    }
                }

                else
                {

                    $output_response = $this->post_check_failure($input_params);
                    return $output_response;
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
     * check_replied_post_exists method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 25.07.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_replied_post_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->post_model->check_replied_post_exists($post_id, $user_id);
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
        $input_params["check_replied_post_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * condition method is used to process conditions.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 25.10.2021
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function condition($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["m_status"];
            $cc_ro_0 = "Inactive";

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
     * post_finish_success_1 method is used to process finish flow.
     * @created Rohit Patidar | 25.10.2021
     * @modified Rohit Patidar | 26.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success_1($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_finish_success_1",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "reply_on_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * cond_check_post_exist method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_post_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_replied_post_exists"]) ? 0 : 1);
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
     * check_replied_comment_exists method is used to process query block.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function check_replied_comment_exists($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $post_comment_id = isset($input_params["post_comment_id"]) ? $input_params["post_comment_id"] : "";
            $post_id = isset($input_params["post_id"]) ? $input_params["post_id"] : "";
            $this->block_result = $this->post_comment_model->check_replied_comment_exists($post_comment_id, $post_id);
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
        $input_params["check_replied_comment_exists"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_check_comment_exist method is used to process conditions.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_comment_exist($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["check_replied_comment_exists"]) ? 0 : 1);
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
     * insert_comment_reply method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_comment_reply($input_params = array())
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
                $images_arr["upload_file"]["ext"] = "jpg,jpeg,png,gif,mp4,mov,wmv,avi,3gp,webp";
                $images_arr["upload_file"]["size"] = "102400";
                if ($this->general->validateFileFormat($images_arr["upload_file"]["ext"], $_FILES["upload_file"]["name"]))
                {
                    if ($this->general->validateFileSize($images_arr["upload_file"]["size"], $_FILES["upload_file"]["size"]))
                    {
                        $images_arr["upload_file"]["name"] = $file_name;
                    }
                }
            }
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["post_comment_id"]))
            {
                $params_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            if (isset($input_params["user_id"]))
            {
                $params_arr["user_id"] = $input_params["user_id"];
            }
            if (isset($input_params["reply_text"]))
            {
                $params_arr["reply_text"] = $input_params["reply_text"];
            }
            $params_arr["_daddeddate"] = "NOW()";
            $params_arr["_dmodifieddate"] = "NOW()";
            $params_arr["_estatus"] = "Active";
            if (isset($images_arr["upload_file"]["name"]))
            {
                $params_arr["upload_file"] = $images_arr["upload_file"]["name"];
            }
            // $this->block_result = $this->post_comment_model->insert_comment_reply($params_arr);
            // if (!$this->block_result["success"])
            // {
            //     throw new Exception("Insertion failed.");
            // }
            //$data_arr = $this->block_result["array"];
            //$upload_path = $this->config->item("upload_path");
            if (!empty($images_arr["upload_file"]["name"]))
            {

                if (strpos($_FILES['upload_file']['type'], 'image') !== false) {
                    $file_tmp_path = $_FILES["upload_file"]["tmp_name"];
                    
                    $response_cloud = \Cloudinary\Uploader::upload($file_tmp_path);
                    if ($response_cloud)
                    {
                        $params_arr['response'] = $response_cloud;

                        $this->block_result = $this->post_comment_model->insert_comment_reply($params_arr);
                        
                        if (!$this->block_result["success"])
                        {
                            throw new Exception("Insertion failed.");
                        }
                    }
                }elseif (strpos($_FILES['upload_file']['type'], 'video') !== false) {
                    
                    $name = str_replace(' ', '_', $_FILES['upload_file']['name']);
                    $tmp_name = $_FILES['upload_file']['tmp_name'];

                    $compress_file = $this->config->item('upload_path') . 'compress_video/'.$name;
                    $return_arr['compress_video_path']=$compress_file;
                    $input = $_FILES['upload_file']['tmp_name'];
                    $move = move_uploaded_file($input,$compress_file);

                    $name = $this->config->item('upload_path') . 'compress_video/'.$name;

                    $response = \Cloudinary\Uploader::upload($name, [
                        'resource_type' => 'video' ,
                        "upload_preset" => 'owa0qgdb',
                        'chunk_size' => 6000000000000000000]
                    );

                    if ($response)
                    {   
                        $params_arr['response'] = $response;

                        $this->block_result = $this->post_comment_model->insert_comment_reply($params_arr);
                        if (!$this->block_result["success"])
                        {
                            throw new Exception("Insertion failed.");
                        }
                    }

                } 

                // $file_path = "compress_post_video";
                // $folder_id = trim($data_arr[0]["iUserId"]);
                // $file_path = $file_path."/".$folder_id;
                // $file_name = $images_arr["upload_file"]["name"];
                // $file_tmp_path = $_FILES["upload_file"]["tmp_name"];
                // $response = $this->general->uploadAWSData($file_tmp_path, $file_path, $file_name);
                // if (!$response)
                // {
                //     //file upload failed

                // }
            }else{
                $this->block_result = $this->post_comment_model->insert_comment_reply($params_arr);
                if (!$this->block_result["success"])
                {
                    throw new Exception("Insertion failed.");
                }
            }
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_comment_reply"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_insert_succes method is used to process conditions.
     * @created CIT Dev Team
     * @modified ---
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_insert_succes($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = (empty($input_params["insert_comment_reply"]) ? 0 : 1);
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
     * get_commented_user_details_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Jay Rajput | 16.08.2022
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function get_commented_user_details_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $user_id = isset($input_params["user_id"]) ? $input_params["user_id"] : "";
            $this->block_result = $this->users_model->get_commented_user_details_v1($user_id);
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
                    $image_arr["width"] = "50";
                    $image_arr["height"] = "50";
                    $image_arr["color"] = "FFFFFF";
                    $image_arr["def_img"] = "Yes";
                    $image_arr["path"] = "compress_profile_image";
                    $data = $this->general->get_image_aws($image_arr);

                    $result_arr[$data_key]["u_profile_image"] = $data;

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
        $input_params["get_commented_user_details_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * update_modifydate_movement_post method is used to process query block.
     * @created Rohit Patidar | 15.10.2021
     * @modified Rohit Patidar | 15.10.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function update_modifydate_movement_post($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = $where_arr = array();
            if (isset($input_params["post_id"]))
            {
                $where_arr["post_id"] = $input_params["post_id"];
            }
            $params_arr["_dmodifieddate"] = "now()";
            $this->block_result = $this->post_model->update_modifydate_movement_post($params_arr, $where_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["update_modifydate_movement_post"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_user_posted_user_check method is used to process conditions.
     * Check weather Posted user & replied user are same
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_user_posted_user_check($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["posted_by_user_id"];

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
     * insert_user_notify_commented_v1 method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_user_notify_commented_v1($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["posted_by_user_id"]))
            {
                $params_arr["posted_by_user_id"] = $input_params["posted_by_user_id"];
            }
            $params_arr["_vnotificationtext"] = "CONCAT('".$input_params["u_name"]."',' has replied to a comment on your post')";
            $params_arr["_etype"] = "Normal";
            $params_arr["_eisread"] = "No";
            $params_arr["_dtaddeddate"] = "NOW()";
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["post_comment_id"]))
            {
                $params_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            $params_arr["_vcode"] = "'RTC'";
            if (isset($input_params["u_users_id"]))
            {
                $params_arr["u_users_id"] = $input_params["u_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_user_notify_commented_v1($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_user_notify_commented_v1"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_posted_notify_pref method is used to process conditions.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_posted_notify_pref($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["posted_notification_pref"];
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
     * notify_posted_user method is used to process mobile push notification.
     * @created CIT Dev Team
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function notify_posted_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["posted_device_token"];
            $code = "RTC";
            $sound = "";
            $badge = $input_params["u_profile_image"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "post_comment_id",
                    "value" => $input_params["post_comment_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#u_name# has replied to a comment on your post";
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
        $input_params["notify_posted_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * cond_check_comment_user_id method is used to process conditions.
     * Check weather replied user id is not commented user id
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_check_comment_user_id($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["user_id"];
            $cc_ro_0 = $input_params["commented_users_id"];

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
     * insert_user_notify_replied method is used to process query block.
     * @created CIT Dev Team
     * @modified Vamsi Ippe | 23.10.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function insert_user_notify_replied($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $params_arr = array();
            if (isset($input_params["commented_users_id"]))
            {
                $params_arr["commented_users_id"] = $input_params["commented_users_id"];
            }
            $params_arr["_vnotificationtext"] = "CONCAT('".$input_params["u_name"]."',' has replied to your comment on a post')";
            $params_arr["_etype"] = "Normal";
            $params_arr["_eisread"] = "No";
            $params_arr["_dtaddeddate"] = "NOW()";
            if (isset($input_params["post_id"]))
            {
                $params_arr["post_id"] = $input_params["post_id"];
            }
            if (isset($input_params["post_comment_id"]))
            {
                $params_arr["post_comment_id"] = $input_params["post_comment_id"];
            }
            $params_arr["_vcode"] = "'RTC'";
            if (isset($input_params["u_users_id"]))
            {
                $params_arr["u_users_id"] = $input_params["u_users_id"];
            }
            $this->block_result = $this->user_notifications_model->insert_user_notify_replied($params_arr);
        }
        catch(Exception $e)
        {
            $success = 0;
            $this->block_result["data"] = array();
        }
        $input_params["insert_user_notify_replied"] = $this->block_result["data"];
        $input_params = $this->wsresponse->assignSingleRecord($input_params, $this->block_result["data"]);

        return $input_params;
    }

    /**
     * cond_commented_user_notify_pref method is used to process conditions.
     * @created Vamsi Ippe | 26.09.2018
     * @modified Vamsi Ippe | 26.09.2018
     * @param array $input_params input_params array to process condition flow.
     * @return array $block_result returns result of condition block as array.
     */
    public function cond_commented_user_notify_pref($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $cc_lo_0 = $input_params["commented_notification_pref"];
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
     * notify_commented_user method is used to process mobile push notification.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Rohit Patidar | 15.07.2021
     * @param array $input_params input_params array to process loop flow.
     * @return array $input_params returns modfied input_params array.
     */
    public function notify_commented_user($input_params = array())
    {

        $this->block_result = array();
        try
        {

            $device_id = $input_params["commented_device_token"];
            $code = "RTC";
            $sound = "";
            $badge = $input_params["insert_notify_id"];
            $silent = "";
            $title = "";
            $send_vars = array(
                array(
                    "key" => "post_id",
                    "value" => $input_params["post_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "post_comment_id",
                    "value" => $input_params["post_comment_id"],
                    "send" => "Yes",
                ),
                array(
                    "key" => "silent",
                    "value" => "0",
                    "send" => "Yes",
                )
            );
            $push_msg = "#u_name# has replied to your comment on a post";
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
        $input_params["notify_commented_user"] = $this->block_result["success"];

        return $input_params;
    }

    /**
     * post_finish_success method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_finish_success($input_params = array())
    {

        $setting_fields = array(
            "success" => "1",
            "message" => "post_finish_success",
        );
        $output_fields = array(
            'comment_reply_id',
        );
        $output_keys = array(
            'insert_comment_reply',
        );

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "reply_on_comment";
        $func_array["function"]["output_keys"] = $output_keys;
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * reply_insert_failure method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function reply_insert_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "reply_insert_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "reply_on_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * comment_check_failure method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function comment_check_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "comment_check_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "reply_on_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }

    /**
     * post_check_failure method is used to process finish flow.
     * @created Vamsi Ippe | 21.09.2018
     * @modified Vamsi Ippe | 21.09.2018
     * @param array $input_params input_params array to process loop flow.
     * @return array $responce_arr returns responce array of api.
     */
    public function post_check_failure($input_params = array())
    {

        $setting_fields = array(
            "success" => "0",
            "message" => "post_check_failure",
        );
        $output_fields = array();

        $output_array["settings"] = $setting_fields;
        $output_array["settings"]["fields"] = $output_fields;
        $output_array["data"] = $input_params;

        $func_array["function"]["name"] = "reply_on_comment";
        $func_array["function"]["single_keys"] = $this->single_keys;

        $this->wsresponse->setResponseStatus(200);

        $responce_arr = $this->wsresponse->outputResponse($output_array, $func_array);

        return $responce_arr;
    }
}
