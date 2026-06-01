<?php

namespace App\Http\Resources\Donor;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class LoginResource extends JsonResource
{

    private $request, $message;

    public function __construct($request, $message =  null) {
        $this->request = $request;
        $this->message = $message;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request, $message =  null): array
    {
        return [
            'donor_id'   => $this->request->id,
            'otp'        => @$this->request->otp,
            'mobile'     => $this->request->mobile,
            'identity'   => $this->request->identity,
            'token'      => $this->request->token,
            'message'    => $message ?? $this->message,
          ];
    }
}
