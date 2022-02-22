<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\User;
use Hash;
use Illuminate\Support\Facades\Redirect;

class PreferencesController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index()
    {
        $user = Auth::user();
        return view('preferences', compact('user'));
    }

    public function updateUsername(User $user)
    {
        $this->validate(
            request(),
            [
                'username' => ['required', 'string', 'max:255', 'unique:users'],
                'current' => 'required'
            ],
            [
                'username.required'    => 'The field new username is required.',
                'current.required'      => 'The field your current password is required.'
            ]
        );

        if (!(Hash::check(request('current'), Auth::user()->password))) {
            return Redirect::back()->withErrors(['Your current password does not matches with the password you provided. Please try again.']);
        }

        $user->username = request('username');
        $user->email_verified_at = null;
        $user->save();
        $user->sendEmailVerificationNotification();

        return back();
    }

    public function updateEmailAddress(User $user)
    {
        $this->validate(
            request(),
            [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'current' => 'required'
            ],
            [
                'email.required'    => 'The field new email address is required.',
                'current.required'      => 'The field your current password is required.'
            ]
        );

        if (!(Hash::check(request('current'), Auth::user()->password))) {
            return Redirect::back()->withErrors(['Your current password does not matches with the password you provided. Please try again.']);
        }

        $user->email = request('email');
        $user->email_verified_at = null;
        $user->save();
        $user->sendEmailVerificationNotification();

        return back();
    }

    public function updatePassword(User $user)
    {
        $this->validate(request(), [
            'current' => 'required',
            'password' => 'required|confirmed',
            'password_confirmation' => 'required'
        ]);

        if (!(Hash::check(request('current'), Auth::user()->password))) {
            return Redirect::back()->withErrors(['Your current password does not matches with the password you provided. Please try again.']);
        }

        $user->password = Hash::make(request('password'));
        $user->save();
        Auth::logout();

        return back();
    }

    public function closeAccount(User $user)
    {
        $this->validate(
            request(),
            [
                'delete' => 'regex:/delete/'
            ],
            [
                'delete.regex'      => 'To close your account, type ‘delete’'
            ]
        );

        if (request('delete') == 'delete') {
            $user = User::find(Auth::user()->id);

            Auth::logout();

            if ($user->delete()) {

                return Redirect::route('home');
            }
        }

        return back();
    }
}
