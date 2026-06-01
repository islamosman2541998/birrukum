<?php

namespace App\Http\Resources\Badal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyRequestResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'request_id'  => $this->id,
            'project_name'  => @$this->badal?->project?->transNow?->title,
            'behafeof'  => $this->badal->behafeof,
            'start_at'  => $this->start_at,
            'status'  => $this->status,
            'is_selected'  => $this->is_selected,
            'badal_selected'  => $this->badal->substitute_id,
        ];
    }
}
