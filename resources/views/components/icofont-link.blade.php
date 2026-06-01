<div>

    @switch ($status) 
    @case('0')
        <button class="btn btn-warning btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Pending')">
            <i class="text-light icofont-not-allowed"></i>
        </button>
    @break

    @case(1)
        <button class="btn btn-success btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Confirmed')">
            <i class="text-light icofont-check-circled"></i>
        </button>
    @break
    @case(3)
        <button class="btn btn-info btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Waiting')" aria-describedby="tooltip358766">
            <i class="text-light icofont-history"></i>
        </button>
    @break

    @case(4)
        <button class="btn btn-danger btn-sm py-1" data-toggle="tooltip" title="" data-original-title="@lang('Canceled')" aria-describedby="tooltip358766">
            <i class='bx bx-window-close text-light'></i>
        </button>
    @break
    @endswitch
</div>

