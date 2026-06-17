<?php

namespace DomainProvider\Http\Requests;

use Auth;
use DomainProvider\Http\Requests\Request;

class DomainCreateRequest extends Request
{
    protected $form = 'DomainForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|alpha_num|max:200',
            'zone_id' => 'required|exists:zones,id'
        ];
    }
}
