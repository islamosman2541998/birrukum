@extends('site.app')

@section('title', __('Register'))

@section('content')

   <!--Login-->
   <div class="Login">
    <div class="container text-center">
      <div class="row justify-content-center">
        <div class="col-12">
          <div class="title d-flex justify-content-center align-items-center my-md-5 my-3">
            <h1 class="mx-md-3 mx-1"> @lang('Register')</h1>
            {{-- <img class="img-fuild login-icon" src="{{ site_path('img/icon.gif') }}" alt="@lang('Register')" /> --}}
          </div>
        </div>

        <livewire:site.auth.register />

      </div>
    </div>
  </div>
  <!--Login-->

@endsection
