<div>
    <div class="tab-pane fade show">
        <h5 class="fs-6 mb-3"> @lang('Pay From Bank Transfer') </h5>
        <form wire:submit.prevent="checkout" class="">
            @include('livewire.site.payments.message')
            <div class="mb-3 row">
                <label class="col-12 col-form-label">@lang('Bank name')</label>
                <div class="col-12">
                    <select wire:model="bank_id" class="form-select" aria-label="Default select example">
                        <option value="" selected disabled></option>
                        @forelse (@$bank_accounts as $account)
                            <option value="{{ $account->id }}" selected=""> {{ $account->bank_name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('bank_id')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-12 col-form-label">
                    @lang('Account Holder Name')
                </label>
                <div class="col-12">
                    <input type="text" class="form-control" value="جمعية بركم الأهلية" readonly />
                </div>
            </div>
            <div class="mb-3 row">
                <label class="col-12 col-form-label">
                    @lang('Account number')
                </label>
                <div class="col-12 mb-3">
                    <input type="text" class="form-control" wire:model="account_type" readonly />
                </div>
                <div class="col-12">
                    <input type="text" class="form-control" wire:model="iban" readonly />
                </div>
            </div>

            <div class="mb-3 row">
                <label class="form-label">
                    @lang('Attach the payment receipt/transfer copy')
                </label>
                <input wire:model="image" class="form-control" type="file" />
                <small>@lang('jpg-jpeg-png-pdf')</small>
                <small class="text-danger text-start"> @lang('Maximum file size is 2MB')</small>
                @error('image')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            <div class="mb-3 row">
                <div class="col-md-9 mb-1">
                    <button class="btn bg-main w-100" @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled @endif type="submit">@lang('Send')</button>
                </div>
                <div class="col-md-3 mb-1">
                    <a href="{{ route('site.home') }}" class="btn bg-secound w-100"> @lang('Cancel') </a>
                </div>
                
            </div>
        </form>
    </div>
</div>
