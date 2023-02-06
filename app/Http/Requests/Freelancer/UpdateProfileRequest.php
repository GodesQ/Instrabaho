<?php

namespace App\Http\Requests\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
            'firstname' => 'required|min:2|max:20',
            'lastname' => 'required|min:2|max:20',
            'middlename' => 'nullable',
            'hourly_rate' => 'required|numeric',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'description' => 'nullable|min:10|max:500',
            'gender' => 'nullable|in:Male,Female',
            'contactno' => 'required',
        ];
    }
}
