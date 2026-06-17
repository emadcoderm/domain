<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use DomainProvider\Models\Zone;

class BlacklistDomainRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\BlacklistDomain';
    }

    public function findForList()
    {
        return $this->model->with(['zone'])
            ->orderBy('zone_id', 'asc')
            ->orderBy('id', 'desc');
    }

    public function findOneByNameAndZone($name, Zone $zone)
    {
        return $this->model->where('name', '=', $name)
            ->where(function ($q) use ($zone) {
                $q->where('zone_id', '=', $zone->id)
                    ->orWhere('zone_id', null);
            })
            ->first();
    }
}
