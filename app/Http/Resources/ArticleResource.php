<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [
            "article_id" => $this->id,
            "title" => $this->trans?->title,
            "alias" => $this->trans?->slug,
            "content" => $this->trans?->description,
            "section_id" =>  $this->section_id,
            "image" =>  asset($this->image),
            "hits" =>  null,
            "status" =>  $this->status,
            "create_date" =>  $this->created_at,
            "modified_date" =>  $this->updated_at,
        ];
    }
}
