<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SelectRequest extends FormRequest
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
            'orderBy' => 'required',
            'order' => 'required|in:asc,desc',
            'model' => 'required|in:Product',
            'q' => '',
            'filters' => '',
            'with' => '',
        ];
    }
}
