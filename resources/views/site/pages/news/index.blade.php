@extends('site.app')

@section('title', trans('News'))
@section('meta_description', trans('News'))

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
                                @lang('News')
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="site-news-section py-5">
    <div class="container">

        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h2 class="site-news-title">الأخبار</h2>
            </div>
        </div>

        <div class="row">
            @forelse($items as $item)
                @php
                    $trans = $item->trans->where('locale', $current_lang)->first();
                    $title = @$trans->title;
                    $slug = @$trans->slug;
                    $description = strip_tags(@$trans->description);
                @endphp

                <div class="col-lg-4 col-md-6 col-sm-12 mb-4">
                    <div class="news-card h-100">

                        <div class="news-card-image">
                            <a href="{{ route('site.news.show', $slug) }}">
                                <img src="{{ getImage($item->image) }}"
                                     alt="{{ $title }}"
                                     class="img-fluid">
                            </a>
                        </div>

                        <div class="news-card-content">
                            <h4>
                                <a href="{{ route('site.news.show', $slug) }}">
                                    {{ $title }}
                                </a>
                            </h4>

                            <p>
                                {{ \Illuminate\Support\Str::limit($description, 120) }}
                            </p>

                            <a href="{{ route('site.news.show', $slug) }}" class="news-read-more">
                                عرض المزيد
                            </a>
                        </div>

                    </div>
                </div>
            @empty
                <div class="col-md-12">
                    <div class="alert alert-warning text-center">
                        لا توجد أخبار حالياً
                    </div>
                </div>
            @endforelse
        </div>

        <div class="row mt-4">
            <div class="col-md-12 text-center">
                {{ $items->links('pagination::bootstrap-5') }}
            </div>
        </div>

    </div>
</section>

<style>
    .site-news-section {
        background: #f8f9fa;
    }

    .site-news-title {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 20px;
    }

    .news-card {
        background: #fff;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
    }

    .news-card-image {
        width: 100%;
        height: 230px;
        overflow: hidden;
    }

    .news-card-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
        transition: all 0.3s ease;
    }

    .news-card:hover .news-card-image img {
        transform: scale(1.05);
    }

    .news-card-content {
        padding: 20px;
        text-align: right;
    }

    .news-card-content h4 {
        font-size: 20px;
        font-weight: 700;
        margin-bottom: 12px;
        line-height: 1.5;
    }

    .news-card-content h4 a {
        color: #222;
        text-decoration: none;
    }

    .news-card-content h4 a:hover {
        color: #0d6efd;
    }

    .news-card-content p {
        font-size: 15px;
        line-height: 1.8;
        color: #666;
        margin-bottom: 16px;
    }

    .news-read-more {
        display: inline-block;
        padding: 8px 18px;
        border-radius: 8px;
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
    }

    .news-read-more:hover {
        color: #fff;
        opacity: 0.9;
    }
</style>

@endsection