<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Auth\Authenticatable;
use Nexmo;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function credentials(Request $request)
    {
        //Check if we have a valid email ortherwise take username as the variable
        $field = filter_var($request->get($this->username()), FILTER_VALIDATE_EMAIL)
            ? $this->username()
            : 'username';
        return [
            $field => $request->get($this->username()),
            'password' => $request->password,
        ];
    }

    public function authenticated(Request $request, Authenticatable $user)
    {
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
    }
}
