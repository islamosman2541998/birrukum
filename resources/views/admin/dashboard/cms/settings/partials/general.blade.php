@extends('admin.app')

@section('title', trans('settings.edit', ['name' => $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('style')
{{-- @vite(['resources/assets/admin/css/data-tables.js']) --}}
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
@endsection

@section('content')


<form class="form-horizontal" action="{{route('admin.settings.update-custom', $settingMain->key)}}" method="POST" enctype="multipart/form-data" role="form">
    @csrf

    <div class="row text-center mt-5 mb-3">
        <label class="col-sm-2 col-form-label"> @lang('settings.title_setting') </label>
        <div class="col-sm-10">
            <input class="form-control" type="text" name="title" value="{{ @$settings['title'] }}" required>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">

            {{-- general setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionGeneral">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingGeneral">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseGeneral" aria-expanded="true" aria-controls="collapseGeneral">
                            @lang('settings.settings')
                        </button>
                    </h2>
                    <div id="collapseGeneral" class="accordion-collapse collapse show mt-3" aria-labelledby="headingGeneral" data-bs-parent="#accordionGeneral">
                        <div class="accordion-body">
                            <div class="row">
                                @forelse ($languages as $key => $locale)
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> {{ trans('settings.site') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                        <div class="col-sm-9">
                                            <input class="form-control" type="text" name="site_{{ $locale }}" value="{{ @$settings['site_' . $locale] }}" id="title{{ $key }}">
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                                {{-- link applications  --}}
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang(('settings.google_play')) </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="url" name="google_play" value="{{ @$settings['google_play'] }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-2 col-form-label"> @lang(('settings.app_store')) </label>
                                            <div class="col-sm-9">
                                                <input class="form-control" type="url" name="app_store" value="{{ @$settings['app_store'] }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- item status --}}
                                <div class="row">
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label"> @lang('settings.show_slider') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_slider" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_slider" {{ @$settings['show_slider'] == 1 ? 'checked' : '' }} id="show_slider">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 col-md-6">
                                        <div class="row mb-3">
                                            <label class="col-sm-4 col-form-label"> @lang('settings.show_category') </label>
                                            <div class="col-sm-5">
                                                <div class="form-check form-switch form-check-success mt-1">
                                                    <input type="hidden" name="show_category" value="0">
                                                    <input class="form-check-input" type="checkbox" name="show_category" {{ @$settings['show_category'] == 1 ? 'checked' : '' }} id="show_category">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- logo & icons  --}}
            <div class="accordion mt-4 mb-4" id="accordionFooter">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingFooter">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFooter" aria-expanded="true" aria-controls="collapseFooter">
                            @lang('settings.logo&Icons')
                        </button>
                    </h2>
                    <div id="collapseFooter" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFooter" data-bs-parent="#accordionFooter">
                        <div class="accordion-body">
                            @forelse ($languages as $key => $locale)
                                {{-- logos  --}}
                                <div class="col-12 col-md-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label class="col-sm-12 col-form-label"> {{ trans('settings.logo') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                            <input class="form-control" type="file"  name="logo_{{ $locale }}">
                                        </div>
                                        @if(isset($settings['logo_' . $locale]))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage(@$settings['logo_' . $locale])}}">
                                                <img src="{{ getImageThumb(@$settings['logo_' . $locale])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                {{-- icons  --}}
                            @empty
                            @endforelse

                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label class="col-sm-12 col-form-label"> @lang('settings.icons')</label>
                                        <input class="form-control" type="file"  name="icon">
                                    </div>
                                    @if(isset($settings['icon']))
                                    <div class="col-sm-6">
                                        <a href="{{ getImage(@$settings['icon'])}}">
                                            <img src="{{ getImageThumb(@$settings['icon'])}}" width="50px" />
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-sm-3">
                                        <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- banars  --}}
            <div class="accordion mt-4 mb-4" id="accordionFooter">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingFooter">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFooter" aria-expanded="true" aria-controls="collapseFooter">
                            @lang('settings.Banars')
                        </button>
                    </h2>
                    <div id="collapseFooter" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFooter" data-bs-parent="#accordionFooter">
                        <div class="accordion-body">
                            {{-- banar web   --}}
                            <div class="row">
                                {{-- banar web 1  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb1') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb1')" name="banarWeb1">
                                        </div>
                                        @if(isset($settings['banarWeb1']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb1'])}}">
                                                <img src="{{ getImageThumb($settings['banarWeb1'])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb1_link" value="{{ @$settings['banarWeb1_link'] }}" class="form-control">
                                </div>
                                {{-- banar web 2  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb2') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb2')" name="banarWeb2">
                                        </div>
                                        @if(isset($settings['banarWeb2']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb2'])}}">
                                                <img src="{{ getImageThumb($settings['banarWeb2'])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb2_link" value="{{ @$settings['banarWeb2_link'] }}" class="form-control">
                                </div>
                                {{-- banar web 3  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarWeb3') </label>
                                            <input class="form-control" type="file" placeholder="@lang('settings.banarWeb3')" name="banarWeb3">
                                        </div>
                                        @if(isset($settings['banarWeb3']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarWeb3'])}}">
                                                <img src="{{ getImageThumb($settings['banarWeb3'])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarWeb3_link" value="{{ @$settings['banarWeb3_link'] }}" class="form-control">
                                </div>
                            </div>
                            <hr>
                            {{-- banar mobile   --}}
                            <div class="row">
                                {{-- banar mobile 1  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarMobile1') </label>
                                            <input class="form-control" type="file" name="banarMobile1">
                                        </div>
                                        @if(isset($settings['banarMobile1']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarMobile1'])}}">
                                                <img src="{{ getImageThumb($settings['banarMobile1'])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarMobile1_link" value="{{ @$settings['banarMobile1_link'] }}" class="form-control">
                                </div>
                                {{-- banar mobile 2  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarMobile2') </label>
                                            <input class="form-control" type="file" name="banarMobile2">
                                        </div>
                                        @if(isset($settings['banarMobile2']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarMobile2'])}}">
                                                <img src="{{ getImageThumb($settings['banarMobile2'])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarMobile2_link" value="{{ @$settings['banarMobile2_link'] }}" class="form-control">
                                </div>
                                {{-- banar mobile 3  --}}
                                <div class="col-12 col-md-6 mt-2">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.banarMobile3') </label>
                                            <input class="form-control" type="file" name="banarMobile3">
                                        </div>
                                        @if(isset($settings['banarMobile3']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['banarMobile3'])}}">
                                                <img src="{{ getImageThumb($settings['banarMobile3'])}}" width="50px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12 col-md-6 mt-2">
                                    <label> @lang('admin.link') </label>
                                    <input type="text" name="banarMobile3_link" value="{{ @$settings['banarMobile3_link'] }}" class="form-control">
                                </div>
                            </div>
                            {{-- banar status   --}}
                            <div class="col-12 col-md-6 mt-2">
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"> @lang('settings.show_banars') </label>
                                    <div class="col-sm-5">
                                        <div class="form-check form-switch form-check-success mt-1">
                                            <input type="hidden" name="show_banars" value="0">
                                            <input class="form-check-input" type="checkbox" name="show_banars" {{ @$settings['show_banars'] == 1 ? 'checked' : '' }} id="show_banars">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- footer  --}}
            <div class="accordion mt-4 mb-4" id="accordionFooter">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingFooter">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFooter" aria-expanded="true" aria-controls="collapseFooter">
                            @lang('settings.Footer')
                        </button>
                    </h2>
                    <div id="collapseFooter" class="accordion-collapse collapse show mt-3" aria-labelledby="headingFooter" data-bs-parent="#accordionFooter">
                        <div class="accordion-body">
                            <div class="row">
                                @forelse ($languages as $key => $locale)
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-2 col-form-label"> {{ trans('settings.footer_description') . trans('lang.' .Locale::getDisplayName($locale)) }} </label>
                                        <div class="col-sm-9">
                                            <textarea class="form-control" name="footer_description_{{ $locale }}" cols="30" rows="6">{{ @$settings['footer_description_' . $locale] }}</textarea>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                @endforelse
                                <div class="col-12 col-md-6">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <label> @lang('settings.declaration_image') </label>
                                            <input class="form-control" type="file" name="declaration_image">
                                        </div>
                                     
                                        @if(isset($settings['declaration_image']))
                                        <div class="col-sm-6">
                                            <a href="{{ getImage($settings['declaration_image'])}}" class="bg-info p-3">
                                                <img src="{{ getImageThumb($settings['declaration_image']) }}" width="100px" />
                                            </a>
                                        </div>
                                        @else
                                        <div class="col-sm-3">
                                            <img src="{{ admin_path('images/not_found.PNG') }}" width="50px" />
                                        </div>
                                        @endif
                                    </div>
                                </div>

                                {{-- footer status   --}}
                                <div class="col-12 col-md-6">
                                    <div class="row mb-3">
                                        <label class="col-sm-4 col-form-label"> @lang('settings.show_footer') </label>
                                        <div class="col-sm-5">
                                            <div class="form-check form-switch form-check-success mt-1">
                                                <input type="hidden" name="show_footer" value="0">
                                                <input class="form-check-input" type="checkbox" name="show_footer" {{ @$settings['show_footer'] == 1 ? 'checked' : '' }} id="show_footer">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- header script pixel  --- --}}
            <div class="accordion mt-4 mb-4" id="accordionMeta">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingMeta">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta" aria-expanded="true" aria-controls="collapseMeta">
                            @lang('settings.script_pixel')
                        </button>
                    </h2>
                    <div id="collapseMeta" class="accordion-collapse collapse show mt-3" aria-labelledby="headingMeta" data-bs-parent="#accordionMeta">
                        <div class="accordion-body">
                            {{-- header script pixel  --- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> @lang('settings.script_pixel') </label>
                                <div class="col-sm-10">
                                    <textarea name="script_pixel" class="form-control" cols="30" rows="6">{{ @$settings['script_pixel'] }}</textarea>
                                </div>
                            </div>
                            {{-- pixel status   --}}
                            <div class="col-12 col-md-6">
                                <div class="row mb-3">
                                    <label class="col-sm-4 col-form-label"> @lang('settings.show_pixel') </label>
                                    <div class="col-sm-5">
                                        <div class="form-check form-switch form-check-success mt-1">
                                            <input type="hidden" name="show_pixel" value="0">
                                            <input class="form-check-input" type="checkbox" name="show_pixel" {{ @$settings['show_pixel'] == 1 ? 'checked' : '' }} id="show_pixel">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Meta Setting  --}}
            <div class="accordion mt-4 mb-4" id="accordionMeta">
                <div class="accordion-item border rounded">
                    <h2 class="accordion-header" id="headingMeta">
                        <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseMeta" aria-expanded="true" aria-controls="collapseMeta">
                            @lang('settings.meta')
                        </button>
                    </h2>
                    <div id="collapseMeta" class="accordion-collapse collapse show mt-3" aria-labelledby="headingMeta" data-bs-parent="#accordionMeta">
                        <div class="accordion-body">

                            @forelse ($languages as $key => $locale)
                            {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                <div class="col-sm-10">
                                    <input class="form-control" type="text" name="meta_title_{{ $locale }}" value="{{ @$settings['meta_title_' . $locale] }}" id="title{{ $key }}">
                                </div>
                            </div>

                            {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_description_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-10 mb-2">
                                    <textarea name="meta_description_{{ $locale }}" class="form-control description"> {{ @$settings['meta_description_' . $locale] }} </textarea>
                                </div>
                            </div>

                            {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                            <div class="row mb-3">
                                <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('admin.meta_key_in') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                </label>
                                <div class="col-sm-10 mb-2">
                                    <textarea name="meta_key_{{ $locale }}" class="form-control description"> {{ @$settings['meta_key_' . $locale] }} </textarea>
                                </div>
                            </div>
                            @empty
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>


    <div class="row mb-3 text-end">
        <div>
            <a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
            <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
        </div>
    </div>
    <!-- /.card-footer -->
</form>
@endsection




@section('script')
{{-- @vite(['resources/assets/admin/js/data-tables.js']) --}}
@endsection
