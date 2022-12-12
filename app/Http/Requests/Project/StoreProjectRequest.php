<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'title' => 'required',
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
            'payment_method' => 'required'
        ];
    }
}
