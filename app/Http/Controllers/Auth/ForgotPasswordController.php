<?php

namespace App\Http\Controllers\Auth;

use Mail;
use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
     */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getResetToken(ResetPasswordRequest $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        $token = $this->broker()->createToken($user);

        $domain = config('app.frontend_url');
        $forgotLink = config('app.forgot_url');

        $sourceLink = "{$domain}/{$forgotLink}/email/{$user->email}/token/$token";

        Mail::send('emails.forgot_password', compact('user', 'sourceLink'), function ($message) use ($user) {
            $message->to($user->email)->subject('Reset your password!');
        });

        return response()->json(null, 204);
    }
}
