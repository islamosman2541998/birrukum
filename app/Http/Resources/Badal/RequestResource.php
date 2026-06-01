<?php

namespace App\Http\Resources\Badal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "request_id"        => $this->id,
            "badal_id"          => @$this->badal->id,
            "substitute_id"     => @$this->substitute->id,
            "start_at"          => $this->start_at,
            "is_selected"       => $this->is_selected,
            "status"            => $this->status,
            "modified_date"     => $this->created_at,
            "create_date"       => $this->updated_at,
            "full_name"         => $this->substitute->full_name,
            "nationality"       => $this->substitute->nationality,
            "gender"            => $this->substitute->gender,
            "languages"         => $this->substitute->languages,
            "image"             => asset(@$this->substitute->image),
            "rate"              => "4.0",
        ];
    }
}
