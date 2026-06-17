<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class ContactForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => trans('admin.contact.field_from'),
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ])
            ->add('email', 'email', [
                'label' => trans('admin.contact.field_email'),
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ])
            ->add('message', 'textarea', [
                'label' => trans('admin.contact.field_message'),
                'attr' => [
                    'readonly' => 'readonly'
                ]
            ]);
    }
}
