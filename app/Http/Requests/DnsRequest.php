<?php

namespace DomainProvider\Http\Requests;

use DomainProvider\Http\Requests\Request;
use Illuminate\Support\Str;
use Validator;

class DnsRequest extends Request
{
    protected $form = 'DnsForm';

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if (\Auth::guest()) {
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
            'type' => 'required|in:A,AAAA,CNAME,TXT,NS,MX',
            'name' => 'required|max:255',
            'ttl' => 'in:1,120,300,600,900,1800,3600,7200,18000,43200,86400',
        ];

        switch ($this->type) {
            case 'A':
                $rules['content'] = 'required|ipv4';
                break;
            case 'AAAA':
                $rules['content'] = 'required|ipv6';
                break;
            case 'CNAME':
                $rules['content'] = 'required';
                break;
            case 'TXT':
                $rules['content'] = 'required|max:255';
                break;
            case 'NS':
                $rules['content'] = 'required';
                break;
            case 'MX':
                $rules['priority'] = 'required|numeric|min:0|max:65535';
                $rules['content'] = 'required';
                break;
        }

        return $rules;
    }
}
