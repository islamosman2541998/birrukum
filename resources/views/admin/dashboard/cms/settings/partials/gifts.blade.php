@extends('admin.app')

@section('title', trans('settings.edit', ['name' =>  $settingMain->title]) )
@section('title_page', trans('settings.settings'))
@section('title_route', route('admin.settings.index') )
@section('button_page')
<a href="{{ route('admin.settings.index') }}" class="btn btn-outline-primary waves-effect waves-light ml-3 btn-sm">@lang('button.cancel')</a>
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
                <div class="accordion mt-4 mb-4" id="accordionExample">
                    <div class="accordion-item border rounded">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                @lang('settings.information')
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show mt-3" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                @foreach ($languages as $key => $locale)
                                {{-- meta_title_ ------------------------------------------------------------------------------------- --}}
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label">{{ trans('admin.title') . trans('lang.' .Locale::getDisplayName($locale)) }}</label>
                                    <div class="col-sm-10">
                                        <input class="form-control" type="text" name="gift_title_{{ $locale }}" value="{{ @$settings['gift_title_' . $locale] }}" id="title{{ $key }}">
                                    </div>
                                </div>

                                {{-- meta_description_ ------------------------------------------------------------------------------------- --}}
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="form-group col-10 mb-3">
                                        <br>
                                        <button type="button" class="btn btn-primary" onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[giver_name]]') ;return false;" value=""> @lang('settings.giver_name') </button>
                                        <button type="button" class="btn btn-primary" onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[from_name]]') ;return false;" value=""> @lang('settings.given_name') </button>
                                        <button type="button" class="btn btn-primary" onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[giver_group]]') ;return false;" value=""> @lang('settings.gift_type') </button>
                                        <button type="button" class="btn btn-primary" onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[card]]') ;return false;" value=""> @lang('settings.attach_card') </button>
                                        <button type="button" class="btn btn-primary" onclick="$('#msg{{ $key }}').val($('#msg{{ $key }}').val() +'[[project]]') ;return false;" value=""> @lang('settings.attach_project') </button>
                                        <small class="red "> @lang('settings.change_description_value') </small>
                                    </div>
                                </div>
                                <div class="row mb-3">
                                    <label for="example-text-input" class="col-sm-2 col-form-label"> {{ trans('settings.gift_description') . trans('lang.' .Locale::getDisplayName($locale)) }}
                                    </label>
                                    <div class="col-sm-10 mb-2">
                                        <textarea name="gift_description_{{ $locale }}" class="form-control" rows="9" id="msg{{ $key }}"> {{ @$settings['gift_description_' . $locale] }} </textarea>
                                    </div>
                                </div>

                                <hr>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion mt-4 mb-4 " id="accordionExampletypes">
                    <div class="accordion-item border rounded ">
                        <h2 class="accordion-header" id="headingTypes">
                            <button class="accordion-button fw-medium" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTypes" aria-expanded="true" aria-controls="collapseTypes">
                                {{ trans('settings.gift_categories') }}
                            </button>
                        </h2>

                        <div id="collapseTypes" class="accordion-collapse collapse show mt-3" aria-labelledby="headingTypes" data-bs-parent="#accordionExampletypes">
                            <div class="accordion-body">
                                <div class="row">
                                    <div id="gift-filed">
                                        @if(@$settings['gift_category'])
                                        @forelse (json_decode(@$settings['gift_category']) as $key =>$item)
                                            <div class="row new-gift-field mb-2 item_{{ $key }}">
                                                <div class="col-md-3">
                                                    <label for="example-email-input" class="col-form-label"> {{ trans("settings.category_title")  . trans("lang." .Locale::getDisplayName("en"))}} </label>
                                                    <input type="text" class="form-control" name="gift_category[{{ $key }}][title_en]" value="{{ @$item->title_en }}">
                                                </div>
                                                <div class="col-md-3">
                                                    <label for="example-email-input" class="col-form-label"> {{ trans("settings.category_title")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                                                    <input type="text" class="form-control" name="gift_category[{{ $key }}][title_ar]" value="{{ @$item->title_ar }}">
                                                </div>
                                                <div class="col-md-5">
                                                    <label class="control-label" for="imageUpload">@lang("admin.images") </label>
                                                    <div class="glr-group row">
                                                        <input id="group{{ $key }}" readonly name="gift_category[{{ $key }}][images]" class="form-control" type="text" value="{{ @$item->images }}">
                                                        <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal{{ $key }}" class="mt-2 ml-3 btn btn-primary waves-effect waves-light btn-sm" type="button">@lang("admin.choose")</a>
                                                    </div>
                                                    <div class="modal fade" id="exampleModal{{ $key }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog modal-xl">
                                                            <div class="modal-content">
                                                                <div class="pt-0 mt-0 card-body">
                                                                    <iframe width="100%" height="500" src="{{ asset("admin/filemanager/dialog.php") }}?type=2&field_id=group{{ $key }}&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1 mt-5">
                                                    <a class="text-danger h3 fa-lg remove-row" onclick="removeItem({{ $key }})"  data-key="{{ $key }}"> <i class="bx bx-trash"></i></a>
                                                </div>
                                                <div class="col-md-10 mb-2">
                                                    <div class="row">
                                                    @forelse(json_decode($item->images) as $img)
                                                        <div class="col-md-1">
                                                            <a href="{{ getImageFileManger($img) }}" target="_blank">
                                                                <img class="img-fluid" src="{{ getImageFileManger($img) }}" alt="" width="">
                                                            </a>
                                                        </div>
                                                    @empty
                                                    @endforelse
                                                    </div>
                                                </div>
                                                <hr/>
                                            </div>
                                        @empty
                                        @endforelse
                                        @endif
                                    </div>
                                </div>
                                <div class="row">
                                    <button type="button" class="add-gift-filed btn btn-success">اضافة فئة جديدة</button>
                                </div>
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
    </form>

@endsection


@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    var max_fields = 20; //maximum input boxes allowed
    var giftSection = $("#gift-filed"); //Fields giftSection
    var add_button = $(".add-gift-filed"); //Add button class
    var count = $('#gift-filed .new-gift-field').length; //initlal text box count
    //adding new bank account
    $(add_button).click(function(e) { //on add input button click
        e.preventDefault();
        if (count < max_fields) { //max input box allowed
            count++; //text box increment
            $(giftSection).append(
                `<div class="row new-gift-field mb-2 item_${count}">
                   <div class="col-md-3">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.category_title")  . trans("lang." .Locale::getDisplayName("en"))}} </label>
                       <input type="text" class="form-control" name="gift_category[${count}][title_en]">
                   </div>
                   <div class="col-md-3">
                       <label for="example-email-input" class="col-form-label"> {{ trans("settings.category_title")  . trans("lang." .Locale::getDisplayName("ar"))}} </label>
                       <input type="text" class="form-control" name="gift_category[${count}][title_ar]">
                   </div>
                   <div class="col-md-5"> 
                       <label class="control-label" for="imageUpload">@lang("admin.images") </label> 
                       <div class="glr-group row"> 
                           <input  id="group${count}" readonly name="gift_category[${count}][images]" class="form-control" type="text" value="{{ old("images") }}">
                           <a data-toggle="modal" href="javascript:;" data-bs-toggle="modal" data-bs-target="#exampleModal${count}" class="mt-2 ml-3 btn btn-primary waves-effect waves-light btn-sm" type="button">@lang("admin.choose")</a>
                       </div>
                       <div class="modal fade" id="exampleModal${count}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true"> 
                           <div class="modal-dialog modal-xl"> 
                               <div class="modal-content"> 
                                   <div class="pt-0 mt-0 card-body"> 
                                       <iframe width="100%" height="500" src="{{ asset("admin/filemanager/dialog.php") }}?type=2&field_id=group${count}&relative_url=1" frameborder="0" style="overflow: scroll; overflow-x: hidden; overflow-y: scroll; "></iframe>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
                   <div class="col-md-1 my-5">
                       <a class="text-danger h3 fa-lg remove-row" onclick="removeItem(${count})"> <i class="bx bx-trash" ></i></a>
                   </div>
                <hr/>
                </div>` 
            );
        }
    });

    // remove row
    $('.remove-row').click(function() {
        $(this).parent().parent().remove();
    })

    function removeItem(id){
        $('.item_'+id).remove();
    }
</script>
@endsection
