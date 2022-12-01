<?php

namespace App\Http\Requests\ProjectProposal;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectProposal extends FormRequest
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
            'offer_price' => 'required|numeric',
            'estimated_days' => 'required|numeric',
            'cover_letter' => 'required',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ];
    }
}
