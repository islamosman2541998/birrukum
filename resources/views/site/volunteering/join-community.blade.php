@extends('site.app')
@section('title', "volunteers")


@section('content')

<!--JoinToCommityPage-->
<div class="JoinToCommityPage px-0 py-1">
    <div class="container justify-content-center align-items-center align-contenet-center rounded ">
        <div class="Farm mx-auto px-4 py-4">
            <h5 class="text-end py-2">
                <a class="text-gray fw-bold" href="{{ route('site.volunteering.index') }}"> @lang('volunteers.volunteering')</a> /
                @lang('volunteers.Join_our_community') </a>
            </h5>

            <div class="register_Form my-5">
                <div class="container">
                    <div class="row justify-content-evenly">

                        <div class="logo col-12 col-lg-5 border rounded-custom bg-main d-flex justify-content-center align-items-center text-center p-5">
                            <div class="border border-3 rounded-6">
                                <i class="icofont-handshake-deal mx-3 my-5"></i>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6 my-3 my-lg-0 border rounded-custom  bg-white box_Shadow">
                            <div class="title bg-main text-center my-4 mx-auto border rounded-custom">
                                <h4 class="m-3"> @lang('volunteers.Register_volunteer')</h4>
                            </div>

                            @livewire('site.volunteering.join-community')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--JoinToCommityPage-->

@endsection
