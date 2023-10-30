<?php

namespace App\Http\Controllers;

use Generator;
use Stringable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    //
    public function index()
    {
        return view('admin.Tables.User.auth.forgot-password', [
            'title' => 'Forgot Password'
        ]);
    }

    public function resetPasswordindex()
    {
        return view('admin.Tables.User.auth.reset-password', [
            'title' => 'Reset Password'
        ]);
    }


    public function sendResetLinkEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);

        // Send the password reset link
        $response = Password::sendResetLink($request->only('email'));

        return $response === Password::RESET_LINK_SENT
                    ? back()->with('status', __($response))
                    : back()->withErrors(['email' => __($response)]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed'
        ]);

        // Reset the password
        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password)
                ])->save();

                event(new PasswordReset($user));
            }
        );

        return $response == Password::PASSWORD_RESET
                    ? redirect('/login')->with('status', __($response))
                    : back()->withErrors(['email' => __($response)]);
    }

}
