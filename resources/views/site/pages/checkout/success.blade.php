@extends('site.app')
@section('title', __('Success'))
@section('content')
    <!--Thank You secation-->
    <div class="ThankYou mt-1">
        <div class="container">
            <div class="row mt-3 mx-3 mx-md-0">
                <div class="col-12 mx-auto bg-main x shadow-lg py-3">
                    <div class="icon m-auto text-center">
                    <i class="icofont-thumbs-up text-white thank-icon"></i>
                        <i class="fa-regular fa-thumbs-up text-white thank-icon"></i>
                    </div>
                </div>
                <div class="col-12 text-center pt-1">
                <i class="icofont-star star-icon text-secound fs-1 my-1"></i>
                    <div class="text">
                        <h1 class="text-main display-1" dir="ltr">@lang('Thank you')</h1>
                        @include('site.layouts.message')
                        <p class="fs-4"> مع تحيات جمعية بركم الأهلية بمنطقة مكة المكرمة </p>
                        <a  href="{{ route('site.home') }}" class="btn bg-main py-2 my-3 fs-5">
                            @lang('Back to website')
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
