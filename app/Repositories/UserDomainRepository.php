<?php

namespace DomainProvider\Repositories;

use Auth;
use Bosnadev\Repositories\Eloquent\Repository;
use DomainProvider\Models\User;
use DomainProvider\Models\Zone;

class UserDomainRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\UserDomain';
    }

    public function findForList()
    {
        return $this->model->with(['zone'])
            ->where('user_id', '=', Auth::user()->id)
            ->orderBy('id', 'desc')
            ->paginate();
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

    public function findByUser(User $user)
    {
        return $this->model->with(['zone', 'dnsRecords'])
            ->where('user_id', '=', $user->id)
            ->orderBy('id', 'desc')
            ->paginate();
    }
}
