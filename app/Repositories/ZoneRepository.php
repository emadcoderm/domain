<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use DomainProvider\Models\Zone;

class ZoneRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\Zone';
    }

    public function findForList()
    {
        return $this->model->with(['apiKey', 'userDomains'])
            ->orderBy('id', 'desc');
    }

    public function findOneByEnabled($id, array $fields = ['*'])
    {
        return $this->model->where('enabled', true)
            ->where('id', $id)
            ->first($fields);
    }

    public function findOneForShow(Zone $zone)
    {
        return $this->model->with(['userDomains.user', 'userDomains.dnsRecords'])
            ->where('id', '=', $zone->id)
            ->first();
    }
}
