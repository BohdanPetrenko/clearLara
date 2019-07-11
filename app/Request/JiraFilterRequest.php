<?php

namespace App\Request;

use Illuminate\Foundation\Http\FormRequest;

class JiraFilterRequest extends FormRequest
{
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
            'filter_id' => 'unique:jira_filters|required|integer',
            'schedule' => 'required',
            'max_total_items' => 'required|integer',
            'slack_webhook' => 'required|string',
        ];
    }
}
