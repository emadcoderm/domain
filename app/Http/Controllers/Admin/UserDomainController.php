<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Models\User;
use DomainProvider\Models\UserDomain;
use DomainProvider\Repositories\DnsRecordRepository;

class UserDomainController extends BaseController
{
    private $dnsRecordRepository;

    /**
     * [DependencyInjection]
     *
     * @param DnsRecordRepository $dnsRecordRepository
     */
    public function __construct(DnsRecordRepository $dnsRecordRepository)
    {
        $this->dnsRecordRepository = $dnsRecordRepository;
    }

    /**
     * Display a listing of the User Domain.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new User Domain.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created User Domain in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }

    /**
     * Display the specified User Domain.
     *
     * @param  User       $user
     * @param  UserDomain $userDomain
     * @return Response
     */
    public function show(User $user, UserDomain $userDomain)
    {
        if ($userDomain->user_id !== $user->id) {
            abort(404);
        }

        $dnsRecords = $this->dnsRecordRepository->findByDomain($userDomain);

        return view('admin.user-domain.show', compact('userDomain', 'dnsRecords'));
    }

    /**
     * Show the form for editing the specified User Domain.
     *
     * @param  User       $user
     * @param  UserDomain $userDomain
     * @return Response
     */
    public function edit(User $user, UserDomain $userDomain)
    {
        //
    }

    /**
     * Update the specified User Domain in storage.
     *
     * @param  User       $user
     * @param  UserDomain $userDomain
     * @return Response
     */
    public function update(User $user, UserDomain $userDomain)
    {
        //
    }

    /**
     * Remove the specified User Domain from storage.
     *
     * @param  User       $user
     * @param  UserDomain $userDomain
     * @return Response
     */
    public function destroy(User $user, UserDomain $userDomain)
    {
        //
    }
}
