<?php

namespace App\Http\Requests\ReviewFreelancer;

use Illuminate\Foundation\Http\FormRequest;

class StoreReviewFreelancerRequest extends FormRequest
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
            'reviewer_id' => 'required|exists:user_employer,id',
            'freelancer_id' => 'required|exists:user_freelancer,id',
            'freelancer_rate' => 'required|int|in:1,2,3,4,5',
            'review' => 'nullable|max:400',
            'review_image' => 'nullable|max:400',
            'job_id' => 'required',
            'job_type' => 'required|in:project,service'
        ];
    }
}
