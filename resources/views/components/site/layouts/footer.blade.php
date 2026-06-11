<div>

    <div class="spinner-border text-success htmx-indicator position-fixed top-50 start-50" id="loading" role="status"
        style="z-index: 2;">
        <span class="visually-hidden">Loading...</span>
    </div>
    @if ($settings->getItem('show_footer'))
        <!-- footer -->
        <footer id="footer">
            <div class="container-fluid">
                <div class="footer-info row">
                    <div class="col-md-3 col-12 py-3">
                        <h4 class="col-title">@lang('Our Association')</h4>
                        <p>
                            {{ $settings->getItem('footer_description') }}
                        </p>
                        <div class="social-list">
                            <a class="list-item" href="{{ $settings->getContactInformationData('facebook') }}">
                                <i class="icofont-facebook"></i>
                            </a>
                            <a class="list-item" href="{{ $settings->getContactInformationData('twitter') }}">
                                <i class="icofont-twitter"></i>
                            </a>
                            <a class="list-item" href="{{ $settings->getContactInformationData('youtube') }}">
                                <i class="icofont-youtube-play"></i>
                            </a>
                            <a class="list-item" href="{{ $settings->getContactInformationData('instagram') }}">
                                <i class="icofont-instagram"></i>
                            </a>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 py-3 bg-green">
                        <div class="site-map me-2">
                            <h4 class="col-title">@lang('quick_links')</h4>
                            <div class="site-map-items">
                                @forelse ($menuItems??[] as $menuItem)
                                    @if ($menuItem->type == App\Enums\MunesEnum::DYNAMIC)
                                        <a href="{{ App::make('url')->to($menuItem->dynamic_url) }}"
                                            target="_blank">{{ $menuItem->title }}</a>
                                    @elseif ($menuItem->type == App\Enums\MunesEnum::STATIC)
                                        <a href="{{ App::make('url')->to($menuItem->url) }}"
                                            target="_blank">{{ $menuItem->title }}</a>
                                    @endif
                                @empty
                                @endforelse
                            </div>
                            {{-- <div class="site-map-items">
                                <a href="#">المستفيدن</a> - <a href="#">الأكثر احتياجا</a> -
                                <a href="#">الاوقاف</a> - <a href="#">الحسابات البنكية</a> -
                                <a href="#">المشاريع</a> - <a href="#">الحالات الطارئية</a> -
                                <a href="#">حاسبة الزكاة</a>
                            </div> --}}

                            <h5 class="subtitle-title my-3"> @lang('Donate by text message') </h5>
                            <div class="payment-area my-3">
                                <h5 class="payment-title"> @lang('Or through') </h5>
                                <div class="payment-imgs">
                                    @forelse($payment_methodImages as $pay_img)
                                        <span class="img">
                                            <img src="{{ getImage($pay_img) }}" alt="" />
                                        </span>
                                    @empty
                                        <span class="img">
                                            <img src="{{ site_path('img/payments/visa-mada.png') }}" alt="" />
                                        </span>
                                        <span class="img">
                                            <img src="{{ site_path('img/payments/apple-pay.png') }}" alt="" />
                                        </span>
                                        <span class="img">
                                            <img src="{{ site_path('img/payments/bank-transfer.png') }}"
                                                alt="" />
                                        </span>
                                    @endforelse

                                </div>
                                <div class="d-flex justify-content-center align-items-center">
                                <img class="img-footer" src="{{ site_path('img/footer/qr.png') }}" alt="">

                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 col-12 py-3 footer-middle">
                        <p> تصريح المركز الوطني لتنمية القطاع غير الربحي رقم 664 </p>
                        <div class="row text-center">
                            <div class="col-12">
                                <img src="{{ getImage($settings->getItem('declaration_image')) ?? site_path('img/footer/footer-w-logo.png') }}"
                                    alt="" />
                            </div>
                            {{-- <h5 class="mt-3 mb-3">حمل تطبيق كفارة</h5> --}}
                            <div class="col-6 mb-3 mt-3">
                                <a href="{{ getImage($settings->getItem('app_store')) }}">
                                    <img src="{{ site_path('img/footer/app-store-apple-logo-black-and-white.png') }}"
                                        alt="" height="42" />
                                </a>
                            </div>
                            <div class="col-6 mb-3 mt-3">
                                <a href="{{ getImage($settings->getItem('google_play')) }}">
                                    <img src="{{ site_path('img/footer/google-play-badge.png') }}" alt=""
                                        height="42" />
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 col-12 py-3 bg-green">
                        <div class="site-map">
                            <h4 class="col-title">معلومات الاتصال</h4>
                            <div class="row footer-list">
                                <span class="col-lg-6 nav-item">
                                    <span class="nav-item-icon"><i class="icofont-phone"></i></span>
                                    <a target="_blank"
                                        href="tel:{{ @$store->account->mobile ?? $settings->getContactInformationData('mobile') }}">{{ @$store->account->mobile ?? $settings->getContactInformationData('mobile') }}</a>
                                </span>
                                <span class="col-lg-6 nav-item">
                                    <span class="nav-item-icon"><i class="icofont-telephone"></i></span>
                                    <a target="_blank"
                                        href="tel:{{ @$store->whatsapp ?? $settings->getContactInformationData('whatsapp') }}">{{ @$store->whatsapp ?? $settings->getContactInformationData('whatsapp') }}</a>
                                </span>
                                <span class="col-12 nav-item">
                                    <span class="nav-item-icon"><i class="icofont-envelope"></i></span>
                                    <a
                                        href="mailto:{{ @$store->account->email ?? $settings->getContactInformationData('email') }}">
                                        {{ @$store->account->email ?? $settings->getContactInformationData('email') }}
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="subscribe-area my-3 row">
                            <h5 class="subscribe-title col-lg-3">@lang('Subscribe to receive news from us')</h5>
                            <div class="subscribe-form col-lg-9">
                                <form class="d-flex">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="@lang('Enter email')" />
                                        <button class="btn btn-outline-secondary" type="button" id="button-addon2">
                                            <i class="icofont-envelope"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div>
                            <p>
                                {{ @$store->location ?? $settings->getContactInformationData('address') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="copy-rights">
                <div class="col-md-12 text-center">
                    <p class="m-0 p-2">
                        جميع الحقوق محفوظة لجمعية جمعية البر الخيرية بمكة المكرمة - بركم © {{ date('Y') }}
                    </p>
                </div>
            </div>
        </footer>
    @endif
</div>
<style>
    .img-footer {
        width: 100%;
    }
</style>
