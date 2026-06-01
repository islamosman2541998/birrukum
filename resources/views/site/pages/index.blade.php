@extends('site.app')

@section('content')

<!-- Slider -->
{{-- @livewire('site.home.sliders') --}}
<x-site.home.sliders/>

<!-- Tabs -->
@livewire('site.home.tabs')


<!-- Media -->
<x-site.home.media/>


<!-- quick donation  -->
@livewire('site.fast-donation.index')


@endsection
