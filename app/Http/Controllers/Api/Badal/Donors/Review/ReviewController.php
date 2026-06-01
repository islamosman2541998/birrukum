<?php

namespace App\Http\Controllers\Api\Badal\Donors\Review;

use App\Http\Controllers\Controller;
use App\Models\BadalOffer;
use App\Models\BadalReview;
use App\Models\Review;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    use ApiResponseTrait;

    public function list(Request $request)
    {
        $data = [
            "5" => "راضي تماما",
            "4" => "راضي نوعا ما ",
            "3" => "محايد",
            "2" => "غير راضي نوعا ما",
            "1" => "غير راضي"
        ];
        return $this->apiResponse($data);

    }


    public function store(Request $request)
    {
        $data = $this->requiredArray(['badal_id', 'rate', 'description']);

        $checkReviewExist = BadalReview::where('badal_id', $request->badal_id)->get();

        if(count($checkReviewExist)){  $this->error('Review is already exist');}

        $review = BadalReview::create($data);

        return $this->apiResponse($review, "Review sent successfully");
    }
}
