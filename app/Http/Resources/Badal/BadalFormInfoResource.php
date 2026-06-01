<?php

namespace App\Http\Resources\Badal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BadalFormInfoResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "relations"=> json_decode( $this->getBadalData('relations'), true),
            "types"=> json_decode( $this->getBadalData('gender'), true),
            "languages"=> json_decode( $this->getBadalData('languages'), true),
            "nationality"=> json_decode( $this->getBadalData('nationality'), true),
            "nationality"=> json_decode( $this->getBadalData('nationality'), true),
            "offer_time"=> $this->getBadalData('offer_time'),
            "late_time"=> $this->getBadalData('late_time'),
            "license_img"=> $this->getBadalData('license_img'),
            "haij_icon"=> $this->getBadalData('haij_icon'),
            "haij_image"=> $this->getBadalData('haij_image'),
            "haij_text"=> $this->getBadalData('haij_text'),
            "haij_status"=> $this->getBadalData('haij_status'),
            "umrah_icon"=> $this->getBadalData('umrah_icon'),
            "umrah_image"=> $this->getBadalData('umrah_image'),
            "umrah_text"=> $this->getBadalData('umrah_text'),
            "umrah_status"=> $this->getBadalData('umrah_status'),
            "badalenabled"=> $this->getBadalData('badalenabled'),
        ];
    }
}
