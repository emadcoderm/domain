<?php

namespace DomainProvider\Forms;

use Kris\LaravelFormBuilder\Form;

class EditProfileForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('full_name', 'text', [
                'label' => trans('front.profile.field_full_name'),
            ])
            ->add('email', 'email', [
                'label' => trans('front.profile.field_email'),
            ])
            ->add('new_password', 'password', [
                'label' => trans('front.profile.field_new_password'),
            ])
            ->add('new_password_confirmation', 'password', [
                'label' => trans('front.profile.field_new_password_confirmation'),
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-action'
                ],
            ]);
    }
}
