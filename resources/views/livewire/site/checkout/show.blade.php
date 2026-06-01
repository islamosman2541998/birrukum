<div class="row">
    <!-- project -->
    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-body">
                <ul class="product-list">
                    @php $total = 0; @endphp
                    @forelse ($items as $itemCart)
                    <li>
                        @if($itemCart->item_type == "App\Models\Product")
                                <span class="img">
                                    <img src="{{ getImage($itemCart->item->cover_image) }}" alt="" />
                                </span>
                                <span class="body">
                                    <a href="{{ route('site.charity-product.show', @$itemCart->item?->trans->where('locale', app()->getLocale())->first()?->slug ) }}" class="text-secondary">
                                        <h5 class="title"> {{ @$itemCart->item_name }} </h5>
                                    </a>
                                    <span>{{ trans($itemCart['item_sub_type']) }}</span>
                                    @if(@$itemCart->gift_projects_details != NULL)
                                    @php
                                        $projectCard = json_decode($itemCart['gift_projects_details']);
                                        $itemCart['price'] += @$projectCard->price;
                                    @endphp
                                        <i class="icofont-heart-alt text-success mx-1"></i>
                                    @endif

                                    @if($itemCart->item_type == "App\Models\Product")
                                        @php
                                            $given_datails = json_decode($itemCart['givten_details']);
                                        @endphp
                                        @if($given_datails)
                                        <i class="icofont-flora-flower text-success mx-1"></i>
                                        @else
                                            <button class="btn btn-sm btn-warm warm" data-hover="@lang('please add the data')"  >
                                                <i class="icofont-info-circle mx-1" data-bs-toggle="modal" wire:click="openModal({{ $itemCart->id }})" data-bs-target="#giftGivenEmpty{{ $itemCart->id }}"></i>
                                            </button>
                                            <div class="modal fade @if(@$showModal[$itemCart->id])show @endif"  id="giftGivenEmpty{{ $itemCart->id }}"  @if(@$showModal[$itemCart->id])style="display: block;"@endif data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-hidden="true">
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
                                                                    <img src="{{ getImage($itemCart->item->cover_image) }}"  width="40px" />
                                                                    {{ @$itemCart->item_name  }}
                                                                </div>

                                                                <div class="col-md-6 col-12 my-1">
                                                                    <label for="input-1" class="col-sm-12 col-form-label">@lang('Name')</label>
                                                                    <input type="text" wire:model.defer="cardFields.{{ $itemCart->id }}.giver_name" class="form-control" required >
                                                                    @error('cardFields.{{$itemCart->id}}.giver_name')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror  
                                                                </div>
                                                                <div class="col-md-6 col-12 my-1">
                                                                    <label for="input-2" class="col-sm-12 col-form-label">@lang('Mobile')</label>
                                                                    <input id="phone" type="tel" wire:model.defer="cardFields.{{ $itemCart->id }}.giver_mobile" required dir="rtl" class="form-control phone numberInput" placeholder="5XXXXXXXX" data-inputmask="'mask': '9999999999'"maxlength="9" oninput="this.value = this.value.replace(/[^0-9]/g, '');" />
                                                                    @error('cardFields.{{$itemCart->id}}.giver_mobile')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror                                                            
                                                                </div>
                                                                <div class="col-md-12 col-12 my-1">
                                                                    <label for="input-3" class="col-sm-2 col-form-label">@lang('Address')</label>
                                                                    <input type="text" wire:model.defer="cardFields.{{ $itemCart->id }}.giver_address" class="form-control" required >
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
                                                            
                                                                <div class="col-md-12 col-12 mt-1 text-start">
                                                                    <button wire:click.defer="saveGiftInfo({{ $itemCart->id }})" class="bg-success btn text-white">
                                                                        @lang('Save')
                                                                    </button>
                                                                    <button type="button" class="btn bg-danger btn-secondary" data-bs-dismiss="modal" aria-label="Close"  wire:click="closeModal({{ $itemCart->id }})">
                                                                        @lang('Close')
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
    
                                            <script>
                                                window.addEventListener('closemodal', (event) =>{
                                                    itemId = event.detail;
                                                    console.log('#giftGivenEmpty'+itemId);
                                                    console.log(itemId);
                                                    $('#giftGivenEmpty'+itemId).modal().hide();
                                                    $('#giftGivenEmpty'+itemId).modal('hide');
                                                    $('.modal-backdrop').remove();
                                                });
                                            </script>
                                        @endif
                                    @endif 

                                    
                                </span>
                            @else
                                <span class="img">
                                    <img src="{{ getImage($itemCart->item->background_image) }}" alt="" />
                                </span>
                                <span class="body">
                                    <a href="{{ route('site.charity-project.show', @$itemCart->item?->trans->where('locale', app()->getLocale())->first()?->slug ) }}" class="text-secondary">
                                        <h5 class="title"> {{ @$itemCart->item_name }} </h5>
                                    </a>
                                    <span>{{ $itemCart['item_sub_type'] }}</span>
                                    @if($itemCart['gift_details'] != "null" && $itemCart['gift_details'] != NULL)
                                        <i class="icofont-gift text-success"></i>
                                    @endif
                                </span>
                            @endif
                     
                        @php $total += ($itemCart['price'] * $itemCart['quantity'] ); @endphp
                        <span class="price text-start"> {{ $itemCart['price'] * $itemCart['quantity']  }} <small> &#65020;</small> </span>
                    </li>
                    @empty
                    <li>
                        <span class="body text-center">
                            <h5>@lang('Empty Cart')</h5>
                        </span>
                    </li>
                    @endforelse
                </ul>
            </div>
            <div class="cart-total">
                <span class="title"> @lang('Total')  </span>
                <span class="price"> {{ $total }} <small> &#65020;</small>  </span>
            </div>
        </div>
    </div>
    <!-- card -->
    <div class="col-lg-4">
        <div id="checkout">
            
            @livewire('site.auth.index', ['type' => 'checkout'])

            @livewire('site.payments.index')
        </div>

    </div>
</div>
