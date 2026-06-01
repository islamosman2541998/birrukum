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
                      <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt="">
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

@endsection
