<?php

namespace App\Http\Livewire\Site\Payments;

use Livewire\Component;

class Index extends Component
{
    public  $paymentMethod = "visa";

    protected $listeners = ['updateAuth'];

    public function updateAuth()
    {
        if(@auth('account')->user()?->types->where('type', 'donor')->first() != null){
            $this->render();
        }
    }

    public function SelectPayment($val){
        $this->paymentMethod = $val;
    }

    public function render()
    {
        return view('livewire.site.payments.index');
    }
}
