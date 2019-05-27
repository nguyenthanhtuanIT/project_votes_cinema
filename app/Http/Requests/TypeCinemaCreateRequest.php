<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TypeCinemaCreateRequest extends FormRequest
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
            'name_type_cinema' => 'required|unique:type_cinema',
        ];
    }
    public function messages()
    {
        return [
            'name_type_cinema.required' => ' You have to enter name_type_cinema ',
            'name_type_cinema.unique' => 'name_type_cinema already exist',
        ];
    }
}
