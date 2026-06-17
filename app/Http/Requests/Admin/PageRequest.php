<?php

namespace DomainProvider\Http\Requests\Admin;

use DomainProvider\Http\Requests\Admin\BaseRequest;
use Illuminate\Support\Str;

class PageRequest extends BaseRequest
{
    protected $form = 'Admin\PageForm';

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
                    'title' => 'required|max:255|unique:pages',
                    'content' => 'required',
                ];
                break;

            case 'PUT':
                $except = $this->route()->getParameter('page')->id;

                return [
                    'title' => 'required|max:255',
                    'slug' => 'max:255|unique:pages,slug,'.$except,
                    'content' => 'required',
                ];
                break;
        }
    }
}
