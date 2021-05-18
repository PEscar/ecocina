<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeRequest extends FormRequest
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
            'quantity' => 'required|gt:0',
            'extra_cost' => '',
            'products.*' => 'required|exists:products,id',
            'qttys.*' => 'required|gt:0',
            'name' => 'required',
            'detial' => '',
        ];
    }
}
