<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Nexmo;
use Auth;

class SmsVerificationController extends Controller
{
    public function enableTwoFactor(Request $request)
    {
        $user = $request->user();

        if ($user->contact_no == null) {
            return back()->withErrors('You have to provide your contact number to enable 2FA.');
        }

        $user->sms_2fa_enable = 1;
        $user->save();

        Session::flash('flash_message', 'You have enabled 2FA.');

        return back();
    }

    public function disableTwoFactor(Request $request)
    {
        $user = $request->user();

        $user->sms_2fa_enable = 0;
        $user->save();

        return back();
    }

    public function show(Request $request)
    {
        if ($request->session()->has('verify:user:id')) {
            return view('auth.smsverify');
        }

        return redirect('/dashboard');
    }

    public function verify(Request $request)
    {
        $this->validate($request, [
            'code' => 'size:6',
        ]);

        try {
            Nexmo::verify()->check(
                $request->session()->get('verify:request_id'),
                $request->code
            );
            Auth::loginUsingId($request->session()->pull('verify:user:id'));
            return redirect('/dashboard');
        } catch (Nexmo\Client\Exception\Request $e) {
            return redirect()->back()->withErrors([
                'code' => $e->getMessage()
            ]);
        }
    }
}
