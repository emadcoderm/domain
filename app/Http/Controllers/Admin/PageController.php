<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Http\Controllers\Admin\BaseController;
use DomainProvider\Models\Page;
use DomainProvider\Repositories\PageRepository;
use Kris\LaravelFormBuilder\FormBuilder;
use DomainProvider\Http\Requests\Admin\PageRequest;
use Illuminate\Support\Str;

class PageController extends BaseController
{
    private $pageRepository;

    /**
     * [DependencyInjection]
     *
     * @param PageRepository $pageRepository
     */
    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Display a listing of the Page.
     *
     * @return Response
     */
    public function index()
    {
        return $this->defaultIndex($this->pageRepository, 'admin.page.index');
    }

    /**
     * Show the form for creating a new Page.
     *
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function create(FormBuilder $formBuilder)
    {
        return $this->defaultCreate($formBuilder, 'Admin\PageForm', 'admin.page.form');
    }

    /**
     * Store a newly created Page in storage.
     *
     * @param PageRequest $request
     * @return Response
     */
    public function store(PageRequest $request)
    {
        $page = $request->only(['title', 'slug', 'content']);
        if (!$request->slug) {
            $page['slug'] = Str::slug($request->title);
        } else {
            $page['slug'] = Str::slug($request->slug);
        }

        $this->pageRepository->create($page);

        return redirect($this->route('page.index'))
            ->with('success', $this->returnMessage('store', 'page'));
    }

    /**
     * Show the form for editing the specified Page.
     *
     * @param Page $page
     * @param FormBuilder $formBuilder
     * @return Response
     */
    public function edit(Page $page, FormBuilder $formBuilder)
    {
        return $this->defaultEdit($formBuilder, $page, 'Admin\PageForm', 'admin.page.form');
    }

    /**
     * Update the specified Page in storage.
     *
     * @param Page $page
     * @param PageRequest $request
     * @return Response
     */
    public function update(Page $page, PageRequest $request)
    {
        $update = $request->only(['title', 'slug', 'content']);
        if (!$request->slug) {
            $update['slug'] = Str::slug($request->title);
        } else {
            $update['slug'] = Str::slug($request->slug);
        }

        $this->pageRepository->update($update, $page->id);

        return redirect($this->route('page.index'))
            ->with('success', $this->returnMessage('update', 'page'));
    }

    /**
     * Remove the specified Page from storage.
     *
     * @param Page $page
     * @return Response
     */
    public function destroy(Page $page)
    {
        $this->pageRepository->delete($page->id);

        return redirect()
            ->intended($this->route('page.index'))
            ->with('success', $this->returnMessage('destroy', 'page'));
    }
}
