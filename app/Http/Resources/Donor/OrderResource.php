<?php

namespace App\Http\Resources\Donor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        /****found extra in order table***/
//         'source',
//         'refer_id',
//         'payment_proof',
//        'bank_id',



        return
            [
                "order_id" => $this->id,
                "order_identifier" => $this->identifier,
                "total" => $this->total,
                "quantity" => $this->quantity,
                "payment_method_id" => $this->payment_method_id,
                "payment_method_key" => $this->payment_method_key,
                "banktransferproof" => $this->banktransferproof,
                "app" =>  $this->source,
                "projects" => json_encode(@$this->details->pluck('item_name')->toArray() ?? [], JSON_UNESCAPED_UNICODE),
                "projects_id" => json_encode(@$this->details->pluck('item_id')->toArray() ?? [],true),
                "donor_id" => $this->donor_id,
                "store_id" => $this->refer_id,
                "API_status" => $this->API_status,
                "API_odoo" => $this->API_odoo,
                "status_id" => $this->status_id,
                "donor_name" => $this->donor?->full_name,
                "notified" => $this->is_notified ,
                "status" =>   $this->status ,
                "modified_date" => $this->updated_at,
                "create_date" => $this->created_at,
            ];
    }
}
