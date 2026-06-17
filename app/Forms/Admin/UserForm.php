<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class UserForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('full_name', 'text', [
                'label' => trans('admin.user.field_full_name'),
            ])
            ->add('email', 'email', [
                'label' => trans('admin.user.field_email'),
            ])
            ->add('new_password', 'password', [
                'label' => trans('admin.user.field_new_password'),
            ])
            ->add('new_password_confirmation', 'password', [
                'label' => trans('admin.user.field_new_password_confirmation'),
            ])
            ->add('enabled', 'checkbox', [
                'label' => trans('admin.user.field_enabled'),
                'value' => 1,
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);
    }
}
