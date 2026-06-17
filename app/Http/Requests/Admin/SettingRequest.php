<?php

namespace DomainProvider\Http\Requests\Admin;

use DomainProvider\Http\Requests\Admin\BaseRequest;
use Illuminate\Support\Str;

class SettingRequest extends BaseRequest
{
    protected $form = 'Admin\SettingForm';

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->getMethod()) {
            case 'PUT':
                return [
                    'page_title' => 'required|max:255',
                    'lead_text' => 'required|max:255',
                    'middle_title' => 'required|max:255',
                    'middle_body' => 'required|max:255',
                    'domain_min_chars' => 'required|numeric|min:0|max:255',
                    'domain_max_chars' => 'required|numeric|min:0|max:255',
                    'domain_registration_year' => 'required|numeric|min:1|max:10',
                    'footer_left_title' => 'max:255',
                    'footer_right_title' => 'max:255',
                    'footer_social_title' => 'max:255',
                    'footer_social_facebook' => 'max:255',
                    'footer_social_twitter' => 'max:255',
                    'footer_social_pinterest' => 'max:255',
                    'footer_social_linkedin' => 'max:255',
                    'footer_social_instagram' => 'max:255',
                    'footer_social_youtube' => 'max:255',
                ];
                break;
        }
    }
}
