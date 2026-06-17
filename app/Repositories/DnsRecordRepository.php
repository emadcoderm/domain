<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use DomainProvider\Models\UserDomain;
use DomainProvider\Models\Zone;

class DnsRecordRepository extends Repository
{
    /**
     * @Override
     */
    public function model()
    {
        return 'DomainProvider\Models\DnsRecord';
    }

    /**
     * Use for list on manage domain
     * @param  UserDomain $userDomain
     * @return [DnsRecord]
     */
    public function findForList(UserDomain $userDomain)
    {
        return $this->model
            ->where('zone_id', '=', $userDomain->zone_id)
            ->where('user_domain_id', '=', $userDomain->id)
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function isValidDns(UserDomain $userDomain, $dnsId)
    {
        return $this->model
            ->where('id', '=', $dnsId)
            ->where('zone_id', '=', $userDomain->zone_id)
            ->where('user_domain_id', '=', $userDomain->id)
            ->first();
    }

    public function findByDomain(UserDomain $userDomain)
    {
        return $this->model->where('user_domain_id', '=', $userDomain->id)
            ->where('zone_id', '=', $userDomain->zone_id)
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function findForZone(Zone $zone)
    {
        return $this->model->where('zone_id', '=', $zone->id)
            ->where('user_domain_id', null)
            ->orderBy('id', 'desc')
            ->paginate();
    }

    public function findByNameAndZone($name, Zone $zone)
    {
        return $this->model->where('name', '=', $name)
            ->where('zone_id', '=', $zone->id)
            ->get();
    }
}
