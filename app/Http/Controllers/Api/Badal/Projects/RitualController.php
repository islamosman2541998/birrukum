<?php

namespace App\Http\Controllers\Api\Badal\Projects;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Badal\RitualRequest;
use App\Http\Resources\Badal\Donors\Projects\RiteResource;
use App\Http\Resources\Badal\RitualsResource;
use App\Models\BadalRites;
use App\Models\BadalRituals;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Http\Request;

class RitualController extends Controller
{
    use ApiResponseTrait;

    /**
     * get all project details by id
     *@param integar $id
     *
     * @return response
     */
    public function index(Request $request)
    {
        $project_id = $this->required('project_id');
        $rites = BadalRites::with('transNow')->where('project_id', $project_id)->get();
        if (!$rites) {
            return $this->notFoundResponse();
        }

        return $this->apiResponse(RiteResource::collection($rites));
    }


    /**
     * List Rituals
     * @param  mixed $order_id
     * @return object
     */
    public function ritualsOrder()
    {
        $order_id = $this->required('order_id');

        $rituals = BadalRituals::where('order_id', $order_id)->get();

        return $this->apiResponse(RitualsResource::collection($rituals));
    }


    /**
     * update Rituals
     *
     * @param  mixed $ritual_id
     * @return object
     */
    public function updateRituals()
    {
        $ritual_id = $this->required('ritual_id');
        $ritual = BadalRituals::find($ritual_id);
        if (!$ritual) {
            $this->error('Not Available');
        }

        if (isset($_POST['complete'])) {
            // check if start first
            if ($ritual->start  == 0) {
                $this->error('You must start first');
            }
            if ($ritual->complete  == 1) {
                $this->error('Already Completed');
            }
            if ($ritual->proof == 1 ) {
                $this->error("يجب رفع الفيديو");
            }

            $taken_time =  $ritual->rite->taken_time;
            if ( (time() -  strtotime($ritual->start_time))   < $taken_time * 60) {
                $this->error("لقد استغرقت وقتاً قصيرا");
            }
            $ritual->update(['complete' => 1]);
        } elseif (isset($_POST['start'])) {
            if ($ritual->start  == 1) {
                $this->error('Already Started');
            }
            // check exist start rital and dont be complete
            $uncompletedRitual = BadalRituals::where('order_id',  $ritual->order_id)->where('start', 1)->where('complete', 0)->get();
            if ($uncompletedRitual->first() != "") $this->error('يجب أن تكمل المناسك التي بدأتها');
            $ritualsOrder = BadalRituals::where('order_id', $ritual->order_id)->where('id', '<', $ritual_id)->where('start', 0)->where('complete', 0)->get();
            if ($ritualsOrder->first() != null) {
                $this->error(' يجب ان تبدا منسك ' . @$ritualsOrder[0]->title . ' اولا ');
            }
            $rituals = $ritual->update(['start' => 1, 'start_time' => date('Y-m-d H:i:s')]);
        } else {
            $this->error('No action');
        }

        return $this->apiResponse(null, "Data has been updated successfully");
    }

     /**
     * Uupload video
     *
     * @param  mixed $order_id
     * @return object
     */
    public function uploadVideoRituals()
    {
        $data = $this->requiredArray(['ritual_id', 'proof']);
        // get order Rituals
        $ritual =  BadalRituals::find($data['ritual_id']);
        // check if need to proof
        if ($ritual->proof == "0") {  $this->error("لا يجب رفع الفيديو");  }
        $ritual->update(['proof' => $data['proof']]);
        return $this->apiResponse(null, "تم رفع الفيديو بنجاح");
    }

    
}
