<?php

namespace App\Http\Resources\Badal\Donors\Projects;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CharityBadalProjectResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
//        return parent::toArray($request);

        return [
            "project_id" => $this->project?->id,
            "name" => $this->project?->transNow?->title,
            "alias" => $this->project?->transNow?->slug,
            "project_number" => $this->number,
            "beneficiary" => $this->beneficiary,
            "description" => $this->project?->transNow?->description,
            "category_id" =>  $this->project?->category_id,
            "arrangement" =>  $this->project?->sort,
            "back_home" => "0",
            "image" => [$this->project?->images] ,
            "secondary_image" =>   $this->project?->cover_image,
            "enable_cart" =>  '1' ,  //
            "gift" => "0",
            "gift_card_title" => "",
            "mobile_confirmation" => "0",
            "donation_type" =>  $this->project?->donation_type,
            "payment_methods" =>  $this->project?->payment()->get()->pluck('id'),
            "target_price" =>  $this->project?->target_price , //here
            "target_unit" =>   $this->project?->target_unit ,
            "unit_price" =>$this->project?->target_price  , //here
            "fake_target" =>  $this->project?->fake_target ,
            "min_price" =>  $this->project?->min_price ,
            "collected_traget" => $this->project?->collected_traget ,
            "start_date" =>  $this->project?->start_date ,
            "end_date" =>   $this->project?->end_date ,
            "kafara" =>  $this->project?->project_types,
            "badal" =>  $this->project?->badalField ,
            "badal_type" =>  $this->project?->badalField ?->badal_type,
            "hidden" => "1",
            "hits" => null,
            "thanks_message" => "",
            "sms_msg" => "",
            "mobile" => "",
            "whatsapp" => "",
            "advertising_code" => "",
            "header_code" => "",
            "background_color" =>  $this->project?->background_color ,
            "background_image" =>  $this->project?->background_image ,
            "meta_keywords" => $this->project?->transNow?->meta_key ,
            "meta_description" =>  $this->project?->transNow?->meta_description ,
            "deceased_id" =>  $this->project?->deceased_id ,
            "finished" =>   $this->project?->finished ,
            "featured" =>  $this->project?->featuer ,
            "status" =>  $this->project?->status ,
            "modified_date" => $this->project?->updated_at ,
            "create_date" => $this->project?->created_at ,

        ];


    }
}
