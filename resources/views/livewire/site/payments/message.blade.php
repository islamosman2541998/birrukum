@if(session()->has('success'))
  <h5 class="success-message mt-3">
    <span class="message"> {{session('success') }} </span>
  </h5>
@endif


@if(session()->has('error'))
<h5 class="success-message text-danger mt-3">
    <span class="message"> {{session('error') }} </span>
</h5>
@endif

@if(session()->has('warning'))
  <h5 class="success-message text-warning mt-3">
    <span class="message"> {{session('warning') }} </span>
  </h5>
@endif


@if(count($errors->all()) > 0)
      @foreach($errors->all() as $error)
        <h5 class="success-message text-danger mt-1">
            <span class="message"> {{ $error }} </span>
        </h5>
      @endforeach
@endif
