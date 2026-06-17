<?php

namespace DomainProvider\Http\Requests\Admin;

use DomainProvider\Http\Requests\Admin\BaseRequest;
use Illuminate\Support\Str;

class UserRequest extends BaseRequest
{
    protected $form = 'Admin\UserForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case 'POST':
                return [];
                break;

            case 'PUT':
                $except = $this->route()->getParameter('user')->id;

                return [
                    'full_name' => 'required|max:255',
                    'email' => 'required|email|max:255|unique:users,email,'.$except,
                    'new_password' => 'confirmed|min:6',
                ];
                break;
        }
    }
}
