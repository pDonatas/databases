<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarRequest extends FormRequest
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
            'manufacturer' => 'required|string',
            'model' => 'required|string',
            'year' => 'numeric|min:1900',
            'condition' => 'string|required',
            'register_date' => 'date|required',
            'price' => 'numeric|required',
            'number_plate' => 'string|required',
            'location' => 'string|required'
        ];
    }
}
