<?php

namespace App\Http\Resources\Badal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RitualsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'ritual_id'  => $this->id,
            'title'  => $this->title,
            'proof'  => $this->proof,
            'start'  => $this->start,
            'complete'  => $this->complete,
            'image'  => $this->rite->image,
        ];
    }
}
