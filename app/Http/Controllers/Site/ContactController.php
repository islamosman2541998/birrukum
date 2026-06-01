<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Charity\Settings\SettingSingleton;

class ContactController extends Controller
{

    public function index(){

        $settings = SettingSingleton::getInstance();
        
        return view('site.pages.page.contact', compact('settings'));
    }
}
