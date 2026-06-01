<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ArticleResource;
use App\Models\AppArticles;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $articles = AppArticles::with('trans', 'section')->where('section_id' , $request->section_id)->orderBy('sort', 'ASC')->active()->get();
        if(!$articles ||  count($articles) < 1 ){
            return $this->notFoundResponse();
        }
        return $this->apiResponse(ArticleResource::collection($articles));
    }


    public function show(Request $request)
    {
        $article =  AppArticles::with('trans')->active()->find($request->id);
        if(!$article   ){
            return $this->notFoundResponse();
        }
        return $this->apiResponse( new ArticleResource($article));
    }
}
