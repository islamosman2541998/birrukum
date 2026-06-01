<script src="{{ asset('site/js/jquery.min.js') }}"></script>
<script src="{{ asset('site/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('site/js/wow.min.js') }}"></script>
<script src="{{ asset('site/js/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('site/js/main.js') }}"></script>

<!-- VITE JS -->
@vite(['resources/assets/site/app.js'])


@yield('script')

<script src="{{ asset('site/js/htmx.min.js') }}"></script>


<!-- Livewire Script -->
@livewireScripts
