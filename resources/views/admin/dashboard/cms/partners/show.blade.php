@extends('admin.app')

@section('title', 'عرض شريك')
@section('title_page', 'الشركاء')
@section('title_route', route('admin.partners.index'))
@section('button_page')
<a href="{{ route('admin.partners.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
@endsection

@section('content')

@php
    $trans = $partner->trans->where('locale', $current_lang)->first();
@endphp

<div class="card">
    <div class="card-body">

        <div class="row">
            <div class="col-md-4">
                @if($partner->image)
                    <a href="{{ getImage($partner->image) }}" target="_blank">
                        <img src="{{ getImage($partner->image) }}" class="img-fluid rounded" alt="{{ @$trans->title }}">
                    </a>
                @endif
            </div>

            <div class="col-md-8">
                <h4>{{ @$trans->title }}</h4>

                <p>{{ @$trans->description }}</p>

                @if($partner->url)
                    <p>
                        <strong>الرابط:</strong>
                        <a href="{{ $partner->url }}" target="_blank">{{ $partner->url }}</a>
                    </p>
                @endif

                <p>
                    <strong>@lang('admin.status'):</strong>
                    {{ $partner->status ? trans('admin.active') : trans('admin.dis_active') }}
                </p>

                <p>
                    <strong>@lang('articles.sort'):</strong>
                    {{ $partner->sort }}
                </p>
            </div>
        </div>

    </div>
</div>

@endsection