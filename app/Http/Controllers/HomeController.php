<?php

namespace DomainProvider\Http\Controllers;

use Auth;
use Domain;
use DomainProvider\Exceptions\DomainNotAvailableException;
use DomainProvider\Http\Requests\DomainCreateRequest;
use DomainProvider\Repositories\ZoneRepository;
use Illuminate\Http\Request;
use Kris\LaravelFormBuilder\FormBuilder;

class HomeController extends Controller
{
    private $zoneRepository;

    public function __construct(ZoneRepository $zoneRepository)
    {
        $this->zoneRepository = $zoneRepository;
    }

    /**
     * Render Homepage
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function index(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('DomainForm', [
            'method' => 'POST',
            'url' => route('home.domain.search')
        ]);

        return view('front.home', compact('form'));
    }

    /**
     * Handle domain check from homepage
     *
     * @param  DomainCreateRequest $request
     * @return Response
     */
    public function postCheckDomain(DomainCreateRequest $request)
    {
        $zone = $this->zoneRepository->findOneByEnabled($request->zone_id, ['id', 'name']);
        if (!$zone) {
            abort(404);
        }

        try {
            Domain::checkDomainAvailability($request->name, $zone);

            if (Auth::guest()) {
                return back()
                    ->withInput($request->only('name', 'zone_id'))
                    ->with('domain_status', trans('front.domain.domain_available_guest', [
                            'domain' => $zone->getDomainName($request->name),
                            'sign_up_route' => route('user.register'),
                    ]));
            } else {
                return back()
                    ->withInput($request->only('name', 'zone_id'))
                    ->with('domain_status', trans('front.domain.domain_available', [
                            'domain' => $zone->getDomainName($request->name),
                            'register_domain' => route('user.domain.create', [
                                'domain' => $request->name,
                                'zone' => $request->zone_id,
                            ])
                    ]));
            }
        } catch (DomainNotAvailableException $e) {
            return back()
                ->withInput($request->only('zone_id'))
                ->with('domain_status', trans('front.domain.domain_not_available', ['domain' => $zone->getDomainName($request->name)]));
        }
    }
}
