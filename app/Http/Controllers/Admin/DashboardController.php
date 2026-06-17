<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Repositories\DnsRecordRepository;
use DomainProvider\Repositories\UserDomainRepository;
use DomainProvider\Repositories\UserRepository;
use DomainProvider\Repositories\ZoneRepository;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    private $dnsRepository;
    private $domainRepository;
    private $userRepository;
    private $zoneRepository;

    /**
     * [DependencyInjection]
     *
     * @param DnsRecordRepository $dnsRepository
     * @param UserDomainRepository $domainRepository
     * @param UserRepository $userRepository
     * @param ZoneRepository $zoneRepository
     */
    public function __construct(
        DnsRecordRepository $dnsRepository,
        UserDomainRepository $domainRepository,
        UserRepository $userRepository,
        ZoneRepository $zoneRepository
    ) {
        $this->dnsRepository = $dnsRepository;
        $this->domainRepository = $domainRepository;
        $this->userRepository = $userRepository;
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Render dashboard view
     *
     * @return Response
     */
    public function index()
    {
        $zonesCount = $this->zoneRepository->all(['id'])->count();
        $usersCount = $this->userRepository->all(['id'])->count();
        $domainsCount = $this->domainRepository->all(['id'])->count();
        $dnsCount = $this->dnsRepository->all(['id'])->count();

        return view('admin.dashboard', compact('zonesCount', 'usersCount', 'domainsCount', 'dnsCount'));
    }
}
