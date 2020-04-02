<?php


namespace App\Helpers;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

class Quidpay {


    private $transferUrl = "v2/gpx/transfers/create";
    private $transferConfirmationUrl = "v2/gpx/transfers";
    private $tokenizeUrl = "flwv3-pug/getpaidx/api/tokenized/charge";
    private $chargeUrl = "flwv3-pug/getpaidx/api/charge";
    private $chargeAuthorizationUrl = "flwv3-pug/getpaidx/api/validatecharge";
    private $chargeVerificationUrl = "flwv3-pug/getpaidx/api/v2/verify";
    private $balanceUrl = "v2/gpx/balance";
    private $transactionsUrl = "v2/gpx/transactions/query";
    private $accountVerificationUrl = "flwv3-pug/getpaidx/api/resolve_account";
    private $bankCodeUrl = "v2/banks/NG";
    private $listBanksUrl = "v2/banks/";
    private $bvnVerificationUrl = 'v2/kyc/bvn/';
    private $baseUrl;
    private $env;





    public function __construct() {

        $devBaseUrl = "https://ravesandboxapi.flutterwave.com/";
        $prodBaseUrl = "https://api.ravepay.co/";

        $env = env('QUIDPAY_ENV');

        if($env == 'dev') {
            $this->env     = $env;
            $this->baseUrl = $devBaseUrl;
        }
        else
        {
            $this->env = "prod";
            $this->baseUrl = $prodBaseUrl;
        }


        $this->secretKey = env('QUIDPAY_SECRET_KEY');
        $this->publicKey = env('QUIDPAY_PUBLIC_KEY');
        $this->client = new client();
        $this->headers = [
            "Authorization" => "Bearer $this->secretKey",
            "Content-Type" => "application/json"
        ];
    }

    public function listBanks($country = "NG") {
        $url = $this->listBanksUrl . $country;

        $data = array(
            "public_key" => $this->publicKey,
            "country" => $country
        );

        return json_decode($this->get($url,$data,"query"));

    }

    public function verifyBvn($bvn) {
        $url = $this->bvnVerificationUrl . $bvn;

        $data = array(
            "seckey" => $this->secretKey,
        );

        return json_decode($this->get($url,$data,"query"));

    }

    public function resolveAccount($accountNumber, $bank) {

        $url = $this->baseUrl . $this->accountVerificationUrl;

        $data = array(
            "currency" => "NGN",
            "PBFPubKey" => $this->publicKey,
            "recipientaccount" => $accountNumber,
            "destbankcode" => $this->findBankCode($bank)
        );


        try {
            $post = $this->client->request( 'POST', $url, [
                'form_params' => $data
            ] );
        } catch ( GuzzleException $e ) {
            $message = $e->getMessage();
            $message = explode("response:" ,$message)[1];
            if(!empty(json_decode($message)->message))
            $decodedMessage = json_decode($message)->message;
            else $decodedMessage = $e;
            return  $this->decode( array(
                "message" => "failed",
                "data" => $decodedMessage
            ));
        }

        $response = $post->getBody()->getContents();
        $response =  array(
            "message" => "successful",
            "data" => json_decode($response)
        );

        return $this->decode($response);

    }

    public function verifyCharge( $reference ) {



        $url = $this->baseUrl . $this->chargeVerificationUrl;

        $data = array(
            "txref" => $reference,
            "SECKEY" => $this->secretKey
        );


        try {
            $post = $this->client->request( 'POST', $url, [
                'form_params' => $data
            ] );
        } catch ( GuzzleException $e ) {
            $message = $e->getMessage();
            $message = explode("response:" ,$message)[1];
            return  $this->decode( array(
                "message" => "failed",
                "data" => json_decode($message)->message
            ));
        }

        $response = $post->getBody()->getContents();
        $response =  array(
            "message" => "successful",
            "data" => json_decode($response)
        );

        return $this->decode($response);


    }


    public function makeSingleTransfer( $bankCode, $accountNumber, $amount, $narration, $reference ) {

        $url = $this->baseUrl . $this->transferUrl;

        if($this->env == "dev") $reference = $reference . "_PMCK";

        $data = array(
            "account_bank" => $bankCode,
            "account_number" => $accountNumber,
            "amount" => $amount,
            "currency" => "NGN",
            "narration" => $narration,
            "reference" => $reference,
            "seckey" => $this->secretKey
        );


        try {
            $post = $this->client->request( 'POST', $url, [
                'form_params' => $data
            ] );
        } catch ( GuzzleException $e ) {
            $message = $e->getMessage();
            $message = explode("response:" ,$message)[1];
            return  $this->decode( array(
                "message" => "failed",
                "data" => json_decode($message)->message
            ));
        }

        $response = $post->getBody()->getContents();
        $response =  array(
            "message" => "successful",
            "data" => json_decode($response)
        );

        return $this->decode($response);


    }

    public function confirmSingleTransfer( $reference ) {
        $url = $this->transferConfirmationUrl;

        $data = array(
            "seckey" => $this->secretKey,
            "reference" => $reference
        );

        return json_decode($this->get($url,$data,"query"));

    }

    public function chargeCard( $email , $amount, $reference , $token ) {
        $url = $this->baseUrl . $this->tokenizeUrl;
        $country = "NG";
        $currency = "NGN";

        $data = [

            'currency' => $currency,
            'country' => $country,
            'txRef' => $reference,
            'email'=> $email,
            'amount'=> $amount,
            'token' => $token,
            'SECKEY'=> $this->secretKey,

        ];

        try {
            $post = $this->client->request( 'POST', $url, [
                'form_params' => $data
            ] );
        } catch ( GuzzleException $e ) {
            $message = $e->getMessage();

                $message = explode("response:" ,$message)[1];
                try{
                    return  $this->decode( array(
                        "message" => "failed",
                        "data" => json_decode($message)->message
                    ));

                }catch (\Exception $exception){
                    return  $this->decode( array(
                        "message" => "failed",
                        "data" => $message
                    ));

                }


        }

        $response = $post->getBody()->getContents();
        $response =  array(
            "message" => "successful",
            "data" => json_decode($response)
        );

        return $this->decode($response);

    }

    public function findBankCode($bankName) {

        $url = $this->bankCodeUrl . "?public_key=" . $this->publicKey;

        $banks = $this->get($url);


        $banks = json_decode($banks);

        foreach($banks->data->Banks as $bank){
            if(strtolower($bank->Name) == strtolower($bankName)){
                return $bank->Code;
            }
        }
    }

    public function getBalance() {

        $data = array(
            "currency" => "NGN",
            "seckey" => $this->secretKey
        );

        return $this->post($this->balanceUrl , $data);
    }

    public function decode($data){
        return json_decode(json_encode( $data ));
    }

    public function get($url,$data = null, $type = 'form') {

        if($type == 'form') $typeKey = "form_params";
        else $typeKey = "query";

        $response = $this->client->request('GET', $this->baseUrl . $url,[
            $typeKey => $data,
            'headers' => $this->headers,
        ]);

        return $response->getBody()->getContents();
    }

    public function post($url,$data = null) {

        try{
            $response = $this->client->request('POST', $this->baseUrl . $url,[
                'form_params' => $data,
                'headers' => $this->headers,
            ]);

            return $response->getBody()->getContents();
        }catch (\Exception $exception){
            return $exception->getMessage();
        }

    }

}
