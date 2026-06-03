@extends('site.app')

@section('title', @$page->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$page->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$page->trans->where('locale', $current_lang)->first()->meta_description)


@section('content')

    <div class="container mt-3">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-block px-3">
                        <nav>
                            <ol class="breadcrumb ms-5 ms-md-0">
                                {{-- <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt=""> --}}
                                <li class="breadcrumb-item">
                                    <a href="{{ route('site.home') }}"> @lang('Home') </a>
                                </li>
                                <li class="breadcrumb-item">
                                    @lang('Page')
                                </li>
                                <li class="breadcrumb-item">
                                    {{ $page->title }}
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

            <h2 class="text-center">
                {{ $page->title }}
            </h2>

            <div class="row mt-5">

                <div class="col-md-6">
                    <p>{!! $page->content !!}</p>
                </div>
                <div class="col-md-6">
                    <img src="{{ getImage($page->image) }}" alt=" {{ $page->title }}">
                </div>
            </div>

        </div>
    </section>
    @if ($page->features && $page->features->count() > 0)
        <section class="page-features-section py-5">
            <div class="container">

                <div class="row mb-4">

                </div>

                <div class="row">
                    @foreach ($page->features as $feature)
                        @php
                            $featureTrans = $feature->trans->where('locale', $current_lang)->first();
                        @endphp

                        <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                            <div class="page-feature-card h-100">

                                @if ($feature->image)
                                    <div class="page-feature-image">
                                        <img src="{{ getImage($feature->image) }}" alt="{{ @$featureTrans->title }}"
                                            class="img-fluid">
                                    </div>
                                @endif

                                <div class="page-feature-content">
                                    <h4>
                                        {{ @$featureTrans->title }}
                                    </h4>

                                    <p>
                                        {{ @$featureTrans->description }}
                                    </p>

                                    @if ($feature->url)
                                        <a href="{{ $feature->url }}" class="page-feature-link">
                                            عرض المزيد
                                        </a>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>

            </div>
        </section>
    @endif
    @if ($page->contents && $page->contents->count() > 0)
        <section class="page-extra-contents-section py-5">
            <div class="container">

                @foreach ($page->contents as $content)
                    @php
                        $contentTrans = $content->trans->where('locale', $current_lang)->first();
                    @endphp

                    <div class="row mb-4">
                        <div class="col-md-12">
                            <div class="page-extra-content-box">
                                <h3>{{ @$contentTrans->title }}</h3>
                                <p>{{ @$contentTrans->description }}</p>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </section>
    @endif
@endsection
<style>
    .page-features-section {
        background: #f8f9fa;
    }

    .page-features-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .page-feature-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .page-feature-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .page-feature-image {
        width: 100%;
        height: 300px;
        overflow: hidden;
    }

    .page-feature-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }

    .page-feature-content {
        padding: 15px;
        text-align: center;
    }

    .page-feature-content h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .page-feature-content p {
        font-size: 15px;
        line-height: 1.8;
        color: #666;
        margin-bottom: 15px;
    }

    .page-feature-link {
        display: inline-block;
        margin-top: 8px;
        padding: 8px 18px;
        border-radius: 8px;
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
    }

    .page-feature-link:hover {
        color: #fff;
        opacity: 0.9;
    }
     .page-extra-content-box {
        background: #fff;
        border-radius: 14px;
        padding: 25px;
        box-shadow: 0 8px 25px rgba(0,0,0,0.07);
        margin-bottom: 20px;
    }

    .page-extra-content-box h3 {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 12px;
    }

    .page-extra-content-box p {
        font-size: 16px;
        line-height: 1.9;
        color: #666;
        margin-bottom: 0;
    }
</style>
