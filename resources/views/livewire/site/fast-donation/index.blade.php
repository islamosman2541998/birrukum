<div>
    @if($productStatus && $fast_status)
    <div id="quick-products">
        <a href="{{ route('site.charity-products.index') }}">
            <div class="quick-products-head">
                <span class="text d-none d-md-block" > @lang('Gift Product')</span>
                <span class="icon shadow" style="background-color: {{ $fast_color }};">
                    <img src="{{ getImage( $productIcon) }}" class=" img-fluid p-0 p-lg-2" alt="">
                    {{-- <i class="icofont-location-arrow rotate-270"></i> --}}
                </span>
            </div>
        </a>
    </div>
    @endif
    <div id="quick-donation" class="my-2 @if($open) open @endif">
        <div class="quick-donation-head" wire:click="toogleOpen()">
            <span class="text"> @lang('Fast Donation')</span>
            <span class="icon shadow"><i class="icofont-plus"></i></span>
        </div>
        <div class="quick-donation-body">
            <div class="categories-nav">
                <ul class="navbar-nav">
                    @forelse($categories as $key => $category)
                    <li class="nav-item">
                        <a class="nav-link @if($selectedCategory == $category->id) active @endif " wire:click="SelectCategory({{ $category->id }})">
                            {{ $category->trans->where('locale', $current_lang)->first()->title }}
                        </a>
                    </li>
                    @empty
    
                    @endforelse
                    <select wire:model="selectedProject" wire:change="SelectProject()" class="nav-item selectproduct">
                        <option value=""  selected>@lang('Choose a project')</option>
                        @forelse($projects as $key => $project)
                        <option value="{{ $project->id }}" class="nav-link">
                            {{ $project->trans->where('locale', $current_lang)->first()->title }}
                        </option>
                        @empty
                        @endforelse
                    </select>
                </ul>
            </div>
    
    
            <div class="row">
                @if(is_array($donation))
                    @switch($donation['type'])
                        @case('unit')
                        <div class="options my-2">
                            <div class="d-flex flex-row">
                                @forelse (@$donation['data'] ?? [] as $key => $data)
                                <div class="option-item">
                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" 
                                    class="{{ $colorsAmount[$key % count($colorsAmount)] }} rounded-6 d-flex flex-row {{ $unitValueRadio == json_encode($data) ? 'active' : null }}"
                                     style="background-color: {{  $colors[$key % count($colors)] }}!important">
                                        <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}">
                                        <div class="price">
                                            <span>{{ $data['value'] }}</span>
                                            <small class="large-screen"> &#65020;</small>
                                        </div>
                                    </label>
                                </div>
                                @empty
                                @endforelse
                                <div class="unit-value mx-2">
                                    <input type="number" wire:model.live="unitValueInput" min="0" class="form-control " placeholder="@lang('Another amount')&nbsp; &nbsp; &nbsp; &nbsp">
                                </div>
                            </div>
                        </div>
                        @break
    
                        @case('share')
                        <div class="options my-2">
                            @forelse (@$donation['data']??[] as $key => $data)
                            <div class="option-item">
                                <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount)] }} rounded-6 d-flex flex-row gap-1 {{ $shareValue == json_encode($data) ? 'active' : null }}" style="background-color: {{  $colors[$key % count($colors)] }}!important">
                                    <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}">
                                    <div class="price">
                                        <span>{{ $data['value'] }}</span>
                                        <small class="large-screen"> &#65020;</small>
                                    </div>
                                </label>
                            </div>
                            @empty
                            @endforelse
                        </div>
                        @break
    
                        @case('fixed')
                        <div class="options my-2">
                            <div class="option-item">
                                <label title="{{ @$project['title'] }}" class="bg-secound rounded-6 d-flex flex-row gap-1">
                                    <div class="price">
                                        {{ @$donation['data'] }}
                                        <small> &#65020;</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                        @break
    
                        @case('open')
                        <div class="options my-2">
                            <div class="option-item">
                                <input type="number" wire:model="openValue" min="0" class="form-control amount" placeholder="@lang('Price')">
                            </div>
                        </div>
                        @break
    
                    @default
                        <span>Something went wrong, please try again</span>
                    @endswitch  
                @endif
            </div>
    
            @if(!@$donor )
            @if($msg)
                <div class="row">
                    <span class="text-danger col-12">{{ $msg }}</span>
                </div>
            @endif
                <div class="row">
                    <div class="col-12 mt-2">
                        <input type="number" wire:model="mobile" class="form-control" placeholder="@lang('Mobile')" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9">
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 my-2">
                        <input type="text" wire:model="name" class="form-control" placeholder="@lang('Name')">
                    </div>
                </div>
            @endif
    
          
            <div class="quick-donation-footer">
                <div class="card mb-3">
                    <div class="card-body">
                        <p>@lang('Payment Method')</p>
                        <ul class="nav nav-pills nav-justified" id="payment-methods">
                            <li class="nav-item" role="presentation">
                                <button wire:click="SelectPayment('visa')"   @if(!$donationAmt) disabled @endif class="nav-link @if($paymentMethod == "visa") active @endif" data-bs-toggle="pill" data-bs-target="#visa-pay" type="button" aria-selected="true">
                                    <span class="img">
                                        <img src="{{ site_path('img/payments/visa-mada.png') }}" alt="" />
                                    </span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button wire:click="SelectPayment('applePay')" @if(!$donationAmt) disabled @endif  class="nav-link @if($paymentMethod == "applePay") active @endif" data-bs-toggle="pill" data-bs-target="#apple-pay" type="button" aria-selected="true">
                                    <span class="img">
                                        <img src="{{ site_path('img/payments/apple-pay.png') }}" alt="" />
                                    </span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button wire:click="SelectPayment('bankTransfer')"  @if(!$donationAmt) disabled @endif class="nav-link @if($paymentMethod == "bankTransfer") active @endif" data-bs-toggle="pill" type="button" role="tab" aria-selected="true">
                                    <span class="img">
                                        <img src="{{ site_path('img/payments/bank-transfer.png') }}" alt="" />
                                    </span>
                                </button>
                            </li>
                        </ul>
                        <!-- tab-content/ -->
                        @if($donationAmt)
                            <div class="tab-content my-3" id="pills-tabContent2">
                
                                <!-- visa-pay-tab -->
                                @if($paymentMethod == "visa")
                                    @livewire('site.fast-donation.payments.visa')
                
                                <!-- apple-pay-tab -->
                                @elseif($paymentMethod == "applePay")
                                    @livewire('site.fast-donation.payments.apple-pay')
                
                                <!-- transfer-pay-tab -->
                                @elseif($paymentMethod == "bankTransfer")
                                    @livewire('site.fast-donation.payments.bank-transfer')
                                    
                                @endif
                            </div>
                        @endif
                    </div>
                </div>
            </div>
          
        </div>
    </div>
</div>
