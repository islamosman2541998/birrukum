
<div>
    <a class="cart" href="{{ route('site.cart.show') }}">
        <i class="icofont-cart"></i>
        @if($cartQuantity )<span class='cart-count'> {{ $cartQuantity }} </span> @endif
    </a>
</div>
