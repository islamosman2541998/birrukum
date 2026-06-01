<?php

namespace App\Http\Resources\Badal\Subsitute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OfferResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "offer_id" => $this->id,
            "substitute_id" => $this->substitute_id,
            "project_id" => @$this->project?->transNow->id,
            "amount" => $this->amount,
            "start_at" => $this->start_at,
            "status" => $this->status,
            "create_date" => $this->created_at,
            "project_name" => @$this->project?->transNow->name,
            "full_name" => $this->substitute?->full_name,
            "substitute_image" => $this->substitute?->image,
            "nationality" => $this->substitute?->nationality,
            "gender" => $this->substitute?->gender,
            "rate" => $this->rate   // TO DO
        ];
    }
}