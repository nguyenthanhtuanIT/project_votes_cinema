<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthFacebookRequest;
use App\Models\Social;
use App\Services\RoleService;
use App\User;
use Socialite;

class AuthGoogleController extends Controller {
	public function login(AuthFacebookRequest $request) {
		$provider = Social::PROVIDER_GOOGLE;

		$profile = Socialite::driver($provider)->userFromToken($request->token);

		if (!$profile->email) {
			throw new \Illuminate\Validation\UnauthorizedException('Invalid email');
		}

		$social = Social::firstOrNew([
			'social_name' => $provider,
			'social_id' => $profile->id,
		]);

		if ($social->user_id) {
			$user = User::find($social->user_id);
		} else {
			$user = User::where(['email' => $profile->email])->first();

			if (!$user) {
				$user = new User;
				$user->avatar = $profile->avatar;
				$user->full_name = $profile->name;
				$user->email = $profile->email;
				$user->password = bcrypt($profile->id . time());
				$user->save();
				RoleService::add($user, 'member');
			}
			$social->user_id = $user->id;
			$social->save();
		}

		$device_uuid = $request->input('device_uuid');
		$device_token = $request->input('device_token');

		if ($device_uuid && $device_token) {
			$uuid = DeviceToken::where('uuid', $device_uuid)->first();
			if ($uuid) {
				//update token device
				$uuid->user_id = auth()->user()->id;
				$uuid->token = $device_token;
				$uuid->save();
			} else {
				$device = new DeviceToken();
				$device->user_id = auth()->user()->id;
				$device->uuid = $device_uuid;
				$device->token = $device_token;
				$device->save();
			}
		}

		$token = auth()->fromUser($user);

		return response()->json(formatToken($token));
	}
}
