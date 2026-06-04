<?php

namespace App\Http\Controllers\Site;

use App\Charity\Settings\SettingSingleton;
use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\Partner;
use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Str;


class HomeController extends Controller
{
   public function index()
{
    $cookieValue = Cookie::get('cart');

    if (!$cookieValue) {
        $token = Str::random(32);
        $cookieValue = Cookie::queue('cart', $token, 60 * 24 * 365);
    }

    $newsItems = News::query()
        ->with('trans')
        ->active()
        ->orderBy('sort', 'ASC')
        ->orderBy('id', 'DESC')
        ->get();

    $partners = Partner::query()
        ->with('trans')
        ->active()
        ->orderBy('sort', 'ASC')
        ->orderBy('id', 'DESC')
        ->get();

    return view('site.pages.index', compact('newsItems', 'partners'));
}
}
