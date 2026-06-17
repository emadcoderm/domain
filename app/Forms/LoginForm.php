<?php

namespace DomainProvider\Forms;

use Kris\LaravelFormBuilder\Form;

class LoginForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('email', 'email', [
                'label' => trans('front.log_in.field_email'),
                'required' => true,
            ])
            ->add('password', 'password', [
                'label' => trans('front.log_in.field_password'),
                'required' => true,
            ])
            ->add('remember', 'checkbox', [
                'label' => trans('front.log_in.field_remember_me'),
                'default_value' => 1,
                'checked' => false
            ])
            ->add('login', 'submit', [
                'label' => trans('button.login')
            ]);
    }
}
