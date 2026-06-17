<?php

namespace DomainProvider\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

abstract class Request extends FormRequest
{
    protected $form;

    /**
     * validate no additional field of the request
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->form) {
            $requestFields = array_keys($this->all());
            $formFields = array_keys(\FormBuilder::create($this->form)->getFields());
            array_push($formFields, '_token', '_method', '_wysihtml5_mode', 'g-recaptcha-response');

            // valid if no additional fields
            $diff = array_diff($requestFields, $formFields);
            if (empty($diff)) {
                return true;
            }
        }

        return false;
    }

    /**
     * abort if request not authorize
     *
     * @return Response
     */
    public function forbiddenResponse()
    {
        abort(403);
    }

    /**
     * Attributes name from field label
     *
     * @return [string]
     */
    public function attributes()
    {
        if ($this->form) {
            $attributes = [];

            $formFields = \FormBuilder::create($this->form)->getFields();
            foreach ($formFields as $name => $fields) {
                if ($fields->getOptions()['label']) {
                    $attributes[$name] = $fields->getOptions()['label'];
                }
            }

            return $attributes;
        }

        return [];
    }
}
