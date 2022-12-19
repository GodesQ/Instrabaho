<?php

namespace App\Http\Requests\ProjectOffer    ;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectOfferRequest extends FormRequest
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
            'project_id' => 'required|exists:projects,id',
            'freelancer_id' => 'required|exists:user_freelancer,id',
            'employer_id' => 'required|exists:user_employer,id',
            'private_message' => 'required',
        ];
    }
}
