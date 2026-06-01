<?php

namespace App\Http\Resources\Badal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderBadalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "order_id"      => $this->id,
            "badal_id"      => $this->badalOrder?->id,
            "project_id"    => implode(',', @$this->details?->pluck('item_id')->toArray() ?? []),
            "donor_id"      => $this->donor_id,
            "substitute_id" => $this->badalOrder?->substitute_id,
            "name"          => implode(',', @$this->details?->pluck('item_name')->toArray() ?? []),
            "amount"        => $this->total,
            "total"         => $this->total,
            "quantity"      => $this->quantity,
            "behafeof"      => $this->badalOrder?->behafeof,
            "relation"      => $this->badalOrder?->relation,
            "language"      => $this->badalOrder?->language,
            "gender"        => $this->badalOrder?->gender,
            "start_at"      => $this->badalOrder?->start_at,
            "complete_at"   => $this->badalOrder?->complete_at,
            "is_offer"      => $this->badalOrder?->is_offer,
            "offer_id"      => $this->badalOrder?->offer_id,
            "status"        => $this->status,
            "time"          => $this->badalOrder->complete_at,
            "review"        => $this->badalOrder->review?->rate,
        ];
    }
}
