<?php

namespace App\Http\Requests\Admin\CMS;

use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $req = [];

        foreach (config('translatable.locales') as $locale) {
            $req += [$locale . '.title' => 'nullable'];
            $req += [$locale . '.description' => 'nullable'];
        }

        $req += ['image' => 'nullable|' . ImageValidate()];
        $req += ['url' => 'nullable|string|max:255'];
        $req += ['sort' => 'nullable'];
        $req += ['status' => 'nullable'];

        return $req;
    }

    public function getSanitized()
    {
        $data = $this->validated();

        $data['status'] = isset($data['status']) ? true : false;

        if (request()->isMethod('PUT')) {
            $data['updated_by'] = @auth()->user()->id;
        } else {
            $data['created_by'] = @auth()->user()->id;
        }

        return $data;
    }
}
