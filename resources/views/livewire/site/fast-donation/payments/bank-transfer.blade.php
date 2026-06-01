<div>
    <div class="tab-pane fade show">
        <p> @lang('Pay From Bank Transfer') </p>
        <form wire:submit.prevent="checkout" class="">
            {{-- @include('livewire.site.payments.message') --}}

             <div class="row">
                <label class="col-12 col-form-label"> @lang('Bank name') </label>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <select wire:model="bank_id" class="form-select" aria-label="Default select example">
                        <option value="" selected disabled></option>
                        @forelse (@$bank_accounts as $account)
                            <option value="{{ $account->id }}"> {{ $account->bank_name }} </option>
                        @empty
                        @endforelse
                    </select>
                    @error('bank_id')
                        <span class="text-danger col-12">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="row">
                <label class="col-12 col-form-label">  @lang('Account Holder Name') </label>
            </div>
            <div class="mb-3 row">
                <div class="col-12">
                    <input type="text" class="form-control" value="جمعية بركم  الأهلية" readonly />
                </div>
            </div>
            <div class="row">
                <label class="col-12 col-form-label"> @lang('Account number') </label>
            </div>
            <div class="row mb-1">
                <input type="text" class="form-control col-12 " wire:model="account_type" readonly />
            </div>
            <div class="row mb-1">
                <input type="text" class="form-control col-12 " wire:model="iban" readonly />
            </div>

            <div class="row">
                <label class="col-12 col-form-label"> @lang('Attach the payment receipt/transfer copy') </label>
            </div>
            <div class="row">
                <input wire:model="image" class="form-control" type="file" />                    
            </div>
            <div class="row">
                @error('image')
                    <span class="text-danger col-12">{{ $message }}</span>
                @enderror                   
            </div>

            <div class="row my-3">
                <button class="btn bg-main w-100" type="submit">@lang('Send')</button>
            </div>
        </form>
    </div>
</div>
