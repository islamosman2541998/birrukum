<?php

namespace App\Http\Controllers\Api;

use App\Charity\Settings\SettingSingleton;
use App\Enums\ProjectTypesEnum;
use App\Models\Donor;
use App\Enums\SourcesEnum;
use App\Models\PaymentMethod;
use App\Http\Controllers\Controller;
use App\Http\Resources\Badal\BadalFormInfoResource;
use App\Http\Resources\Badal\OrderBadalResource;
use App\Http\Resources\Badal\OrderResource;
use App\Http\Resources\Badal\RitualsResource;
use App\Models\BadalOffer;
use App\Models\BadalOrder;
use App\Models\BadalRequests;
use App\Models\BadalRites;
use App\Models\BadalRituals;
use App\Models\CharityProject;
use App\Models\Order;
use App\Models\OrderDetails;
use App\Traits\Api\ApiResponseTrait;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    use ApiResponseTrait;

    public function checkout()
    {
        $data = $this->requiredArray(['donor_id', 'total', 'payment_method_id', 'payfortResponse', 'donations']);

        DB::beginTransaction();

        $payfortResponse = json_decode($data['payfortResponse']);
        $donor = Donor::find($data['donor_id']);
        if (!$donor) $this->error('Donor Not found');

        if ($data['payment_method_id'] == 3) {    // Bank transfer
            if (request()->bankImage != "") {    // validate image
                $orderdata['banktransferproof'] = $this->upload_file(request()->bankImage, ('orders'));
                $orderdata['bank_id'] = @request()->bank_id;
            }
        }

        $payment = PaymentMethod::find($data['payment_method_id']);
        if (!$payment) $this->error('Payment Not found');

        if (isset($payfortResponse->status) && ($payfortResponse->status == 14)) {
            $status = 1;
        } else {
            $status = 0;
        }

        $orderdata = [
            'total' => $data['total'],
            'quantity' => 0,
            'source' => SourcesEnum::APP,
            'donor_id' => $donor->id,
            'refer_id' => $donor->refer_id,
            'status' =>  $status,
            'payment_method_id' => $payment->payment_id,
            'payment_method_key' => $payment->payment_key,
            'payment_proof' => $data['payfortResponse'],
            'hash' => sha1(time() . rand(999, 999999)),
        ];

        // convert donation json object
        $donations = json_decode($data['donations']);

        //loop through donations
        foreach ($donations as $key => $donation) {
            $project = CharityProject::find($donation->project_id);
            if (!$project) $this->error('Project Not found');

            $orderdata['quantity'] += $donation->quantity;

            if ($project->project_types == ProjectTypesEnum::BADAL) {
                // check for behafeof // relation // language // gender
                $orderdata['source'] =  SourcesEnum::BADAL;
                $error_msg = ''; // if not any return error message
                if (!isset($donation->behafeof)) $error_msg .= "behafeof field is mandatory \n\t ";
                if (!isset($donation->relation)) $error_msg .= "relation field is mandatory\n\t ";
                if (!isset($donation->language)) $error_msg .= "language field is mandatory\n\t ";
                if (!isset($donation->gender))   $error_msg .= "gender field is mandatory\n\t ";
                if (!empty($error_msg)) $this->error($error_msg);
            }
        }
        // save order
        $order = Order::create($orderdata);
        $orderdata['order_id'] = $order->id;

        // update identifier
        $order->identifier =  $orderdata['order_identifier']  = isset($payfortResponse->merchant_reference) ? $payfortResponse->merchant_reference : orderIdentifier($order->id);
        $order->save();

        // save donations
        foreach ($donations as $donation) {
            $project = CharityProject::active()->find($donation->project_id);
            if (isset($donation->offer_id)) {
                $badalOffer = BadalOffer::active()->find($donation->offer_id);
            }
            $donationData = [
                'order_id' => $orderdata['order_id'],
                'item_type' => 'App\Models\CharityProject',
                'item_id' => $project->id,
                'item_name' => $project->transNow->title,
                'item_sub_type' => $donation->donationType,
                'quantity' => $donation->quantity,
                'price' => $donation->total / $donation->quantity,
                'total' => $donation->total,
                'status' =>  $status,

                'substitute_id' => isset($donation->offer_id) ? @$badalOffer->substitute_id :  null,
                'is_offer' => isset($donation->offer_id) ? 1 : 0,
                'offer_id' => isset($donation->offer_id) ? $donation->offer_id : null,
                'offer_start_at' => isset($donation->offer_id) ?  time() : null,
            ];

            $orderDeatails = OrderDetails::create($donationData);
            //save donation data through saving method

            //save Badal Order data
            if ($project->project_types == ProjectTypesEnum::BADAL) {
                $orderdata['source'] =  SourcesEnum::BADAL;
                $donationData['project_id'] =  $project->id;
                $donationData['behafeof'] = $donation->behafeof;
                $donationData['relation'] = $donation->relation;
                $donationData['language'] = $donation->language;
                $donationData['gender'] = $donation->gender;
                $badal = BadalOrder::create($donationData);
                if (!$badal) {
                    DB::rollBack();
                    $this->error('Something went wrong while trying to save the Badal Order');
                }
                $orderdata['badal_id'] = $badal->id;
                // if order from offer hide offer
                if (isset($donation->offer_id)) {
                    $donationData['badal_id'] = $badal->id;
                    $donationData['is_selected'] = 1;
                    $requestOffer = BadalRequests::create($donationData);
                    // update offer selected
                    $badalOffer->status = 3;
                    $badalOffer->save();
                }
            }
        }

        DB::commit();


        return $this->apiResponse($orderdata);

        // TO DO
        // send data
    }



    /**
     * get all pending badalOrder with no Substitute
     *@param integar $substitute_id
     *
     * @return response
     */
    public function pending()
    {
        $orders = Order::with('donor', 'badalDetails')->badal()->confirmed()
            ->whereHas('badalOrder', function ($q) {
                $q->WhereNull('substitute_id');
            })
            ->orderBy('created_at', 'DESC')->get();

        return $this->apiResponse(OrderResource::collection($orders));
    }


    /**
     * get badal order by donor
     * @param integer $donor_id
     * @param string $status
     * @return response
     */
    public function getOrderDonor()
    {
        $data = $this->requiredArray(['donor_id', 'status']);
        // get badal order by donor
        if ($data['status'] == 3) {
            $Badalorders = Order::where('donor_id', $data['donor_id'])->whereHas('badalOrder', function ($q) {
                $q->whereNotNull('complete_at')->whereNotNull('start_at');
            })->get();
        } elseif ($data['status'] == 2) {
            $Badalorders = Order::where('donor_id', $data['donor_id'])->whereHas('badalOrder', function ($q) {
                $q->whereNull('complete_at')->whereNotNull('start_at');
            })->get();
        } else {
            $Badalorders = Order::where('donor_id', $data['donor_id'])->whereHas('badalOrder', function ($q) {
                $q->whereNull('complete_at')->whereNull('start_at');
            })->get();
        }
        if ($Badalorders->first() == null) $this->error('No data');

        return $this->apiResponse(OrderBadalResource::collection($Badalorders));
    }


    /**
     * get badal order by substitute
     * @param integer $substitute_id
     * @param string $status
     * @return response
     */
    public function getOrderSubstitute()
    {
        $data = $this->requiredArray(['substitute_id', 'status']);
        // get order by substitute
        // get badal order by donor
        if ($data['status'] == 3) {
            $Badalorders = Order::whereHas('badalOrder', function ($q) use ($data) {
                $q->where('substitute_id', $data['substitute_id'])->whereNotNull('complete_at')->whereNotNull('start_at');
            })->get();
        } elseif ($data['status'] == 2) {
            $Badalorders = Order::whereHas('badalOrder', function ($q) use ($data) {
                $q->where('substitute_id', $data['substitute_id'])->whereNull('complete_at')->whereNotNull('start_at');
            })->get();
        } else {
            $Badalorders = Order::whereHas('badalOrder', function ($q) use ($data) {
                $q->where('substitute_id', $data['substitute_id'])->whereNull('complete_at')->whereNull('start_at');
            })->get();
        }
        if ($Badalorders->first() == null) $this->error('No data');

        return $this->apiResponse(OrderBadalResource::collection($Badalorders));
    }



    public function start()
    {
        $data = $this->requiredArray(['project_id', 'substitute_id', 'order_id']);

        $badalOrder = BadalOrder::where('order_id', $data['order_id'])->first();
        if (!$badalOrder) {
            $this->error('Order Not Found');
        }

        // check the start date
        $requestBadal  = BadalRequests::active()->where('badal_id', $badalOrder->id)->where('is_selected', 1)->first();


        $requestStartDate = date('d-m-Y', strtotime($requestBadal->start_at));
        $currentDate = date('d-m-Y');

        // if ($requestStartDate > $currentDate) {
        //     $this->error('يجب بداء الطلب في الموعد المحدد');
        // }
        // check if rituals is already exist
        if ($badalOrder->start_at != null) {
            $rites = BadalRituals::with('rite')->where('order_id', $data['order_id'])->get();
            return $this->apiResponse(RitualsResource::collection($rites), 'Already Started');
        }

        // insert the rits project to rituls order
        $rites = BadalRites::where('project_id', $data['project_id'])->get();
        if (!$rites) {
            $this->error('Not found');
        }

        $rituals = BadalRituals::where('order_id', $data['order_id'])->get();
        $badalOrder->update(['start_at' =>  date('Y-m-d H:i:s')]);
        if ($rituals->first() == "") {
            $rituals = [];
            foreach ($rites as $rite) {
                $rituals[] = BadalRituals::create([
                    'title' => $rite->transNow->title,
                    'order_id' => $data['order_id'],
                    'project_id' => $rite->project_id,
                    'substitute_id' => $data['substitute_id'],
                    'rite_id' => $rite->id,
                    'proof' => $rite->proof,
                    'status' => 1
                ]);
            }
        }


        return $this->apiResponse(RitualsResource::collection($rituals));
    }


    /**
     * update completed of badalOrder by id
     *@param integar $substitute_id
     *
     * @return response
     */
    public function completeOrder()
    {
        $data = $this->requiredArray(['badal_id']);
        // get order by id
        $badalorders = BadalOrder::find($data['badal_id']);
        if (!$badalorders) $this->error('Not Found');
        if ($badalorders->start_at == null) {
            $this->error('You must start first');
        }
        // if ($badalorders->complete_at != null) {
        //     $this->error('Already completed');
        // }

        // check idf riutals not copleted
        $riualsNotComplete = BadalRituals::where('order_id', $badalorders->order_id)->where(function ($query) {
            $query->where('start', 0)
                ->orWhere('complete', 0);
        })->get();
        if ($riualsNotComplete->first() != null) {
            $this->error('يرجى إكمال جميع المناسك أولاً');
        }
        $badalorders->update(['complete_at' =>  date('Y-m-d H:i:s')]);

        // TO DO
        // send messages  (email - sms - whatsapp)
        $sendData = [
            'order_id'              => @$badalorders->order_id,
            'mailto'                => @$badalorders->order?->donor?->account->email,
            'mobile'                => @$badalorders->order?->donor?->mobile,
            'identifier'            => @$badalorders->order?->identifier,
            'total'                 => @$badalorders->order?->total,
            'project'               => implode(',', @$badalorders->order?->details?->pluck('item_name')->toArray() ?? []),
            'donor'                 => @$badalorders->order?->donor?->name,
            'substitute_phone'      => @$badalorders->substitute?->account?->email,
            'notify_id'             => @$badalorders->order?->donor->id,
            'notify'                => "تم اكتمال طلبك ",
        ];

        // send the notify of to the donor and subsitude
        $this->CompleRitesNotify($sendData);

        // send messages
        // $messaging->sendNotfication($sendData, 'complete_order');
        return $this->apiResponse($badalorders);
    }


    public function CompleRitesNotify($data)
    {
        $data['name'] = $data['donor'];
        $data['project_name'] = $data['project'];

        $riualsProofed = BadalRituals::where('order_id', $data['order_id'])->whereNotIn('proof', ["1", "0"])->get();
        $links = "";
        foreach ($riualsProofed as $inf) {
            $links .= ($inf->title . ': ' . $inf->proof . ', ');
        }
        $data['links'] = $links;

        // TO DO
        // $whatsAppSettings = json_decode($whatsAppSettings->value);

        // $parameters = [
        //     ["name" => "name", "value" => $data['donor']],
        //     ["name" => "project_name", "value" => $data['project']],
        //     ["name" => "links", "value" => $links],
        // ];
        // if (!$whatsAppSettings->whatsappenabled) {
        //     return false;
        // }

        // $broadcast =  $whatsAppSettings->broadcast_name_complete_rites;
        // $template =  $whatsAppSettings->template_name_complete_rites;
        // // send data to donor
        // sendWhatsAppParameter($whatsAppSettings->gateurl, $whatsAppSettings->accessToken, $template, $broadcast, $data['mobile'], $parameters);

        // // send data to subsitude
        // sendWhatsAppParameter($whatsAppSettings->gateurl, $whatsAppSettings->accessToken, $template, $broadcast, $data['substitute_phone'], $parameters);
    }


    /**
     * Form badal
     *
     * @return object
     */
    public function badalFormInfo()
    {

        $badalsettings = SettingSingleton::getInstance();

        return $this->apiResponse(new BadalFormInfoResource($badalsettings));
    }
}
