@extends('site.app')

@section('title', @$settings->getContactInformationData('meta_title_' . $current_lang))
@section('meta_key', $settings->getContactInformationData('meta_key_' . $current_lang))
@section('meta_description', $settings->getContactInformationData( 'meta_description_' . $current_lang))


@section('content')


<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3">
                    <nav>
                        <ol class="breadcrumb ms-5 ms-md-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}"> @lang('Home') </a>
                            </li>
                            <li class="breadcrumb-item">
                                @lang('Page')
                            </li>
                            <li class="breadcrumb-item">
                                @lang('Contact Us')
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section>
    <div class="container mt-5">
        <div class="row mt-5">

            <div class="col-12 col-md-6 px-5">
                <h2 class="heading--primary contact-us__heading heading--border-left"> @lang('Contact Data') </h2>

                <div class="contact-us__item">
                    <i class="icofont-location-pin contact-us__item-icon"></i>
                    <h5 class="contact-us__item-info">
                        <span class="label"> @lang('Address') </span>
                        <span class="title"> {{ $settings->getContactInformationData('address_' . app()->getLocale()) }} </span>
                    </h5>
                </div>

                <div class="contact-us__item">
                    <i class="icofont-email contact-us__item-icon"></i>
                    <h5 class="contact-us__item-info">
                        <span class="label">@lang('Email')</span>
                        <span class="title"> {{ $settings->getContactInformationData('email') }} </span>
                    </h5>
                </div>

                <div class="contact-us__item">
                    <i class="icofont-telephone contact-us__item-icon"></i>
                    <h5 class="contact-us__item-info">
                        <span class="label">@lang('Mobile')</span>
                        <span class="title"> {{ $settings->getContactInformationData('mobile') }} </span>
                    </h5>
                </div>

                <div class="contact-us__item mb-2">
                    <i class="icofont-phone contact-us__item-icon"></i>
                    <h5 class="contact-us__item-info">
                        <span class="label">@lang('Phone')</span>
                        <span class="title"> {{ $settings->getContactInformationData('whatsapp') }} </span>
                    </h5>
                </div>

                <div class="navbar navbar-expand text-center">
                    <ul class="navbar-nav mt-3 mx-auto ">
                        <li class="nav-item p-1">
                            <a class="nav-link btn btn-lg bg-secound" href="{{ $settings->getContactInformationData('facebook') }}" target="_blank">
                                <i class="h3 icofont-facebook"></i>
                            </a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link btn btn-lg bg-secound" href="{{ $settings->getContactInformationData('twitter') }}" target="_blank">
                                <i class="h3 icofont-twitter"></i>
                            </a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link btn btn-lg bg-secound" href="{{ $settings->getContactInformationData('youtube') }}" target="_blank">
                                <i class="h3 icofont-youtube"></i>
                            </a>
                        </li>
                        <li class="nav-item p-1">
                            <a class="nav-link btn btn-lg bg-secound" href="{{ $settings->getContactInformationData('instagram') }}" target="_blank">
                                <i class="h3 icofont-instagram"></i>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>


            <div class="col-12 col-md-6 mt-2">
                <h2 class="heading--primary contact-us__heading heading--border-left contact-us__form"> @lang('Keep in touch') </h2>
                @livewire('site.contact-us')
            </div>

        </div>
    </div>
</section>



<section class="find-us mt-5 mb-3">
    <div class="container">
        <div class="find-us-container" style="visibility: visible;">
            <h2 class="heading--primary heading--border-left find-us__heading">@lang('Location') </h2>
            <div class="find-us__location-img">
                <iframe src="{{ $settings->getContactInformationData('maps') }} " width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </div>
    </div>
</section>

@endsection
