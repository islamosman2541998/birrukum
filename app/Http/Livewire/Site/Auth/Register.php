<?php

namespace App\Http\Livewire\Site\Auth;

use App\Charity\Carts\DatabaseCart;
use App\Models\Donor;
use Livewire\Component;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Charity\Notfications\SmsService;
use Illuminate\Support\Facades\Cookie;

class Register extends Component
{

    public $mobile = "", $name ="", $email ="", $identity = "", $otp = "";

    public $otpError = "", $authMessage = "", $authError = "", $otp_modal = "";

    public $new_donor = false, $sendOTP = "", $sendOTPExpirate = "";
  
    public $testMobiles = [
        "597767751",
        "567296308",
        "561611117",
        "540265614",
    ];


    protected function rules(){
        return [
            'mobile' => 'required|min:9|max:9',
            'name' => 'required|string|min:3',
            'email' => 'required|email|string',
            'identity' => 'nullable|string|min:3',
        ];
    }
    
    public function updated($field)
    {
        $this->validateOnly($field);
    }


    public function register(){
        $data = $this->validate();
        $this->emptymessage();
        $donor = Donor::where('mobile', $this->mobile)->get()->first();
       
        if($donor != null){
            return $this->authError = __('This number is already exist');
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

        $this->sendOTPExpirate = time() + 600;
        // Send OTP in SMS 
        $this->otp = "";
        $this->otp_modal = true;
    }


    public function checkOTP(){
        $this->emptymessage();
        if($this->otp ==""){
            return $this->otpError = __('OTP is required');
        }
        if($this->sendOTPExpirate < time() ){ return $this->otpError = __('The OTP is expired');  }
        if( $this->sendOTP != $this->otp){ return $this->otpError = __('The OTP is wrong'); }
        $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();
        // add type 'donor' to account if account exists
        if($donorAccountExist = Accounts::where('mobile', $this->mobile)->get()->first()){
            if (!$donorAccountExist->types()->where('type_id', $types)->exists()) {
                // If not attached, attach the 'donor' type
                $donorAccountExist->types()->attach($types);
            }
            $donor = Donor::with('account')->create([
                'account_id'    => $donorAccountExist->id,
                'full_name'     => $this->name,
                'mobile'        => $this->mobile,
                'identity'        => $this->identity,
                'refer_id'      => Cookie::get('referrer') ?? 1,
            ]);
        }
        else{
            $account = Accounts::create(['email' => $this->email, 'mobile' => $this->mobile]);
            
            $account->types()->attach($types);
            $donor = Donor::with('account')->create([
                'account_id' => $account->id,
                'full_name' => $this->name,
                'mobile' => $this->mobile, 
                'identity' => $this->identity, 
                'refer_id'      => Cookie::get('referrer') ?? 1,

            ]);
        }
      
        auth()->login($donor->account);
        $this->updateCart();
        $this->authMessage = __("You Register Sucessfully");
        $this->otp_modal = false;
        $this->emit('authUpdated');
        return redirect()->route('site.profile.index');

    }

    public function updateCart(){
        $cart = new DatabaseCart(); 
        $cart->updateDonor();
    }


    public function closeModalOTP(){
        $this->otp_modal = false;
    }

    public function emptymessage(){
        $this->authError = "";
        $this->otpError = "";
        $this->authMessage = "";
    }


    public function render()
    {
        return view('livewire.site.auth.register');
    }
}
