<?php

namespace DomainProvider\Http\Controllers\Front\Auth;

use DomainProvider\Helpers\Constants;
use DomainProvider\Http\Controllers\Controller;
use DomainProvider\Http\Requests\LoginRequest;
use DomainProvider\Http\Requests\RegistrationRequest;
use DomainProvider\Repositories\RoleRepository;
use DomainProvider\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Guard;
use Kris\LaravelFormBuilder\FormBuilder;

class AuthController extends Controller
{
    private $userRepository;

    /**
     * Create a new authentication controller instance.
     *
     * @param  \Illuminate\Contracts\Auth\Guard  $auth
     */
    public function __construct(Guard $auth, UserRepository $userRepository)
    {
        $this->auth = $auth;
        $this->middleware('guest', ['except' => 'getLogout']);
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for creating a new User.
     *
     * @param  FormBuilder $formBuilder
     * @return Response
     */
    public function getRegister(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('RegisterForm', [
            'method' => 'POST',
            'url' => route('user.register')
        ]);

        return view('front.auth.register', compact('form'));
    }

    /**
     * Process register data
     *
     * @param RegistrationRequest $request
     * @param RoleRepository $roleRepository
     * @return Response
     */
    public function postRegister(RegistrationRequest $request, RoleRepository $roleRepository)
    {
        $role = $roleRepository->findBy('name', Constants::ROLE_USER, ['id']);
        // abort if no role exists
        if (!$role) {
            return redirect()->intended(route('user.register'))
                    ->withInput($request->only('full_name', 'email'))
                    ->withErrors([
                        trans('front.error.please_contact_admin'),
                    ]);
        }

        $datas = $request->all();
        $datas['role_id'] = $role->id;

        $this->userRepository->create($datas);

        return redirect()
            ->route('user.login')
            ->with('success', trans('front.sign_up.success_register'));
    }

    /**
     * Show the form for process User login.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getLogin(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('LoginForm', [
            'method' => 'POST',
            'url' => route('user.login')
        ]);

        return view('front.auth.login', compact('form'));
    }

    /**
     * Process login data
     *
     * @param LoginRequest $request
     * @return Response
     */
    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['enabled'] = true;

        if ($this->auth->attempt($credentials, $request->has('remember'))) {
            return redirect()->intended(route('user.dashboard'));
        }

        return redirect()->intended(route('user.login'))
            ->withInput($request->only('email', 'remember'))
            ->withErrors([
                'email' => trans('front.log_in.failed_login'),
            ]);
    }

    /**
     * Process logout
     *
     * @return Response
     */
    public function getLogout()
    {
        $this->auth->logout();
        return redirect(route('home'));
    }
}
