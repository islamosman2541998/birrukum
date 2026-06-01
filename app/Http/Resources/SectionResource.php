<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SectionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "section_id" => $this->id,
            "name" => $this->trans?->title,
            "alias" => $this->trans?->slug,
            "description" => $this->trans?->description,
            "arrangement" => $this->sort,
            "image" => [ asset($this->image) ],
            "featured" => $this->feature,
            "status" => $this->status,
            "modified_date" => $this->updated_at,
            "create_date" => $this->created_at,
        ];
    }
}
