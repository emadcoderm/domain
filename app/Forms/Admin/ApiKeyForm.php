<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class ApiKeyForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'email', [
                'label' => trans('admin.apikey.field_email'),
                'required' => true,
            ])
            ->add('api_key', 'text', [
                'label' => trans('admin.apikey.field_key'),
                'required' => true,
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);
    }
}
