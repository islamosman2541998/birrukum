<?php

namespace App\Http\Livewire\Site\Auth;

use App\Charity\Carts\DatabaseCart;
use App\Models\Donor;
use Livewire\Component;
use App\Charity\Notfications\SmsService;
use Illuminate\Support\Facades\Cookie;

class Login extends Component
{
    public $mobile = "";
    public $otpError = "", $authMessage = "", $authError = "", $otp_modal = "";



    public $testMobiles = [
        "597767751",
        "567296308",
        "561611117",
        "540265614",
    ];


    protected function rules(){
        return [
            'mobile' => 'required|min:9|max:9',
        ];
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }

    public function login(){
        $data = $this->validate();
        $this->emptymessage();
        $donor = Donor::with('account')->where('mobile', $this->mobile)->get()->first();
        if($donor == null){
            return $this->authError = __('This number is not registered with us');
        }
     
        if(in_array($this->mobile, $this->testMobiles)){
            $this->sendOTP = "1234";
        }
        else{
            $this->sendOTP = rand(1000, 9999);
            // Send OTP in SMS 
            $sms = new SmsService($this->mobile, $this->sendOTP);
            $sms = $sms->send();
        }
        // update donor otp
        $donor->otp = $this->sendOTP ;
        $donor->expiration = time() + 600;
        $donor->save();
        $this->otp = "";
        $this->otp_modal = true;
    }

    public function checkOTP(){
        $this->emptymessage();
        if($this->otp ==""){
            return $this->otpError = __('OTP is required');
        }
        $donor = Donor::with('account', 'account.types')->where('mobile', $this->mobile)->get()->first();
        if(@$donor->expiration < time() ){ return $this->otpError = __('The OTP is expired');  }
        if(@$this->otp != strval($donor->otp)){ return $this->otpError = __('The OTP is wrong'); }
        if($donor->account->types->where('type', 'donor')->first() == null){
            $this->otp_modal = false;
            return $this->authError = __('This number is not registered with us'); 
        }
        // save refer_id in  donor
        if($donor->refer_id == null){
            $donor->refer_id = Cookie::get('referrer') ?? 1; 
            $donor->save();
        }

        auth()->login($donor->account);
        $this->updateCart();
        $this->authMessage = __("You Loggin Sucessfully");
        $this->otp_modal = false;
        $this->emit('authUpdated');
        return redirect()->route('site.profile.index');
    }

    public function updateCart(){
        $cart = new DatabaseCart(); 
        $cart->updateDonor();
    }

    
    public function emptymessage(){
        $this->authError = "";
        $this->otpError = "";
        $this->authMessage = "";
    }

    public function closeModalOTP(){
        $this->otp_modal = false;
    }


    public function render()
    {
        return view('livewire.site.auth.login');
    }
}
