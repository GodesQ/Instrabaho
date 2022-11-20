<?php

namespace App\Http\Requests\Addon;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAddonRequest extends FormRequest
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
            'id' => 'required|exists:addons,id',
            'freelancer' => 'required',
            'title' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ];
    }
}
