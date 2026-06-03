@extends('admin.app')

@section('title', trans('admin.page_edit'))
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

                    <form action="{{ route('admin.pages.update', $page->id) }}" method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                                value="{{ @$page->trans->where('locale', $locale)->first()->title }}"
                                                                id="title{{ $key }}">
                                                        </div>
                                                        @if ($errors->has($locale . '.title'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- slug ------------------------------------------------------------------------------------- --}}
                                                    {{-- Start Slug --}}
                                                    <div class="row mb-3 slug-section">
                                                        <label for="example-text-input"
                                                            class="col-sm-12 col-form-label">{{ trans('admin.slug_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>

                                                        <div class="col-sm-12">
                                                            <input type="text" id="slug{{ $key }}"
                                                                name="{{ $locale }}[slug]"
                                                                value="{{ @$page->trans->where('locale', $locale)->first()->slug }}"
                                                                class="form-control slug mb-2" required>
                                                            @if ($errors->has($locale . '.slug'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.slug') }}</span>
                                                            @endif
                                                        </div>
                                                        @include('admin.layouts.scriptSlug')
                                                        {{-- End Slug --}}



                                                        {{-- content ------------------------------------------------------------------------------------- --}}
                                                        <div class="row mb-3">
                                                            <label for="example-text-input"
                                                                class="col-sm-12 col-form-label">
                                                                {{ trans('admin.content_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                            </label>
                                                            <div class="col-sm-12 mb-2">
                                                                <textarea id="content{{ $key }}" name="{{ $locale }}[content]"> {{ @$page->trans->where('locale', $locale)->first()->content }} </textarea>
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
                                @endforeach


                                <div class="accordion mt-4 mb-4" id="accordionExample">
                                    <div class="accordion-item border rounded">
                                        <h2 class="accordion-header" id="headingTwo{{ $key }}">
                                            <button class="accordion-button fw-medium" type="button"
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
                                                            class="col-sm-2 col-form-label">{{ trans('admin.meta_title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text"
                                                                name="{{ $locale }}[meta_title]"
                                                                value="{{ @$page->trans->where('locale', $locale)->first()->meta_title }}"
                                                                id="title{{ $key }}">
                                                        </div>
                                                        @if ($errors->has($locale . '.meta_title'))
                                                            <span
                                                                class="missiong-spam">{{ $errors->first($locale . '.meta_title') }}</span>
                                                        @endif
                                                    </div>

                                                    {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">
                                                            {{ trans('admin.meta_description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="{{ $locale }}[meta_description]" class="form-control description"> {{ @$page->trans->where('locale', $locale)->first()->meta_description }} </textarea>
                                                            @if ($errors->has($locale . '.meta_description'))
                                                                <span
                                                                    class="missiong-spam">{{ $errors->first($locale . '.meta_description') }}</span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- meta_key_ ------------------------------------------------------------------------------------- --}}
                                                    <div class="row mb-3">
                                                        <label for="example-text-input" class="col-sm-2 col-form-label">
                                                            {{ trans('admin.meta_key_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                                        </label>
                                                        <div class="col-sm-10 mb-2">
                                                            <textarea name="{{ $locale }}[meta_key]" class="form-control description"> {{ @$page->trans->where('locale', $locale)->first()->meta_key }} </textarea>
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
                        </div>








                        <div class="col-md-4">

                            <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                                <div class="accordion-item border rounded">
                                    <h2 class="accordion-header" id="headingSetting">
                                        <button class="accordion-button fw-medium" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#collapseSetting"
                                            aria-expanded="true" aria-controls="collapseOne">
                                            {{ trans('admin.settings') }}
                                        </button>
                                    </h2>
                                    <div id="collapseSetting" class="accordion-collapse collapse show"
                                        aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                        <div class="accordion-body">
                                            <div class="col-sm-3 mb-3">
                                                <a href="{{ getImage($page->image) }}" target="_blank">
                                                    <img src="{{ getImageThumb($page->image) }}" alt=""
                                                        style="width:100%">
                                                </a>
                                            </div>

                                            {{-- image ------------------------------------------------------------------------------------- --}}
                                            <div class="col-12">
                                                <div class="row mb-3">
                                                    <label for="example-number-input" col-form-label>
                                                        @lang('admin.image')</label>
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
                                                        <input class="form-check-input" type="checkbox" role="switch"
                                                            name="status" {{ @$page->status == 1 ? 'checked' : '' }}
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
                                <div id="features-wrapper">
                                    @foreach ($page->features as $featureIndex => $feature)
                                        <div class="feature-item border rounded p-3 mb-3"
                                            data-index="{{ $featureIndex }}">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">ميزة رقم {{ $featureIndex + 1 }}</h6>

                                                <button type="button" class="btn btn-sm btn-danger remove-feature">
                                                    حذف الميزة
                                                </button>
                                            </div>

                                            <input type="hidden" name="features[{{ $featureIndex }}][id]"
                                                value="{{ $feature->id }}">
                                            <input type="hidden" name="features[{{ $featureIndex }}][sort]"
                                                value="{{ $feature->sort }}">
                                            <input type="hidden" name="features[{{ $featureIndex }}][old_image]"
                                                value="{{ $feature->image }}">

                                            <div class="row">
                                                <div class="col-md-3 mb-3">
                                                    <label class="form-label">الصورة الحالية</label>

                                                    @if ($feature->image)
                                                        <div>
                                                            <a href="{{ getImage($feature->image) }}" target="_blank">
                                                                <img src="{{ getImageThumb($feature->image) }}"
                                                                    style="width:80px">
                                                            </a>
                                                        </div>
                                                    @else
                                                        <div class="text-muted">لا توجد صورة</div>
                                                    @endif
                                                </div>

                                                <div class="col-md-4 mb-3">
                                                    <label class="form-label">تغيير الصورة</label>
                                                    <input type="file" name="features[{{ $featureIndex }}][image]"
                                                        class="form-control">
                                                </div>

                                                <div class="col-md-5 mb-3">
                                                    <label class="form-label">الرابط</label>
                                                    <input type="text" name="features[{{ $featureIndex }}][url]"
                                                        value="{{ $feature->url }}" class="form-control"
                                                        placeholder="https://example.com">
                                                </div>
                                            </div>

                                            @foreach ($languages as $key => $locale)
                                                <div class="border rounded p-3 mb-3">
                                                    <h6>{{ trans('lang.' . Locale::getDisplayName($locale)) }}</h6>

                                                    <div class="mb-3">
                                                        <label class="form-label">العنوان</label>
                                                        <input type="text"
                                                            name="features[{{ $featureIndex }}][{{ $locale }}][title]"
                                                            value="{{ @$feature->trans->where('locale', $locale)->first()->title }}"
                                                            class="form-control" placeholder="اكتب عنوان الميزة">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">الوصف</label>
                                                        <textarea name="features[{{ $featureIndex }}][{{ $locale }}][description]" class="form-control"
                                                            rows="3" placeholder="اكتب وصف الميزة">{{ @$feature->trans->where('locale', $locale)->first()->description }}</textarea>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
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
                                <div id="contents-wrapper">
                                    @foreach ($page->contents as $contentIndex => $content)
                                        <div class="content-item border rounded p-3 mb-3"
                                            data-index="{{ $contentIndex }}">
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="mb-0">محتوى رقم {{ $contentIndex + 1 }}</h6>

                                                <button type="button" class="btn btn-sm btn-danger remove-content">
                                                    حذف المحتوى
                                                </button>
                                            </div>

                                            <input type="hidden" name="contents[{{ $contentIndex }}][id]"
                                                value="{{ $content->id }}">
                                            <input type="hidden" name="contents[{{ $contentIndex }}][sort]"
                                                value="{{ $content->sort }}">

                                            @foreach ($languages as $key => $locale)
                                                <div class="border rounded p-3 mb-3">
                                                    <h6>{{ trans('lang.' . Locale::getDisplayName($locale)) }}</h6>

                                                    <div class="mb-3">
                                                        <label class="form-label">العنوان</label>
                                                        <input type="text"
                                                            name="contents[{{ $contentIndex }}][{{ $locale }}][title]"
                                                            value="{{ @$content->trans->where('locale', $locale)->first()->title }}"
                                                            class="form-control" placeholder="اكتب عنوان المحتوى">
                                                    </div>

                                                    <div class="mb-3">
                                                        <label class="form-label">الوصف</label>
                                                        <textarea name="contents[{{ $contentIndex }}][{{ $locale }}][description]" class="form-control"
                                                            rows="4" placeholder="اكتب وصف المحتوى">{{ @$content->trans->where('locale', $locale)->first()->description }}</textarea>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endforeach
                                </div>
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
                        <button type="submit" name="submit" value="update"
                            class="btn btn-outline-success waves-effect waves-light  btn-sm">@lang('button.save_update')</button>
                    </div>
                </div>





                </form>

            </div>
        </div>
    </div>

    </div> <!-- container-fluid -->

@endsection


@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="{{ asset('site/js/ckeditor/ckeditor.js') }}"></script>
    <script>
        var featureIndex = {{ $page->features->count() }};

        function featureTemplate(index) {
            return `
            <div class="feature-item border rounded p-3 mb-3" data-index="${index}">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h6 class="mb-0">ميزة رقم ${index + 1}</h6>

                    <button type="button" class="btn btn-sm btn-danger remove-feature">
                        حذف الميزة
                    </button>
                </div>

                <input type="hidden" name="features[${index}][sort]" value="${index}">

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">الصورة</label>
                        <input type="file" name="features[${index}][image]" class="form-control">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">الرابط</label>
                        <input type="text"
                               name="features[${index}][url]"
                               class="form-control"
                               placeholder="https://example.com">
                    </div>
                </div>

                @foreach ($languages as $key => $locale)
                    <div class="border rounded p-3 mb-3">
                        <h6>{{ trans('lang.' . Locale::getDisplayName($locale)) }}</h6>

                        <div class="mb-3">
                            <label class="form-label">العنوان</label>
                            <input type="text"
                                   name="features[${index}][{{ $locale }}][title]"
                                   class="form-control"
                                   placeholder="اكتب عنوان الميزة">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">الوصف</label>
                            <textarea name="features[${index}][{{ $locale }}][description]"
                                      class="form-control"
                                      rows="3"
                                      placeholder="اكتب وصف الميزة"></textarea>
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
        var contentIndex = {{ $page->contents->count() }};

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
