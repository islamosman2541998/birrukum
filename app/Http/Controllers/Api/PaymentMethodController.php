<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BankAccountResorce;
use App\Http\Resources\PaymentMethodResource;
use App\Models\PaymentBank;
use App\Models\PaymentMethod;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    use ApiResponseTrait;

    public    $SHARequestPhrase = '82rJ.pmZVuyq1QaaTERA07@?'; //'egvierrbvjb';

    // TO DO
    public function index(Request $request)
    {
        $method =
            PaymentMethod::active()->get();

        if (!$method || count($method) < 1) {
            return $this->notFoundResponse();
        }
        $methodRes = PaymentMethodResource::collection($method);
        return $this->apiResponse($methodRes);
    }

    public function getBankAccounts()
    {
        $accounts = PaymentBank::get();
        return $this->apiResponse(BankAccountResorce::collection($accounts));
    }

    public function tokenRequest()
    {
        $data = $this->requiredArray(['device_id', 'isApplePay']);
        $shaString  = '';


        $test = false;

        if ($test) {
            $identifier = 'KTToIJFr';
            $url = 'https://sbpaymentservices.payfort.com/FortAPI/paymentApi';

            if ($data['isApplePay'] == 'false') {
                $accessCode = 'N0qFZwdUYTxibxDpnsef';
                $this->SHARequestPhrase = 'vuyculflgluv';
            } else {
                $accessCode = '3SVETdHDjxuJrhF099qX';
                $this->SHARequestPhrase = '65TNlKz4amrEH9TVJkIzEJ_?';
            }
        } else {
            $identifier = 'BiZjlLxK';
            $url = 'https://paymentservices.payfort.com/FortAPI/paymentApi';

            if ($data['isApplePay'] == 'false') {
                $accessCode = 'PFEiLpPP5luIGAsOyoFy';
                $this->SHARequestPhrase = 'egvierrbvjb';
            } else {
                $accessCode = 'nB4tY4pRnItey1PwrGCM';
                $this->SHARequestPhrase = $this->SHARequestPhrase;
            }
        }
        // array request
        $arrData = [
            'service_command' => 'SDK_TOKEN',
            'access_code' => $accessCode,
            'merchant_identifier' => $identifier,
            'language' => 'ar',
            'device_id' => $data['device_id']
        ];
        ksort($arrData);
        foreach ($arrData as $k => $v) {
            $shaString .= "$k=$v";
        }
        $shaString = $this->SHARequestPhrase . $shaString . $this->SHARequestPhrase;
        $signature = hash('sha256', $shaString);
        $arrData['signature'] = $signature;
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => json_encode($arrData),
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/json'
            ),
        ));

        $response = json_decode(curl_exec($curl));

        curl_close($curl);

        return $this->apiResponse($response);
    }
}
