<?php

namespace App\Http\Requests\UserAuth;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'firstname' => 'required|min:2|max:15',
            'lastname' => 'required|min:2|max:15',
            'username' => 'required|unique:user|max:15',
            'email' => 'required|email|unique:user',
            'password' => 'min:3|required_with:password_confirmation|same:password_confirmation',
            'password_confirmation' => 'min:3'
        ];
    }
}
