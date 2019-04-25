<?php
/**
 * Global helpers file with misc functions
 *
 */

if (!function_exists('throwError')) {
    function throwError($message, $code)
    {
        if (!is_array($message)) {
            $message = [$message];
        }
        throw new \Illuminate\Http\Exceptions\HttpResponseException(new \Illuminate\Http\JsonResponse($message, $code));
    }
}

if (!function_exists('get_class_name')) {
    function get_class_name($object)
    {
        $classname = get_class($object);
        if ($pos = strrpos($classname, '\\')) {
            return substr($classname, $pos + 1);
        }

        return $classname;
    }
}

if (!function_exists('formatToken')) {
    function formatToken($token)
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
        ];
    }
}


if (!function_exists('currentUser')) {
    function currentUser()
    {
        $user = null;
        if ($token = \JWTAuth::setRequest(request())->getToken()) {
            try {
                $user = \JWTAuth::authenticate($token);
            } catch (\JWTException $e) {
                return null;
            }
        }

        return $user;
    }
}
