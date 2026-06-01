<?php

namespace App\Http\Livewire\Site\Home;

use Livewire\Component;
use App\Charity\Carts\Item;
use App\Models\CharityProject;
use App\Charity\Carts\DatabaseCart;
use App\Charity\Settings\SettingSingleton;

class Project extends Component
{
    public $project;
    public $progressBar = ['collected' => 0, 'reminder' => 0, 'percent' => 0];
    public $donation;
    public $msg = [];

    public $unitValueRadio, $unitValueInput, $shareValue, $fixedValue, $openValue; // price values

    public $donationAmt,  $donationtype = "", $donationQty = 1; // cart info 

    public  $colors = [], $colorsAmount = ['bg-secound', 'bg-main', 'bg-dark'];


    public function mount($project)
    {
        // define color categories
        $settings = SettingSingleton::getInstance();
        $this->colors = $settings->getColor('donation_color');
        // define projects data
        $this->project = $project;
        $this->donation = json_decode($this->project['donation_type'], true);
        if ($this->donation['type'] == "fixed") {
            $this->donationAmt = @$this->donation['data'];
        }
        //calculate the progress bar:
        $target = $project['collected_target'] + $project['fake_target'];
        $this->progressBar['collected'] = $project['fake_target'];
        $this->progressBar['reminder'] = $project['target_price'] - $this->progressBar['collected'];
        $this->progressBar['percent'] = ceil($target * 100 / ($project['target_price'] == 0 ? 1 : $project['target_price']));
        $this->project['slug'] = $this->project['trans'][0]['slug'];
        $this->project['title'] = $this->project['trans'][0]['title'];
        $this->project['description'] = $this->project['trans'][0]['description'];
        // $this->progressBar['percent'] = $project['target_price'] <= 0 ? 0 : floor(($this->progressBar['collected'] /  $project['target_price']) * 100); 
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

    public function donate($id)
    {
        return redirect()->route('site.charity-project.show', $id);
    }

    public function addToCart()
    {
        $this->clear();
        $item = new Item(CharityProject::class, $this->project['id'], $this->donationtype); // create item data 
        // add to card 
        $cart = new DatabaseCart();
        $this->msg = $cart->addItem($item, $this->donationQty, $this->donationAmt);
        // update in cart item 
        $this->emit('cartUpdated');
        // show model
        if ($this->msg['type'] == "success") {
            $this->emit('showModel');
        }
    }

    public function clear()
    {
        $this->msg = [];
    }

    public function render()
    {
        $donationAmt = 0;
        $donationtype = "";
        return view('livewire.site.home.project');
    }
}
