<div>
    @if($show_auth)
        @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null)
        

        <ul class="nav nav-pills nav-justified mb-3" id="pills-tab">
            <li class="nav-item" role="presentation">
                <button class="nav-link @if(!$new_donor) active @endif"  wire:click="updateNewDonor(0)"  data-bs-toggle="pill" data-bs-target="#form-1" type="button" role="tab" aria-controls="form-1" aria-selected="true">
                    @lang('Old Donor')
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link @if($new_donor) active @endif" id="pills-profile-tab"  wire:click="updateNewDonor(1)"  data-bs-toggle="pill" data-bs-target="#form-2" type="button">
                    @lang('New Donor')
                </button>
            </li>
        </ul>

        <div class="card mb-3">
            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    @if(!$new_donor)
                        <div class="tab-pane fade show active">
                            <form class="" action="#">
                                <div class="mb-3 row">
                                    <label class="col-12 col-form-label">@lang('Mobile')</label>
                                    <div class="col-12">
                                        <input id="phone" type="tel" wire:model="mobile" class="form-control phone numberInput" placeholder="5XXXXXXXX"  id="mobile" data-inputmask="'mask': '9999999999'"
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" />
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center text-center">
                                    <div class="col-md-6">
                                        <button class="btn bg-main" type="button"  wire:click="login()"> @lang('Send') </button>
                                    </div>
                                </div>
                                
                                <div class="row text-center">
                                    <div class="col">
                                        @if($authError)
                                        <h5 class="success-message text-danger">
                                            <span class="icon">  <i class="icofont-close"></i> </span>
                                            <span class="message"> {{ $authError }}</span>
                                        </h5>
                                        @endif
                                        @if($authMessage)
                                            <h5 class="success-message">
                                                <span class="icon">  <i class="icofont-check"></i> </span>
                                                <span class="message"> {{ $authMessage }} </span>
                                            </h5>
                                        @endif
                                    </div>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="tab-pane fade show active" >
                            <form class="" action="#">
                                <div class="mb-3 row">
                                    <label class="col-12 col-form-label">الإسم</label>
                                    <div class="col-12">
                                        <input type="text" wire:model="name" class="form-control" />
                                            @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-form-label">الجوال</label>
                                    <div class="col-12">
                                        <input id="phone" type="tel" wire:model="mobile" class="form-control phone numberInput" placeholder="5XXXXXXXX" data-inputmask="'mask': '9999999999'" 
                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" />
                                        @error('mobile')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 row">
                                    <label class="col-12 col-form-label">الإيميل</label>
                                    <div class="col-12">
                                        <input type="email" wire:model="email" class="form-control" />
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mb-3 justify-content-center  text-center">
                                    <div class="col-md-6">
                                        <button class="btn bg-main" type="button"  wire:click="register()">@lang('Send') </button>
                                    </div>
                                </div>
                                @if($authError)
                                    <h5 class="success-message text-danger">
                                        <span class="icon">  <i class="icofont-close"></i> </span>
                                        <span class="message"> {{ $authError }}</span>
                                    </h5>
                                @endif
                                @if($authMessage)
                                    <h5 class="success-message">
                                        <span class="icon">  <i class="icofont-check"></i> </span>
                                        <span class="message"> {{ $authMessage }} </span>
                                    </h5>
                                @endif
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    @endif
    
    <!-- OTP Modal -->
    <div class="modal fade @if($otp_modal)show @endif" @if($otp_modal)style="display: block;"@endif  id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">@lang('OTP') </h5>
            <div class="col-md-3 text-start">
                <button type="button" wire:click="closeModalOTP()" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            </div>
            <div class="modal-body">
                <div class="row text-center">
                    <div class="col-md-9">
                        <input type="text" max="4" min="4" wire:model="otp" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-success" type="button"  wire:click="checkOTP()">@lang('Send') </button>
                    </div>
                    @if($otpError)
                        <h5 class="success-message text-danger mt-3">
                            <span class="message"> {{ $otpError }} </span>
                        </h5>
                    @endif
                    
                </div>
            </div>
        </div>
        </div>
    </div>
    @endif
</div>
