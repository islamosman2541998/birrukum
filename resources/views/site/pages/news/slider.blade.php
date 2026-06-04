

<section class="news-slider-section py-5">
    <div class="container">

        <div class="row mb-4">
            <div class="col-md-12 text-center">
                <h2 class="news-slider-title">الأخبار</h2>
            </div>
        </div>

        @if($items->count() > 0)
            <div class="position-relative">

                <div class="swiper news-swiper news-swiper">
                    <div class="swiper-wrapper">

                        @foreach($items as $item)
                            @php
                                $trans = $item->trans->where('locale', $current_lang)->first();
                                $title = @$trans->title;
                                $slug = @$trans->slug;
                                $description = strip_tags(@$trans->description);
                            @endphp

                            <div class="swiper-slide">
                                <div class="news-swiper-card ">

                                    <div class="news-swiper-image">
                                        <a href="{{ route('site.news.show', $slug) }}">
                                            <img src="{{ getImage($item->image) }}"
                                                 alt="{{ $title }}"
                                                 class="img-fluid">
                                        </a>
                                    </div>

                                    <div class="news-swiper-content">
                                        <h4>
                                            <a href="{{ route('site.news.show', $slug) }}">
                                                {{ $title }}
                                            </a>
                                        </h4>

                                        <a href="{{ route('site.news.show', $slug) }}" class="news-swiper-btn">
                                            عرض المزيد
                                        </a>
                                    </div>

                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

                <div class="news-swiper-button-next">
                    <i class="icofont-thin-left"></i>
                </div>

                <div class="news-swiper-button-prev">
                    <i class="icofont-thin-right"></i>
                </div>

                <div class="news-swiper-pagination"></div>

            </div>
        @else
            <div class="alert alert-warning text-center">
                لا توجد أخبار حالياً
            </div>
        @endif

    </div>
</section>

<style>
    .news-slider-section {
        background: #FFFFFF;
        overflow: hidden;
    }

    .news-slider-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 15px;
    }

    .news-swiper {
        padding: 10px 5px 112px;
    }
    

   .news-swiper-card {
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
    transition: all 0.3s ease;

    display: flex;
    flex-direction: column;
}

.news-swiper-image {
    width: 100%;
    height: 230px; 
    overflow: hidden;
    flex-shrink: 0;
}

.news-swiper-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}

.news-swiper-content {
    padding: 18px 20px;
    text-align: center;

    flex: 1;
    display: flex;
    flex-direction: column;
    justify-content: flex-start;
}

.news-swiper-content h4 {
    font-size: 19px;
    font-weight: 700;
    line-height: 1.8;
    margin-bottom: 10px;

    max-height: none;
    overflow: visible;
}

.news-swiper-content h4 a {
    color: #222;
    text-decoration: none;
}

.news-swiper-content p {
    font-size: 15px;
    line-height: 1.8;
    color: #666;
    margin-bottom: 15px;
}

    .news-swiper-btn {
        display: inline-block;
        padding: 8px 18px;
        border-radius: 8px;
        background: #0d6efd;
        color: #fff;
        text-decoration: none;
        font-size: 14px;
    }

    .news-swiper-btn:hover {
        color: #fff;
        opacity: 0.9;
    }

    .news-swiper-button-next,
    .news-swiper-button-prev {
        position: absolute;
        top: 45%;
        transform: translateY(-50%);
        width: 42px;
        height: 42px;
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

    .news-swiper-button-next:hover,
    .news-swiper-button-prev:hover {
        background: #0d6efd;
        color: #fff;
    }

    .news-swiper-button-next {
        left: -15px;
    }

    .news-swiper-button-prev {
        right: -15px;
    }

    .news-swiper-pagination {
        position: relative;
        text-align: center;
        margin-top: 10px;
    }

    .news-swiper-pagination .swiper-pagination-bullet {
        width: 10px;
        height: 10px;
        opacity: 1;
        background: #ccc;
    }

    .news-swiper-pagination .swiper-pagination-bullet-active {
        background: #0d6efd;
        width: 28px;
        border-radius: 20px;
    }

    @media (max-width: 768px) {
        .news-swiper-image {
            height: 210px;
        }

        .news-swiper-content h4 {
            font-size: 18px;
            min-height: auto;
        }

        .news-swiper-content p {
            min-height: auto;
        }

        .news-swiper-button-next,
        .news-swiper-button-prev {
            width: 36px;
            height: 36px;
        }

        .news-swiper-button-next {
            left: 5px;
        }

        .news-swiper-button-prev {
            right: 5px;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        new Swiper('.news-swiper', {
            loop: true,
            speed: 700,
            spaceBetween: 24,
            grabCursor: true,

            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
                pauseOnMouseEnter: true,
            },

            navigation: {
                nextEl: '.news-swiper-button-next',
                prevEl: '.news-swiper-button-prev',
            },

            pagination: {
                el: '.news-swiper-pagination',
                clickable: true,
            },

            breakpoints: {
                0: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                576: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                },
                1200: {
                    slidesPerView: 3,
                    spaceBetween: 24,
                }
            }
        });
    });
</script>

