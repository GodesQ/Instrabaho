<?php

namespace App\Http\Requests\Freelancer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFreelancerRequest extends FormRequest
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
            'id' => 'required',
            'username' => 'required',
            'firstname' => 'required',
            'lastname' => 'required',
            'display_name' => 'required',
            'tagline' => 'required',
            'freelancer_type' => 'required|in:Individual,Group,Student',
            'hourly_rate' => 'required|numeric',
            'gender' => 'required|in:Male,Female',
            'contactno' => 'required',
            'description' => 'required',
            'address' => 'required',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ];
    }
}
