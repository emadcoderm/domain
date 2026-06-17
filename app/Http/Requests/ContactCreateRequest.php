<?php

namespace DomainProvider\Http\Requests;

use DomainProvider\Http\Requests\Request;

class ContactCreateRequest extends Request
{
    protected $form = 'ContactForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required',
            'email' => 'required|email|max:255',
            'message' => 'required',
        ];
    }
}
