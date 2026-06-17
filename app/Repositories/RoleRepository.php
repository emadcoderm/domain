<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class RoleRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\Role';
    }
}
