<div class="col-md-4">
    <div class="project shadow  projects-home">
        <div class="header d-flex">
            <h5 class="project-title">
                <a href="{{ route('site.charity-project.show', $project['slug']) }}">
                    {{ $project['title'] }}
                </a>
            </h5>

            <ul class="project-social p-0 nav flex-column" data-bs-toggle="collapse"
                href="#socialShare1{{ $project['id'] }}" role="button" aria-expanded="false"
                aria-controls="socialShare1{{ $project['id'] }}">
                <a class="social-share nav-link active">
                    <i class="icofont-share"></i>
                </a>
                <span class="collapse toggelShare" id="socialShare1{{ $project['id'] }}">
                    <a target="blank" class="nav-link">
                        <i class="icofont-facebook"></i>
                    </a>
                    <a target="blank" class="nav-link">
                        <i class="icofont-brand-whatsapp"></i>
                    </a>
                    <a target="blank" class="nav-link">
                        <i class="icofont-envelope"></i>
                    </a>
                    <a target="blank" class="nav-link">
                        <i class="icofont-twitter"></i>
                    </a>
                </span>
            </ul>
        </div>
        <div class="project-img">
            <a class="" href="{{ route('site.charity-project.show', $project['slug']) }}" title="">
                <img class="" src="{{ getImage($project['background_image']) }}" />
            </a>
        </div>

        <div class="project-details my-2">
            @if ($project['target_price'])
                <div class="progress mt-3">
                    <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                        style="width: {{ $progressBar['percent'] }}%" aria-valuenow="37" aria-valuemin="0"
                        aria-valuemax="100">
                        {{ $progressBar['percent'] }}@lang('%')
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
            @endif


            @if (is_array($donation))
                @switch($donation['type'])
                    @case('unit')
                        <div class="options my-2">
                            <div class="d-flex flex-row">
                                @forelse (@$donation['data'] ?? [] as $key => $data)
                                    <div class="option-item">
                                        <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}"
                                            class="{{ $colorsAmount[$key % count($colorsAmount)] }} rounded-6 d-flex flex-row gap-1 {{ $unitValueRadio == json_encode($data) ? 'active' : null }}"
                                            style="background-color: {{ $colors[$key % count($colors)] }}!important">
                                            <input wire:model.live="unitValueRadio" type="radio"
                                                value="{{ json_encode($data) }}">
                                            <div class="price">
                                                <span>{{ $data['value'] }}</span>
                                                <small class="large-screen"> &#65020;</small>
                                            </div>
                                        </label>
                                    </div>
                                @empty
                                @endforelse
                                <div class="mx-2">
                                    <input type="number" wire:model.live="unitValueInput" min="0" class="form-control"
                                        placeholder="@lang('Another amount')">
                                </div>
                            </div>
                        </div>
                    @break

                    @case('share')
                        <div class="options my-2">
                            @forelse (@$donation['data']??[] as $key => $data)
                                <div class="option-item">
                                    <label data-toggle="tooltip" data-placement="top" title="{{ $data['name'] }}"
                                        class="{{ $colorsAmount[$key % count($colorsAmount)] }} rounded-6 d-flex flex-row gap-1 {{ $shareValue == json_encode($data) ? 'active' : null }}"
                                        style="background-color: {{ $colors[$key % count($colors)] }}!important">
                                        <input wire:model.live="shareValue" type="radio" value="{{ json_encode($data) }}">
                                        <div class="price">
                                            <span>{{ $data['value'] }}</span>
                                            <small class="large-screen"> &#65020;</small>
                                        </div>
                                    </label>
                                </div>
                            @empty
                            @endforelse
                        </div>
                    @break

                    @case('fixed')
                        <div class="options my-2">
                            <div class="option-item">
                                <label title="{{ @$project['title'] }}" class="bg-secound rounded-6 d-flex flex-row gap-1">
                                    <div class="price">
                                        {{ @$donation['data'] }}
                                        <small> &#65020;</small>
                                    </div>
                                </label>
                            </div>
                        </div>
                    @break

                    @case('open')
                        <div class="options my-2">
                            <div class="option-item">
                                <input type="number" wire:model="openValue" min="0" class="form-control amount"
                                    placeholder="@lang('Price')">
                            </div>
                        </div>
                    @break

                    @default
                        <span>Something went wrong, please try again</span>
                @endswitch
            @endif

            <div class="donation-now">
                <input type="فثءف" class="form-control" disabled
                    value="{{ @$donationAmt }} {{ $donationAmt > 0 ? trans('SAR') : '' }}" />
                <a href="{{ route('site.charity-project.show', $project['slug']) }}?amount={{ @$donationAmt }}"
                    class="bg-main btn ">
                    @lang('Donate Now')
                </a>
                <button type="button" class="btn bg-secound" wire:click="addToCart" data-bs-toggle="modal"
                    data-bs-target=".modalCart">
                    <i class="icofont-cart"></i>
                </button>
            </div>



        </div>
        @include('site.layouts.cart-msg')
    </div>
</div>
