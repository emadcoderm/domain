<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class ContactRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\Contact';
    }

    public function getCountUnread()
    {
        return $this->model->whereSeen(0)->count();
    }

    public function findForList()
    {
        return $this->model->orderBy('seen', 'asc')
            ->orderBy('created_at', 'desc');
    }
}
