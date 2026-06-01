<!--Menu section-->
<div class="col-12 order-lg-1 order-1 col-lg-3">
        
        <!--Hello window-->
        {{-- <div class="col-12 mb-3 border-main">
            <div class="my-5 mx-3 py-2 px-5 rounded-3 bg-main">

                <div class="row  py-3 nameInfo text-end">
                    <div class="col-1 text-end">
                        <i class="icofont-user-alt-3 fa-user fs-2"></i>
                    </div>
                    <div class="col-10 text-end">
                        <h1 class="fs-4 mx-3" dir="rtl">@lang('Welcome') {{ $donor->full_name }} </h1>
                    </div>
                   
                </div>

                <div class="row py-3  phoneInfo text-end">
                    <div class="col-1 text-end">
                        <i class="icofont-phone fa-phone-volume fs-2"></i>
                    </div>
                    <div class="col-10 text-end">
                        <h1 class="fs-4 mx-3">×××××××××05
                        </h1>
                    </div>
                </div>

                <hr style="background-color: white; height: 6px;">

                <div class="row py-3 emailInfo text-end">
                    <div class="col-1 text-end">
                        <i class="icofont-envelope fa-envelope fs-1"></i>
                    </div>
                    <div class="col-10 text-end">

                        <h1 class="fs-4 mx-3"> ××××××××××@gmail.com</h1>
                        </h1>
                    </div>
                    
                </div>

                <div class="row m-3">
                    <a href="{{ route('site.profile.edit') }}" class="btn bg-transparent col-md-3 mx-auto col-12  text-white fs-3" dir="rtl">
                        @lang('Edit')
                    </a>
                </div>

            </div>
        </div> --}}
        <!--Hello window-->

        <!--Menu-->
        <div class="row border-main my-4 mx-3 bg-white">

            <div class="col-12 meun-li p-3 {{ Route::is('site.profile.index') ? 'active' : '' }} ">
                <a href="{{ route('site.profile.index') }}">
                    <div class="row py-2  justify-content-center align-content-center">
                        <div class="col-2">
                            <i class="icofont-user fa-user fs-3 text-main"></i>
                        </div>
                        <div class="col-10">
                            <h1 class="fs-5"> @lang('Personal account') </h1>
                        </div>
                    </div>
                </a>
            </div>
            <hr>

            <div class="col-12  meun-li p-3 {{ Route::is('site.profile.statistics') ? 'active' : '' }} ">
                <a href="{{ route('site.profile.statistics') }}">
                    <div class="row py-2  justify-content-center align-content-center">
                        <div class="col-2">
                            <i class="icofont-chart-pie fs-3 text-main"></i>
                        </div>
                        <div class="col-10">
                            <h1 class="fs-5"> @lang('Statistics') </h1>
                        </div>
                    </div>
                </a>
            </div>
            <hr>

            <div class="col-12  meun-li p-3 {{ Route::is('site.profile.orders') ? 'active' : '' }}">
                <a href="{{ route('site.profile.orders') }}">
                <div class="row py-2  justify-content-center align-content-center">
                    <div class="col-2">
                        <i class="icofont-file-spreadsheet fs-3 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-5"> @lang('Orders List') </h1>
                    </div>
                </div>
                </a>
            </div>
            <hr>


            <div class="col-12  meun-li p-3 {{ Route::is('site.profile.gifts') ? 'active' : '' }}">
                <a href="{{ route('site.profile.gifts') }}">
                <div class="row py-2  justify-content-center align-content-center">
                    <div class="col-2">
                        <i class="icofont-gift fs-3 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-5"> @lang('Gifts Order') </h1>
                    </div>
                </div>
                </a>
            </div>
            <hr>

            
            <div class="col-12  meun-li p-3 {{ Route::is('site.profile.cards.index') ? 'active' : '' }}">
                <a href="{{ route('site.profile.cards.index') }}">
                    <div class="row py-2  justify-content-center align-content-center">
                        <div class="col-2">
                            <i class="icofont-visa-alt fs-3 text-main"></i>
                        </div>
                        <div class="col-10">
                            <h1 class="fs-5"> @lang('Payment Cards')</h1>
                        </div>
                    </div>
                </a>
            </div>
            <hr>

            {{-- <div class="col-12  meun-li p-3">
                <div class="row py-3  justify-content-center align-content-center">
                    <div class="col-2">
                        <i class="fa-solid fa-hand-holding-dollar fs-1 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-4">حملات تبرعك</h1>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-12  meun-li p-3">
                <div class="row py-3  justify-content-center align-content-center">
                    <div class="col-2">
                        <i class="fa-solid fa-house-chimney-user fs-1 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-4">كفالاتك</h1>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-12  meun-li p-3">
                <div class="row py-3  justify-content-center align-content-center">
                    <div class="col-2">
                        <i class="fa-solid fa-bell fs-1 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-4">تبرعك الدوري</h1>
                    </div>
                </div>
            </div> --}}
            {{-- <hr> --}}

            <div class="col-12  meun-li p-3 ">
                <div class="row py-2  justify-content-center align-content-center"  data-bs-toggle="modal" data-bs-target="#closeAccountModal">
                    <div class="col-2">
                        <i class="icofont-delete-alt fs-3 text-main"></i>
                    </div>
                    <div class="col-10">
                        <h1 class="fs-5"> @lang('Delete Account')</h1>
                    </div>
                </div>
                <!-- Modal -->
                <div class="modal fade" id="closeAccountModal" tabindex="-1" aria-labelledby="closeAccountModal" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="closeAccountModal">@lang('Delete Account')</h5>
                        </div>
                        <div class="modal-body">
                            @lang('Are you Sure You Want To Close Your Account ?')
                        </div>
                        <div class="modal-footer">
                            <form action="{{ route('site.profile.close') }}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">@lang('No')</button>
                                <button type="submit" class="btn btn-danger my-3">@lang('Yes') </button>
                            </form>
                        
                        </div>
                    </div>
                    </div>
                </div>
            </div>
            <hr>

            <div class="col-12  meun-li p-3" dir="ltr">
                <a href="{{ route('site.logout') }}">
                    <div class="row py-3  justify-content-center align-content-center">
                        <div class="col-12 text-center">
                            <button class="btn btn-danger fs-6"> 
                                @lang('logout')
                                <i class="icofont-logout fs-6 px-1 text-white"></i>
                            </button>
                        </div>
                    </div>
                </a>
            </div>

        </div>
        <!--Menu-->

</div>
<!--Menu section-->