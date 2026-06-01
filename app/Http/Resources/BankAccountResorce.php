<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BankAccountResorce extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "image" => asset($this->image),
            "bankname" => $this->bank_name,
            "account_type" => $this->account_type,
            "iban" => $this->iban,
            "payment_key" => $this->payment_key,
            "url" => $this->bank_url,
        ];
    }
}
