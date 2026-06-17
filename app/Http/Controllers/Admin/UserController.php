<?php

namespace DomainProvider\Http\Controllers\Admin;

use Auth;
use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Http\Requests\Admin\UserRequest;
use DomainProvider\Models\User;
use DomainProvider\Repositories\UserDomainRepository;
use DomainProvider\Repositories\UserRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class UserController extends BaseController
{
    private $userRepository;
    private $userDomainRepository;

    /**
     * [DependencyInjection]
     *
     * @param UserRepository $userRepository
     * @param UserDomainRepository $userDomainRepository
     */
    public function __construct(UserRepository $userRepository, UserDomainRepository $userDomainRepository)
    {
        $this->userRepository = $userRepository;
        $this->userDomainRepository = $userDomainRepository;
    }

    /**
     * Display a listing of the User.
     *
     * @return Response
     */
    public function index()
    {
        return $this->defaultIndex($this->userRepository->findForList(), 'admin.user.index');
    }

    /**
     * Display the specified User.
     *
     * @param  User $user
     * @return Response
     */
    public function show(User $user)
    {
        $userDomains = $this->userDomainRepository->findByUser($user);

        return view('admin.user.show', compact('user', 'userDomains'));
    }

    /**
     * Show the form for editing the specified User.
     *
     * @param User $user
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit(User $user, FormBuilder $formBuilder)
    {
        return $this->defaultEdit($formBuilder, $user, 'Admin\UserForm', 'admin.user.form', 'user');
    }

    /**
     * Update the specified User in storage.
     *
     * @param User $user
     * @param UserRequest $request
     * @return Response
     */
    public function update(User $user, UserRequest $request)
    {
        $datas = $request->only(['full_name', 'email']);
        if ($request->new_password) {
            $datas['password'] = $request->new_password;
        }
        if ($request->has('enabled')) {
            $datas['enabled'] = 1;
        } else {
            /**
             * cannot disabled self account
             */
            if ($user->id === Auth::user()->id) {
                return redirect($this->route('user.edit', ['id' => $user->id]))
                        ->withInput($request->except('_token', 'enabled'))
                        ->withErrors([
                            'enabled' => trans('admin.user.cannot_disabeled_self'),
                        ]);
            }

            $datas['enabled'] = 0;
        }

        $this->userRepository->update($datas, $user->id);

        return redirect($this->route('user.index'))
            ->with('success', $this->returnMessage('update', 'user'));
    }
}
