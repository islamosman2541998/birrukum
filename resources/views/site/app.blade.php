<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}"  @if( app()->isLocale('ar') ) dir="rtl" @endif >
  
    {{-- @include('site.layouts.header') --}}
    <x-site.layouts.header/>

<body  @if( app()->isLocale('ar') ) dir="rtl" @endif>

    @include('site.layouts.menus')
    {{-- @livewire('site.menus') --}}

    @include('site.layouts.message')

    <div class="content-wapper" style="min-height: 80vh">
        @yield('content')
    </div>

    <x-site.layouts.footer/>

    @include('site.layouts.script')

</body>
</html>