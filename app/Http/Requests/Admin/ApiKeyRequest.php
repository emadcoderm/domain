<?php

namespace DomainProvider\Http\Requests\Admin;

use DomainProvider\Http\Requests\Admin\BaseRequest;

class ApiKeyRequest extends BaseRequest
{
    protected $form = 'Admin\ApiKeyForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case 'POST':

                return [
                    'email' => 'required|email|unique:api_keys,email',
                    'api_key' => 'required',
                ];
                break;

            case 'PUT':
                $except = $this->route()->getParameter('apikey')->id;

                return [
                    'email' => 'required|email|unique:api_keys,email,'.$except,
                    'api_key' => 'required',
                ];
                break;
        }
    }
}
