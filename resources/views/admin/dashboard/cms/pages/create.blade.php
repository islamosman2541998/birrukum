@extends('admin.app')

@section('title', trans('admin.page_create'))
@section('title_page', trans('admin.pages'))
@section('title_route', route('admin.pages.index'))
@section('button_page')
    <a href="{{ route('admin.pages.index') }}"
        class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection


@section('content')


    <div class="row">
        <div class="col-12 m-3">

            <div class="card">
                <div class="card-body">

                    <form action="{{ route('admin.pages.store') }}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-8">
                                @foreach ($languages as $key => $locale)
                                    <div class="accordion mt-4 mb-4" id="accordionExampleTitle{{ $key }}">
                                        <div class="accordion-item border rounded">
                                            <h2 class="accordion-header" id="headingTitle{{ $key }}">
                                                <button class="accordion-button fw-medium" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapseTitle{{ $key }}" aria-expanded="true"
                                                    aria-controls="collapseOne{{ $key }}">
                                                    {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                                </button>
                                            </h2>
                                            <div id="collapseTitle{{ $key }}"
                                                class="accordion-collapse collapse show mt-3"
                                                aria-labelledby="headingTitle{{ $key }}"
                                                data-bs-parent="#accordionExampleTitle{{ $key }}">
                                                <div class="accordion-body">



                                                    {{-- title ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-12 col-form-label">{{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text"
                                                                name="{{ $locale }}[title]"
                                                                value="{{ old($locale . '.title') }}"
                                                                id="title{{ $key }}">
                                                            @if ($errors->has($locale . '.title'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                            @endif
                                                        </div>

                                                    </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    {{-- Start Slug --}}
                                                    <div class="row mb-3 slug-section">
                                                        <label for="example-text-input"
                                                            class="col-sm-2 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-12">
                                                            <input type="text" id="slug{{ $key }}"
                                                                name="{{ $locale }}[slug]"
                                                                value="{{ old($locale . '.slug') }}"
                                                                class="form-control slug" required>
                                                            @if ($errors->has($locale . '.slug'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                            @endif
                                                        </div>
                                                        @include('admin.layouts.scriptSlug')
                                                        {{-- End Slug --}}



                                                        <div class="row mt-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">
                                                                {{ trans('admin.content_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-12 mb-2">
                                                                <textarea id="content{{ $key }}" name="{{ $locale }}[content]" class="m-auto form-control "
                                                                    style="margin-top: 10px"> {{ old($locale . '.content') }} </textarea>
                                                                @if ($errors->has($locale . '.content'))
                                                                    <span
                                                                        class="missiong-spam">{{ $errors->first($locale . '.content') }}</span>
                                                                @endif
                                                            </div>

                                                            <script type="text/javascript">
                                                                CKEDITOR.replace('content{{ $key }}', {
                                                                    filebrowserUploadUrl: "{{ route('admin.ckeditor.upload', ['_token' => csrf_token()]) }}",
                                                                    filebrowserUploadMethod: 'form'
                                                                });
                                                            </script>

                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                            <button class="accordion-button fw-medium " type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseTwo{{ $key }}"
                                                aria-expanded="true" aria-controls="collapseTwo{{ $key }}">
                                                @lang('admin.meta')
                                            </button>
                                        </h2>
                                        <div id="collapseTwo{{ $key }}" class="accordion-collapse collapse  mt-3"
                                            aria-labelledby="headingTwo{{ $key }}"
                                            data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                @foreach ($languages as $key => $locale)
                                                    {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input"
                                                            class="col-sm-12 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="text"
                                                                name="{{ $locale }}[meta_title]"
                                                                value="{{ old($locale . '.meta_title') }}"
                                                                id="title{{ $key }}">
                                                        </div>
                                                        @if ($errors->has($locale . '.meta_title'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-12 col-form-label">
                                                            {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-12 mb-2">
                                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ old($locale . '.meta_description') }} </textarea>
                                                            @if ($errors->has($locale . '.meta_description'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-12 col-form-label">
                                                            {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-12 mb-2">
                                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ old($locale . '.meta_key') }} </textarea>
                                                            @if ($errors->has($locale . '.meta_key'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_key') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <hr>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingSetting">
                                            <button class="accordion-button fw-medium" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapseSetting"
                                                aria-expanded="true" aria-controls="collapseOne">
                                                {{ trans('admin.settings') }}
                                            </button>
                                        </h2>
                                        <div id="collapseSetting" class="accordion-collapse collapse show"
                                            aria-labelledby="headingSetting" data-bs-parent="#accordionExample">
                                            <div class="accordion-body">

                                                {{-- image ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <div class="row mb-3">
                                                        <label for="example-number-input" class="col-sm-12 col-form-label"
                                                            l>
                                                            @lang('admin.image') : </label>
                                                        <div class="col-sm-12">
                                                            <input class="form-control" type="file"
                                                                placeholder="@lang('admin.image')" id="example-number-input"
                                                                name="image" value="{{ old('image') }}">
                                                        </div>
                                                    </div>
                                                </div>
                                                {{-- Status ------------------------------------------------------------------------------------- --}}
                                                <div class="col-12">
                                                    <label class="col-sm-12 col-form-label"
                                                        for="available">{{ trans('admin.status') }}</label>
                                                    <div class="col-sm-10">
                                                        <div class="form-check form-switch form-check-success">
                                                            <label class="form-check-label"
                                                                for="flexSwitchCheckSuccessStatus">@lang('admin.status')</label>
                                                            <input class="form-check-input" type="checkbox"
                                                                role="switch" name="status"
                                                                {{ request('status') == 1 ? 'checked' : '' }}
                                                                id="flexSwitchCheckSuccessStatus">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">مميزات الصفحة</h5>

                                        <button type="button" class="btn btn-sm btn-success" id="add-feature">
                                            <i class="bx bx-plus"></i>
                                            إضافة ميزة
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <div id="features-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row mt-4">
                            <div class="col-md-12">
                                <div class="card border">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">محتويات إضافية للصفحة</h5>

                                        <button type="button" class="btn btn-sm btn-success" id="add-content">
                                            <i class="bx bx-plus"></i>
                                            إضافة محتوى
                                        </button>
                                    </div>

                                    <div class="card-body">
                                        <div id="contents-wrapper"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- Butoooons ------------------------------------------------------------------------- --}}
                        <div class="row mb-3 text-end">
                            <div>
                                <a href="{{ route('admin.pages.index') }}"
                                    class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                                <button type="submit"
                                    class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                                <button type="submit" name="submit" value="new" id="submit"
                                    class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        var featureIndex = 0;

        function featureTemplate(index) {
            return `
            <div class="feature-item border rounded p-3 mb-3" data-index="${index}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">ميزة رقم ${index + 1}</h6>
                    <button type="button" class="btn btn-sm btn-danger remove-feature">حذف الميزة</button>
                </div>

                <input type="hidden" name="features[${index}][sort]" value="${index}">

                <div class="row">
                    <div class="col-md-6 mb-3">
<label class="form-label">الصورة أو ملف PDF</label>    
                   <input type="file"
       name="features[${index}][image]"
       class="form-control"
       accept="image/*,.pdf">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الرابط</label>
                        <input type="text" name="features[${index}][url]" class="form-control" placeholder="https://example.com">
                    </div>
                </div>

                @foreach ($languages as $key => $locale)
                    <div class="border rounded p-3 mb-3">
                        <h6>{{ trans('lang.' . Locale::getDisplayName($locale)) }}</h6>

                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text" name="features[${index}][{{ $locale }}][title]" class="form-control" placeholder="اكتب عنوان الميزة">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea name="features[${index}][{{ $locale }}][description]" class="form-control" rows="3" placeholder="اكتب وصف الميزة"></textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        `;
        }

        $(document).on('click', '#add-feature', function(e) {
            e.preventDefault();

            $('#features-wrapper').append(featureTemplate(featureIndex));

            featureIndex++;
        });

        $(document).on('click', '.remove-feature', function(e) {
            e.preventDefault();

            $(this).closest('.feature-item').remove();
        });
    </script>
    <script>
        var contentIndex = 0;

        function contentTemplate(index) {
            return `
            <div class="content-item border rounded p-3 mb-3" data-index="${index}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">محتوى رقم ${index + 1}</h6>

                    <button type="button" class="btn btn-sm btn-danger remove-content">
                        حذف المحتوى
                    </button>
                </div>

                <input type="hidden" name="contents[${index}][sort]" value="${index}">

                @foreach ($languages as $key => $locale)
                    <div class="border rounded p-3 mb-3">
                        <h6>{{ trans('lang.' . Locale::getDisplayName($locale)) }}</h6>

                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text"
                                   name="contents[${index}][{{ $locale }}][title]"
                                   class="form-control"
                                   placeholder="اكتب عنوان المحتوى">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea name="contents[${index}][{{ $locale }}][description]"
                                      class="form-control"
                                      rows="4"
                                      placeholder="اكتب وصف المحتوى"></textarea>
                        </div>
                    </div>
                @endforeach
            </div>
        `;
        }

        $(document).on('click', '#add-content', function(e) {
            e.preventDefault();

            $('#contents-wrapper').append(contentTemplate(contentIndex));

            contentIndex++;
        });

        $(document).on('click', '.remove-content', function(e) {
            e.preventDefault();

            $(this).closest('.content-item').remove();
        });
    </script>
@endsection
