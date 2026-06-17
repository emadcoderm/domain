<?php

namespace DomainProvider\Forms;

use Kris\LaravelFormBuilder\Form;

class RegisterForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('full_name', 'text', [
                'label' => trans('front.sign_up.field_full_name'),
                'required' => true,
            ])
            ->add('email', 'email', [
                'label' => trans('front.sign_up.field_email'),
                'required' => true,
            ])
            ->add('password', 'password', [
                'label' => trans('front.sign_up.field_password'),
                'required' => true,
            ])
            ->add('password_confirmation', 'password', [
                'label' => trans('front.sign_up.field_password_confirmation'),
                'required' => true,
            ])
            ->add('register', 'submit', [
                'label' => trans('button.register'),
            ]);
    }
}
