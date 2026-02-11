<?php


/**
 * Description of Viral Plus Media List Extended Controller
 *
 * @category webservice
 *
 * @package post
 *
 * @subpackage controllers
 *
 * @module Extended Viral Plus Media List
 *
 * @class Cit_Viral_plus_media_list.php
 *
 * @path application\webservice\post\controllers\Cit_Viral_plus_media_list.php
 *
 * @version 4.3
 *
 * @author CIT Dev Team
 *
 * @since 21.07.2022
 */

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Cit_Viral_plus_media_list extends Viral_plus_media_list
{
    public function __construct()
    {
        parent::__construct();
    }

    public function get_display_image($value = '', $data_arr = array())
    {
        $value = $data_arr['pm_upload_file'];
        if ($data_arr['pm_media_type'] == 'Video') {
            $value = $data_arr['pm_video_thumbnail'];
        }
        return $value;
    }

    public function get_viral_plus_post_id($input_params = array())
    {
        $ret_arr = $post_arr = array();
        $ret_arr[0]['post_id_arr'] =  $post_arr;
        $sql = "SELECT `iPostId` FROM `post` WHERE `eStatus` = 'Active' AND   (( `eVisibility` = 'Viral' AND `iUserId` IN (SELECT `iUserId` FROM `user_followers` WHERE `iFollowerId` = '" . $input_params['user_id'] . "' AND `eStatus` = 'Accepted')) OR `eVisibility` = 'Viral') AND iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId = '" . $input_params['user_id'] . "' AND `eStatus` = 'block' ) AND iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId = '" . $input_params['user_id'] . "' AND `eStatus` = 'block')";
        // $sql="SELECT `iPostId` FROM `post` WHERE `eStatus` = 'Active' AND   (( `eVisibility` = 'Public' AND `iUserId` IN (SELECT `iUserId` FROM `user_followers` WHERE `iFollowerId` = '".$input_params['user_id']."' AND `eStatus` = 'Accepted')) OR `eVisibility` = 'Viral') AND iUserId NOT IN (SELECT iBlockUserId FROM block_user_list WHERE iBlockByUserId = '".$input_params['user_id']."' AND `eStatus` = 'block' ) AND iUserId NOT IN (SELECT iBlockByUserId FROM block_user_list WHERE iBlockUserId = '".$input_params['user_id']."' AND `eStatus` = 'block')";
        $ret_arr[0]['sql'] =  $sql;
        return $ret_arr;
    }
}
