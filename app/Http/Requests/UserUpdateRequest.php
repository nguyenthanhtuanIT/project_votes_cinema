<?php

namespace App\Http\Requests;

use App\Models\Trust\Role;

class UserUpdateRequest extends BaseRequest
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
        $id = request()->id ? request()->id : request()->segment(4);

        return [
            'name' => 'sometimes|string|max:191',
            'email' => "sometimes|string|unique:users,email,$id",
            'phone' => "sometimes|string|unique:users,phone,$id",
            'photo' => 'sometimes|nullable|numeric|exists:images,id',
            'password' => 'sometimes|string',
            'address' => 'sometimes|nullable|string|max:191',
            'role' => 'sometimes|string|in:' . implode(',', Role::roles()),
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
