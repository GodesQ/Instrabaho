<?php

namespace App\Http\Requests\EmployerRegisterForm;

use Illuminate\Foundation\Http\FormRequest;

class RegisterEmployerRequest extends FormRequest
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
            'display_name' => 'required|min:6',
            'tagline' => 'required',
            'number_employees' => 'required|in:0,1-10,11-20,21-30,31-50',
            'contactno' => 'required|numeric',
            'description' => 'required|max:500',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
    }
}
