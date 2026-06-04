@extends('admin.app')

@section('title', 'إضافة شريك')
@section('title_page', 'الشركاء')
@section('title_route', route('admin.partners.index'))
@section('button_page')
<a href="{{ route('admin.partners.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

<div class="card">
    <div class="card-body">

        <form action="{{ route('admin.partners.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <div class="row">
                <div class="col-md-8">
                    @foreach ($languages as $key => $locale)
                        <div class="accordion mt-4 mb-4" id="accordionExamplePartner{{ $key }}">
                            <div class="accordion-item border rounded">
                                <h2 class="accordion-header" id="headingPartner{{ $key }}">
                                    <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapsePartner{{ $key }}" aria-expanded="true" aria-controls="collapsePartner{{ $key }}">
                                        {{ trans('lang.' . Locale::getDisplayName($locale)) }}
                                    </button>
                                </h2>

                                <div id="collapsePartner{{ $key }}" class="accordion-collapse collapse show mt-3" aria-labelledby="headingPartner{{ $key }}" data-bs-parent="#accordionExamplePartner{{ $key }}">
                                    <div class="accordion-body">

                                        <div class="row mb-3 title-section">
                                            <label class="col-sm-12 col-form-label">
                                                {{ trans('admin.title_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>

                                            <div class="col-sm-12">
                                                <input type="text" name="{{ $locale }}[title]" value="{{ old($locale . '.title') }}" class="form-control" required>

                                                @if ($errors->has($locale . '.title'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.title') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="row mb-3">
                                            <label class="col-sm-12 col-form-label">
                                                {{ trans('admin.description_in') . trans('lang.' . Locale::getDisplayName($locale)) }}
                                            </label>

                                            <div class="col-sm-12 mb-2">
                                                <textarea name="{{ $locale }}[description]" class="form-control" rows="5">{{ old($locale . '.description') }}</textarea>

                                                @if ($errors->has($locale . '.description'))
                                                    <span class="missiong-spam">{{ $errors->first($locale . '.description') }}</span>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="col-md-4">
                    <div class="accordion mt-4 mb-4" id="accordionExampleSetting">
                        <div class="accordion-item border rounded">
                            <h2 class="accordion-header" id="headingSetting">
                                <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
                                    {{ trans('admin.settings') }}
                                </button>
                            </h2>

                            <div id="collapseSetting" class="accordion-collapse collapse show" aria-labelledby="headingSetting" data-bs-parent="#accordionExampleSetting">
                                <div class="accordion-body">

                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-form-label">@lang('admin.image')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="file" name="image" value="{{ old('image') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-form-label">الرابط</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="text" name="url" value="{{ old('url') }}" placeholder="https://example.com">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="row mb-3">
                                            <label class="col-form-label">@lang('articles.sort')</label>
                                            <div class="col-sm-12">
                                                <input class="form-control" type="number" name="sort" value="{{ old('sort') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mt-3">
                                        <div class="col-sm-10">
                                            <div class="form-check form-switch form-check-success">
                                                <label class="form-check-label" for="partnerStatus">@lang('admin.status')</label>
                                                <input class="form-check-input" type="checkbox" role="switch" name="status" {{ request('status') == 1 ? 'checked' : '' }} id="partnerStatus">
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mb-3 text-end">
                    <div>
                        <a href="{{ route('admin.partners.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
                        <button type="submit" class="btn btn-outline-success waves-effect waves-light ml-3 btn-sm">@lang('button.save')</button>
                        <button type="submit" name="submit" value="new" id="submit" class="btn btn-outline-success waves-effect waves-light btn-sm">@lang('button.save_new')</button>
                    </div>
                </div>

            </div>
        </form>

    </div>
</div>

@endsection