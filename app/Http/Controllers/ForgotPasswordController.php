<?php

namespace App\Http\Controllers;

use Generator;
use Stringable;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Validation\ValidationException;

use App\Models\User;


class ForgotPasswordController extends Controller
{
    //
    public function publicIndex()
    {
        return view('public.user.auth.forgot-password', [
            'title' => 'Forgot Password'
        ]);
    }

    public function resetPasswordindex()
    {
        return view('public.user.auth.reset-password', [
            'title' => 'Reset Password'
        ]);
    }

    public function changePasswordIndex(User $user)
    {
        return view('public.user.auth.changePassword', [
            'title' => 'Change Password',
            'user' => $user,
        ]);
    }

    public function changePassword(Request $request, User $user){

        $request->validate([
            'oldPassword' => 'required',
            'newPassword' => 'required|min:8|confirmed',
            'newPassword_confirmation' => 'required|min:8',
        ]);

        if (!Hash::check($request->oldPassword, $user->password)) {
            throw ValidationException::withMessages(['oldPassword' => 'Your old password is incorrect.']);
        }

        // Update the user's password
        $user->update([
            'password' => Hash::make($request->newPassword),
        ]);

        return redirect('/')>with('success', 'Password changed successfully!');
    }



    public function validateChangePassword(Request $req){
        //check if req input is === user's pw in db
        $isCorrectOldPassword = false;
        if ($isCorrectOldPassword){
            $this->resetPassword($req);
        }else{

        }
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
