<?php


namespace App\Helpers;


use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Validator;
use Kreait\Firebase\Factory;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Messaging\Notification as fNotification;

class Guruhelpers
{

    public static function random_number($length, $keyspace = '0123456789')
    {
        $str = '';
        $max = mb_strlen($keyspace, '8bit') - 1;
        for ($i = 0; $i < $length; ++$i) {
            $str .= $keyspace[random_int(0, $max)];
        }
        return $str;
    }



    public static function sendSms($phone,$message,$provider = "sling"){


        if(env('APP_ENV') == 'production') {

//            try{

                if($provider == 'sling') {
                    $key = "Bearer " . env('SLING_SMS_KEY');

                    $data = [
                        "to" => "$phone",
                        "channel" => '0000',
                        "message" => $message
                    ];
                    $client = new Client();
                    $res = $client->post('https://v2.sling.com.ng/api/v1/send-sms',
                        [
                            'headers' => [
                                'Authorization' => $key,
                                'Content-Type' => 'application/x-www-form-urlencoded',
                                'Accept' => 'application/json',
                            ],
                            'form_params' => $data
                        ]
                    );

                    $response = json_decode($res->getBody()->getContents());


                    if ($response->status == 'queued') return true; else return false;
                }
                else if ($provider == 'bulksmsnigeria'){
                    $message = urlencode($message);
                    $response = file_get_contents("https://www.bulksmsnigeria.com/api/v1/sms/create?dnd=2&api_token=rVY7mjk9AfG2CCx9KdzHkqB1CSVCoyOvNxEvKLdnhEVbtrtcZ7uM8ElPeC7S&from=STROM&to=$phone&body=$message");
                    if($response == false) return $response; else return true;
                }
                else if ($provider == 'smslive247'){

                    $owneremail = "tobennaa@gmail.com";
                    $subacct = "dropster";
                    $subacctpwd = "dropster";
                    $sendto = $phone; /* destination number */
                    $sender = "STROM"; /* sender id */


                    /* create the required URL */
                    $url = "http://www.smslive247.com/http/index.aspx?" . "cmd=sendquickmsg" . "&owneremail=" . UrlEncode($owneremail)
                        . "&subacct=" . UrlEncode($subacct)
                        . "&subacctpwd=" . UrlEncode($subacctpwd)
                        . "&message=" . UrlEncode($message)
                        . "&sender=" . UrlEncode($sender)
                        . "&sendto=" . UrlEncode($sendto)
                        . "&msgtype=0";


                    /* call the URL */
                    if ($f = @fopen($url, "r")) {

                        $answer = fgets($f, 255);

                        if (substr($answer, 0, 1) == "+") {

                            return true;
                        } else {
                            return false;
                        }
                    } else {
                        return false;
                    }
                }


//            }catch (\Exception $exception){
////                Bugsnag::notifyException($exception);
//            }
        } else{
            // if on staging or local. don't send sms
            return true;
        }

        return false;
    }



    public static function sendNotificationToUser( $nid,$device_id,$title,$body ,$route_to,$data_id,$image_url = "https://www.borome.ng/favicon.png") {

        $factory = new Factory();
        $messaging = $factory->createMessaging();

        $notification = fNotification::fromArray([
            'title' => $title,
            'body' => $body,
            'image' => $image_url,
        ]);

        $message = CloudMessage::withTarget('token', $device_id)
            ->withNotification($notification)
            ->withData([
                "id" => $nid,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "intent" => "$route_to:$data_id"
            ]);

        return $messaging->send($message);

    }

    public static function sendNotificationToTopic($nid,$topic,$title,$body,$image_url,$route_to,$data_id) {

        $factory = new Factory();
        $messaging = $factory->createMessaging();

        $notification = fNotification::fromArray([
            'title' => $title,
            'body' => $body,
            'image' => $image_url,
        ]);

        $message = CloudMessage::withTarget('topic', $topic)
            ->withNotification($notification)
            ->withData([
                "id" => $nid,
                "click_action" => "FLUTTER_NOTIFICATION_CLICK",
                "intent" => "$route_to:$data_id"
            ]);

        return $messaging->send($message);

    }


}
