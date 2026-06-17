<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class ZoneForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => trans('admin.zone.field_name'),
            ])
            ->add('api_key_id', 'entity', [
                'label' => trans('admin.zone.field_api_key'),
                'class' => 'DomainProvider\Models\ApiKey',
                'property' => 'email',
                'property_key' => 'id',
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);
    }
}
