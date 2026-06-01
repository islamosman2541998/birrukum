@extends('admin.app')

@section('title', trans('users.edit_user'))
@section('title_page', trans('admin.users'))
@section('title_route', route('admin.users.index') )
@section('button_page')
    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('style')
<link rel="stylesheet" href="{{ asset('tell/intlTelInput.css') }}" />
@endsection


@section('content')
    <div class="row">
        <div class="card">
            <form action="{{ route('admin.users.update', $user->id) }}" method="post" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="id" value="{{ $user->id }}">
                <div class="row d-flex justify-content-center">
                    <div class="col-md-6">
                        <div class="accordion mt-4 mb-4" id="accordionExamUser">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingUser">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseUser" aria-expanded="true" aria-controls="collapseUser">
                                        <span class=" text-success "> {{ $user->user_name }}</span>
                                    </button>
                                </h2>
                                <div id="collapseUser" class="accordion-collapse collapse show mt-3" aria-labelledby="headingUser" data-bs-parent="#accordionExamUser">
                                    <div class="accordion-body">

                                        <div class="row mb-3">
                                            <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('users.user_name') }}</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control @error('user_name') is-invalid @enderror" type="text" name="user_name" value="{{ $user->user_name }}" required>
                                                    <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-user'></i></span>
                                                </div>
                                                @error('user_name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-email-input" class="col-sm-2 col-form-label">{{ trans('users.email') }}</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control @error('email') is-invalid @enderror" type="email" value="{{ $user->email }}" name="email" required>
                                                    <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-envelope'></i></span>
                                                </div>
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-tel-input" class="col-sm-2 col-form-label">{{ trans('users.mobile') }}</label>
                                            <div class="col-sm-10">
                                                <div class="form-outline">
                                                    <div class="iti form-control">
                                                        <input type="tel" id="phone" name="mobile" class="form-control @error('mobile') is-invalid @enderror " value="{{ $user->mobile }}" style="border:none" required 
                                                        oninput="this.value = this.value.replace(/[^0-9]/g, '');" maxlength="9"/>
                                                    </div>
                                                    <span id="valid-msg" class="hide" style="color:green"></span>
                                                    <span id="error-msg" class="hide" style="color:red"></span>
                                                </div>
                                                @error('mobile')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="example-password-input" class="col-sm-2 col-form-label">@lang('admin.password')</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control" type="password" name="password" >
                                                    <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-lock-alt'></i></span>
                                                </div>
                                                @error('password')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-3">

                                            <label for="example-password-input" class="col-sm-2 col-form-label">@lang('admin.confirm_password')</label>
                                            <div class="col-sm-10">
                                                <div class="position-relative input-icon">
                                                    <input class="form-control" type="password" name="password_confirmation" >
                                                    <span class="position-absolute top-50 translate-middle-y"><i class='bx bx-lock-alt'></i></span>
                                                </div>
                                                @error('password_confirmation')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-5">
                        <div class="accordion mt-4 mb-4" id="accordionExample">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button fw-medium " type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        {{ trans('admin.settings') }}
                                    </button>
                                </h2>
                                <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <div class="col-sm-3 mb-3">
                                            <img src="{{ getImageThumb($user->image) }}" alt="" style="width:100%">
                                        </div>
                                        {{-- image ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12">
                                            <div class="row mb-3">
                                                <label for="example-number-input" col-form-label>
                                                    @lang('admin.image')</label>
                                                <div class="col-sm-12">
                                                    <input class="form-control" type="file" placeholder="@lang('admin.image')" id="example-number-input" name="image" value="{{ old('image') }}">
                                                </div>
                                            </div>
                                        </div>
                                        {{-- role ------------------------------------------------------------------------------------- --}}
                                        <div class="col-md-12">
                                            <label for="input30" class="form-label">Role</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="bx bx-flag"></i></span>
                                                <select class="form-select" id="input30" multiple="" name="roles[]" required>
                                                    @foreach ($roles as $role)
                                                        <option {{ $user->roles->pluck('name')->contains($role->name) ? 'selected' : '' }} value="{{ $role->name }}">
                                                            {{ $role->name }}</option>
                                                        @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        {{-- Status ------------------------------------------------------------------------------------- --}}
                                        <div class="col-12 mt-3">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status"  {{  @$user->status == 1 ? 'checked' : '' }} id="flexSwitchCheckSuccessStatus">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>                                                            
                    </div>
                    <div class="row mb-3 text-end">
                        <div>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-primary waves-effect waves-light  btn-sm">@lang('button.cancel')</a>
                            <button type="submit" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save')</button>
                            <button type="submit" name="submit" value="update" class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

