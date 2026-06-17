<?php

namespace DomainProvider\Http\Requests\Admin;

use Auth;
use DomainProvider\Http\Requests\Request;

class BaseRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (!Auth::user()->isAdmin()) {
            return false;
        }

        return parent::authorize();
    }
}
