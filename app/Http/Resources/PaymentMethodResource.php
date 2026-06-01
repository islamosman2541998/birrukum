<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentMethodResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);
        return  [
            "payment_id" => $this->id,
            "title" =>  $this->transNow?->title,
            "payment_key" =>  $this->payment_key
        ];
    }
}
