<?php

namespace DomainProvider\Forms\Admin;

use DomainProvider\Repositories\ZoneRepository;
use Kris\LaravelFormBuilder\Form;

class BlacklistDomainForm extends Form
{
    private $repository;

    public function __construct(ZoneRepository $repository)
    {
        $this->repository = $repository;
    }

    public function buildForm()
    {
        $zones = $this->repository->all();
        $zonesList = ['0' => trans('admin.blacklist_domain.global')];
        foreach ($zones as $zone) {
            $zonesList[$zone->id] = $zone->name;
        }

        $this
            ->add('name', 'text', [
                'label' => trans('admin.blacklist_domain.field_name'),
            ])
            ->add('zone_id', 'choice', [
                'label' => trans('admin.blacklist_domain.field_zone'),
                'choices' => $zonesList,
                'multiple' => false,
            ])
            ->add('reason', 'textarea', [
                'label' => trans('admin.blacklist_domain.field_reason'),
            ])
            ->add('save', 'submit', [
                'label' => trans('button.save'),
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
            ]);
    }
}
