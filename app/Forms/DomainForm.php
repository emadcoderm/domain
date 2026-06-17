<?php

namespace DomainProvider\Forms;

use Cache;
use DomainProvider\Models\Zone;
use Kris\LaravelFormBuilder\Form;

class DomainForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => trans('front.domain.domain_name'),
                'required' => true,
                'attr' => [
                    'class' => 'form-control col-md-4'
                ],
            ])
            ->add('zone_id', 'entity', [
                'label' => trans('front.domain.domain_extension'),
                'class' => 'DomainProvider\Models\Zone',
                'property' => 'name',
                'property_key' => 'id',
                'query_builder' => function (Zone $zone) {
                    $dbZones = Cache::remember('enabled_zones', env('CACHE_REMEMBER', 10), function () use ($zone) {
                        return $zone::where('enabled', true)->get();
                    });

                    $zones = new \Illuminate\Database\Eloquent\Collection();
                    foreach ($dbZones as $zone) {
                        $zone->name = '.'.$zone->name;
                        $zones->add($zone);
                    }

                    return $zones;
                },
                'attr' => [
                    'class' => 'selectpicker form-control'
                ],
            ])
            ->add('submit', 'submit', [
                'label' => trans('button.register'),
                'attr' => [
                    'class' => 'btn btn-action btn-lg-normal'
                ]
            ]);
    }
}
