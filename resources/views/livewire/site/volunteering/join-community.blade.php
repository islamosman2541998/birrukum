<div>
    <div class="content mx-lg-5 mx-2 my-3 border rounded-custom box_Shadow p-lg-5 p-2 pb-0 pb-lg-2">

        @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show mt-1 mx-2" role="alert">
            <p class="text-center">{{ session('success') }} </p>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @else
        @endif

        <form wire:submit.prevent="submit" class="">
            {{-- type ---------------------------------------------------------- --}}
            <div class="row mt-3 mt-lg-0 type-radio text-center">
                <div class="col-12 col-lg-6 mb-3">
                    <label data-toggle="tooltip" data-placement="top" title="@lang('volunteers.volunteer')" class="rounded-6  form-control {{ $type == 'volunteer' ? 'bg-success text-white' : 'bg-secondary' }}">
                        <input wire:model.live="type" type="radio" value="volunteer">
                        <span> @lang('volunteers.individual') </span>
                    </label>
                </div>
                <div class="col-12 col-lg-6">
                    <label data-toggle="tooltip" data-placement="top" title="@lang('volunteers.team')" class="rounded-6  form-control {{ $type == 'team' ? 'bg-success text-white' : 'bg-secondary' }}">
                        <input wire:model.live="type" type="radio" value="team">
                        <span class="text-center"> @lang('volunteers.team') </span>
                    </label>
                </div>

                @error('type')
                <span class="text-danger text-start">{{ $message }}</span>
                @enderror
            </div>

            {{-- Name ---------------------------------------------------------- --}}
            <div class="mt-1 mt-lg-0 row p-2">
                <input type="text" wire:model="name" class="form-control" id="exampleInputNama" placeholder=" @lang('volunteers.name')" />
                @error('name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- identify ---------------------------------------------------------- --}}
            <div class="mb-1 row p-2">
                <input type="text" wire:model="identity" class="form-control" id="exampleInputIdentify" placeholder="@lang('volunteers.identity')" />
                @error('identity')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- Mobile ---------------------------------------------------------- --}}
            <div class="mb-1 row p-2">
                <input type="number" wire:model="mobile" class="form-control" id="exampleInputMobile" placeholder="@lang('users.mobile')" />
                @error('mobile')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- activity ---------------------------------------------------------- --}}
            <div class="mb-1 mt-1 mt-lg-0 row p-2">
                <input type="text" wire:model="activity" class="form-control" id="exampleInputActivity" placeholder="@lang('volunteers.activity')" />
                @error('activity')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            {{-- Image ---------------------------------------------------------- --}}
            <div class="mb-1 row p-2">
                {{-- <label for="exampleInputImage" class="form-label col-12 mt-1"> @lang('admin.image') </label> --}}
                <input type="file" wire:model="image" class="form-control" id="exampleInputImage" />
                <span class="text-start text-danger"> @lang('Maximum file size is 2MB') </span>
                @error('image')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            {{-- @if($type == "team") --}}
            {{-- Name ------------------------------------------------------------}}
            {{-- <div class="mb-1 row p-2">
                <label for="exampleInputTeam_name" class="form-label col-12 mt-1"> @lang('volunteers.team_name') </label>
                <input type="text" wire:model="team_name" class="form-control" id="exampleInputTeam_name" />
                @error('team_name')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div> --}}
            {{-- Image ---------------------------------------------------------- --}}
            {{-- <div class="mb-1 row p-2">
                <label for="exampleInputTeam_Logo" class="form-label col-12 mt-1"> @lang('volunteers.team_logo') </label>
                <input type="file" wire:model="team_logo" class="form-control" id="exampleInputTeam_Logo" />
                <span class="text-start text-danger"> @lang('Maximum file size is 2MB') </span>
                @error('team_logo')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>  
            @endif--}}

            <div class=" w-100 mx-auto row p-2">
                <button type="submit" class="btn bg-main my-2"> @lang('Send') </button>
            </div>

            <hr>

            <div class="join d-flex flex-wrap flex-lg-nowrap justify-content-center align-items-center my-4">
                <h5 class="ms-3">انضم إلى مجتمعنا عبر الواتساب</h5>
                <div class="whatappIcon border p-3 rounded-circle">
                    <a href="https://api.whatsapp.com/send?phone={{ $whatsapp }}" class="text-white">
                        <i class="icofont-brand-whatsapp fa-2xl"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>
