<?php

namespace App\Http\Controllers\Site;

use App\Models\News;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class NewsController extends Controller
{
    public function index()
    {
        $items = News::query()
            ->with('trans')
            ->active()
            ->orderBy('sort', 'ASC')
            ->orderBy('id', 'DESC')
            ->paginate(9);

        return view('site.pages.news.index', compact('items'));
    }

    public function show($slug)
    {
        $item = News::query()
            ->with('trans')
            ->active()
            ->whereHas('trans', function ($q) use ($slug) {
                $q->where('slug', $slug)
                    ->where('locale', app()->getLocale());
            })
            ->firstOrFail();

        return view('site.pages.news.show', compact('item'));
    }
}