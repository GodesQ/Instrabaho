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
            'title' => 'required|max:100',
            'attachments' => 'file|mimes:png,jpg,jpeg,pdf,docx,doc',
            'category_id' => 'required',
            'description' => 'required',
            'project_cost_type' => 'required',
            'cost' => 'required|numeric',
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
