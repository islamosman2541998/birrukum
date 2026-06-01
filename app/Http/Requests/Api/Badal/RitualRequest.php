<?php

namespace App\Http\Requests\Api\Badal;

use App\Traits\Api\Request\RequestSanitizer;
use App\Traits\Api\Request\RequestValidationErrorResponse;
use Illuminate\Foundation\Http\FormRequest;

class RitualRequest extends FormRequest
{
  
    use RequestSanitizer, RequestValidationErrorResponse;
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "project_id" =>  'required',
        ];
    }
}
