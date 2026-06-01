<?php

namespace App\Http\Resources\Donor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{

    protected $msg;


    public function __construct($resource, $msg)
    {
        parent::__construct($resource);
        $this->msg = $msg;
    }

    public function toArray(Request $request): array
    {
        return [
            'donor_id' => $this->id,
            'mobile' => $this->mobile,
            "full_name" => $this->full_name,
            "email" => $this->account ?->email,
            'token' => $this->token,
            "expiration" => $this->expiration,
            "message"=> $this->msg

        ];
    }
}
