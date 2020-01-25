<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SearchRequest extends FormRequest
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
            'from_date' => 'required|date|after_or_equal:today|date_format:Y-m-d',
            'to_date' => 'required|date|after:from_date|date_format:Y-m-d',
            'city' => 'required|string|min:3|max:3',
            'adults_number' => 'required|integer',
        ];
    }
}
