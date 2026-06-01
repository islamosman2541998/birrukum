<div>
    <div class="row">
        <!-- project -->
        <div class="col-lg-8">
            <div class="product-list">
                @php $total = 0; @endphp
                @forelse ($items as $key => $itemCart)
                <div class="card mt-2">
                    <div class="card-body">
                        @if($itemCart->item_type == "App\Models\Product")
                            <a href="{{ route('site.charity-product.show', @$itemCart->item?->trans->where('locale', app()->getLocale())->first()?->slug ) }}">
                                <h5 class="title text-success"> {{ @$itemCart->item_name }} <small class="text-secondary"> ({{ $itemCart['item_sub_type'] }} ) </small> </h5>
                            </a>
                            @else
                            <a href="{{ route('site.charity-project.show', @$itemCart->item?->trans->where('locale', app()->getLocale())->first()?->slug ) }}">
                                <h5 class="title text-success"> {{ @$itemCart->item_name }} <small class="text-secondary"> ({{ $itemCart['item_sub_type'] }} )</small> </h5>
                            </a>
                        @endif

                        <div class="row">
                            <div class="col-2 col-md-4 p-0">
                                @if($itemCart->item_type == "App\Models\Product")
                                <span class="cart-img">
                                    <img src="{{ getImage($itemCart->item->cover_image) }}" alt="" />
                                </span>
                                @php
                                $given_datails = json_decode($itemCart['givten_details']);
                                @endphp
                                @if($given_datails)
                                <button class="btn btn-sm btn-success m-1" data-bs-toggle="modal" data-bs-target="#giftGiven{{ $key }}">
                                    <i class="icofont-flora-flower mx-1"></i>
                                </button>
                                <div class="modal fade" id="giftGiven{{ $key }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-success" id="staticBackdropLabel"> @lang('The information of then given')</h5>
                                            </div>
                                            <div class="modal-body h6">

                                                <div class="row">
                                                    <div class="col-md-6 col-12">
                                                        <p class="text-dark"> <span class="text-dark-blue"> @lang('Name') : </span>{{ $given_datails?->giver_name }}</p>
                                                    </div>
                                                    <div class="col-md-6 col-12">
                                                        <p class="text-dark"> <span class="text-dark-blue"> @lang('Mobile') : </span> {{ @$given_datails->giver_mobile }}</p>
                                                    </div>
                                                    <div class="col-md-12 col-12">
                                                        <p class="text-dark"> <span class="text-dark-blue"> @lang('address') : </span> {{ @$given_datails->giver_address }}</p>
                                                    </div>
                                                    {{-- <div class="col-md-12 col-12">
                                                                <p class="text-dark"> <span class="text-dark-blue"> @lang('Gift message') : </span> {{ @$given_datails->giver_message }}</p>
                                                </div> --}}
                                            </div>
                                            @if(@$itemCart->gift_card_details != NULL)
                                            @php
                                            $card_details = json_decode($itemCart['gift_card_details']);
                                            @endphp
                                            <hr class="my-2">
                                            <div class="row">
                                                <div class="col-md-6 col-12">
                                                    <p class="text-dark"> <span class="text-dark-blue"> @lang('Donation field') : </span> {{ @$card_details->occasionName }}</p>
                                                </div>
                                                <div class="col-md-6 col-12">
                                                    <p class="text-dark"> <span class="text-dark-blue">@lang('Gifting occasions') : </span> {{ @$card_details->categoryName }}</p>
                                                </div>
                                                <div class="col-md-3 col-12">
                                                    <p class="text-dark"> <span class="text-dark-blue">@lang('card'): </span></p>

                                                </div>
                                                <div class="col-md-6 col-12 mt-3">
                                                    <img src="{{ getImageThumb($card_details->cardImage) }}" class="rounded" alt="">
                                                </div>
                                            </div>

                                            @endif
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-danger btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @else
                                <button class="btn btn-sm btn-warm warm m-1" data-hover="@lang('please add the data')" wire:click="openModal({{ $itemCart->id }})" data-bs-toggle="modal" data-bs-target="#giftGivenEmpty{{ $itemCart->id }}">
                                    <i class="icofont-info-circle mx-1"></i>
                                </button>
                                <div class="modal fade @if(@$showModal[$itemCart->id])show @endif" id="giftGivenEmpty{{ $itemCart->id }}" @if(@$showModal[$itemCart->id])style="display: block;"@endif data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title text-danger" id="staticBackdropLabel"> @lang('Please compleate the information of then given')</h5>

                                            </div>
                                            <div class="modal-body h6">
                                                @if($giftError)
                                                <div class="col-md-12 col-12 my-1 text-center">
                                                    <span class="text-danger"> {{ $giftError }}</span>
                                                </div>
                                                @endif
                                                <div class="row">
                                                    <div class="col-md-12 text-center mb-3">
                                                        <img src="{{ getImage($itemCart->item->cover_image) }}" width="40px" />
                                                        {{ @$itemCart->item_name  }}
                                                    </div>
                                                    <div class="col-md-6 col-12 my-1">
                                                        <label for="input-1" class="col-sm-12 col-form-label">@lang('Name')</label>
                                                        <input type="text" wire:model.defer="cardFields.{{ $itemCart->id }}.giver_name" class="form-control" required>
                                                        @error('cardFields.{{$itemCart->id}}.giver_name')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-6 col-12 my-1">
                                                        <label for="input-2" class="col-sm-12 col-form-label">@lang('Mobile')</label>
                                                        <input id="phone" type="tel" wire:model.defer="cardFields.{{ $itemCart->id }}.giver_mobile" required dir="rtl" class="form-control phone numberInput" placeholder="5XXXXXXXX" data-inputmask="'mask': '9999999999'" maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                                                        @error('cardFields.{{$itemCart->id}}.giver_mobile')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    <div class="col-md-12 col-12 my-1">
                                                        <label for="input-3" class="col-sm-2 col-form-label">@lang('Address')</label>
                                                        <input type="text" wire:model.defer="cardFields.{{ $itemCart->id }}.giver_address" class="form-control" required>
                                                        @error('cardFields.{{$itemCart->id}}.giver_address')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                    {{-- <div class="col-md-12 col-12 my-1">
                                                                    <label for="input-4" class="col-sm-12 col-form-label">@lang('Gift message')</label>
                                                                    <textarea wire:model.defer="cardFields.{{ $itemCart->id }}.giver_message" class="form-control" rows="3">{{ @$cardFields[$itemCart->id]->giver_message }}</textarea>
                                                    @error('cardFields.{{$itemCart->id}}.giver_message')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div> --}}

                                                <div class="col-md-12 col-12 mt-2 text-start">
                                                    <button wire:click.defer="saveGiftInfo({{ $itemCart->id }})" class="bg-success btn text-white">
                                                        @lang('Save')
                                                    </button>
                                                    <button type="button" class="btn bg-danger btn-secondary" data-bs-dismiss="modal" aria-label="Close" wire:click="closeModal({{ $itemCart->id }})">
                                                        @lang('Close')
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <script>
                                window.addEventListener('closemodal', (event) => {
                                    itemId = event.detail;
                                    console.log('#giftGivenEmpty' + itemId);
                                    console.log(itemId);
                                    $('#giftGivenEmpty' + itemId).modal().hide();
                                    $('#giftGivenEmpty' + itemId).modal('hide');
                                    $('.modal-backdrop').remove();
                                });

                            </script>
                            @endif

                            @if(@$itemCart->gift_projects_details != NULL)

                            <button class="btn btn-sm btn-secound m-1" data-bs-toggle="modal" data-bs-target="#gifcard{{ $key }}">
                                <i class="icofont-heart-alt mx-1"></i>
                            </button>

                            <div class="modal fade" id="gifcard{{ $key }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-success" id="staticBackdropLabel"> @lang('The information of then donation Project')</h5>
                                        </div>
                                        <div class="modal-body h6">
                                            @php
                                            $projectCard = json_decode($itemCart['gift_projects_details']);
                                            $itemCart['price'] += @$projectCard->price;
                                            @endphp
                                            <p class="text-dark"> <span class="text-dark-blue">@lang('item_name') : </span>{{ @$projectCard->item_name }}</p>
                                            <p class="text-dark"> <span class="text-dark-blue">@lang('item_sub_type') :</span> {{ @$projectCard->item_sub_type }}</p>
                                            <p class="text-dark"> <span class="text-dark-blue">@lang('price') : </span>{{ @$projectCard->price }}</p>
                                            <p class="text-dark"> <span class="text-dark-blue h6">@lang('quantity') : </span>{{ @$projectCard->quantity }}</p>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-danger btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @else
                            <span class="cart-img">
                                <img src="{{ getImage($itemCart->item->background_image) }}" alt="" />
                            </span>
                            @if($itemCart['gift_details'] != "null" && $itemCart['gift_details'] != NULL)
                            <button class="btn btn-sm btn-success m-1" data-bs-toggle="modal" data-bs-target="#giftCardModal{{ $key }}">
                                <i class="icofont-gift"></i>
                            </button>
                            <!-- Modal -->
                            <div class="modal fade" id="giftCardModal{{ $key }}" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title text-success" id="staticBackdropLabel"> @lang('The information of then given')</h5>
                                        </div>
                                        <div class="modal-body h6">
                                            @php
                                            $gift_details = json_decode($itemCart['gift_details']);
                                            @endphp
                                            <p class="text-dark"> <span class="text-dark-blue"> @lang('Project name') : </span>
                                                {{ $gift_details->donationtype }}
                                            </p>
                                            <p class="text-dark"> <span class="text-dark-blue"> @lang('Donation Amount') : </span>
                                                {{ $gift_details->donationAmt }}
                                            </p>
                                            <p class="text-dark"> <span class="text-dark-blue"> @lang('Name') : </span>
                                                {{ $gift_details->giver_name }}
                                            </p>
                                            <p class="text-dark"> <span class="text-dark-blue"> @lang('Mobile') : </span>
                                                {{ $gift_details->giver_mobile }}
                                            </p>
                                            <p class="text-dark"> <span class="text-dark-blue"> @lang('Email') : </span>
                                                {{ $gift_details->giver_email }}
                                            </p>
                                            <p class="text-dark"> <span class="text-dark-blue"> @lang('Send a copy of the card to my mobile phone') : </span>
                                                {{ $gift_details->sendCopy == 1 ? trans('yes') : trans('no') }}
                                            </p>
                                            <img src="{{ getImageThumb(@$gift_details->image) }}" class="rounded" alt="">
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn bg-danger btn-secondary" data-bs-dismiss="modal">@lang('Close')</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                            @endif
                            </div>
                            <div class="col-7 col-md-4 text-center">
                                <p class="text-success">الوحده <span class="total_num bg-light mx-2"> {{ $itemCart['price']  }} <small> &#65020;</small> </span></p>
                                <p class="text-success  mt-3">
                                    الكمية
                                    <span class="cart-number bg-light px-2 mx-2">
                                        <span wire:click="minus({{ $itemCart->id }})" class="btn-number">
                                            <i class="icofont-minus"></i>
                                        </span>
                                        <span class="px-2">{{ $itemCart['quantity'] }}</span>
                                        <span wire:click="plus({{ $itemCart->id }})" class="btn-number">
                                            <i class="icofont-plus"></i>
                                        </span>
                                    </span>
                                </p>

                            </div>
                            <div class="col-3 col-md-2 d-flex justify-content-center align-items-center mt-sm-1">
                                @php $total += ($itemCart['price'] * $itemCart['quantity'] ); @endphp
                                <p class="price"><span class="cart-price">{{ ($itemCart['price'] * $itemCart['quantity'] ) }}</span> <small class="text-dark"> &#65020;</small> </p>
                            </div>
                            <div class="col-12 col-md-1 d-flex justify-content-end align-items-center">
                                <a wire:click="removeItem({{ $itemCart->id }})" class="text-secondary"><i class="icofont-trash"></i></a>
                            </div>
                </div>
            </div>
        </div>
        @empty
        <li>
            <span class="body text-center">
                <h5> @lang('The cart is empty') </h5>
            </span>
        </li>
        @endforelse
        @if(count($items))
        <li class="justify-content-end">
            <span>
                <p wire:click="emptyCart()" class="bg-secondary px-3 py-1 rounded">
                    @lang('Empty Cart')
                </p>
            </span>
        </li>
        @endif

    </div>
</div>


<!-- card -->
<div class="col-lg-4">
    <div class="d-none d-md-block d-lg-block">
        @livewire('site.auth.index', ['type' => 'cart'])
    </div>

    <div>
        <ul class="nav nav-pills nav-justified" id="pills-tab">
            <li class="nav-item" role="presentation">
                <h2 class="bg-main rounded-6 p-2"> @lang('Total') </h2>
            </li>
        </ul>

        <div class="card  mb-3">
            <div class="card-body text-center">
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="form-1" role="tabpanel" aria-labelled tabindex="0">
                        <h1 class="text-main">{{ $total }} <small> &#65020;</small> </h1>
                        <a href="{{ route('site.checkout.show') }}" class="btn bg-main p-2 mt-4">
                            <h5> @lang('Continue Payment') </h5>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-block  d-md-none d-lg-none">
        @livewire('site.auth.index', ['type' => 'cart'])
    </div>
</div>
</div>
