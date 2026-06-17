<?php

namespace DomainProvider\Http\Requests;

use DomainProvider\Http\Requests\Request;
use Setting;

class RegistrationRequest extends Request
{
    protected $form = 'RegisterForm';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::user()) {
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
        $rules = [
            'full_name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ];

        if (true === Setting::get('captcha_on_register') && env('NOCAPTCHA_SITEKEY') && env('NOCAPTCHA_SECRET')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }
}
