<?php

namespace DomainProvider\Http\Requests\Admin;

use DomainProvider\Http\Requests\Admin\BaseRequest;

class ZoneCreateRequest extends BaseRequest
{
    protected $form = 'Admin\ZoneForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|max:253|unique:zones,name|regex:/^((?!-)[A-Za-z0-9-]{1,63}(?<!-)\\.)+[A-Za-z]{2,6}$/',
            'api_key_id' => 'required|exists:api_keys,id',
        ];
    }
}
