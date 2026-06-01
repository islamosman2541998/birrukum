<?php

namespace App\Http\Controllers\Api;

use App\Charity\Notfications\SmsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;
use App\Http\Resources\Donor\LoginResource;
use App\Http\Resources\Donor\OrderResource;
use App\Http\Resources\Donor\RegisterResource;
use App\Http\Resources\Donor\ValidateOtpResource;
use App\Models\Accounts;
use App\Models\Donor;
use App\Models\FcmToken;
use App\Models\LoginTypes;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class 
DonorController extends Controller
{
    use ApiResponseTrait;

    public $testMobiles = [
        "597767751",
        "567296308",
        "561611117",
        "540265614",
    ];


    public function login(LoginRequest $request)
    {
        $data = $request->validated();

        $data['mobile'] = substr($data['mobile'], -9);
        $donor = Donor::with('account')->where('mobile', $data['mobile'])->get()->first();

        if ($donor == null) {
            return $this->apiResponse(null, trans('This number is not registered with us'), 404);
        }
        if (in_array($data['mobile'], $this->testMobiles)) {
            $generateOTP = "1234";
        } else {
            $generateOTP = rand(1000, 9999);
            // Send OTP in SMS
            $sms = new SmsService($data['mobile'], $generateOTP);
            $sms = $sms->send();
        }
        // update donor otp , token & expiration date
        $userToken = $donor->createToken('userToken')->plainTextToken;
        $donor->otp = $generateOTP;
        $donor->token = $userToken;
        $donor->expiration = time() + 600;
        $donor->save();

        // updatre the fcm
        $device = FcmToken::updateOrCreate(['device_id' => @$data['device_id']], ['donor_id' => $donor->id]);
        return $this->apiResponse(new LoginResource($donor, trans('Verification code has been sent successfully')));
    }


    public function register(RegisterRequest $request)
    {
        $data = $request->validated();
        $data['mobile'] = substr($request['mobile'], -9);
        $account = Accounts::where('mobile', $data['mobile'])->get()->first();
        if (!$account) {
            $account = Accounts::create($data);
            $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();
            $account->types()->attach($types);
        }
        else{
            $account->email = $data['email'];
            $account->save();
        } 
        $data['account_id'] = $account->id;
        $donor = Donor::where('mobile', $data['mobile'])->get()->first();
        if (!$donor) {
            Donor::with('account')->create([
                'account_id' => $account->id,
                'full_name' => $request['full_name'],
                'mobile' => $data['mobile'],
                'identity' => $data['identity'],
                'mobile_confirmed' => 'no',
                'status' => 0,
            ]);
        }
        else{
            $donor->identity = $data['identity'];
        }

        if (in_array($data['mobile'], $this->testMobiles)) {
            $generateOTP = "1234";
        } else {
            $generateOTP = rand(1000, 9999);
            // Send OTP in SMS
            $sms = new SmsService($data['mobile'], $generateOTP);
            $sms = $sms->send();
        }

        // update donor otp , token & expiration date
        $userToken = $donor->createToken('userToken')->plainTextToken;
        $donor->otp = $generateOTP;
        $donor->token = $userToken;
        $donor->expiration = time() + 600;
        $donor->save();

        // updatre the fcm
        FcmToken::updateOrCreate(['device_id' => @$data['device_id']], ['donor_id' => $donor->id]);
        return $this->apiResponse(new RegisterResource($donor, trans('Verification code has been sent successfully')), '', 201);
    }


    public function validateOtp(Request $request)
    {
        $donor = Donor::with('refer', 'account')->find($request->donor_id);

        if (!$donor) {
            return $this->notFoundResponse();
        }

        if ($donor->otp != (string)$request->otp) {
            return $this->notFoundResponse(__('admin.wrong_otp'));
        }
        if ($donor->token !== $request->token) {
            return $this->notFoundResponse(__('admin.wrong_token'));
        }

        if (time() > $donor->expiration) {
            return $this->notFoundResponse(__('admin.otp_is_expired'));
        }
        $donor->mobile_confirm = 1;
        $donor->save();

        return $this->apiResponse(new  ValidateOtpResource($donor));
    }


    public function getDonations(Request $request)
    {
        $donor = Donor::with('orders')->find($request->id);
        if (!$donor || $donor->token != $request->token) {
            return $this->notFoundResponse(trans('admin.token_valied'));
        }

        if (!$donor->orders || $donor->orders->count() < 1) {
            return $this->notFoundResponse(trans('admin.you_have_no_donations'));
        }

        return $this->apiResponse(OrderResource::collection($donor->orders));
    }
}
