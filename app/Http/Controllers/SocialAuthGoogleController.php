<?php

namespace App\Http\Controllers;

use Socialite;
use Auth;
use App\Services\SocialGoogleAccountService;
use Illuminate\Http\Request;
use Nexmo;

class SocialAuthGoogleController extends Controller
{
    /**
     * Create a redirect method to google api.
     *
     * @return void
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }
    /**
     * Return a callback method from google api.
     *
     * @return callback URL from google
     */
    public function callback(SocialGoogleAccountService $service, Request $request)
    {
        $user = $service->createOrGetUser(Socialite::driver('google')->user());

        if ($user->sms_2fa_enable) {
            Auth::logout();
            $request->session()->put('verify:user:id', $user->id);

            try {
                $verification = Nexmo::verify()->start([
                    'number' => $user->contact_no,
                    'brand'  => 'AMSystem',
                    'code_length'  => '6'
                ]);
            } catch (Nexmo\Client\Exception\Request $e) {
                return redirect()->back()->withErrors([
                    'code' => $e->getMessage()
                ]);
            }

            $request->session()->put('verify:request_id', $verification->getRequestId());

            return redirect('2fa/verify');
        }

        auth()->login($user);
        return redirect()->to('/dashboard');
    }
}
