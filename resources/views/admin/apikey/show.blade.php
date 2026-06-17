@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            API Key
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">API Key Detail</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Total Zones</th>
                            </tr>
                            <tr>
                                <td>{{ $apikey->email }}</td>
                                <td>{{ $apikey->created_at->format('D, d F y') }}</td>
                                <td>{{ $apikey->zones->count() }}</td>
                            </tr>
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.button', ['action' => 'b'])
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">Zones List</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>Zone</th>
                                <th>Created Date</th>
                                <th>Total Domains</th>
                            </tr>
                            @foreach ($apikey->zones as $zone)
                                <tr>
                                    <td>{{ $zone->name }}</td>
                                    <td>{{ $zone->created_at->format('D, d F y') }}</td>
                                    <td>{{ $zone->userDomains->count() }}
                                    <td>
                                        @include('admin.partials.action_button', ['action' => 's', 'route' => ['zone', $zone->id]])
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        {{-- @include('admin.partials.pagination', ['model' => $userDomains]) --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection