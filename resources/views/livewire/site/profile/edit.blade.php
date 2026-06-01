<div>
    <form wire:submit.prevent="updateProfile">
        @csrf
        <div class="info row px-5 bg-white m-md-5 border-main">
            <h1 class="col-12 fs-2 text-center mt-5" dir="rtl"> @lang('personal account information') </h1>
            <div class="row personl_info mt-3 mb-3">
                <i class="icofont-user-alt-3 col-2 fa-user-pen fs-2"></i>
                <input type="text" class="border-0 col-10 @error('full_name') is-invalid @enderror" wire:model="full_name" value="{{ $donor->full_name }}"  placeholder="عمرو ××××××××××××× " />
                @error('full_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
                
            </div>
            <hr class="spater" />
            <div class="row personl_info mt-2 mb-3">
                <i class="icofont-phone fa-envelope col-2 fs-2 mt-2"></i>
                <input type="text" class="border-0 col-10 @error('mobile') is-invalid @enderror" wire:model="mobile" value="{{ $donor->account->mobile }}" placeholder="5xxxxxxxx" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" />
                @error('mobile')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <hr class="spater" />
            <div class="row personl_info mt-2 mb-3">
                <i class="icofont-envelope fa-envelope col-2 fs-2 mt-2"></i>
                <input type="text" class="border-0 col-10 @error('email') is-invalid @enderror" wire:model="email" value="{{ $donor->account->email }}" placeholder="gmail@.com××××××××××" />
                @error('email')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <hr />


            <button type="submit" class="btn bg-main text-center px-md-0 px-2 col-md-3 col-12 text-white fs-6 m-md-3 mx-2" >
                @lang('Save')
            </button>
        </div>
    </form>

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
</div>
