<?php

namespace DomainProvider\Services;

use Auth;
use DomainProvider\Exceptions\DomainNotAvailableException;
use DomainProvider\Models\Zone;
use DomainProvider\Repositories\BlacklistDomainRepository;
use DomainProvider\Repositories\UserDomainRepository;
use DomainProvider\Repositories\UserRepository;
use DomainProvider\Repositories\ZoneRepository;
use Setting;

class Domain
{
    private $domainRepository;
    private $blacklistDomainRepository;
    private $userRepository;
    private $zoneRepository;

    public function __construct(
        BlacklistDomainRepository $blacklistDomainRepository,
        UserDomainRepository $domainRepository,
        UserRepository $userRepository,
        ZoneRepository $zoneRepository
    ) {
        $this->blacklistDomainRepository = $blacklistDomainRepository;
        $this->domainRepository = $domainRepository;
        $this->userRepository = $userRepository;
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Check is the domain valid or not
     *
     * @param  string  $domainName
     * @return UserDomain|boolean
     */
    public function isDomainValid($domainName)
    {
        if (!is_string($domainName)) {
            return false;
        }

        if (strlen($domainName) !== strlen(parse_url($domainName, PHP_URL_PATH))) {
            return false;
        }

        $name = array_shift((explode('.', $domainName)));
        $domain = $this->domainRepository->findBy('name', $name);
        if (is_null($domain)) {
            return false;
        }

        if (Auth::user()) {
            if (Auth::user()->id !== $domain->user_id) {
                return false;
            }
        }
        if ($name . '.' . $domain->zone->name !== $domainName) {
            return false;
        }

        return $domain;
    }

    /**
     * Check domain availability
     * @param  string $name
     * @param  Zone   $zone
     * @return boolean
     */
    public function checkDomainAvailability($name, Zone $zone)
    {
        /**
         * check domain availbility
         * 1. check to blacklist_domains
         * 2. check to user_domains
         */
        $blacklistDomain = $this->blacklistDomainRepository->findOneByNameAndZone($name, $zone);
        if (!is_null($blacklistDomain)) {
            // throw exception - the domain blacklist
            throw new DomainNotAvailableException(trans('domain.not_available'));
        }

        $takenDomain = $this->domainRepository->findOneByNameAndZone($name, $zone);
        if (!is_null($takenDomain)) {
            // throw exception - the domain already taken
            throw new DomainNotAvailableException(trans('domain.already_taken'));
        }

        if (strlen($name) < Setting::get('domain_min_chars')) {
            throw new DomainNotAvailableException(trans('domain.minimum_chars', ['min' => Setting::get('domain_min_chars')]));
        }

        if (strlen($name) > Setting::get('domain_max_chars')) {
            throw new DomainNotAvailableException(trans('domain.maximum_chars', ['max' => Setting::get('domain_max_chars')]));
        }

        return true;
    }
}
