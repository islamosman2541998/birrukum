<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectionResource;
use App\Models\AppSection;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    use ApiResponseTrait;


    public function index(Request $request)
    {
        $sections = AppSection::with('trans')->active()->orderBy('sort', 'ASC')->get();

        if (!$sections || count($sections) < 1) {
            return $this->notFoundResponse();
        }
        return $this->apiResponse(SectionResource::collection($sections));
    }



    public function show(Request $request)
    {
        $section = AppSection::with('trans')->active()->find($request->id);
        if (!$section) {
            return $this->notFoundResponse();
        }
        return $this->apiResponse(new SectionResource($section));
    }
}
