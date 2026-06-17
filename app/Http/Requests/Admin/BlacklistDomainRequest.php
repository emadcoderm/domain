<?php

namespace DomainProvider\Http\Requests\Admin;

use DomainProvider\Http\Requests\Admin\BaseRequest;

class BlacklistDomainRequest extends BaseRequest
{
    protected $form = 'Admin\BlacklistDomainForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case 'POST':
                if ('0' === $this->zone_id) {
                    return [
                        'zone_id' => 'required|numeric',
                        'name' => 'required|max:200|unique:blacklist_domains,name,null,id,zone_id,NULL',
                    ];
                } else {
                    return [
                        'zone_id' => 'required|numeric',
                        'name' => 'required|max:200|unique:blacklist_domains,name,null,id,zone_id,'.$this->zone_id,
                    ];
                }

                break;

            case 'PUT':
                $except = $this->route()->getParameter('blacklist_domain')->id;

                if ('0' === $this->zone_id) {
                    return [
                        'zone_id' => 'required|numeric',
                        'name' => 'required|max:200|unique:blacklist_domains,name,'.$except.',id,zone_id,NULL',
                    ];
                } else {
                    return [
                        'zone_id' => 'required|numeric',
                        'name' => 'required|max:200|unique:blacklist_domains,name,'.$except.',id,zone_id,'.$this->zone_id,
                    ];
                }
                break;
        }
    }
}
