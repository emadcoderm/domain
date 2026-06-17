<?php

namespace DomainProvider\Http\Controllers\Front;

use Auth;
use Cloudflare;
use Domain;
use DomainProvider\Exceptions\CloudflareException;
use DomainProvider\Exceptions\DomainNotAvailableException;
use DomainProvider\Http\Controllers\Controller;
use DomainProvider\Http\Requests\DnsRequest;
use DomainProvider\Http\Requests\DomainCreateRequest;
use DomainProvider\Repositories\DnsRecordRepository;
use DomainProvider\Repositories\UserDomainRepository;
use DomainProvider\Repositories\UserRepository;
use DomainProvider\Repositories\ZoneRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Kris\LaravelFormBuilder\FormBuilder;
use Setting;

class DomainController extends Controller
{
    private $domainRepository;
    private $dnsRepository;
    private $userRepository;
    private $zoneRepository;

    /**
     * [DependencyInjection]
     *
     * @param UserDomainRepository $domainRepository
     * @param DnsRecordRepository $dnsRepository
     * @param UserRepository $userRepository
     * @param ZoneRepository $zoneRepository
     */
    public function __construct(
        UserDomainRepository $domainRepository,
        DnsRecordRepository $dnsRepository,
        UserRepository $userRepository,
        ZoneRepository $zoneRepository
    ) {
        $this->domainRepository = $domainRepository;
        $this->dnsRepository = $dnsRepository;
        $this->userRepository = $userRepository;
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Display a listing of the User Domain.
     *
     * @return Response
     */
    public function getList()
    {
        $domains = $this->domainRepository->findForList();

        return view('front.domain.list', compact('domains'));
    }

    /**
     * Show the form for creating a new User Domain.
     *
     * @param FormBuilder $formBuilder
     * @param Request $request
     * @return Response
     */
    public function getCreate(FormBuilder $formBuilder, Request $request)
    {
        $form = $formBuilder->create('DomainForm', [
            'method' => 'POST',
            'url' => route('user.domain.create')
        ]);

        return view('front.domain.create', compact('form', 'request'));
    }

    /**
     * Store a newly created User Domain in storage.
     *
     * @param DomainCreateRequest $request
     * @return Response
     */
    public function postCreate(DomainCreateRequest $request)
    {
        try {
            $zone = $this->zoneRepository->findOneByEnabled($request->zone_id, ['id']);
            Domain::checkDomainAvailability($request->name, $zone);
        } catch (DomainNotAvailableException $e) {
            return back()
                ->withInput($request->only('name', 'zone_id'))
                ->withErrors([
                    'name' => $e->getMessage(),
                ]);
        }

        // just save to database
        $userDomain = $request->only('name', 'zone_id');
        $userDomain['user_id'] = Auth::user()->id;
        $expired = sprintf("P%dY", (int) Setting::get('domain_registration_year'));
        $userDomain['expired_at'] = (new \DateTime())->add(new \DateInterval($expired));

        $newDomain = $this->domainRepository->create($userDomain);

        // add user domains_total
        $datas = ['domains_total' => Auth::user()->domains_total + 1];
        $this->userRepository->update($datas, Auth::user()->id);

        return redirect()
            ->route('user.domain.list')
            ->with('success', trans('front.domain.success_register', [
                'domain_name' => $newDomain->complete_domain_name
            ]));
    }

    /**
     * Remove the specified API Key from storage.
     *
     * @param string $domainName
     * @return Response
     */
    public function deleteDomain($domainName)
    {
        // validate domain name
        $domain = Domain::isDomainValid($domainName);
        if (false === $domain) {
            abort(404);
        }

        $dnsRecords = $this->dnsRepository->findByDomain($domain);

        if (count($dnsRecords) > 0) {
            // remove all the dns
            $complete = true;
            foreach ($dnsRecords as $dnsRecord) {
                try {
                    // delete to cloudflare server
                    $cfDns = Cloudflare::deleteDnsRecord($domain->zone, $dnsRecord->cf_id);

                    // delete dns record
                    if ($cfDns->id === $dnsRecord->cf_id) {
                        $this->dnsRepository->delete($dnsRecord->id);
                    }
                } catch (CloudflareException $e) {
                    $complete = false;
                    break;
                }
            }

            if ($complete) {
                // last, delete the domain
                $this->domainRepository->delete($domain->id);

                // sub user domains_total
                $datas = ['domains_total' => Auth::user()->domains_total - 1];
                $this->userRepository->update($datas, Auth::user()->id);
            }
        } else {
            // just remove the domain
            $this->domainRepository->delete($domain->id);
        }

        return redirect(route('user.domain.list'))
            ->with('success', trans('front.domain.success_delete', [
                'domain_name' => $domain->complete_domain_name
            ]));
    }

    /**
     * Render Manage Domain page
     *
     * @param string $domainName
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getManage($domainName, FormBuilder $formBuilder)
    {
        // validate domain name
        $domain = Domain::isDomainValid($domainName);
        if (false === $domain) {
            abort(404);
        }

        $form = $formBuilder->create('DnsForm', [
            'method' => 'POST',
            'url' => route('user.domain.dns.create', ['domainName' => $domainName])
        ]);

        $dnsystems = $this->dnsRepository->findForList($domain);

        foreach ($dnsystems as $dns) {
            $formEdit = $formBuilder->create('DnsForm', [
                'method' => 'PUT',
                'model' => $dns,
                'url' => route('user.domain.dns.update', ['domainName' => $domainName, 'id' => $dns->id]),
            ]);

            $dns->setFormEdit($formEdit);
        }

        return view('front.domain.manage', compact('domainName', 'form', 'dnsystems'));
    }

    /**
     * Show the form for creating a new DNS Record for Domain.
     *
     * @param string $domainName
     * @param  DnsRequest $request
     * @return Response
     */
    public function postCreateDns($domainName, DnsRequest $request)
    {
        // validate domain name
        $domain = Domain::isDomainValid($domainName);
        if (false === $domain) {
            abort(404);
        }

        // check dns total, if dns_per_domain = 0 (unlimited) then dont check
        $dnsTotal = $domain->dnsRecords->count();
        if (Setting::get('dns_per_domain') > 0) {
            if ($dnsTotal > Setting::get('dns_per_domain')) {
                return back()->withInput()
                    ->withErrors([
                        trans('front.dns.reach_max_domain_dns'),
                    ]);
            }
        }

        try {
            $datas = $request->except(['_token']);
            if ('@' === $datas['name']) {
                $datas['name'] = $domainName;
            } else {
                $datas['name'] .= '.'.$domainName;
            }

            $cfDns = Cloudflare::createDnsRecord($domain->zone, $datas);

            $dnsRecord = $request->all();
            $dnsRecord['name'] = $datas['name'];
            $dnsRecord['cf_id'] = $cfDns->id;
            $dnsRecord['zone_id'] = $domain->zone->id;
            $dnsRecord['user_domain_id'] = $domain->id;

            $this->dnsRepository->create($dnsRecord);

            return redirect(route('user.domain.manage', ['domainName' => $domainName]))
                ->with('success', trans('front.dns.success_add'));
        } catch (CloudflareException $e) {
            return back()->withInput()
                ->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        } catch (\Exceptions $e) {
            return back()->withInput()
                ->withErrors([
                    trans('front.error.please_contact_admin'),
                ]);
        }
    }

    /**
     * Update the specified DNS Record for Domain in storage.
     * @param string $domainName
     * @param DnsRequest $request
     * @param int $id
     * @return Response
     */
    public function postUpdateDns($domainName, DnsRequest $request, $id)
    {
        // validate domain name
        $domain = Domain::isDomainValid($domainName);
        if (false === $domain) {
            abort(404);
        }

        // validate dns
        $dns = $this->dnsRepository->isValidDns($domain, $id);
        if (is_null($dns)) {
            abort(404);
        }

        try {
            $datas = $request->except(['_token', '_method']);
            if ('@' === $datas['name']) {
                $datas['name'] = $domainName;
            } else {
                $datas['name'] .= '.'.$domainName;
            }

            $cfDns = Cloudflare::updateDnsRecord($domain->zone, $dns->cf_id, $datas);

            $dnsUpdate = $request->except(['_token', '_method']);
            $dnsUpdate['name'] = $datas['name'];
            $this->dnsRepository->update($dnsUpdate, $id);

            return redirect(route('user.domain.manage', ['domainName' => $domainName]))
                ->with('success', trans('front.dns.success_update'));
        } catch (CloudflareException $e) {
            return back()->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        } catch (\Exceptions $e) {
            return back()->withErrors([
                    trans('front.error.please_contact_admin'),
                ]);
        }
    }

    /**
     * Remove the specified DNS Record for Domain from storage.
     *
     * @param string $domainName
     * @param int $id
     * @return Response
     */
    public function deleteDns($domainName, $id)
    {
        // validate domain name
        $domain = Domain::isDomainValid($domainName);
        if (false === $domain) {
            abort(404);
        }

        // validate dns
        $dns = $this->dnsRepository->isValidDns($domain, $id);
        if (is_null($dns)) {
            abort(404);
        }

        try {
            $cfDns = Cloudflare::deleteDnsRecord($domain->zone, $dns->cf_id);

            if ($cfDns->id === $dns->cf_id) {
                $this->dnsRepository->delete($id);
            }

            return redirect(route('user.domain.manage', ['domainName' => $domainName]))
                ->with('success', trans('front.dns.success_delete'));
        } catch (CloudflareException $e) {
            return back()->withInput()
                ->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        } catch (\Exceptions $e) {
            return back()->withInput()
                ->withErrors([
                    trans('front.error.please_contact_admin'),
                ]);
        }
    }
}
