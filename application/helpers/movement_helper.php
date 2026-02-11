<?php
function share_post($params) {
    $CI =& get_instance();
    $added_date = date('Y-m-d H:i:s');
    $data = [
        'iActualPostId'=> $params['post_id'],
        'iUserId'=> $params['user_id'],
        'ePostType'=> 'Share',
        'tPostText'=>$params['share_text'],
        'eVisibility'=> $params['visibility'],
        'eDraft'=> 'No',
        'dAddedDate'=> $added_date,
        'eStatus'=> 'Active',
        'tPostTextEmoji'=> $params['share_text'],
        'iMovementsId'=> $params['movement_id'],
    ];

    $CI->db->insert('post', $data);
    return $CI->db->insert_id();

    return $data;
}

// function post_short($posts) {
    
// }

function invite_movement($params) {
    $CI =& get_instance();
    $added_date = date('Y-m-d H:i:s');
    if(!empty($params)) {
        $data = [
            'iUserId'=> $params['inviter_user_id'],
            'vNotificationText'=> 'You have a new request from ' . $params['notification_details']['user_name'] . ' for your ' . $params['notification_details']['Movement_name'] . ' Movement',
            'eType'=> 'MovementFollower',
            'eIsRead'=> 'No',
            'vCode'=> 'MR',
            'dtAddedDate'=> $added_date,
            'iSysRecDeleted'=> 0,
            'iTokboxSessionId'=> 0,
            'iNotifiyUserId'=> $params['invitee_user_id'],
            'iMovementId'=> $params['movement_id'],
            'eMovementReadStatus'=> 'No',
        ];

        $CI->db->insert('user_notifications', $data);
        $result =  $CI->db->insert_id();
    } else {
        $result =  'Params is empty';
    }

    return $result;
}