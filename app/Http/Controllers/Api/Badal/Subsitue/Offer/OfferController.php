<?php

namespace App\Http\Controllers\Api\Badal\Subsitue\Offer;

use App\Http\Controllers\Controller;
use App\Http\Resources\Badal\Subsitute\OfferResource;
use App\Models\BadalOffer;
use App\Models\CharityBadalProject;
use App\Models\CharityProject;
use App\Traits\Api\ApiResponseTrait;
use Carbon\Carbon as CarbonCarbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class OfferController extends Controller
{
    use ApiResponseTrait;

    public function index(Request $request)
    {
        $offers = BadalOffer::with('badalProject.project', 'substitute')->where('start_at', '<=', Carbon::now()->format('Y-m-d H:i:s') )->latest()->get(); // here     in api there is an input of subsititute_id but not selected

        if ($offers->count() < 1) {
            return $this->notFoundResponse();
        }
        return $this->apiResponse(OfferResource::collection($offers));

    }


    /**
     * list offers by substitute
     *@param integar $substitute_id
     * @return response
     */
    public function substituteOffers(Request $request) //get offers of a subsitute
    {
        $data = $this->requiredArray(['substitute_id']);

        $offers = BadalOffer::with('badalProject.project', 'substitute')->where('substitute_id', $data['substitute_id'])->latest()->get();
        if ($offers->count() < 1) {
            return $this->notFoundResponse();
        }
        return $this->apiResponse(OfferResource::collection($offers), "Offer sent successfully");
    }

    /**
     * add new offer
     *@param integar $substitute_id
     *@param integar $project_id
     *@param integar $amount
     *@param integar $start_at
     * @return response
     */
    public function store(Request $request)
    {
        $data = $this->requiredArray(['substitute_id', 'project_id', 'amount', 'start_at']);

        $badalProject = CharityProject::find($request->project_id);

        if (!$badalProject) $this->notFoundResponse();

        if ($badalProject->min_price > $request->amount) {
            return $this->notFoundResponse("الحد الادني : " . $badalProject->min_price . ' ريال ');
        }
        $offerGapTime = 2;   // TO DO

        $fromDate = Carbon::parse($data['start_at'])->subHours($offerGapTime);
        $fromDate = $fromDate->format('Y-m-d H:i:s');
        $toDate = Carbon::parse($data['start_at'])->addHours($offerGapTime);
        $toDate = $toDate->format('Y-m-d H:i:s');

        $checkexist = BadalOffer::where('substitute_id', $data['substitute_id'])->where('start_at', '>', $fromDate)
            ->where('start_at', '<', $toDate)->get();
        if (count($checkexist)) {
            $this->error("لا يمكن اضافه العرض في هذا الوقت ,  يجب ان يكون مضي " .  $offerGapTime .  " ساعات علي اخر العرض ");
        }
        $data['start_at'] = new DateTime($data['start_at']);
        $data['start_at'] = $data['start_at']->format('Y-m-d H:i:s');

        $offer = BadalOffer::create($data)->refresh();

        return $this->apiResponse($offer, "Offer sent successfully");
    }


    /**
     * cancel offer from substitutes
     *@param integar $offer_id
     * @return response
     */
    public function destroy(Request $request)
    {
        $offer_id = $this->required('offer_id');
        $badalOffer = BadalOffer::find($offer_id);
        if (!$badalOffer) {
            return $this->notFoundResponse("Offer not found");
        }
        $badalOffer->delete();
        return $this->apiResponse(null, "لقد تم الغاء العرض بنجاح ");

    }

}
