<?php

namespace App\Http\Requests\Accounting;

use Illuminate\Foundation\Http\FormRequest;

class StoreAccountingRequest extends FormRequest
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
            'email' => 'required|email|unique:accounting,email',
            'username' => 'required|max:20|unique:accounting,username',
            'password' => 'required|min:6',
            'firstname' => 'required|min:2|max:20',
            'middlename' => 'nullable|min:2|max:20',
            'lastname' => 'required|min:2|max:20'
        ];
    }
}
