<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class PageForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('title', 'text', [
                'label' => trans('admin.page.field_title'),
                'required' => true,
            ])
            ->add('slug', 'text', [
                'label' => trans('admin.page.field_slug'),
            ])
            ->add('content', 'textarea', [
                'label' => trans('admin.page.field_content'),
                'required' => true,
                'attr' => [
                    'class' => 'form-control whtml5',
                ]
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);
    }
}
