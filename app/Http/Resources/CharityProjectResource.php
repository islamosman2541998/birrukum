<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharityProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {

        return [

            "project_id" => $this->id,
            "name" => $this->transNow ?->title ,
            "alias"=>  $this->transNow ?->slug ,
            "description"=>  $this->transNow ?->description ,
            "donation_type"=>   json_decode($this->donation_type, true) ,
            "project_number"=>  $this->number ,
            "beneficiary"=>     $this->beneficiary,
            "category_id"=>  $this->category_id,
            "arrangement"=>  $this->sort,
            "back_home"=>      "0",
            "image"=>  json_decode($this->images ?? [], true),
            'secondary_image' =>   $this->cover_image, //

            "target_price"=>  $this->target_price ,
            "target_unit"=>  $this->target_unit ,
            "unit_price"=> $this->target_price  , //here
            "fake_target"=>  $this->fake_target ,
            "min_price"=>  $this->min_price ,
            "collected_traget"=>  $this->collected_traget ,
            "start_date"=>  $this->start_date ,
            "end_date"=>  $this->end_date ,
            "kafara"=>  $this->project_types,
            "badal"=>  $this->badalField ,
            "badal_type"=>   $this->badalField ?->badal_type,
            "background_color"=>  $this->background_color ,
            "background_image"=>  $this->background_image ,
            "meta_keywords"=>  $this->transNow?->meta_key ,
            "meta_description"=>  $this->transNow?->meta_description ,
            "deceased_id"=>  $this->deceased_id ,
            "finished"=>  $this->finished ,
            "featured"=>  $this->featuer ,
            "status"=>  $this->status ,
            "modified_date"=>  $this->updated_at ,
            "create_date"=>  $this->created_at ,

        ];
    }
}
