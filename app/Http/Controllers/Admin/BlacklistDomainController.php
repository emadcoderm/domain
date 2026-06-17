<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Http\Requests\Admin\BlacklistDomainRequest;
use DomainProvider\Models\BlacklistDomain;
use DomainProvider\Repositories\BlacklistDomainRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class BlacklistDomainController extends BaseController
{
    private $blacklistRepository;

    /**
     * [DependencyInjection]
     *
     * @param BlacklistDomainRepository $blacklistRepository
     */
    public function __construct(BlacklistDomainRepository $blacklistRepository)
    {
        $this->blacklistRepository = $blacklistRepository;
    }

    /**
     * Display a listing of the Blacklist Domain.
     *
     * @return Response
     */
    public function index()
    {
        return $this->defaultIndex($this->blacklistRepository->findForList(), 'admin.blacklist-domain.index');
    }

    /**
     * Show the form for creating a new Blacklist Domain.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return $this->defaultCreate($formBuilder, 'Admin\BlacklistDomainForm', 'admin.blacklist-domain.form');
    }

    /**
     * Store a newly created Blacklist Domain in storage.
     *
     * @param BlacklistDomainRequest $request
     * @return Response
     */
    public function store(BlacklistDomainRequest $request)
    {
        $new = $request->all();

        if ('0' === $request->zone_id) {
            $new['zone_id'] = null;
        }

        $this->blacklistRepository->create($new);

        return redirect($this->route('blacklist-domain.index'))
            ->with('success', $this->returnMessage('store', 'blacklist_domain'));
    }

    /**
     * Display the specified Blacklist Domain.
     *
     * @param BlacklistDomain $blacklistDomain
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function show(BlacklistDomain $blacklistDomain, FormBuilder $formBuilder)
    {
        if ($blacklistDomain->zone_id) {
            $zoneName = $blacklistDomain->zone->name;
        } else {
            $zoneName = trans('admin.blacklist_domain.global');
        }

        $form = $formBuilder->create('Admin\BlacklistDomainForm', [
            'model' => $blacklistDomain,
        ])
        ->add('zone_name', 'text', [
            'label' => trans('admin.blacklist_domain.field_zone_name'),
            'default_value' => $zoneName,
            'attr' => [
                'disabled' => 'disabled',
            ],
        ]);

        return view('admin.blacklist-domain.show', compact('form'));
    }

    /**
     * Show the form for editing the specified Blacklist Domain.
     *
     * @param BlacklistDomain $blacklistDomain
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit(BlacklistDomain $blacklistDomain, FormBuilder $formBuilder)
    {
        return $this->defaultEdit($formBuilder, $blacklistDomain, 'Admin\BlacklistDomainForm', 'admin.blacklist-domain.form');
    }

    /**
     * Update the specified Blacklist Domain in storage.
     *
     * @param BlacklistDomain $blacklistDomain
     * @param BlacklistDomainRequest $request
     * @return Response
     */
    public function update(BlacklistDomain $blacklistDomain, BlacklistDomainRequest $request)
    {
        $update = $request->only('zone_id', 'name', 'reason');

        if ('0' === $request->zone_id) {
            $update['zone_id'] = null;
        }

        $this->blacklistRepository->update($update, $blacklistDomain->id);

        return redirect($this->route('blacklist-domain.index'))
            ->with('success', $this->returnMessage('update', 'blacklist_domain'));
    }

    /**
     * Remove the specified Blacklist Domain from storage.
     *
     * @param BlacklistDomain $blacklistDomain
     * @return Response
     */
    public function destroy(BlacklistDomain $blacklistDomain)
    {
        $this->blacklistRepository->delete($blacklistDomain->id);

        return redirect()
            ->intended($this->route('blacklist-domain.index'))
            ->with('success', $this->returnMessage('destroy', 'blacklist_domain'));
    }
}
