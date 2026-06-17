<?php

namespace DomainProvider\Http\Controllers\Front;

use DomainProvider\Http\Controllers\Controller;
use DomainProvider\Models\Page;
use DomainProvider\Repositories\PageRepository;

class PageController extends Controller
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
     * Render Page
     * @param string $slug
     * @return Response
     */
    public function getShow($slug)
    {
        $page = $this->pageRepository->findBy('slug', $slug);
        if (!$page) {
            abort(404);
        }

        return view('front.page', compact('page'));
    }
}
