<?php

namespace App\Http\Resources\Badal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BadalSelectedResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "name" => $this->transNow ?->title,
            "url" =>  route('site.charity-project.show', $this->transNow ?->slug),
            "secondary_image" => $this->secondary_image,
            "target_price" => $this->target_price,
            "unit_price" => $this->unit_price,
            "fake_target" => $this->fake_target,
        ];
    }
}
