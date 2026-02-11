<?php
    ini_set('display_errors', "1");
    error_reporting(E_ALL);
    $email='rlhilliard45@gmail.com';
    $BOUNCE_API_URL = 'https://api.clearout.io/v2/email_verify/instant';
    $BOUNCE_API_KEY = 'c0797bc901c69ae607cd1226e6ebf618:e44ca65fa334cdb316f004d510da638dce14257f566195fa6c72b04bb2f629d0';
    try
    {

        $curl = curl_init();
        curl_setopt_array($curl, array(
          CURLOPT_URL => $BOUNCE_API_URL,
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_ENCODING => '',
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => 'POST',
          CURLOPT_POSTFIELDS => '{"email": "'.$email.'"}',
          CURLOPT_HTTPHEADER => array(
            "Content-Type: application/json",
            "Authorization: ".$BOUNCE_API_KEY
          ),
        ));
        
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $response = curl_exec($curl);

        if($response === false)
        {
            echo 'Curl error: ' . curl_error($curl);
        }

        curl_close($curl);
        $response = json_decode($response, true);
        echo "Here";
        print_r($response); die();
        $return_arr['API_status'] = $response['status'];
        if($response['status'] == 'failed'){                         
            $return_arr['status'] = $response['status'];                               
            $return_arr['code'] = $response['error']['code'];
            $return_arr['API_error'] = $response['error']['message'];
        }else if($response['status'] == 'success'){
            $return_arr['status'] = $response['data']['status'];                               
            $return_arr['code'] = $response['data']['sub_status']['code'];
            $return_arr['API_error'] = $response['data']['sub_status']['desc'];
        }
    }
    catch(Exception $e)
    {
        echo "error";
        print_r($e); die();
        $return_arr['API_error'] = $e->getMessage();
    }
    //print_r($return_arr); die();
    return ($return_arr);
?>