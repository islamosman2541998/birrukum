<div>
    <div class="col-12 col-md-6 mx-md-auto">
        <div class="login_form rounded mx-auto text-center mx-auto border p-3 mb-4">
            <div class="head py-3 rounded-3">
                <h4> @lang('Login') </h4>
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
            <form wire:submit.prevent="login" class="">
                <div class="body my-3 d-flex flex-column align-items-center">
                    <h5 class="fs-6">@lang('Log in using mobile number')</h5>
                    <h2 class="my-4" style="color: black"> @lang('Mobile') </h2>
                    @if($authError)
                        <div class="alert alert-danger d-none my-3 w-75" id="emptyInputAlert" role="alert">
                            {{ $authError }}
                        </div>
                    @endif
                    <input type="text" wire:model="mobile" class="w-75 p-2" maxlength="9" id="number" oninput="this.value = this.value.replace(/[^0-9]/g, '');" placeholder="500000000" />
                    @error('mobile')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                    <button type="submit" id="btnSend" class="btn d-block my-5 px-5 py-2 btn-send">
                        @lang('Send')
                    </button>
                    <p>
                        <span> @lang('Don`t have an account?') </span>
                        <a href="{{ route('site.register') }}"> @lang('Create an account') </a>
                    </p>
                </div>
            </form>
        </div>
    </div>

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
