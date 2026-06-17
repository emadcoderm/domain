<?php

namespace DomainProvider\Services;

use DomainProvider\Repositories\SettingRepository;

class Setting
{
    private $setting = [];

    public function __construct(SettingRepository $repository)
    {
        $setting = $repository->findOneForGlobal();
        if ($setting) {
            $this->setting = $setting;
        }
    }

    /**
     * get App setting by key
     *
     * @return string|integer
     */
    public function get($key)
    {
        if (isset($this->setting->{$key})) {
            return $this->setting->{$key};
        }

        return null;
    }
}
