<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
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

    // protected function failedValidation(Validator $validator)
    // {
    //     $errors = [
    //         "message" => "The given data was invalid.",
    //         "errors" => $validator->errors(),
    //     ];

    //     throw new HttpResponseException(response()->json($errors, 422));
    // }
}
