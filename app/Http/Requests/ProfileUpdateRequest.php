<?php

namespace DomainProvider\Http\Requests;

use Auth;
use DomainProvider\Http\Requests\Request;

class ProfileUpdateRequest extends Request
{
    protected $form = 'EditProfileForm';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::guest()) {
            return false;
        }

        return parent::authorize();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users,email,'.Auth::user()->id,
            'new_password' => 'confirmed|min:6',
        ];
    }
}
