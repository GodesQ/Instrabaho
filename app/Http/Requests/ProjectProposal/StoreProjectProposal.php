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
            'project_id' => 'required',
            'offer_price' => 'required|numeric',
            'address' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'project_cost_type' => 'required|in:Fixed,Hourly',
            'cover_letter' => 'nullable'
        ];
    }
}
