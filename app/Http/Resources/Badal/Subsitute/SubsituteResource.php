<?php

namespace App\Http\Resources\Badal\Subsitute;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SubsituteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "substitute_id" => @$this->account->substitute->id,
            "identity" => @$this->account->substitute->identity,
            "image" => @$this->account->substitute->image,
            "full_name" => @$this->account->substitute->full_name,
            "nationality" => @$this->account->substitute->nationality,
            "gender" => @$this->account->substitute->gender,
            "email" => @$this->account->email,
            "phone" => @$this->account->mobile,
            "languages" => @$this->account->substitute->languages,
            "status" => @$this->account->substitute->status,
            "proportion" => @$this->account->substitute->proportion,
            "create_date" => @$this->account->substitute->created_at,
            "rate" => @$this->account->substitute->identity, // TO DO 
        ];
    }
}
