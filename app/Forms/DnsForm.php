<?php

namespace DomainProvider\Forms;

use Kris\LaravelFormBuilder\Form;

class DnsForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('type', 'choice', [
                'choices' => [
                    'A' => 'A',
                    'AAAA' => 'AAAA',
                    'CNAME' => 'CNAME',
                    'NS' => 'NS',
                    'MX' => 'MX',
                    'TXT' => 'TXT',
                    // 'LOC' => 'LOC',
                    // 'SRV' => 'SRV',
                    // 'SPF' => 'SPF',
                ],
                'label' => false,
                'attr' => [
                    'class' => 'form-control dns-type',
                ],
                'required' => true,
            ])
            ->add('name', 'text', [
                'label' => false,
                'attr' => [
                    'maxlength' => '255',
                    'placeholder' => trans('front.dns.field_name'),
                ],
                'required' => true,
            ])
            ->add('content', 'text', [
                'label' => false,
                'attr' => [
                    'maxlength' => '255',
                    'placeholder' => trans('front.dns.field_content'),
                ],
                'required' => true,
            ])
            ->add('ttl', 'choice', [
                'choices' => [
                    '1' => trans('domain.dns_ttl.1'),
                    '120' => trans('domain.dns_ttl.120'),
                    '300' => trans('domain.dns_ttl.300'),
                    '600' => trans('domain.dns_ttl.600'),
                    '900' => trans('domain.dns_ttl.900'),
                    '1800' => trans('domain.dns_ttl.1800'),
                    '3600' => trans('domain.dns_ttl.3600'),
                    '7200' => trans('domain.dns_ttl.7200'),
                    '18000' => trans('domain.dns_ttl.18000'),
                    '43200' => trans('domain.dns_ttl.43200'),
                    '86400' => trans('domain.dns_ttl.86400'),
                ],
                'label' => false,
                'required' => true,
            ])
            ->add('priority', 'number', [
                'label' => false,
                'attr' => [
                    'min' => '0',
                    'max' => '65535',
                    'placeholder' => trans('front.dns.field_priority'),
                    'class' => 'form-control dns-priority',
                ],
                'required' => true,
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-action btn-normal',
                ],
            ]);
    }
}
