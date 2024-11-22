<?php // Code within app\Helpers\Helper.php

namespace App\Helper\Helpers;

class Helpers
{
    public static function shout(string $string)
    {
        return strtoupper($string);
    }


    public static function sms_send(string $number, string $message)
    {
        // $url = "https://bulksmsbd.net/api/smsapi";
        // $api_key = "3INLatKCpSDmfLVKkgQe";
        // $senderid = "8809612443871";
        // $number = $number;
        // $message = $message;

        // $data = [
        //     "api_key" => $api_key,
        //     "senderid" => $senderid,
        //     "number" => $number,
        //     "message" => $message
        // ];
        // $ch = curl_init();
        // curl_setopt($ch, CURLOPT_URL, $url);
        // curl_setopt($ch, CURLOPT_POST, 1);
        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        // $response = curl_exec($ch);
        // curl_close($ch);

      /*this sms api not working */
        // $url = "https://isms.mimsms.com/smsapi";
        // $api_key = "C2001726634f7b8e248892.80825982";
        // $senderid = "8809601004747";
        // $number = $number;
        // $message = $message;
        // $data = [
        //     "api_key" => $api_key,
        //     "type" => "text",
        //     "contacts" => $number,
        //     "senderid" => $senderid,
        //     "msg" => $message,
        //   ];
        //   $ch = curl_init();
        //   curl_setopt($ch, CURLOPT_URL, $url);
        //   curl_setopt($ch, CURLOPT_POST, 1);
        //   curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        //   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        //   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        //   $response = curl_exec($ch);
        //   curl_close($ch);
        // return $response;

        //Creative Software
        $url = 'https://24bulksms.com/24bulksms/api/api-sms-send';
        $data = array(
        'api_key' => '17468290953528972022/10/1601:40:43pm3N1sI0HA',
        'sender_id' => 30,
        'message' => $message,
        'mobile_no' => $number,
        'user_email' => 'dilouarbd@gmail.com'
        );

        // use key 'http' even if you send the request to https://...
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

                 
    //     $params = [
    //         "api_token" => 'svlh35i7-krsvgcep-0mlubtyg-vzudoac7-ja2f8ydb',
    //         "sid" => 'SHEIKHSOHELRANA',
    //         "msisdn" => $number,
    //         "sms" => $message,
    //         "csms_id" => "2934fe343"
    //     ];
    //     $params = json_encode($params);

    //     $ch = curl_init(); // Initialize cURL
    //     curl_setopt($ch, CURLOPT_URL, 'https://smsplus.sslwireless.com/api/v3/send-sms');
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    //     curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    //     curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    //         'Content-Type: application/json',
    //         'Content-Length: ' . strlen($params),
    //         'accept:application/json'
    //     ));

    //   return  $response = curl_exec($ch);
    }


    //DMAN SMS Panel
    // public static function otp_send(string $number, string $message)
    // { 
    //     $url = 'https://msg.elitbuzz-bd.com/Developers';
    //     $data = array(
    //     'api_key' => 'C200887465786cd3eb63d8.99241342',
    //     'sender_id' => 8809601011425,
    //     'message' => $message,
    //     'mobile_no' => $number,
    //     'user_email' => 'dmanbd@gmail.com'
    //     );

    //     // use key 'http' even if you send the request to https://...
    //     $curl = curl_init($url);
    //     curl_setopt($curl, CURLOPT_POST, true);
    //     curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
    //     curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    //     curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    //     $response = curl_exec($curl);
    //     curl_close($curl);

    //     return $response;
    // }


    public static function otp_send(string $number, string $message)
    { 
        $url = 'https://24bulksms.com/24bulksms/api/otp-api-sms-send';
        $data = array(
            'api_key' => '17468290953528972022/10/1601:40:43pm3N1sI0HA',
            'sender_id' => 30,
            'message' => $message,
            'mobile_no' => $number,
            'user_email' => 'dilouarbd@gmail.com'
        );

        // use key 'http' even if you send the request to https://...
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    
    }
}
