<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;

class UserRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\User';
    }

    public function update(array $data, $id, $attribute = 'id')
    {
        if (isset($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }

        parent::update($data, $id, $attribute);
    }

    public function findForList()
    {
        return $this->model->with(['userDomains'])
            ->orderBy('id', 'desc');
    }
}
