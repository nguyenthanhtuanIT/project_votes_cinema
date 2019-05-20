<?php

namespace App\Http\Requests;

class AuthFacebookRequest extends BaseRequest {
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize() {
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules() {
		return [
			'token' => 'required',
			// 'email' => [
			// 	'required',
			// 	'email',
			// 	function ($attribute, $value, $fail) {
			// 		$email = explode('@', $value);
			// 		if ($email[1] != 'greenglobal.com') {
			// 			return $fail('The ' . $attribute . ' must be greenglobal.com');
			// 		}
			// 	},
			// ],
		];
	}
}
