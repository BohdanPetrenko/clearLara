<?php

namespace App\Request;

use Illuminate\Database\Eloquent\Model;

class JiraFilterRequest extends Model
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
            'title' => 'required|min:5|max:200',
        ];
    }
}
