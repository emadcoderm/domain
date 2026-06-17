<?php

namespace DomainProvider\Forms;

use Kris\LaravelFormBuilder\Form;

class ContactForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => trans('front.contact.field_full_name'),
                'required' => true,
            ])
            ->add('email', 'email', [
                'label' => trans('front.contact.field_email'),
                'required' => true,
            ])
            ->add('message', 'textarea', [
                'label' => trans('front.contact.field_message'),
                'required' => true,
            ])
            ->add('send', 'submit', [
                'label' => trans('button.send'),
                'attr' => [
                    'class' => 'btn btn-action'
                ]
            ]);
    }
}
