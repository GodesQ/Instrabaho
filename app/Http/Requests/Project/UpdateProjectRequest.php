<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
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
            'id' => 'required|exists:projects,id',
            'title' => 'required|max:100',
            'category_id' => 'required',
            'description' => 'required',
            'project_cost_type' => 'required',
            'cost' => 'required|numeric|min:100',
            'location' => 'required',
            'project_type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'total_dates' => 'required|numeric',
            'payment_method' => 'required',
            'skills' => 'required|array|max:5'
        ];
    }
}
