<div> 
    <div id="gift-block" class="my-3">
        <label class="form-check-label checkbox-label">
            <input class="form-check-input" wire:change="startGift()" wire:model="giftStatus" type="checkbox" @if($giftStatus==1) checked @endif>
            <span class="checkbox"></span>
            @lang('Donate on behalf of your family or friends and share the reward with them')
        </label>
    </div>
    <div>
        @forelse($cardFields as $index => $field)

            @if($cardInfo[$index]['saved'])
                <div class="gift-info mt-2">

                    <div class="form-group rounded-6">
                        <div class="text-start">
                            <i class="icofont-close-circled text-danger fs-4" wire:click="removeField({{ $index }})"></i>
                        </div>
                        <h5 class="fs-6 text-center"> @lang('The information of then given') </h5>
                        {{-- donation  --}}
                        <div class="row">
                            <div class="col-2">
                                <h6 class="fs-6 my-2 text-body-secondary"> @lang('Donation Amount')</h6>
                            </div>
                            <div class="col-10 gift-donation options">
                                <div class="row">
                                    <div class="col-6 col-md-6">
                                        <input type="text" wire:model="cardFields.{{ $index }}.donationAmt" disabled class="form-control">
                                    </div>
                                    <div class="col-6 col-md-6">
                                        <input type="text" wire:model="cardFields.{{ $index }}.donationtype" disabled class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-2">
                            <div class="mb-3 col-md-4">
                                <input type="text" wire:model="cardFields.{{ $index }}.giver_name" class="form-control" placeholder="@lang('Name')" disabled>
                            </div>
                            <div class="mb-3 col-md-4">
                                <input type="tel" wire:model="cardFields.{{ $index }}.giver_mobile" class="form-control" placeholder="@lang('Mobile')" disabled>
                            </div>
                            <div class="mb-3 col-md-4">
                                <input type="email" wire:model="cardFields.{{ $index }}.giver_email" class="form-control" placeholder="@lang('Email')" disabled>
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <div class="col-12 col-md-3">
                                <input type="text" wire:model="cardFields.{{ $index }}.cardTitle" value="{{ getImageFileManger($cardFields[$index]['image'])  }}" class="form-control" disabled>
                            </div>
                            <div class="col-md-3">
                                <a href="{{ getImageFileManger($cardFields[$index]['image']) }}" target="_blank">
                                    <img src="{{ getImageFileManger($cardFields[$index]['image']) }}" width="60">
                                </a>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-check-label checkbox-label my-3">
                                    <input wire:model="cardFields.{{ $index }}.sendCopy" class="form-check-input" type="checkbox" disabled>
                                    <span class="checkbox"></span>
                                    @lang('Send a copy of the card to my mobile phone')
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="gift-info mt-2">
                    <div class="form-group rounded-6">
                        @if($index == $errorIndex)
                        <div class="alert alert-danger text-center" role="alert">
                            {{ $cardInfoMessage }}
                        </div>
                        @endif
                        <div class="text-start">
                            <i class="icofont-close-circled text-danger fs-4" wire:click="removeField({{ $index }})"></i>
                            {{-- <i class="icofont-close-line text-danger fs-4"></i> --}}
                        </div>
                        {{-- Given info ---------------------------------- --}}
                        <h5 class="fs-6 text-center"> @lang('The information of then given') </h5>

                        {{-- donation  --}}
                        <div class="row my-3">
                            <div class="col-2">
                                <h6 class="fs-6 text-body-secondary"> @lang('Donation Amount')</h6>
                            </div>
                            <div class="col-10 gift-donation options">
                                @if(is_array($donation))
                                    @switch($donation['type'])
                                        @case('unit')
                                            <div class="options">
                                                @foreach ($donation['data'] as $key =>$data)
                                                <div class="option-item">
                                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount)] }} 
                                                                {{ $cardFields[$index]['unitValueRadio']  == json_encode($data) ? 'active' : null }} ">
                                                        <input wire:model.live="cardFields.{{ $index }}.unitValueRadio" wire:click="updateDonation({{ $index }})" type="radio" value="{{ json_encode($data) }}">
                                                        {{-- <h6 class="title">{{ $project['title'] }} </h6> --}}
                                                        <div class="price">
                                                            {{ $data['value'] }}
                                                            <small> &#65020;</small>
                                                        </div>
                                                    </label>
                                                </div>
                                                @endforeach
                                                <div class="mx-2">
                                                    <input type="number" wire:model.live="cardFields.{{ $index }}.unitValueInput" wire:change="updateDonation({{ $index }})" min="0" class="form-control py-4" placeholder="@lang('Another amount')">
                                                </div>
                                            </div>
                                        @break

                                        @case('share')
                                            <div class="options">
                                                @foreach ($donation['data'] as $key => $data)
                                                <div class="option-item">
                                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount)] }}  rounded-6 d-flex flex-row gap-1 
                                                                {{ @$cardFields[$index]['shareValue']  == json_encode($data) ? 'active' : null }}  ">
                                                        <input wire:model.live="cardFields.{{ $index }}.shareValue" type="radio" wire:click="updateDonation({{ $index }})" value="{{ json_encode($data) }}">
                                                        <h6 class="title">{{ $data['name'] }}</h6>
                                                        <div class="price">
                                                            <span>{{ $data['value'] }}</span>
                                                            <small> &#65020;</small>
                                                        </div>
                                                    </label>
                                                </div>
                                                @endforeach
                                            </div>
                                        @break

                                        @case('fixed')
                                            <div class="options">
                                                <div class="option-item">
                                                    <label title="{{ $project['title'] }}" class="bg-secound">
                                                        <h6 class="title">{{ $project['title'] }} </h6>
                                                        <div class="price">
                                                            {{ $donation['data'] }}
                                                            <small> &#65020;</small>
                                                        </div>
                                                    </label>
                                                </div>
                                            </div>
                                        @break

                                        @case('open')
                                            <div class="options">
                                                <div class="option-item">
                                                    <input type="number" wire:model="cardFields.{{ $index }}.openValue" min="0" wire:change="updateDonation({{ $index }})" class="form-control amount" placeholder="@lang('Donation Amount')">
                                                </div>
                                            </div>
                                        @break

                                    @default
                                        <span>Something went wrong, please try again</span>
                                    @endswitch
                                @endif

                            </div>
                        </div>

                        <div class="row">
                            <div class="mb-3 col-md-4">
                                <input type="text" wire:model="cardFields.{{ $index }}.giver_name" class="form-control" placeholder="@lang('Name')">
                            </div>
                            <div class="mb-3 col-md-4">
                                <input type="tel" wire:model="cardFields.{{ $index }}.giver_mobile" class="form-control" placeholder="@lang('Mobile')"
                                oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" >
                            </div>
                            <div class="mb-3 col-md-4">
                                <input type="email" wire:model="cardFields.{{ $index }}.giver_email" class="form-control" placeholder="@lang('Email')">
                            </div>
                        </div>


                        <div class="mb-3 row">
                            <div class="col-12 col-md-3">
                                <select wire:model="cardFields.{{ $index }}.giftType" wire:change="selectGiftType({{  $index }})" add class="form-control">
                                    <option value=""> @lang('Choose the gifting category') </option>
                                    @forelse ( json_decode($cards ??"", true)??[] as $keyCard => $cardtitle)
                                    <option value="{{ $keyCard }}"> {{ $cardtitle['title_' . app()->getLocale()] }} </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                            
                            <div class="col-md-9">
                                {{-- cards-------------------------------------------------- --}}
                                @if(@$cardInfo[$index]['cardImages'] != "")
                                    @forelse(json_decode(@$cardInfo[$index]['cardImages'], true)??[] as $keyImg => $img)
                                        <label class="btn btn-light gift-img group-img @if($cardFields[$index]['image'] == $img) active @endif" for="gift-{{ $keyImg }}">
                                            <input type="radio" id="gift-{{ $keyImg }}" class="d-relative" value="{{ $img }}" wire:model.live="cardFields.{{ $index }}.image" required="">
                                            <img width="100" height="100%" src="{{ getImageFileManger($img) }}" class="h-100 img-thumbnail" alt="lightbox">
                                        </label>
                                    @empty
                                    @endforelse
                                @endif
                            </div>
                        </div>


                        <div class="row">
                            <div class="col-12 col-md-6">
                                <label class="form-check-label checkbox-label my-3">
                                    <input wire:model="cardFields.{{ $index }}.sendCopy" class="form-check-input" type="checkbox">
                                    <span class="checkbox"></span>
                                    @lang('Send a copy of the card to my mobile phone')
                                </label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="text-start ">
                                    <button class="btn bg-main btn-small" wire:click="saveGiftInfo({{ $index }})">@lang('Save')</button>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            @endif

        @empty
      
        @endforelse

        @if($cardFields)
        <button wire:click="addField" class="btn btn-sm fs-6 mt-2 add-gift-btn my-3">
            <i class="icofont-plus ms-1 "></i>
            <span> @lang('Add a gift for someone else') </span>
        </button>
        @endif

        <!-- Bootstrap Modal HTML -->
        <div class="modal fade" id="popup" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">
                        <!-- Image will be inserted here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
