<?php

namespace App\Http\Livewire\Site\FastDonation;

use App\Charity\Settings\SettingSingleton;
use App\Models\CategoryProjects;
use App\Models\CharityProject;
use Livewire\Component;

class Index extends Component
{

    public $open = false, $productStatus, $productIcon;
    public  $colors = [], $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];

    public $donor;
    public $mobile, $name , $dataDonation, $fast_status, $fast_color;
    public $categories = [], $projects = [], $project;
    public $selectedCategory, $selectedProject;

    public $donation, $donationAmt = 0, $paymentMethod, $donationtype, $msg;
    public $unitValueRadio, $unitValueInput, $shareValue, $fixedValue, $openValue; // price values

    protected $listeners = ['updateMessage'];


    public function updateFastDonationData(){
       $dataDonation = [
            'mobile'        => $this->mobile,
            'name'          => $this->name,
            'donationAmt'   => $this->donationAmt,
            'donationtype'  => $this->donationtype,
            'project'       => $this->project,
            'project_name'  => @$this->project?->trans()->where('locale', app()->getLocale())->first()->title,
        ];
        $this->emit('getFastDonationData', $dataDonation);
    }

    public function updateMessage($msg){
        $this->msg = $msg;
    }


    public function SelectPayment($val){
        
        if($this->mobile == ""){
            $this->msg = trans("Please fill in the mobile number to proceed.");
            return;
        }
        if($this->name == ""){
            $this->msg = trans("Please fill in the name to proceed.");
            return;
        }
        $this->paymentMethod = $val;
        $this->clear();
    }

    public function toogleOpen(){
        $this->open = !$this->open;
    }

    public function SelectCategory($id){
        $this->selectedCategory = $id;
        $this->projects = CharityProject::where('category_id', $id)->fastDonation()->get();
        $this->donationAmt = 0;
        $this->donation = null;
    }

    public function SelectProject(){
        $this->donationAmt = 0;
        $this->project = CharityProject::find($this->selectedProject);
        $this->donation = json_decode( $this->project['donation_type'], true);
        if ($this->donation['type'] == "fixed") {
            $this->donationAmt = @$this->donation['data'];
        }
        $this->clear();
    }

    public function updatedUnitValueRadio($data)
    {
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->unitValueInput = "";
        $this->clear();
    }

    public function updatedUnitValueInput($value)
    {
        $this->donationAmt = $value;
        $this->donationtype = $this->project['title'];
        $this->unitValueRadio = "";
        $this->clear();
    }

    public function updatedShareValue($data)
    {
        $data = json_decode($data);
        $this->donationAmt = $data->value;
        $this->donationtype = $data->name;
        $this->clear();
    }
    public function updatedOpenValue($value)
    {
        $this->donationtype = $this->project['title'];
        $this->donationAmt = $value;
        $this->clear();
    }
    public function updatedDonationQty()
    {
        if ($this->donation['type'] == 'fixed') {
            $this->donationtype = $this->project['title'];
        }
        $this->clear();
    }
    public function clear()
    {
        $this->msg = [];
        $this->updateFastDonationData();

    }

    public function mount(){
        // define color categories
        $settings = SettingSingleton::getInstance();
        $this->colors = $settings->getColor('donation_color');
        // define projects data
        $this->categories = CategoryProjects::active()->fastDonation()->get();

        $this->donor = @auth('account')->user()->donor;
        $this->mobile = @$this->donor->mobile;
        $this->name = @$this->donor->full_name;

        $this->productStatus = $settings?->getProductsData('status');
        $this->fast_status = $settings?->getProductsData('fast_status');
        $this->fast_color = $settings?->getProductsData('background_color');
        $this->productIcon = $settings?->getProductsData('image');

    }
   
    public function render()
    {   
        $this->updateFastDonationData();
        return view('livewire.site.fast-donation.index');
    }
}
