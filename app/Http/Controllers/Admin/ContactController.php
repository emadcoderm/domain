<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Models\Contact;
use DomainProvider\Repositories\ContactRepository;
use Kris\LaravelFormBuilder\FormBuilder;

class ContactController extends BaseController
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
     * Display a listing of the Contact.
     *
     * @return Response
     */
    public function index()
    {
        return $this->defaultIndex($this->contactRepository->findForList(), 'admin.contact.index');
    }

    /**
     * Display the specified Contact.
     *
     * @param Contact $contact
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function show(Contact $contact, FormBuilder $formBuilder)
    {
        $this->contactRepository->update(['seen' => 1], $contact->id);

        $form = $formBuilder->create('Admin\ContactForm', [
            'model' => $contact
        ]);

        return view('admin.contact.show', compact('form'));
    }

    /**
     * Remove the specified Contact from storage.
     *
     * @param Contact $contact
     * @return Response
     */
    public function destroy(Contact $contact)
    {
        $this->contactRepository->delete($contact->id);

        return redirect()
            ->intended($this->route('contact.index'))
            ->with('success', $this->returnMessage('destroy', 'message'));
    }
}
