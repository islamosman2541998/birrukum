<?php

namespace App\Http\Livewire\Site\Auth;

use App\Charity\Carts\DatabaseCart;
use App\Models\Donor;
use Livewire\Component;
use App\Models\Accounts;
use App\Models\LoginTypes;
use App\Charity\Notfications\SmsService;
use App\Charity\Settings\SettingSingleton;

class Index extends Component
{
    public $new_donor = false, $otp_modal = false, $sendOTP = "", $sendOTPExpirate = "";
    public $mobile = "", $name ="", $email ="", $otp = "";
    public $authError = "", $otpError = "";
    public $authMessage = "", $show_auth =  true, $otp_status =  true;
    public $type;

    public $testMobiles = [
        "597767751",
        "567296308",
        "561611117",
        "540265614",
    ];

    protected function rules(){
        if($this->new_donor){
            return [
                'mobile' => 'required|min:9|max:9',
                'name' => 'required|string|min:3',
                'email' => 'required|email|string',
            ];
        }
        else{
            return [
                'mobile' => 'required|min:9|max:9',
            ];
        }   
    }

    public function updated($field)
    {
        $this->validateOnly($field);
    }


    public function updateNewDonor($val){
        $this->emptymessage();
        $this->mobile = "";
        $this->name   = "";
        $this->email  = "";
        $this->otp    = "";
        $this->new_donor = $val;
    }

    public function login(){
        $data = $this->validate();
        
        $this->emptymessage();
        $donor = Donor::with('account')->where('mobile', $this->mobile)->get()->first();
        if($donor == null){
            return $this->authError = __('This number is not registered with us');
        }
        if($this->otp_status){
            // generate otp
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
        }else{
            $this->LoginWithOutOtp();
        }        
        
    }


    public function register(){
        $data = $this->validate();
        $this->emptymessage();
        $donor = Donor::where('mobile', $this->mobile)->get()->first();
        if($donor != null){
            return $this->authError = __('This number is already exist');
        }
        if($this->otp_status){
             // generate otp
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

        }else{
            $this->LoginWithOutOtp();
        }        
        

    }


    public function checkOTP(){
        $this->emptymessage();
        
        if($this->otp ==""){
            return $this->otpError = __('OTP is required');
        }

        if(!$this->new_donor){
            $donor = Donor::with('account', 'account.types')->where('mobile', $this->mobile)->get()->first();
            if(@$donor->expiration < time() ){ return $this->otpError = __('The OTP is expired');  }
            if(@$this->otp !=  $donor->otp){ return $this->otpError = __('The OTP is wrong'); }
            if($donor->account->types->where('type', 'donor')->first() == null){
                $this->otp_modal = false;
                return $this->authError = __('This number is not registered with us'); 
            }
        }else{
            if($this->sendOTPExpirate < time() ){ return $this->otpError = __('The OTP is expired');  }
            if( $this->sendOTP != $this->otp){ return $this->otpError = __('The OTP is wrong'); }
            $account = Accounts::create(['email' => $this->email, 'mobile' => $this->mobile]);
            $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();
            $account->types()->attach($types);
            $donor = Donor::with('account')->create([
                'account_id' => $account->id,
                'full_name' => $this->name,
                'mobile' => $this->mobile,
            ]);
        }
        auth()->login($donor->account);
        $this->authMessage = __("You Loggin Sucessfully");
        $this->otp_modal = false;
        $this->updateCart();
        $this->emit('authUpdated');
        $this->emit('updateAuth');
    }


    public function LoginWithOutOtp(){
        if(!$this->new_donor){
            $donor = Donor::with('account', 'account.types')->where('mobile', $this->mobile)->get()->first();
            if($donor->account->types->where('type', 'donor')->first() == null){
                return $this->authError = __('This number is not registered with us'); 
            }
        }else{
            $account = Accounts::create(['email' => $this->email, 'mobile' => $this->mobile]);
            $types = LoginTypes::query()->whereIn('type', ['donor'])->pluck('id')->toArray();
            $account->types()->attach($types);
            $donor = Donor::with('account')->create([
                'account_id' => $account->id,
                'full_name' => $this->name,
                'mobile' => $this->mobile,
            ]);
        }
        auth()->login($donor->account);
        $this->updateCart();
        $this->authMessage = __("You Loggin Sucessfully");
        $this->otp_modal = false;
        $this->emit('authUpdated');
        $this->emit('updateAuth');
    }

    public function closeModalOTP(){
        $this->otp_modal = false;
    }

    public function emptymessage(){
        $this->authError = "";
        $this->otpError = "";
        $this->authMessage = "";
    }


    public function updateCart(){
        $cart = new DatabaseCart(); 
        $cart->updateDonor();
    }

    public function mount($type)
    {
        $this->show_auth = SettingSingleton::getInstance()->getLoginStatus('show_login_' .$type);
        $this->otp_status = SettingSingleton::getInstance()->getLoginStatus('send_otp_' .$type);
    }
    public function render()
    {
        // @auth('account')->user();
        // @auth('account')->logout();
        // dd(@auth('account')->user());

        return view('livewire.site.auth.index');
    }
}
