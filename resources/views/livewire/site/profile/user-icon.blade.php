<div>
    @if($user == null)
        <div class="login">
            <a class="dropdown-toggle" href="#" id="login" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="icofont-user"></i>
                <span class="login-text d-none d-lg-inline">
                    @lang('Login') 
                </span>
            </a>
            <ul class="dropdown-menu" aria-labelledby="login">
                <li><a class="dropdown-item" href="{{ route('site.login') }}"> @lang('Login') </a></li>
            </ul>
        </div>
    @else
    <div class="login">
        <a class="dropdown-toggle" href="#" id="login" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="icofont-user"></i>
            <span class="login-text d-none d-lg-inline">
                @lang('Welcome') {{ @explode(" ", @$this->user->donor?->full_name)[0];  }}
            </span>
        </a>
        <ul class="dropdown-menu" aria-labelledby="login">
            <li><a class="dropdown-item" href="{{ route('site.profile.index') }}"> @lang('Profile') </a></li>
            <li>
                <hr class="dropdown-divider" />
            </li>
            <li><a class="dropdown-item" href="{{ route('site.logout') }}"> @lang('logout') </a></li>
        </ul>
    </div>
    @endif
</div>
