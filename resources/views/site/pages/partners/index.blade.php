@if(isset($partners) && $partners->count() > 0)
<section class="partners-section py-5">
    <div class="container">

        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h2 class="partners-title">شركاؤنا</h2>
            </div>
        </div>

        <div class="swiper partners-swiper">
            <div class="swiper-wrapper">

                @foreach($partners as $partner)
                    @php
                        $partnerTrans = $partner->trans->where('locale', $current_lang)->first();
                    @endphp

                    <div class="swiper-slide">
                        @if($partner->url)
                            <a href="{{ $partner->url }}" target="_blank" class="partner-card">
                                <img src="{{ getImage($partner->image) }}"
                                     alt="{{ @$partnerTrans->title }}">
                            </a>
                        @else
                            <div class="partner-card">
                                <img src="{{ getImage($partner->image) }}"
                                     alt="{{ @$partnerTrans->title }}">
                            </div>
                        @endif
                    </div>
                @endforeach

            </div>

            <div class="partners-swiper-button-next">
                <i class="icofont-thin-left"></i>
            </div>

            <div class="partners-swiper-button-prev">
                <i class="icofont-thin-right"></i>
            </div>
        </div>

    </div>
</section>
@endif

<style>
    .partners-section {
    background: #fff;
    overflow: hidden;
}

.partners-title {
    font-size: 32px;
    font-weight: 700;
    margin-bottom: 20px;
}

.partners-swiper {
    position: relative;
    padding: 10px 45px;
}

.partner-card {
    height: 120px;
    background: #fff;
    border-radius: 14px;
    padding: 20px;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.07);
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.3s ease;
}

.partner-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.partner-card img {
    max-width: 100%;
    max-height: 80px;
    object-fit: contain;
    display: block;
}

.partners-swiper-button-next,
.partners-swiper-button-prev {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background: #fff;
    color: #222;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 5;
    cursor: pointer;
    box-shadow: 0 6px 18px rgba(0, 0, 0, 0.12);
    transition: all 0.3s ease;
}

.partners-swiper-button-next:hover,
.partners-swiper-button-prev:hover {
    background: #0d6efd;
    color: #fff;
}

.partners-swiper-button-next {
    left: 0;
}

.partners-swiper-button-prev {
    right: 0;
}

@media (max-width: 768px) {
    .partners-swiper {
        padding: 10px 35px;
    }

    .partner-card {
        height: 105px;
        padding: 15px;
    }

    .partner-card img {
        max-height: 65px;
    }

    .partners-title {
        font-size: 26px;
    }
}
</style>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (document.querySelector('.partners-swiper')) {
            new Swiper('.partners-swiper', {
                loop: true,
                speed: 700,
                spaceBetween: 20,
                grabCursor: true,

                autoplay: {
                    delay: 2500,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },

                navigation: {
                    nextEl: '.partners-swiper-button-next',
                    prevEl: '.partners-swiper-button-prev',
                },

                breakpoints: {
                    0: {
                        slidesPerView: 2,
                        spaceBetween: 12,
                    },
                    576: {
                        slidesPerView: 3,
                        spaceBetween: 15,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 18,
                    },
                    992: {
                        slidesPerView: 5,
                        spaceBetween: 20,
                    },
                    1200: {
                        slidesPerView: 6,
                        spaceBetween: 20,
                    }
                }
            });
        }
    });
</script>