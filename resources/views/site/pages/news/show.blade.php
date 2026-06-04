@extends('site.app')

@php
    $trans = $item->trans->where('locale', $current_lang)->first();
@endphp

@section('title', @$trans->meta_title ?: @$trans->title)
@section('meta_key', @$trans->meta_key)
@section('meta_description', @$trans->meta_description ?: @$trans->description)

@section('content')

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3">
                    <nav>
                        <ol class="breadcrumb ms-5 ms-md-0">
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}">@lang('Home')</a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.news.index') }}">@lang('News')</a>
                            </li>
                            <li class="breadcrumb-item">
                                {{ @$trans->title }}
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="news-details-section py-5">
    <div class="container">

        <div class="row justify-content-center">
            <div class="col-lg-10 col-md-12">

                <div class="news-details-card">

                    <h1 class="news-details-title">
                        {{ @$trans->title }}
                    </h1>

                    @if($item->image)
                        <div class="news-details-image">
                            <img src="{{ getImage($item->image) }}"
                                 alt="{{ @$trans->title }}"
                                 class="img-fluid w-100 h-100">
                        </div>
                    @endif

                    @if(@$trans->description)
                        <div class="news-details-description">
                            {!! @$trans->description !!}
                        </div>
                    @endif

                    @if(@$trans->content)
                        <div class="news-details-content">
                            {!! @$trans->content !!}
                        </div>
                    @endif

                </div>

            </div>
        </div>

    </div>
</section>

<style>
    .news-details-section {
        background: #f8f9fa;
    }

    .news-details-card {
        background: #fff;
        border-radius: 16px;
        padding: 30px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    }

    .news-details-title {
        font-size: 34px;
        font-weight: 700;
        line-height: 1.5;
        margin-bottom: 25px;
        text-align: center;
    }

    .news-details-image {
        width: 100%;
        max-height: 480px;
        overflow: hidden;
        border-radius: 14px;
        margin-bottom: 25px;
    }

    .news-details-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .news-details-description {
        font-size: 17px;
        line-height: 2;
        color: #555;
        margin-bottom: 25px;
    }

    .news-details-content {
        font-size: 16px;
        line-height: 2;
        color: #333;
    }

    .news-details-content img {
        max-width: 100%;
        height: auto;
    }
</style>

@endsection