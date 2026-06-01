<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\CharityProjectResource;
use App\Models\CharityProject;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class CharityProjectController extends Controller
{
    use ApiResponseTrait;

    public function showByCategoryId()
    {
        $projects =  CharityProject::with('transNow' , 'payment:id')->app()->active()->get();
        if(!$projects){
            return $this->notFoundResponse();
        }
        return $this->apiResponse( CharityProjectResource::collection($projects ));
    }



    public function show(Request $request)
    {
        $category =  CharityProject::with('transNow' , 'payment:id')->active()->find($request->id);
        if(!$category){
            return $this->notFoundResponse();
        }
        return $this->apiResponse(new CharityProjectResource($category));
    }


}
