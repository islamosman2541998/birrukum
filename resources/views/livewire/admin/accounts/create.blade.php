<div>
    <div class="row mb-3">
        @if($msg)
            <div class="mb-3 text-center">
                <span class="text-danger my-2 text-center"> {{ $msg }} </span>
            </div>
        @endif
        <label for="example-text-input" class="col-sm-3 col-form-label">{{ trans('admin.users') }}</label>
        <div class="col-sm-9">
            <input class="form-control" wire:model='search_accounts' wire:keydown.escape="reseting()" type="text">
            @error('name')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <ul class="list-group list-group-numbered">
                @if($accounts)
                @forelse ($accounts as $account)
                <li class="list-group-item d-flex justify-content-between align-items-start bg" wire:click="selectAccount({{ $account }})">
                    <div class="text-start col-10"> ({{ $account->email }}) {{ $account->user_name }}  </div>
                    <span class="badge bg-primary rounded-pill"> @lang('Add') </span>
                </li>
                @empty
                <li class="list-group-item d-flex justify-content-between align-items-start bg-sucess-light" wire:click="newAccount()">
                    <div class="text-start col-10"> @lang('New Account') </div>
                </li>
                @endforelse
                @endif
            </ul>
        </div>

    </div>

    @if ($new)
        <div class="row">
            <!-- Name input -->
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example1">@lang('users.name')</label>
                    <input type="text" id="form8Example1" class="form-control @error('user_name') is-invalid @enderror" value="{{ old('user_name') }}" name="user_name" />
                </div>
            </div>
            <!-- phone input -->
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example3">@lang('users.mobile')</label>
                    <div class="iti form-control">
                        <input type="tel" id="phone" name="mobile" class="form-control @error('mobile') is-invalid @enderror " value="{{ old('mobile') }}" style="border:none" />
                    </div>
                    <span id="valid-msg" class="hide" style="color:green"></span>
                    <span id="error-msg" class="hide" style="color:red"></span>
                </div>
            </div>
            <!-- Email input -->
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example2">@lang('users.email')
                    </label>
                    <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" name="email" />
                </div>
            </div>
            <!-- password input -->
            @if($show_password)
            <div class="col-12 col-md-6">
                <div class="form-outline">
                    <label class="form-label" for="form8Example5">@lang('users.password')</label>
                    <input type="password" id="form8Example5" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password') }}" />
                </div>
            </div>
            @endif
        </div>
    @else
    @if($user)
    <div class="row">
        <input type="hidden" name="account_id" value="{{ $user['id'] }}">
        <!-- phone input -->
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example3">@lang('users.mobile')</label>
                <input type="tel" name="mobile" disabled class="form-control @error('mobile') is-invalid @enderror " value="{{ $user['mobile'] }}" style="border:none" />
            </div>
        </div>
        <!-- Name input -->
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example1">@lang('users.name')</label>
                <input type="text" id="form8Example1" class="form-control @error('user_name') is-invalid @enderror" value="{{ $user['user_name'] }}" name="user_name" />
            </div>
        </div>
        <!-- Email input -->
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example2">@lang('users.email')
                </label>
                <input type="email" id="form8Example2" class="form-control @error('email') is-invalid @enderror" value="{{ $user['email'] }}" name="email" />
            </div>
        </div>

        <!-- password input -->
        @if($show_password)
        <div class="col-12 col-md-6">
            <div class="form-outline">
                <label class="form-label" for="form8Example5">@lang('users.password')</label>
                <input type="password" id="form8Example5" name="password" class="form-control @error('password') is-invalid @enderror" value="" />
            </div>
        </div>
        @endif
    </div>
    @endif
    @endif
    <script src="{{ asset('tell/intlTelInput.js') }}"></script>

</div>
