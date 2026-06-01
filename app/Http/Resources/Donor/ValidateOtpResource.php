<?php

namespace App\Http\Resources\Donor;

use App\Http\Resources\Badal\Subsitute\SubsituteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ValidateOtpResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            "donor_id" => $this->id,
            "mobile" => $this->mobile,
            "full_name" => $this->full_name,
            "email" => $this->account?->email,
            "identity" => $this->identity,
            "mobile_confirmed" => $this->mobile_confirm == 1 ? 'yes' : 'no'  ,
            "otp" => $this->otp,
            "token" => $this->token,
            "expiration" => $this->expiration,
            "store_id" => $this->refer_id,
            "token_name" => null,
            "deleted" => !($this->deleted_at) ? 0 : 1,
            "status" => $this->status,
            "is_substitute" => $this->account->substitute ? 1: 0,
            "modified_date" => $this->updated_at,
            "create_date" => $this->created_at,
            'substitute' => $this->whenLoaded('substitute', function () {
                return SubsituteResource::collection($this->substitute); // TO DO 
            }),
        ];
    }
}
