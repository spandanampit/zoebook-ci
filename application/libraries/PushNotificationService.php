<?php
class PushNotificationService {
    private $serverKey;

    public function __construct() {
        $this->serverKey = "YOUR_FCM_SERVER_KEY";
    }

    public function sendToToken($token, $title, $body) {
        $url = "https://fcm.googleapis.com/fcm/send";
        $fields = [
            'to' => $token,
            'notification' => [
                'title' => $title,
                'body'  => $body,
                'click_action' => 'OPEN_APP_PAGE'
            ]
        ];

        $headers = [
            'Authorization: key=' . $this->serverKey,
            'Content-Type: application/json'
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
