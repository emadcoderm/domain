<?php

namespace DomainProvider\Http\Controllers\Front;

use Auth;
use DomainProvider\Http\Controllers\Controller;
use DomainProvider\Http\Requests\ProfileUpdateRequest;
use DomainProvider\Repositories\UserRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class UserController extends Controller
{
    private $userRepository;

    /**
     * [DependencyInjection]
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Show the form for editing the User profile.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getEdit(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('EditProfileForm', [
            'method' => 'POST',
            'url' => route('user.edit_profile'),
            'model' => \Auth::user()
        ]);

        return view('front.editProfile', compact('form'));
    }

    /**
     * Process User profile data
     * @param ProfileUpdateRequest $request
     * @return Response
     */
    public function postEdit(ProfileUpdateRequest $request)
    {
        $datas = $request->only(['full_name', 'email']);
        if ($request->new_password) {
            $datas['password'] = $request->new_password;
        }

        $this->userRepository->update($datas, Auth::user()->id);

        return redirect()
            ->route('user.edit_profile')
            ->with('success', trans('front.profile.success_update_profile'));
    }
}
