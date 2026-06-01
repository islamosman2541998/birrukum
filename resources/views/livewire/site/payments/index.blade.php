<div>
    {{-- Payment --------------------------------------------------- --}}
    <div class="card mb-3">
        <div class="card-body">
            <h5 class="fs-6 mb-3">@lang('Payment Method')</h5>
            <ul class="nav nav-pills nav-justified" id="payment-methods">
                <li class="nav-item" role="presentation">
                    <button wire:click="SelectPayment('visa')" class="nav-link @if($paymentMethod == "visa") active @endif" data-bs-toggle="pill" data-bs-target="#visa-pay" type="button" aria-selected="true">
                        <span class="img">
                            <img src="{{ site_path('img/payments/visa-mada.png') }}" alt="" />
                        </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="SelectPayment('applePay')" class="nav-link @if($paymentMethod == "applePay") active @endif" data-bs-toggle="pill" data-bs-target="#apple-pay" type="button" aria-selected="true">
                        <span class="img">
                            <img src="{{ site_path('img/payments/apple-pay.png') }}" alt="" />
                        </span>
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button wire:click="SelectPayment('bankTransfer')" class="nav-link @if($paymentMethod == "bankTransfer") active @endif" data-bs-toggle="pill" type="button" role="tab" aria-selected="true">
                        <span class="img">
                            <img src="{{ site_path('img/payments/bank-transfer.png') }}" alt="" />
                        </span>
                    </button>
                </li>
            </ul>
            <!-- tab-content/ -->
            <div class="tab-content my-3" id="pills-tabContent2">

                <!-- visa-pay-tab -->
                @if($paymentMethod == "visa")
                    @livewire('site.payments.visa')

                <!-- apple-pay-tab -->
                @elseif($paymentMethod == "applePay")
                    @livewire('site.payments.apple-pay')

                <!-- transfer-pay-tab -->
                @elseif($paymentMethod == "bankTransfer")
                    @livewire('site.payments.bank-transfer')
                    
                @endif
            </div>
        </div>
    </div>
</div>
