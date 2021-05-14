<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => 'required',
            'detail' => '',
            'sales' => 'min:0|max:1|required_without_all:shoppings,productions',
            'shoppings' => 'min:0|max:1|required_without_all:sales,productions',
            'productions' => 'min:0|max:1|required_without_all:sales,shoppings',
            'measure' => 'required|max:3',
        ];
    }
}
