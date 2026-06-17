<?php

namespace DomainProvider\Http\Controllers\Front;

use DomainProvider\Http\Controllers\Controller;
use DomainProvider\Http\Requests\ContactCreateRequest;
use DomainProvider\Models\Contact;
use DomainProvider\Repositories\ContactRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class ContactController extends Controller
{
    private $contactRepository;

    /**
     * [DependencyInjection]
     *
     * @param ContactRepository $contactRepository
     */
    public function __construct(ContactRepository $contactRepository)
    {
        $this->contactRepository = $contactRepository;
    }

    /**
     * Show the form for creating a new Contact Us.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function getCreate(FormBuilder $formBuilder)
    {
        $form = $formBuilder->create('ContactForm', [
            'method' => 'POST',
            'url' => route('contact')
        ]);

        return view('front.contact', compact('form'));
    }

    /**
     * Store a newly created Contact Us in storage.
     *
     * @param ContactCreateRequest $request
     * @return Response
     */
    public function postCreate(ContactCreateRequest $request)
    {
        $this->contactRepository->create($request->all());

        return redirect()
            ->route('contact')
            ->with('success', trans('front.contact.success_submit'));
    }
}
