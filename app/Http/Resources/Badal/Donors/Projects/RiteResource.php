<?php

namespace App\Http\Resources\Badal\Donors\Projects;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RiteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"    => $this->id,
            "title" => $this->transNow->title,
            "proof" => $this->proof,
            "image" => asset($this->image),
        ];
    }
}
