<?php

namespace App\Http\Controllers\Api\Badal;

use App\Http\Controllers\Controller;
use App\Http\Resources\Badal\MyRequestResource;
use App\Http\Resources\Badal\RequestResource;
use App\Models\BadalOrder;
use App\Models\BadalRequests;
use App\Models\Substitutes;
use App\Traits\Api\ApiResponseTrait;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class RequestController extends Controller
{
    use ApiResponseTrait;


    /**
     * list new request 
     * @return response
     */
    public function list()
    {
        $badal_id = $this->required('badal_id');

        $badal = BadalOrder::find($badal_id);
        if ($badal->substitute_id != null) {
            $this->error('لقد تم اختيار المتقدمين مسبقًا');
        }
        $requests = BadalRequests::with('substitute')->active()->where('badal_id', $badal_id)
            ->orderBy('created_at', 'DESC')->get();
        // ->select(
        //     DB::raw("(SELECT round(AVG(badal_reviews.rate) * 2, 0) / 2
        //         FROM badal_reviews, badal_orders
        //         WHERE badal_orders.substitute_id = badal_requests.substitute_id
        //         AND badal_reviews.badal_id = badal_orders.id
        //     ) AS rate")
        // )

        // TO DO
        return $this->apiResponse(RequestResource::collection($requests));
    }

    /**
     * Subsitude requests
     * @return response
     */
    public function myRequests()
    {
        $substitute_id = $this->required('subsitute_id');
        $requests = BadalRequests::with(['badal', 'badal.project'])->where('substitute_id', $substitute_id)
            ->orderBy('created_at', 'DESC')->get();
        foreach ($requests as $key => $req) {

            if ($req->status == 1 && $req->is_selected == 1) {
                $requests[$key]->status = "مقبول";
            } elseif ($req->status == 1 && $req->is_selected == 0 && $req->badal_selected == null) {
                $requests[$key]->status = "في الانتظار";
            } elseif ($req->status == 1 && $req->is_selected == 0 && $req->badal_selected != null) {
                $requests[$key]->status = "مرفوض";
            } elseif ($req->status == 0) {
                $requests[$key]->status = "تم الالغاء";
            }
        }
        return $this->apiResponse(MyRequestResource::collection($requests));
    }


    /**
     * add new request by substitute
     *@param integar $badal_id
     *@param integar $substitute_id
     *@param integar $start_at
     * @return response
     */
    public function create()
    {
        $data = $this->requiredArray(['badal_id', 'substitute_id', 'start_at']);


        $data['start_at'] = Carbon::createFromFormat('d/m/Y H:i', $data['start_at'])->toDateTimeString();

        $badalOrder = BadalOrder::with('requests')->find($data['badal_id']);

        if ($badalOrder->requests?->where('substitute_id', $data['substitute_id'])->first() != "") {
            $this->error("لقد قمت بالتسجيل من قبل");
        }

        $request = BadalRequests::create($data);

        return $this->apiResponse(null, "Request added successfully");

        // TO DO
        // $this->messaging->sendNotfication($sendData, 'newRequest');
    }




    /**
     * select request
     *@param integar $request_id
     * @return response
     */
    public function select()
    {
        $request_id = $this->required('request_id');
        // get request 
        $request = BadalRequests::where('id', $request_id)->where('status', 1)->first();
        if ($request == null) $this->error("request not found");
        else {
            // select request
            $request->update(['is_selected' => 1]);

            // update BadalOrder Substiute_id
            $badal = BadalOrder::find($request->badal_id);
            $badal->substitute_id =  $request->substitute_id;
            $badal->save();

            // // cancel the remaining request
            // $removeOtherRequest =  BadalRequests::where('id', '!=', $request_id)
            //     ->where('badal_id', $request->badal_id)
            //     ->update([
            //         'status' => 0,
            //     ]);

            // delete all request with same day 
            $removeSameDate = BadalRequests::whereDate('start_at', date('Y-m-d', strtotime($request->start_at)))
                ->where('id', '!=', $request_id)
                ->where('substitute_id', $request->substitute_id)
                ->where('status', 1)
                ->update([
                    'status' => 0,
                ]);

            if ($request == true) {
                return $this->apiResponse($request, 'selected Sucessfully');
            } else {
                $this->error("There is a problem .. Please try again");
            }

            // TO DO
        }
    }


    /**
     * cancel request from donor
     *@param integar $request_id
     * @return response
     */
    public function cancel()
    {
        $request_id = $this->required('request_id');
        $request = BadalRequests::where('id', $request_id)->first();
        if ($request == null) $this->error("request not found");
        if ($request->status == 0) $this->error("Already canceled");
        if ($request->is_selected == 1) $this->error("Unfortunately, the request cannot be canceled ... The request is approved "); //check if not selected
        else {
            $request->update(['status' => 0]);
            if ($request) return $this->apiResponse($request, 'Request Canceled successfully');
            else {
                $this->error("There is a problem .. Please try again");
            }
        }
    }



    /**
     * cancel request
     *@param integar $request_id
     * @return response
     */
    public function cancelOrderRequest()
    {
        $request_id = $this->required('request_id');
        $request = BadalRequests::find($request_id); // get request
        // if ($request == null) $this->error("Request not found");
        // if ($request->status == 0) $this->error("Already canceled");
        //  update substuite to null in badal order
        $request->badal->update(['substitute_id' => null, 'start_at' => null]);
        
        //  cancel request of badal
        $cancelOrder = $request->update(['status' => 0, 'is_selected' => 0]);
        if (!$cancelOrder) {
            $this->error("There is a problem .. while cancel Request");
        }
        // get all subsitutes to send (sms - whatsapp - email)
        // TO DO
        $order =    $request->badal->order; // get get badal by id
        $subsitues =  Substitutes::active()->get();
        if ($subsitues) {
            foreach ($subsitues as $subsitue) {
                $subsitueData = [
                    'mailto' => $subsitue->email,
                    'mobile' => $subsitue->phone,
                    'identifier' => $order->identifier,
                    'total' => $order->total,
                    'project' => $order->projects,
                    'donor' => $subsitue->full_name,
                    'subject' => 'تم تسجيل تبرع جديد ',
                    'msg' => "تم تسجيل تبرع جديد بمشروع : {$order->projects} <br/> بقيمة : " . $order->total,

                ];
                // $messaging->sendNotfication($subsitueData, 'newOrder');
            }
        }
        return $this->apiResponse(null, "Request of Order Cancel sucessfully");
    }
}
