<?php

namespace DomainProvider\Http\Controllers\Admin;

use Cloudflare;
use DomainProvider\Exceptions\CloudflareException;
use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Http\Requests\Admin\ZoneCreateRequest;
use DomainProvider\Http\Requests\DnsRequest;
use DomainProvider\Models\DnsRecord;
use DomainProvider\Models\Zone;
use DomainProvider\Repositories\ApiKeyRepository;
use DomainProvider\Repositories\BlacklistDomainRepository;
use DomainProvider\Repositories\DnsRecordRepository;
use DomainProvider\Repositories\ZoneRepository;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class ZoneController extends BaseController
{
    private $zoneRepository;
    private $dnsRepository;
    private $blacklistRepository;

    /**
     * [DependencyInjection]
     *
     * @param ZoneRepository $zoneRepository
     * @param DnsRecordRepository $dnsRepository
     * @param BlacklistDomainRepository $blacklistRepository
     */
    public function __construct(ZoneRepository $zoneRepository, DnsRecordRepository $dnsRepository, BlacklistDomainRepository $blacklistRepository)
    {
        $this->zoneRepository = $zoneRepository;
        $this->dnsRepository = $dnsRepository;
        $this->blacklistRepository = $blacklistRepository;
    }

    /**
     * Display a listing of the Zone.
     *
     * @return Response
     */
    public function index()
    {
        return $this->defaultIndex($this->zoneRepository->findForList(), 'admin.zone.index');
    }

    /**
     * Show the form for creating a new Zone.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return $this->defaultCreate($formBuilder, 'Admin\ZoneForm', 'admin.zone.form');
    }

    /**
     * Store a newly created Zone in storage.
     *
     * @param ZoneCreateRequest $request
     * @param ApiKeyRepository $apikeyRepository
     * @return Response
     */
    public function store(ZoneCreateRequest $request, ApiKeyRepository $apikeyRepository)
    {
        try {
            $apiKey = $apikeyRepository->find($request->api_key_id);

            $response = Cloudflare::createZone($apiKey, $request->name);

            $zone = [
                'api_key_id' => $request->api_key_id,
                'cf_id' => $response->id,
                'name' => $response->name,
                'name_servers' =>json_encode($response->name_servers),
                'status' => $response->status,
                'paused' => $response->paused,
            ];

            $saved = $this->zoneRepository->create($zone);

            // disable cloudflare email obfuscation
            $emailObfuscation = Cloudflare::disableEmailObfuscation($saved);

            return redirect($this->route('zone.show', ['id' => $saved->id]))
                ->with('success', $this->returnMessage('store', 'zone'));

        } catch (CloudflareException $e) {
            return back()->withInput()
                ->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        }
    }

    /**
     * Display the specified Zone.
     *
     * @param Zone $zone
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function show(Zone $zone, FormBuilder $formBuilder)
    {
        $zone = $this->zoneRepository->findOneForShow($zone);

        $ns = json_decode($zone->name_servers, true);

        $model = new \stdClass();
        $model->name = $zone->name;
        $model->api_key_id = $zone->api_key_id;
        $model->ns1 = $ns[0];
        $model->ns2 = $ns[1];
        $model->totalDomains = $zone->userDomains->count();

        $form = $formBuilder->create('Admin\ZoneEditForm', [
            'model' => $model,
        ]);

        return view('admin.zone.show', compact('form', 'zone'));
    }

    /**
     * Show the form for editing the specified Zone.
     *
     * @param Zone $zone
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit(Zone $zone, FormBuilder $formBuilder)
    {
        $zone = $this->zoneRepository->findOneForShow($zone);

        $ns = json_decode($zone->name_servers, true);

        $model = new \stdClass();
        $model->name = $zone->name;
        $model->api_key_id = $zone->api_key_id;
        $model->ns1 = $ns[0];
        $model->ns2 = $ns[1];
        $model->totalDomains = $zone->userDomains->count();

        $form = $formBuilder->create('Admin\ZoneEditForm', [
            'method' => 'PUT',
            'url' => $this->route('zone.update', ['zone' => $zone->id]),
            'model' => $model,
        ]);

        // zone dns
        $formDns = $formBuilder->create('DnsForm', [
            'method' => 'POST',
            'url' => route('admin.zone.store_dns', ['zone' => $zone->id])
        ]);

        $dnsystems = $this->dnsRepository->findForZone($zone);

        foreach ($dnsystems as $dns) {
            $formEdit = $formBuilder->create('DnsForm', [
                'method' => 'PUT',
                'model' => $dns,
                'url' => route('admin.zone.update_dns', ['zone' => $zone->id, 'zonedns' => $dns->id]),
            ]);

            $dns->setFormEdit($formEdit);
        }

        return view('admin.zone.edit', compact('form', 'zone', 'formDns', 'dnsystems'));
    }

    /**
     * Update the specified Zone in storage.
     *
     * @param Zone $zone
     * @param Request $request
     * @return Response
     */
    public function update(Zone $zone, Request $request)
    {
        if ($request->has('enabled')) {
            $update['enabled'] = 1;
        } else {
            $update['enabled'] = 0;
        }

        $this->zoneRepository->update($update, $zone->id);

        return redirect($this->route('zone.index'))
            ->with('success', $this->returnMessage('update', 'zone'));
    }

    /**
     * Remove the specified Zone from storage.
     *
     * @param  Zone $zone
     * @return Response
     */
    public function destroy(Zone $zone)
    {
        try {
            $response = Cloudflare::deleteZone($zone);

            // if success delete from cloudflare then remove local
            if ($response->id === $zone->cf_id) {
                $this->zoneRepository->delete($zone->id);
            }
            return redirect()
                ->intended($this->route('zone.index'))
                ->with('success', $this->returnMessage('destroy', 'zone'));

        } catch (CloudflareException $e) {
            return back()->withInput()
                ->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        }
    }

    /**
     * Store a newly created DNS Record of Zone in storage.
     *
     * @param  Zone $zone
     * @param  DnsRequest $request
     * @return Response
     */
    public function storeDns(Zone $zone, DnsRequest $request)
    {
        try {
            $datas = $request->except(['_token']);
            if ('@' === $datas['name']) {
                $datas['name'] = $zone->name;
            } else {
                if (strpos($request->name, '.') !== false) {
                    return back()->withInput()->withErrors([
                        trans('admin.zone.invalid_name'),
                    ]);
                }
            }

            $cfDns = Cloudflare::createDnsRecord($zone, $datas);

            $dnsRecord = $request->all();
            $dnsRecord['name'] = $datas['name'];
            $dnsRecord['cf_id'] = $cfDns->id;
            $dnsRecord['zone_id'] = $zone->id;

            $this->dnsRepository->create($dnsRecord);

            // add to blacklist domain
            $isBlacklisted = $this->blacklistRepository->findOneByNameAndZone($datas['name'], $zone);
            if (!$isBlacklisted) {
                $blacklist = [
                    'name' => $datas['name'],
                    'zone_id' => $zone->id,
                ];

                $this->blacklistRepository->create($blacklist);
            }

            return redirect($this->route('zone.edit', ['zone' => $zone->id]))
                ->with('success', $this->returnMessage('store', 'dns'));
        } catch (CloudflareException $e) {
            return back()->withInput()->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        } catch (\Exceptions $e) {
            return back()->withInput()->withErrors([
                    trans('admin.error.unknown_error'),
                ]);
        }
    }

    /**
     * Update the specified DNS Record of Zone in storage.
     *
     * @param Zone $zone
     * @param DnsRecord $dns
     * @param DnsRequest $request
     * @return Response
     */
    public function updateDns(Zone $zone, DnsRecord $dns, DnsRequest $request)
    {
        try {
            $datas = $request->except(['_token']);
            if ('@' === $datas['name']) {
                $datas['name'] = $zone->name;
            } else {
                if (strpos($request->name, '.') !== false) {
                    return back()->withInput()->withErrors([
                        trans('admin.error.unknown_error'),
                    ]);
                }
            }

            $cfDns = Cloudflare::updateDnsRecord($zone, $dns->cf_id, $datas);

            $updateDns = $request->except(['_token']);
            $updateDns['name'] = $datas['name'];
            $this->dnsRepository->update($updateDns, $dns->id);

            $dnsName = $this->dnsRepository->findByNameAndZone($dns->name, $zone);
            if (count($dnsName) > 1) {
                // if dnsName > 1 and exists in blacklist domain then delete
                $isBlacklisted = $this->blacklistRepository->findOneByNameAndZone($dns->name, $zone);
                if ($isBlacklisted) {
                    $this->blacklistRepository->delete($isBlacklisted->id);
                }
            }

            return redirect($this->route('zone.edit', ['zone' => $zone->id]))
                ->with('success', $this->returnMessage('update', 'dns'));
        } catch (CloudflareException $e) {
            return back()->withInput()->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        } catch (\Exceptions $e) {
            return back()->withInput()->withErrors([
                    trans('admin.error.unknown_error'),
                ]);
        }
    }

    /**
     * Remove the specified DNS Record of Zone from storage.
     *
     * @param Zone $zone
     * @param DnsRecord $dns
     * @return Response
     */
    public function destroyDns(Zone $zone, DnsRecord $dns)
    {
        if ($zone->id !== $dns->zone->id) {
            abort(404);
        }

        try {
            $cfDns = Cloudflare::deleteDnsRecord($zone, $dns->cf_id);

            if ($cfDns->id === $dns->cf_id) {
                $this->dnsRepository->delete($dns->id);
            }

            $dnsName = $this->dnsRepository->findByNameAndZone($dns->name, $zone);
            if (count($dnsName) > 1) {
                // if dnsName > 1 and exists in blacklist domain then delete
                $isBlacklisted = $this->blacklistRepository->findOneByNameAndZone($dns->name, $zone);
                if ($isBlacklisted) {
                    $this->blacklistRepository->delete($isBlacklisted->id);
                }
            }

            return redirect($this->route('zone.edit', ['zone' => $zone->id]))
                ->with('success', $this->returnMessage('destroy', 'dns'));
        } catch (CloudflareException $e) {
            return back()->withInput()->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        } catch (\Exceptions $e) {
            return back()->withInput()->withErrors([
                    trans('admin.error.unknown_error'),
                ]);
        }
    }
}
