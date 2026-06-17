<?php

namespace DomainProvider\Http\Controllers\Front;

use DomainProvider\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Redirect to User Domain list
     *
     * @return Response
     */
    public function getShow()
    {
        return redirect()->route('user.domain.list');
    }
}
