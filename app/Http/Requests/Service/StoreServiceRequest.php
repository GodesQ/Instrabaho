<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;

class StoreServiceRequest extends FormRequest
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
            'name' => 'required',
            'cost' => 'required|numeric',
            'english_level' => 'required|in:Basic,Bilingual,Fluent,Professional',
            'service_category' => 'required',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'required',
            'type' => 'required|in:simple,featured',
        ];
    }
}
