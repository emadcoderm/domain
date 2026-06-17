<?php

namespace DomainProvider\Http\Requests;

use DomainProvider\Http\Requests\Request;
use Setting;

class LoginRequest extends Request
{
    protected $form = 'LoginForm';

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
            'email' => 'required|email',
            'password' => 'required',
        ];

        if (true === Setting::get('captcha_on_login') && env('NOCAPTCHA_SITEKEY') && env('NOCAPTCHA_SECRET')) {
            $rules['g-recaptcha-response'] = 'required|captcha';
        }

        return $rules;
    }
}
