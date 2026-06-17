<?php

namespace DomainProvider\Repositories;

use Bosnadev\Repositories\Eloquent\Repository;
use Cache;

class SettingRepository extends Repository
{
    public function model()
    {
        return 'DomainProvider\Models\Setting';
    }

    public function findOneForList()
    {
        return $this->model->first();
    }

    public function findOneForGlobal()
    {
        $setting = Cache::remember('settings', env('CACHE_REMEMBER', 10), function () {
            return $this->model->first();
        });

        return $setting;
    }
}
