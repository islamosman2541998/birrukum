<?php

namespace App\Http\Resources\Badal;

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
        return [
            "project_name"          => $this->badalDetails->item_name,
            "project_id"            => $this->badalDetails->item_id,
            "donor_id"              => @$this->donor->id,
            "donor_name"            => $this->donor->full_name,
            "order_id"              => $this->id,
            "order_identifier"      => $this->identifier,
            "badal_id"              => $this->badalOrder->id,
            "amount"                => $this->total,
            "total"                 => $this->total,
            "quantity"              => $this->quantity,
            "substitute_id"         => $this->badalOrder->substitute_id,
            "behafeof"              => $this->badalOrder->behafeof,
            "relation"              => $this->badalOrder->relation,
            "language"              => $this->badalOrder->language,
            "gender"                => $this->badalOrder->gender,
            "start_at"              => $this->badalOrder->start_at,
            "complete_at"           => $this->badalOrder->complete_at,
            "is_offer"              => $this->badalOrder->is_offer,
            "offer_id"              => $this->badalOrder->offer_id,
            "status"                => $this->status,
            "time"                  => $this->create_date,
            "create_date"           => $this->create_date,
        ];
    }
}
