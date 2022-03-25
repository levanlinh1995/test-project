<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class CreateProductRequest extends FormRequest
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
            'sku' => 'required|max:255|unique:products,sku',
            'product_name' => 'required|max:255',
            'price' => 'required|numeric',
            'qty' => 'required|integer',
            'unit' => 'required|string',
            'status' => 'required|integer',
        ];
    }
}
