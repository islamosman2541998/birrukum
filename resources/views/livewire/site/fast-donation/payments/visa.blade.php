<div>
    <div class="tab-pane fade show active row " id="visa-pay" role="tabpanel" aria-labelled tabindex="0">
        <form wire:submit.prevent="checkout" class="">
            @include('livewire.site.payments.message')

            <h5 class="fs-6 mb-3"> @lang('Pay From Visa') </h5>

            @if(count($myCards??[]))
            <div class="payment-card payment-white p-1" id="paymentByCard" style="">

                @forelse ($myCards as $myCard)
                <div class="row selected_saved_card my-2">
                    <div class="text-start">
                        <label class="checkcontainer">
                            <span>({{ base64_decode($myCard->name) }})</span>
                            <span style="color:black">
                                {{ substr(($myCard->number), -4) . str_repeat('*', 4) }}
                            </span>
                            <img src="{{ site_path('img/visa/visa.jpg') }}" alt="visa" width="30" class="rounded-0 m-1">
                            <input type="radio" wire:model="selected_card" name="selected_card" value="{{ $myCard->id }}" class="select_card" data-gtm-form-interact-field-id="1">
                        </label>
                    </div>
                </div>
                <div class="row selected_cvv my-2 {{ $selected_card == $myCard->id ? 'd-block' : 'd-none'}} text-center">
                    <input type="text" wire:model="selected_cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" class="form-control col-md-6 only-number card-exp valid">
                </div>
                <hr>
                @empty

                @endforelse

                <label class="row text-start my-3 ms-4" id="add_new_card">
                    <div class="col-md-12" wire:click="addNewCardBlock()">
                        <i class="icofont-plus me-2" aria-hidden="true"></i>
                        @lang('Add Payment Card')
                    </div>
                </label>
                <hr>
            </div>
            @endif

            <div class="newCard {{ $this->showNewCard == false && count($myCards) != 0? 'd-none' :'d-block' }}">

                <div class="row mb-3">
                    <div class="col-12">
                        <input wire:model="card_number" type="text" class="form-control" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" placeholder="@lang('Card Number')" />
                        @error('card_number')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
          
                <div class="row mb-3">
                    <div class="col-12">
                        <input wire:model="card_name" type="text" class="form-control" placeholder="@lang('Card Name')" />
                        @error('card_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-6">
                        <input type="text" wire:model="expired_month" class="form-control text-center" placeholder="MM" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        @error('expired_month')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                    <div class="col-6">
                        <input type="text" wire:model="expired_year" class="form-control text-center" placeholder="YY" maxlength="2" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        @error('expired_year')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-12">
                        <input wire:model="cvv" type="text" class="form-control" placeholder="@lang('CVV')" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        @error('cvv')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                
            </div>
            <div class="row my-3">
                <div class="col-md-12">
                    <button class="btn bg-main w-100" type="submit"> @lang('Pay') </button>
                </div>
            </div>
            
        </form>
    </div>
</div>
