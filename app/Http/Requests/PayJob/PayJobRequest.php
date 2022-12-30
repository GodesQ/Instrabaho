<?php

namespace App\Http\Requests\PayJob;

use Illuminate\Foundation\Http\FormRequest;

class PayJobRequest extends FormRequest
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
            'job_cost' => 'required|numeric',
            'system_deduction' => 'required|numeric',
            'total' => 'required|numeric',
            'employer_id' => 'required|numeric',
            'freelancer_id' => 'required|numeric',
            'payment_method' => 'required',
            'job_type' => 'required|in:project,service'
        ];
    }
}
