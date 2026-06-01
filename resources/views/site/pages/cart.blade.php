@extends('site.app')
@section('title', __('cart'))


@section('content')
        

<section>
    <div class="container mt-5">
      <h2 class="sec-title"> 
        <a href="{{ route('site.home') }}" class="text-secondary">@lang('Home') </a> 
        <span class="px-4 text-main"> @lang('cart') </span> 
      </h2>

      <livewire:site.carts.show/>

    </div>
  </section>

@endsection