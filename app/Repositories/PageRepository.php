<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class PageRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\Page';
    }

    public function findForList()
    {
        return $this->model->orderBy('id', 'desc');
    }
}
