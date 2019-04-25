<?php

namespace App\Http\Requests;

use App\Models\Trust\Role;

class UserCreateRequest extends BaseRequest
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
            'name' => 'required|string|max:191',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string',
            'phone' => 'sometimes|nullable|numeric|unique:users,phone',
            'address' => 'sometimes|nullable|string|max:191',
            'role' => 'required|string|in:' . implode(',', Role::roles()),
        ];
    }

    /**
     * @return array Custom message errors
     */
    public function messages()
    {
        return [
            'role.in' => 'The selected role is invalid. Must be in ' . implode(', ', Role::roles()),
        ];
    }
}
