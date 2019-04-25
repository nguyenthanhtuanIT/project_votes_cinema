<?php

namespace App\Http\Controllers\Auth;

use JWTAuth;
use App\User;
use App\Http\Controllers;
use App\Models\Trust\Role;
use App\Models\DeviceToken;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = request(['email', 'phone', 'password']);

        try {
            if (!$token = auth()->attempt($credentials)) {
                $data = [
                    'jsonapi' => [
                        'version' => '1.0',
                    ],
                    'errors' => [
                        'title' => 'AuthenticateError',
                        'detail' => 'Invalid_email_or_password',
                    ],
                ];

                return response()->json($data, 401);
            }

            switch ($request->get('platform')) {
                case User::PF_ADMIN:
                    $trust = auth()->user()->hasRole(Role::SUPER_ADMIN);
                    break;
                case User::PF_OWNER:
                    $trust = auth()->user()->hasRole(Role::SALON_OWNER);
                    break;
                case User::PF_USER:
                default:
                    $trust = true;
                    break;
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

            if (!$trust) {
                $data = [
                    'jsonapi' => [
                        'version' => '1.0',
                    ],
                    'errors' => [
                        'title' => 'AuthenticateError',
                        'detail' => 'Invalid_email_or_password',
                    ],
                ];

                return response()->json($data, 401);
            }

            return response()->json(formatToken($token));
        } catch (JWTAuthException $e) {
            $data = [
                'jsonapi' => [
                    'version' => '1.0',
                ],
                'errors' => [
                    'title' => 'AuthenticateError',
                    'detail' => 'Failed_to_create_token',
                ],
            ];

            return response()->json($data, 500);
        }
    }

    public function logout(Request $request)
    {
        $user = auth()->user();
        $device_uuid = $request->input('device_uuid');

        if ($device_uuid && $user) {
            $uuid = DeviceToken::where('uuid', $device_uuid)->where('user_id', $user->id)->first();
            if ($uuid) {
                $uuid->delete();
            }
        }

        JWTAuth::invalidate(JWTAuth::getToken());

        return response()->json(null, 204);
    }
}
