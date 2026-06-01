<div>
    <div class="col-12 col-md-6 mx-md-auto">
        <div class="login_form rounded mx-auto text-center border p-3 mb-4">
            <div class="head py-3 rounded-3">
                <h4> @lang('Register') </h4>
            </div>
            @if($authError)
            <h5 class="success-message text-danger">
                <span class="icon"> <i class="icofont-close"></i> </span>
                <span class="message"> {{ $authError }}</span>
            </h5>
            @endif
            @if($authMessage)
            <h5 class="success-message">
                <span class="icon"> <i class="icofont-check"></i> </span>
                <span class="message"> {{ $authMessage }} </span>
            </h5>
            @endif
            <div class="body my-3 d-flex flex-column align-items-center">
                <h5 class="fs-6"> @lang('New Account') </h5>
                <form wire:submit.prevent="register" class="">
                    @if($authError)
                    <div class="alert alert-danger d-none my-3 w-75" id="emptyInputAlert" role="alert">
                        {{ $authError }}
                    </div>
                    @endif
                    <!--username-->
                    <div class="User_info row mt-4 w-100">
                        <div class="Username col-12 d-flex flex-column">
                            <label for="username" dir="rtl" class="text-end my-2 text-primary control-label"> @lang('Name') </label>
                            <input type="text" wire:model="name" class="p-2 form-control" dir="rtl" placeholder="@lang('Full Name')" />
                            @error('name')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!--email-->
                        <div class="Useremail col-12 d-flex flex-column mt-">
                            <label for="username" dir="rtl" class="text-end my-2 text-primary control-label"> @lang('Email') </label>
                            <input type="email" wire:model="email" class="p-2 form-control" dir="rtl" placeholder="@lang('Email')" />
                            @error('email')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>

                        <!--Phone-->
                        <div class="Userphone col-12 col-12 d-flex flex-column">
                            <label for="userphone" dir="rtl" class="text-end my-2 text-primary control-label"> @lang('Mobile') </label>
                            <input type="text" wire:model="mobile" id="user_phone" class="p-2 form-control" dir="rtl" oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9" placeholder="5XXXXXXXXX" />
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <!--Phone-->
                        <div class="col-12 col-12 d-flex flex-column">
                            <label for="userphone" dir="rtl" class="text-end my-2 text-primary control-label"> @lang('Identity') </label>
                            <input type="text" wire:model="identity" class="p-2 form-control" dplaceholder=" @lang('Identity')" />
                            @error('mobile')
                            <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="d-flex justify-content-center">
                            <!-- btn-->
                            <button type="submit" id="btnSend" class="btn d-block my-5 px-5 py-2 btn-send w-50">
                                @lang('Create New Account')
                            </button>
                            <!--btn-->
                        </div>

                    </div>
                    <p>
                        <span> @lang('Do you have account') </span>
                        <a href="{{ route('site.login') }}"> @lang('Login') </a>
                    </p>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal OTP  --}}
    <div class="modal fade @if($otp_modal)show @endif" @if($otp_modal)style="display: block;" @endif id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                            <button class="btn btn-success" type="button" wire:click="checkOTP()">@lang('Send') </button>
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
