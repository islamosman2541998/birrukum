<div>
    <div class="tab-pane fade show" id="apple-pay" role="tabpanel" aria-labelled tabindex="0">
        <h5 class="fs-6 mb-3"> @lang('Pay From Apple Pay')</h5>
        <div class="mb-3 row">
            <div class="col-md-12">
                <button class="btn bg-main w-100" wire:click="payment" @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled @endif> @lang('Pay') </button>
            </div>
           
        </div>
    </div>
</div>
