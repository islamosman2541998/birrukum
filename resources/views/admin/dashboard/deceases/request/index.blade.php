

@extends('admin.app')

@section('title', trans('decease.show_deceases_request'))
@section('title_page', trans('decease.decease_request'))
@section('title_route', route('admin.deceases.request.index') )
@section('button_page')
<a href="{{ route('admin.deceases.request.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('content')
<div class="card">
    <div class="card-body  search-group">
        {{-- Start Form Search User Search By name,email,role,status --}}
        <form action="{{ route('admin.deceases.request.index') }}" method="get">
            <div class="row mt-3">
                <div class="col-md-2 mt-1">
                    <input type="text" value="{{ request()->title != '' ? request()->title : '' }}" name="title" placeholder="{{ trans('decease.search') }}" class="form-control">
                </div>
                <div class="col-md-2 mt-1">
                    <select class="form-select" name="status" aria-label=".form-select-sm example">
                        <option selected value=""> @lang('admin.status') </option>
                        <option value="1" {{ old('status', request()->input('status')) == 1? "selected":"" }}>@lang('admin.active') </option>
                        <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null? "selected":"" }}> @lang('admin.dis_active') </option>
                    </select>
                </div>
                <div class="search-input col-md-2">
                    <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                    <a class="btn btn-success btn-sm" href="{{ route('admin.eccommerce.attributes-set.index') }}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                </div>
            </div>
        </form>
        {{-- End Form Search User Search By name,email,role,status --}}
    </div>
</div>

<div class="card">
    <div class="card-body ">
        <form id="update-pages" action="{{ route('admin.deceases.request.actions') }}" method="post">
            @csrf
        </form>
        <div class="table-responsive">
            <table id="main-datatable" class="table table-bordered text-center table-striped table-table-success table-hover table-sm" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                <thead>
                    <tr>
                    <tr class="bluck-actions" style="display: none" scope="row">
                        <td colspan="12">
                            <div class="col-md-12 mt-0 mb-0 text-center">
                                <button form="update-pages" class="btn btn-neutral text-success" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                <button form="update-pages" class="btn btn-neutral text-warning" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                <button form="update-pages" class="btn btn-neutral text-danger" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                            </div>
                        </td>

                    </tr>
                    <th style="width: 1px">
                        <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                    </th>
                    <th>#</th>
                    <th>@lang('users.name')</th>
                    <th>@lang('users.mobile')</th>
                    <th>@lang('decease.target_price')</th>
                    <th>@lang('decease.project')</th>
                    <th>@lang('decease.deceased_name')</th>
                    <th>@lang('decease.relative_relation')</th>
                    <th>@lang('decease.created_at')</th>
                    <th>@lang('decease.updated_at')</th>
                    <th>@lang('users.action')</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($decease as $key => $item)
                    <tr>
                        <td>
                            <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value={{ $item->id }}>
                        </td>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->mobile }}</td>
                        <td>{{ $item->target_price }}</td>

                        <td>{{ @$item->Project->trans?->where('locale',$current_lang)->first()->title }}</td>
                        <td>{{ $item->deceased_name }}</td>
                        <td>{{ $item->relative_relation }}</td>
                       
                        <td>{{ $item->created_at }}</td>
                        <td>{{ $item->updated_at }}</td>
                        <td>
                            <div class="d-flex justify-content-center">
                                @if ($item->confirmed == 1)
                                    <a class="btn btn-neutral text-success"><i class="bx bxs-check-square"></i></a>
                                @else
                                    <a href="{{ route('admin.deceases.request.show', $item->id) }}" class="btn btn-neutral text-warning"><i class="bx bx-no-entry"></i></a>
                                @endif
                                <a href="{{ route('admin.deceases.request.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>
                                <a type="button" class="btn btn-neutral text-danger" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                    <i class="bx bxs-trash"></i>
                                </a>
                            </div>
                    </tr>
                    </tr>
                    @include('admin.layouts.delete', ['route'=> 'admin.deceases.request.destroy'])

                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


