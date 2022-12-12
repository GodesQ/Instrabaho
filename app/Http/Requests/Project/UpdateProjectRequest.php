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
            'employer' => 'required',
            'title' => 'required',
            'category_id' => 'required',
            'description' => 'required',
            'project_level' => 'required',
            'project_cost_type' => 'required',
            'cost' => 'required|numeric',
            'location' => 'required',
            'project_type' => 'required|in:simple,featured',
            'skills' => 'required'
        ];
    }
}
