<?php

namespace DomainProvider\Forms\Admin;

use Kris\LaravelFormBuilder\Form;

class ZoneEditForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => trans('admin.zone.field_name'),
                'attr' => [
                    'disabled' => 'disabled',
                ],
            ])
            ->add('api_key_id', 'entity', [
                'label' => trans('admin.zone.field_api_key'),
                'class' => 'DomainProvider\Models\ApiKey',
                'property' => 'email',
                'property_key' => 'id',
                'attr' => [
                    'disabled' => 'disabled',
                ],
            ])
            ->add('ns1', 'text', [
                'label' => trans('admin.zone.field_name_server_1'),
                'attr' => [
                    'disabled' => 'disabled',
                ],
            ])
            ->add('ns2', 'text', [
                'label' => trans('admin.zone.field_name_server_2'),
                'attr' => [
                    'disabled' => 'disabled',
                ],
            ])
            ->add('totalDomains', 'number', [
                'label' => trans('admin.zone.field_total_domains'),
                'attr' => [
                    'disabled' => 'disabled',
                ],
            ])
            ->add('enabled', 'checkbox', [
                'label' => trans('admin.zone.field_enabled'),
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
