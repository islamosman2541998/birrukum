<div class="container">
    <h5 class="fs-6 mb-3"> @lang('Pay From ApplePay') </h5>
    <form wire:submit.prevent="checkout" class="">
        <div class="my-3 row">
            <div class="col-md-9 mb-1">
                <button class="btn bg-main w-100" type="submit" @if(@auth('account')->user()?->types->where('type', 'donor')->first() == null) disabled @endif>
                    @lang('Pay')
                </button>
            </div>
            <div class="col-md-3 mb-1">
                <a href="#" class="btn bg-secound w-100"> @lang('Cancel') </a>
            </div>
        </div>
    </form>
</div>



  