<?php

namespace App\Http\Livewire\Site\CharityProject;

use Livewire\Component;
use App\Charity\Carts\Item;
use App\Models\CharityProject;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Settings\SettingSingleton;

class Show extends Component
{
    public $project, $donation, $amount, $giftStatus = 0, $cards = [], $selectCardTitle;
    
    public $donationAmt = 0, $donationQty = 1, $donationtype;

    public $progressBar = ['collected' => 0, 'reminder' => 0, 'percent' => 0]; 

    public $unitValueRadio, $unitValueInput;

    public $shareValue, $fixedValue, $openValue; 

    public $msg = []; 

    public $select_card = 0 , $select_category = 0, $select_ocassion = 0; 
    
    public  $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];
    
    public $info_gift, $donation_status = 0, $donation_gift = 0, $dynamicAmt = 0; 

    public $giver_name = [], $giver_mobile = [], $giver_email = [];

    public $mustLogin = false;

    protected $listeners = ['updateGiftInfo', 'donationStatus', 'updateAuth', 'updateDonationAmount', 'updateDynamicGiftAmount'];

    
    public function updatedUnitValueRadio($data){
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->donationQty = 1;
        $this->unitValueInput = "";
        $this->clear();
    }

    public function updatedUnitValueInput($value){
        $this->donationAmt = $value;
        $this->donationtype = $this->project['title'];
        $this->unitValueRadio = "";
        $this->clear();
    }

    public function updatedShareValue($data){
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->clear();
    }

    public function updatedOpenValue($value){

        $this->donationAmt = $value;
        $this->donationtype = $this->project['title'];
        $this->clear();
    }

    /**
     * @return [type]
     */
    public function updatedDonationQty(){
        if( $this->donation['type'] == 'fixed' ){
             $this->donationtype = $this->project['title'];
        }
        $this->clear();
    }

    public function updateGiftInfo($info, $amount = 0){
        if($amount != 0)$this->updateDonationAmount($amount);
        $this->info_gift = $info;
    }

    public function updateDynamicGiftAmount($val){
        $this->dynamicAmt = $val;
    }
    

    public function donationStatus($val){
        // $this->donation_status = $val;
        $this->clear();
        $this->donationAmt = 0;
        $this->donationtype = "";
        $this->unitValueRadio = "";
        $this->unitValueInput = "";
        $this->shareValue = "";
        $this->openValue = "";
        if($val == 0){
            if($this->donation['type'] == "fixed" ){ 
                $this->donationAmt = $this->donation['data'];
            }
        }
    }

    public function addToCart($showModal = true){
        
        $this->clear();
        
        if($this->donationAmt > 0){
            $item = new Item(CharityProject::class, $this->project['id'], $this->donationtype); // create item data 
            // add to card 
            $cart = new DatabaseCart();  //dd($item, $this->donationQty, $this->donationAmt);
            $this->msg = $cart->addItem($item, $this->donationQty, $this->donationAmt);
        }

        if($this->info_gift != null){
            foreach($this->info_gift as $ind => $cardInfo){
                if($cardInfo['saved'] == false){
                   $this->emit('updateMessageCard', $ind, trans('Please enter all fields'));
                   return false;
                }
            }
            // add gifts to cart
            $this->addCardsToCart();
        }
       
        // update in cart item 
        $this->emit('cartUpdated');
        
        if(@$this->msg['type'] == "success" && $showModal){
            // show model
            $this->emit('showModel');
            $this->emit('UpdategiftStatus', 0);
            $this->clearGift();
        }
        return true;
    }


    public function addCardsToCart(){
        $cart = new DatabaseCart();
        foreach(@session()->get('card') as $gift){
            $item = new Item(CharityProject::class, $this->project['id'], $gift['donationtype']);
            $info_gift =[
                'donationtype'  => $gift['donationtype'],
                'donationAmt'   => $gift['donationAmt'],
                'giver_name'    => $gift['giver_name'],
                'giver_mobile'  => $gift['giver_mobile'],
                'giver_email'   => $gift['giver_email'],
                'cardTitle'     => $gift['cardTitle'],
                'image'         => $gift['image'],
                'sendCopy'      => $gift['sendCopy'],
            ];
            $this->msg = $cart->addItem($item, $this->donationQty, $gift['donationAmt'], $info_gift);
        }
        session()->put('card', []);
        $this->emit('finishedSaveGifts');
    }

 
    public function clear(){
        $this->msg = [];
    }

    public function clearGift(){
        $this->msg = [];
        $this->donationAmt = 0;
        $this->donation_gift = 0;
        $this->dynamicAmt = 0;
        $this->donationtype = "";
        $this->giftStatus = false;
    }

    public function donateNow(){
        $status = $this->addToCart(false);
        if($status) redirect()->route('site.checkout.show');
    }

    public function updateAuth(){
        $mustLogin = SettingSingleton::getInstance()->getLoginStatus('show_login_project');
        if($mustLogin == true && @auth('account')->user()?->types->where('type', 'donor')->first()->id == null){
        $this->mustLogin = true;
        }
        else{
            $this->mustLogin = false;
        }
    }
    
    public function updateDonationAmount($val){
        $this->donation_gift = $this->donation_gift + $val;
    }
    
    public function mount($project){
        $this->project = $project;

        $gift_setting = SettingSingleton::getInstance();
        $this->cards  =  $gift_setting->getGift('gift_category');

        $this->donation = json_decode($this->project['donation_type'], true); 
        if($this->donation['type'] == "fixed" ){ 
            $this->donationAmt = $this->donation['data'];
        }
        if($this->donation['type'] == "open" ){ 
            $this->openValue = $this->donationAmt = $this->amount;
        }
        if($this->donation['type'] == "share" ){ 
            foreach($this->donation['data'] as $donshare){
                if($donshare['value'] == $this->amount){
                    $this->donationAmt = $this->amount;
                }
            };
        }
        if($this->donation['type'] == "unit" ){ 
            $this->unitValueInput = $this->donationAmt = $this->amount;
            foreach($this->donation['data'] as $donshare){
                if($donshare['value'] == $this->amount){
                    $this->donationAmt = $this->amount;
                    $this->unitValueInput = 0;
                }
            };
        }
        //calculate the progress bar:
        $target = $project['collected_target'] + $project['fake_target'];
        
        $this->progressBar['collected'] = $project['fake_target']; 
        $this->progressBar['reminder'] = $project['target_price'] - $this->progressBar['collected']; 
        $this->progressBar['percent'] = ceil($target * 100 / ($project['target_price'] == 0? 1 : $project['target_price'] ));

        $this->updateAuth();
    }



    public function render()
    {
        return view('livewire.site.charity-project.show');
    }
}
