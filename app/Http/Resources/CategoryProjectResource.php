<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;

class CategoryProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request)
    {
//        return parent::toArray($request);
        return [
            "category_id" => $this->id,
            "name" => $this->transNow ?->title  ,
            "alias" =>  $this->transNow ?->slug,
            "description" => removeHTML($this->transNow ?->description),
            "parent_id" =>  $this->parent ?->id ?? 0 ,
            "kafara" =>  $this->project_types,
            "level" =>  $this->level,
            "arrangement" =>  $this->sort,
            "back_home" =>  $this->back_home,
            "image" =>  asset($this->image) ,
            "background_color" =>  $this->background_color,
            "background_image" =>  asset($this->background_image) ,
            "meta_keywords" =>  $this->transNow->meta_keywords,
            "meta_description" =>  $this->transNow->meta_description,
            "featured" => $this->feature,
            "status" => $this->status,
            "modified_date" =>   $this->updated_at ,
            "create_date" =>   $this->created_at  ,

        ];
    }
}
