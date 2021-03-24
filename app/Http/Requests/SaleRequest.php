<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => [
                'required', 'date'
            ],
            'client_id' => [
                'required', 'exists:clients,id'
            ] ,
            'products.*.product_id' => 'required|exists:products,id',     
            'products.*.qty' => 'required|min:1|gt:0',     
            'products.*.price' => 'required|numeric',     

        ];
    }
}
