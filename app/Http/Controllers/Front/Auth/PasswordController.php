<?php

namespace DomainProvider\Http\Controllers\Front\Auth;

use DomainProvider\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Foundation\Auth\ResetsPasswords;

class PasswordController extends Controller
{
    use ResetsPasswords;
    protected $redirectTo;

    /**
     * Create a new password controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     * @param  \Illuminate\Contracts\Auth\PasswordBroker  $passwords
     * @return void
     */
    public function __construct(Guard $auth, PasswordBroker $passwords)
    {
        $this->auth = $auth;
        $this->passwords = $passwords;

        $this->middleware('guest');
        $this->redirectTo = route('home');
    }

    /**
     * Show the form for creating a new Forgot password.
     *
     * @return Response
     */
    public function getEmail()
    {
        return view('front.auth.password');
    }

    /**
     * Show the form for creating a Reset Password.
     *
     * @param string $token
     * @return Response
     */
    public function getReset($token = null)
    {
        if (is_null($token)) {
            throw new NotFoundHttpException;
        }

        return view('front.auth.reset')->with('token', $token);
    }
}
