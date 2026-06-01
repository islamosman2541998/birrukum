@extends('admin.app')

@section('title', trans('refer.show_refers'))
@section('title_page', trans('refer.refers') )
@section('title_route', route('admin.charity.refers.index') )
@section('button_page')
    <a href="{{ route('admin.charity.refers.create') }}" class="btn btn-outline-success btn-sm">@lang('admin.create')</a>
@endsection


@section('content')
    <div class="card">
        <div class="card-body  search-group">
            {{-- Start Form Search User Search By name,email,role,status --}}
            <form action="{{ route('admin.charity.refers.index') }}" method="get">

                <div class="row mt-3">
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->name != '' ? request()->name : '' }}" name="name" placeholder="{{ trans('refers.name') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mt-1">
                        <input type="text" value="{{ request()->employee_name != '' ? request()->employee_name : '' }}" name="employee_name" placeholder="{{ trans('refer.employee_name') }}" class="form-control">
                    </div>
                    <div class="col-md-2 mt-1">
                        <select class="select form-control" name="status">
                            <option selected value=""> @lang('admin.status') </option>
                            <option value="1" {{ old('status', request()->input('status')) == 1 ? 'selected' : '' }}>
                                @lang('admin.active') </option>
                            <option value="0" {{ old('status', request()->input('status')) != 1 && old('status', request()->input('status')) != null ? 'selected' : '' }}>
                                @lang('admin.dis_active') </option>

                        </select>
                    </div>
                    <div class="search-input col-md-2">
                        <button class="btn btn-primary btn-sm" type="submit" data-hover="{{ trans('pages.search') }}"><i class="bx bx-search-alt"> </i></button>
                        <a class="btn btn-success btn-sm" href="{{ route('admin.users.index') }}" data-hover="{{ trans('button.reset') }}"><i class="bx bx-refresh"></i></a>
                    </div>
                </div>
            </form>
            {{-- End Form Search User Search By name,email,role,status --}}

        </div>
    </div>

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <form id="update-pages" action="{{ route('admin.charity.refers.actions') }}" method="post">
                    @csrf
                </form>
                <table id="main-datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                    <thead>
                        <tr>
                        <tr class="bluck-actions" style="display: none" scope="row">
                            <td colspan="8">
                                <div class="col-md-12 mt-0 mb-0 text-center">
                                    <button form="update-pages" class="btn btn-neutral text-success btn-sm" type="submit" name="publish" value="1"> <i class="bx bxs-check-square"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-warning btn-sm" type="submit" name="unpublish" value="1"> <i class="bx bx-no-entry"></i></button>
                                    <button form="update-pages" class="btn btn-neutral text-danger btn-sm" type="submit" name="delete_all" value="1"> <i class="bx bxs-trash"></i></button>
                                </div>
                            </td>
                        </tr>
                        <th style="width: 1px">
                            <input form="update-pages" class="checkbox-check flat" type="checkbox" name="check-all" id="check-all">
                        </th>
                        <th>#</th>
                        <th>@lang('users.name')</th>
                        <th>@lang('refer.employee_name')</th>
                        <th>@lang('refer.show_orders')</th>
                        <th>@lang('refer.created_at')</th>
                        <th>@lang('refer.updated_at')</th>
                        <th>@lang('users.action')</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($refers as $key => $item)
                        <tr>
                            <td>
                                <input form="update-pages" class="checkbox-check" type="checkbox" name="record[{{ $item->id }}]" value={{ $item->id }}>
                            </td>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->employee_name }}</td>
                            <td> 
                                <a href="{{ route('admin.charity.refers.orders', $item->id) }}" class="btn btn-success btn-sm" target="_blank"> @lang('refer.orders') </a>
                                {{-- <button class="btn btn-success btn-sm"> @lang('refer.orders') </button>  --}}
                            </td>
                            <td>{{ $item->created_at }}</td>
                            <td>{{ $item->updated_at }}</td>

                            <td>
                                <div class="d-flex justify-content-center">
                                    @if ($item->status == 1)
                                    <a href="{{ route('admin.charity.refers.update-status', $item->id) }}" class="btn btn-neutral text-success"><i class="bx bxs-check-square"></i></a>
                                    @else
                                    <a href="{{ route('admin.charity.refers.update-status', $item->id) }}" class="btn btn-neutral text-warning"><i class="bx bx-no-entry"></i></a>
                                    @endif

                                    <a href="{{ route('site.store.show', $item->slug) }}" class="btn btn-neutral text-success" data-hover="{{ trans('admin.link') }}" target="_blank"><i class='bx bx-link' ></i></a>

                                    <a href="{{ route('admin.charity.refers.edit', $item->id) }}" class="btn btn-neutral text-warning" data-hover="{{ trans('button.edit') }}"><i class="bx bxs-edit"></i></a>
                                    <a href="{{ route('admin.charity.refers.show', $item->id) }}" data-hover="@lang('admin.show')" class="btn btn-neutral text-info"><i class="bx bxs-show"></i></a>

                                    <a type="button" class="btn btn-neutral text-danger" class="color-red" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $item->id }}">
                                        <i class="bx bxs-trash"></i>
                                    </a>

                                </div>
                            </td>
                        </tr>


                        @include('admin.layouts.delete', ['route'=> 'admin.charity.refers.destroy'])


                        @endforeach



                    </tbody>


                </table>

            </div>
        </div>
    </div>
@endsection


