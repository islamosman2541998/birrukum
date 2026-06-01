<?php

namespace App\View\Components\Site\Layouts;

use App\Charity\Settings\SettingSingleton;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Header extends Component
{
    public $settings;
    public $main_color, $primary_color, $secound_color, $background_color;
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->settings  = SettingSingleton::getInstance();
        $this->main_color  =  $this->settings->getTheme('main');
        $this->primary_color  =  $this->settings->getTheme('primary');
        $this->secound_color  =  $this->settings->getTheme('secound');
        $this->background_color  =  $this->settings->getTheme('background');
    }
   
    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.site.layouts.header');
    }
}
