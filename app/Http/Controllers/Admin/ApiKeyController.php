<?php

namespace DomainProvider\Http\Controllers\Admin;

use Auth;
use Cloudflare;
use DomainProvider\Exceptions\CloudflareException;
use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Http\Requests\Admin\ApiKeyRequest;
use DomainProvider\Http\Requests\Request;
use DomainProvider\Models\ApiKey;
use DomainProvider\Repositories\ApiKeyRepository;
use DomainProvider\Repositories\ZoneRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class ApiKeyController extends BaseController
{
    private $apikeyRepository;
    private $zoneRepository;

    /**
     * [DependencyInjection]
     *
     * @param ApiKeyRepository $apikeyRepository
     * @param ZoneRepository $zoneRepository
     */
    public function __construct(ApiKeyRepository $apikeyRepository, ZoneRepository $zoneRepository)
    {
        $this->apikeyRepository = $apikeyRepository;
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Display a listing of the API Key.
     *
     * @return Response
     */
    public function index()
    {
        return $this->defaultIndex($this->apikeyRepository->findForList(), 'admin.apikey.index');
    }

    /**
     * Show the form for creating a new API Key.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return $this->defaultCreate($formBuilder, 'Admin\ApiKeyForm', 'admin.apikey.form');
    }

    /**
     * Store a newly created API Key in storage.
     *
     * @param ApiKeyRequest $request
     * @return Response
     */
    public function store(ApiKeyRequest $request)
    {
        try {
            $apiKey = new ApiKey();
            $apiKey->email = $request->email;
            $apiKey->api_key = $request->api_key;

            $user = Cloudflare::getUserDetail($apiKey);

            $apikey = [
                'cf_id' => $user->id,
                'email' => $request->email,
                'api_key' => $request->api_key,
                'user_id' => Auth::user()->id
            ];

            $this->apikeyRepository->create($apikey);

            return redirect($this->route('apikey.index'))
                ->with('success', $this->returnMessage('store', 'api_key'));
        } catch (CloudflareException $e) {
            return back()->withInput()
                ->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        }
    }

    /**
     * Show the form for editing the specified API Key.
     *
     * @param ApiKey $apikey
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit(ApiKey $apikey, FormBuilder $formBuilder)
    {
        return $this->defaultEdit($formBuilder, $apikey, 'Admin\ApiKeyForm', 'admin.apikey.form');
    }

    /**
     * Update the specified API Key in storage.
     *
     * @param ApiKey $apikey
     * @param ApiKeyRequest $request
     * @return Response
     */
    public function update(ApiKey $apikey, ApiKeyRequest $request)
    {
        try {
            $apiKey = new ApiKey();
            $apiKey->email = $request->email;
            $apiKey->api_key = $request->api_key;

            $user = Cloudflare::getUserDetail($apiKey);

            $update = [
                'cf_id' => $user->id,
                'email' => $request->email,
                'api_key' => $request->api_key,
            ];

            $this->apikeyRepository->update($update, $apikey->id);

            return redirect($this->route('apikey.index'))
                ->with('success', $this->returnMessage('update', 'api_key'));
        } catch (CloudflareException $e) {
            return back()->withInput()
                ->withErrors([
                    $e->getCode() . ' - ' . trans($e->getMessage()),
                ]);
        }
    }

    /**
     * Display the specified API Key.
     *
     * @param ApiKey $apikey
     * @return Response
     */
    public function show(ApiKey $apikey)
    {
        return view('admin.apikey.show', compact('apikey'));
    }

    /**
     * Remove the specified API Key from storage.
     *
     * @param ApiKey $apikey
     * @return Response
     */
    public function destroy(ApiKey $apikey)
    {
        if ($apikey->zones->count() > 0) {
            // remove all the dns
            $complete = true;
            foreach ($apikey->zones as $zone) {
                try {
                    $response = Cloudflare::deleteZone($zone);

                    // if success delete from cloudflare then remove local
                    if ($response->id === $zone->cf_id) {
                        $this->zoneRepository->delete($zone->id);
                    }
                } catch (CloudflareException $e) {
                    $complete = false;
                    break;
                }
            }

            if ($complete) {
                // last delete the api
                $this->apikeyRepository->delete($apikey->id);
            }
        } else {
            // no zones just remove the api
            $this->apikeyRepository->delete($apikey->id);
        }

        return redirect()
            ->intended($this->route('apikey.index'))
            ->with('success', $this->returnMessage('destroy', 'api_key'));
    }
}
