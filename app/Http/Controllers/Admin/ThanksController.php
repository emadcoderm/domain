<?php

namespace DomainProvider\Http\Controllers\Admin;

use DomainProvider\Http\Controllers\Admin\BaseController;

class ThanksController extends BaseController
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        return view('admin.thanks.index');
    }
}
