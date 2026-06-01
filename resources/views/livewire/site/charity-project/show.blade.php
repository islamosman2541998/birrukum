<section id="projects">
    <div class="container mt-5">
        <div class="projects-body row mb-5">
            <!-- project -->
            <div class="col-lg-5 wow bounceInRight">
                <div class="project shadow">
                    <div class="header d-flex">
                        <h5 class="project-title">
                            <a title="#">
                                {{$project->trans?->where('locale', $current_lang)->first()->title}}
                            </a>
                        </h5>
                        <ul class="project-social p-0 nav flex-column" data-bs-toggle="collapse" href="#socialShare1" role="button" aria-expanded="false" aria-controls="socialShare1">
                            <a class="social-share nav-link active">
                                <i class="icofont-share"></i>
                            </a>
                            <span class="collapse toggelShare" id="socialShare1">
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ route('site.charity-project.show', $project->trans?->where('locale', $current_lang)->first()->slug) }}" 
                                    target="blank" class="nav-link">
                                    <i class="icofont-facebook"></i>
                                </a>
                                <a href="https://wa.me/?text="  target="blank" class="nav-link">
                                    <i class="icofont-brand-whatsapp"></i>
                                </a>
                                <a href="mailto:?&subject=&cc=&bcc=&body={{ route('site.charity-project.show',  $project->trans?->where('locale', $current_lang)->first()->slug) }}" target="blank" class="nav-link">
                                    <i class="icofont-envelope"></i>
                                </a>
                                <a target="blank" class="nav-link">
                                    <i class="icofont-twitter"></i>
                                </a>
                            </span>
                        </ul>

                    </div>
                    
                    <div class="projects-show">
                        
                        @if(json_decode($project['images'], true)  != null)
                            <div class="container">
                                <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-interval="10000">
                                    <div class="carousel-indicators">
                                        @forelse (json_decode($project['images'], true)??[] as $key => $img)
                                            <button type="button" data-bs-target="#carouselExampleIndicators" class="{{$key == 0 ? 'active' : null }}" data-bs-slide-to="{{ $key }}" aria-label="Slide {{ $key }}"></button>
                                        @empty
                                        @endforelse
                                    </div>
                                    <div class="carousel-inner">
                                        @forelse (json_decode($project['images'], true)??[] as $key => $img)
                                            <div class="carousel-item {{$key == 0 ? 'active' : null}}">
                                                <img src="{{ getImageFileManger($img) }}" class="d-block w-100" alt="{{$project->title}}" width="100%">
                                            </div>
                                        @empty
                                        @endforelse
                                    </div>
                                    <!-- slider content  -->
                                    
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Previous</span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                                        data-bs-slide="next">
                                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                        <span class="visually-hidden">Next</span>
                                    </button>
                                </div>
                            </div>
                        @else
                            <div class="item text-center">
                                <img class="" src="{{ getImage($project['background_image'])}}" alt="{{$project->title}}">
                            </div>
                        @endif

                    </div>


                    {{-- <a class="" href="{{ getImage($project['background_image'])}}" target="_blank">
                    <img class="" src="{{ getImage($project['background_image'])}}" alt="{{$project->title}}">
                    </a> --}}

                    <div class="project-details my-3">
                        <div class="progress mt-3">
                            <div class="progress-bar progress-bar-striped bg-main" role="progressbar" style="width: {{ $progressBar['percent'] }}%" aria-valuenow="37" aria-valuemin="0" aria-valuemax="100">
                                {{ $progressBar['percent'] }}%
                            </div>
                        </div>

                        <div class="target mt-2">
                            <small class="">
                                @lang('Collected')
                                <span class="target-number text-main"> {{ $progressBar['collected'] }} </span>
                                <span class="text-main"> &#65020; </span>
                            </small>
                            <small class="float-start">
                                @lang('Remaining')
                                <span class="target-number text-secound"> {{ $progressBar['reminder'] }} </span>
                                <span class="text-secound"> &#65020; </span>
                            </small>
                        </div>

                    </div>
                </div>
            </div>
            <!-- card -->
            <div class="col-lg-7 wow bounceInLeft">
                <div class="card project-details">
                    <div class="card-body">
                        <h5 class="card-title main-donation">
                            {!!$project->trans?->where('locale', $current_lang)->first()->description!!}
                        </h5>
                        <hr class="my-3">
                        @livewire('site.auth.index', ['type' => 'project'])
                        
                        <h6 class="fs-6 my-2 text-body-secondary"> @lang('Donation Amount')</h6>

                        @if(is_array($donation))
                            @switch($donation['type'])
                            @case('unit')
                                <div class="options my-3">
                                    @foreach ($donation['data'] as $key => $data)
                                    <div class="option-item">
                                        <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount)] }} {{ $unitValueRadio == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}
                                            @if($donation_status == 1) input-disable @endif" >
                                            <input wire:model.live="unitValueRadio" type="radio" value="{{ json_encode($data) }}"  @if($donation_status == 1) disabled @endif>
                                            <h6 class="title">{{ $project['title'] }} </h6>
                                            <div class="price">
                                                {{ $data['value'] }}
                                                <small> &#65020;</small>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                    <div class="mx-2">
                                        <input type="number" wire:model.live="unitValueInput" min="0" class="form-control" placeholder="@lang('Another amount')" @if($donation_status == 1) disabled @endif>
                                    </div>
                                </div>
                            @break

                            @case('share')
                                <div class="options my-3">
                                    @foreach ($donation['data'] as $key => $data)
                                    <div class="option-item">
                                        <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}" class="{{ $colorsAmount[$key % count($colorsAmount)] }}  rounded-6 d-flex flex-row gap-1 {{ $shareValue == json_encode($data) ? 'active' : null }} {{ $data['value'] == $donationAmt ? 'active' : null }}
                                            @if($donation_status == 1) input-disable @endif">
                                            <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}" @if($donation_status == 1) disabled @endif>
                                            <h6 class="title">{{ $data['name'] }}</h6>
                                            <div class="price">
                                                <span>{{ $data['value'] }}</span>
                                                <small> &#65020;</small>
                                            </div>
                                        </label>
                                    </div>
                                    @endforeach
                                </div>
                            @break

                            @case('fixed')
                                <div class="options my-3">
                                    <div class="option-item">
                                        <label title="{{ $project['title'] }}" class="bg-secound active @if($donation_status == 1) input-disable @endif" >
                                            <h6 class="title">{{ $project['title'] }} </h6>
                                            <div class="price">
                                                {{ $donation['data'] }}
                                                <small> &#65020;</small>
                                            </div>
                                        </label>
                                    </div>
                                </div>
                            @break

                            @case('open')
                                <div class="options my-3">
                                    <div class="option-item">
                                        <input type="number" wire:model="openValue" min="0" class="form-control amount" placeholder="@lang('Donation Amount')" @if($donation_status == 1) disabled @endif>
                                    </div>
                                </div>
                            @break

                            @default
                                <span>Something went wrong, please try again</span>
                            @endswitch
                        @endif

                        <hr />

                            @livewire('site.gifts.add-gifts', [
                            'cards' => $cards,
                            'donation' => $donation,
                            'colorsAmount' => $colorsAmount,
                            'project' => $project,
                            ])


                        <div class="donation-now mt-3 mb-3">
                            <input type="number" class="form-control" min="0" disabled value="{{  @$donationAmt + @$donation_gift + $dynamicAmt}}" />
                            <button wire:click="donateNow()" class="bg-main btn" {{ $mustLogin ? 'disabled':'' }}>
                                @lang('Donate Now')
                            </button>
                            <button wire:click="addToCart()" class="bg-secound btn" {{ $mustLogin ? 'disabled':'' }}>
                                <i class="icofont-cart-alt"></i>
                            </button>
                        </div>

                        @include('site.layouts.cart-msg')

                        <hr/>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('site.carts.add-modal')

</section>
