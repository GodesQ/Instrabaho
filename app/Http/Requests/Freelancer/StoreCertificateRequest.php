<?php

namespace App\Http\Requests\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class StoreCertificateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "certificate"    => "required",
            "certificate_date"  => "required|date",
            "certificate_image"  => "file|max:8192|mimes:png,jpg,jpeg,pdf,docs",
        ];
    }
}
