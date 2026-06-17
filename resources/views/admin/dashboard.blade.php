@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Dashboard
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $zonesCount }}</h3>
                        <p>{{ trans('admin.menu.zone') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-world"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $usersCount }}</h3>
                        <p>{{ trans('admin.menu.user') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-people"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $domainsCount }}</h3>
                        <p>{{ trans('admin.menu.domain') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-ios-list"></i>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-xs-6">
                <div class="small-box bg-red">
                    <div class="inner">
                        <h3>{{ $dnsCount }}</h3>
                        <p>{{ trans('admin.menu.dns') }}</p>
                    </div>
                    <div class="icon">
                        <i class="ion ion-disc"></i>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection