<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CategoryProjectResource;
use App\Models\CategoryProjects;
use App\Traits\Api\ApiResponseTrait;

class  CategoryProjectController extends Controller
{
    use ApiResponseTrait;

    public function index()
    {
        $categories = CategoryProjects::with('transNow')->app()->active()->get();
        if(!$categories){
            return $this->notFoundResponse();
        }
        return $this->apiResponse(CategoryProjectResource::collection($categories));
    }
}
