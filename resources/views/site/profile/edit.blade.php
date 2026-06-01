@extends('site.app')
@section('title', __('personal account information'))
@section('content')

<div class="profile">
    <div class="container bg-light mt-5 border-main">
        <div class="row gx-2">

            <x-site.profile.side-menu />
            
            <!--edit section -->
            <div class="col-12 order-lg-2 order-2 col-lg-9 mx-auto mb-5">
                @livewire('site.profile.edit')
            </div>
            <!--edit section -->

        </div>
    </div>
</div>

@endsection
