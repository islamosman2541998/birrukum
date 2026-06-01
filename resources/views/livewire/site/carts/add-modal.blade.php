<div class="addCartMoal">
    <style>
        /* Modal wrapper */
        .addCartMoal .modal-wrapper {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            /* Background color with opacity */
            z-index: 9999;
        }

        /* Modal content */
        .addCartMoal .modal {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.3);
        }

        /* Modal close button */
        .addCartMoal .close {
            position: absolute;
            top: 10px;
            right: 10px;
            cursor: pointer;
        }
    </style>

    @if($showModal)
        <div class="modal-wrapper" style="display: {{ $showModal ? 'block' : 'none' }}">
            <div class=" show" id="alertModal" aria-modal="true" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="cartAddModalLabel">
                                <img src="{{ site_path('img/logo.png') }}" alt="namaa" width="50%">
                            </h5>
                        </div>
                        <div class="modal-body">
                            <p class="text-center">
                                @if($message != null)
                                    {{ $message }}
                                @else 
                                    @lang('The project has been successfully added to the donation basket') 
                                @endif
                            </p>
                        </div>
                        <div class="modal-footer">
                            <a href="{{ route('site.cart.show') }}" class="btn bg-main">@lang('Show Cart')</a>
                            <button type="button" wire:click="closeModal" class="btn bg-danger" data-bs-dismiss="modal">@lang('Close')</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
