<div>
    <div class="tab-pane fade show active" id="visa-pay" role="tabpanel" aria-labelled tabindex="0">
        <h5 class="fs-6 mb-3"> @lang('Pay From Visa') </h5>
        <form wire:submit.prevent="checkout" class="">
            @include('livewire.site.payments.message')

            @if(count($myCards))
            <div class="payment-card payment-white p-1" id="paymentByCard" style="">

                @forelse ($myCards as $myCard)
                <div class="row selected_saved_card my-2">
                    <div class="col-md-3" >
                        <div class="selected_cvv {{ $selected_card == $myCard->id ? 'd-block' : 'd-none'}}">
                            <input type="text" wire:model="selected_cvv" placeholder="CVV" maxlength="3" inputmode="numeric" pattern="[0-9]*" class="form-control only-number card-exp valid">
                        </div>
                    </div>
                    <div class="col-md-9 text-start">
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
                <div class="mb-3 row">
                    <label class="col-12 col-form-label"> @lang('Card Number') </label>
                    <div class="col-12">
                        <input wire:model="card_number" type="text" class="form-control" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                        @error('card_number')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="col-12 col-form-label"> @lang('Card Name') </label>
                    <div class="col-12">
                        <input wire:model="card_name" type="text" class="form-control" />
                        @error('card_name')
                        <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="mb-3 row">
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-12 col-form-label">
                                @lang('Expired Date')
                            </label>
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
                    </div>
                    <div class="col-md-6">
                        <div class="row">
                            <label class="col-12 col-form-label">
                                @lang('CVV')
                            </label>
                            <div class="col-12">
                                <input type="text" wire:model="cvv" class="form-control text-center" placeholder="XXX" maxlength="3" inputmode="numeric" pattern="[0-9]*" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');" />
                                @error('cvv')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3 row">
                    <label class="form-check-label checkbox-label">
                        <input class="form-check-input" wire:model="savecard" type="checkbox" />
                        <span class="checkbox"></span>
                        @lang('Save the card data for future donations')
                    </label>
                </div>
                <div class="mb-3 row">
                    <label class="form-check-label checkbox-label">
                        <input class="form-check-input" type="checkbox" />
                        <span class="checkbox"></span>
                        @lang('agree for')
                        <a href="{{ route('site.page.show', 53) }}" target="_blank">@lang('Donation policies')</a>
                    </label>
                </div>
            </div>
            <div class="my-3 row">
                <div class="col-md-9 mb-1">
                    <button class="btn bg-main w-100" type="submit" @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled @endif> @lang('Pay') </button>
                </div>
                <div class="col-md-3 mb-1">
                    <a href="#" class="btn bg-secound w-100"> @lang('Cancel') </a>
                </div>
            </div>
        </form>
    </div>
</div>
