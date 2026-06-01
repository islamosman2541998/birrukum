@extends('site.app')

@section('title', @$category->trans->where('locale', $current_lang)->first()->meta_title)
@section('meta_key', @$category->trans->where('locale', $current_lang)->first()->meta_key)
@section('meta_description', @$category->trans->where('locale', $current_lang)->first()->meta_description)

@section('content')

<div class="container mt-3">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-block px-3 wow bounceInUp">
                    <nav>
                        <ol class="breadcrumb ms-5 ms-md-0">
                            
                            <img src="{{site_path('img/favicon.ico')}}" class="mx-2" alt="">

                            <li class="breadcrumb-item">
                                <a href="{{ route('site.home') }}"> @lang('Home') </a>
                            </li>
                            <li class="breadcrumb-item">
                                <a href="{{ route('site.projectCategories.show', $category->trans?->where('locale', $current_lang)->first()->slug ) }}">
                                    {{ $category->trans?->where('locale', $current_lang)->first()->title }}
                                </a>
                            </li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Project Banner secation-->
<div class="ProjectBanner mt-1">
    <div class="container">
        <div class="row mt-3 text-center rounded wow bounceInDown">
            <div class="col-12 banner text-center mt-2">
                <img src="{{ getImage($category->background_image) }}" class="border border-3" alt="{{ $category->trans?->where('locale', $current_lang)->first()->title }}" />
                <h1 class="my-5 text-main">
                    {{ $category->trans?->where('locale', $current_lang)->first()->title  }}
                </h1>
                <p class="fs-5">
                    {!! $category->trans?->where('locale', $current_lang)->first()->description !!}
                </p>
            </div>
        </div>
    </div>
</div>
<!--Project Banner secation-->


<section id="projects">
    <div class="container mt-5">
        <div class="projects-body">
            <div class="">
                <div class="row">
                    <livewire:site.charity-project.category :category="$category" />
                </div>
            </div>
        </div>
    </div>
</section>


@endsection
