<?php

namespace App\Http\Requests\ProjectContract;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectContract extends FormRequest
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
            'project_id' => 'required|exists:projectS,id',
            'proposal_id' => 'required',
            'freelancer_id' => 'required|exists:user_freelancer,id',
            'employer_id' => 'required|exists:user_employer,id',
            'cost' => 'required|numeric',
            'total_cost' => 'required|numeric',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'proposal_type' => 'required|in:offer,proposal'
        ];
    }
}
