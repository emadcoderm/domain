<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ApiKeyRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\ApiKey';
    }

    public function findForList()
    {
        return $this->model->with(['zones'])
            ->orderBy('id', 'desc');
    }
}
