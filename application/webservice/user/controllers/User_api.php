<?php
defined('BASEPATH') || exit('No direct script access allowed');

class User_api extends Cit_Controller {
    public function __construct()
    {
        return parent::__construct();
    }


    public function updateUserProfile()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");

        $rawInput = file_get_contents('php://input');
        $json = json_decode($rawInput, true);

        if (empty($json['user_id'])) {
            echo json_encode([
                "success" => false,
                "message" => "user_id is required"
            ]);
            return;
        }

        $userId = (int) $json['user_id'];

        // Map frontend → DB columns
        $fieldMap = [
            "about_me" => "tAboutMe",
            "covervideo_thumbnail" => "vCoverYDimention", // adjust if needed
            "cover_photo" => "vCoverPhoto",
            "profile_image" => "vProfileImage",
            "user_email" => "vEmail",
            "user_name" => "vName",
            "user_phone" => "vPhone"
        ];

        $updateData = [];

        foreach ($fieldMap as $inputKey => $dbColumn) {
            if (isset($json[$inputKey])) {
                $updateData[$dbColumn] = $json[$inputKey];
            }
        }

        if (empty($updateData)) {
            echo json_encode([
                "success" => false,
                "message" => "No valid fields to update"
            ]);
            return;
        }

        // Always update modified date
        $updateData['dtModifiedDate'] = date('Y-m-d H:i:s');

        // Update query
        $this->db->where('iUsersId', $userId);
        $updated = $this->db->update('users', $updateData);

        if ($updated) {
            echo json_encode([
                "success" => true,
                "message" => "Profile updated successfully"
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Update failed"
            ]);
        }
    }
}