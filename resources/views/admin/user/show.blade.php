@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.user.header') }} <b>{{ $user->full_name }}</b>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.user.box_show') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th>{{ trans('admin.user.head_full_name') }}</th>
                                <th>{{ trans('admin.user.head_email') }}</th>
                                <th>{{ trans('admin.user.head_registered_at') }}</th>
                                <th>{{ trans('admin.user.head_enabled') }}</th>
                                <th>{{ trans('admin.user.head_total_domain') }}</th>
                            </tr>
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('D, d F y') }}</td>
                                <td>
                                    @if($user->enabled)
                                        {{ trans('admin.true') }}
                                    @else
                                        {{ trans('admin.false') }}
                                    @endif
                                </td>
                                <td>{{ $user->userDomains->count() }}</td>
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
                        <h3 class="box-title">{{ trans('admin.user.box_domain_list') }}</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.zone.head_domain') }}</th>
                                <th>{{ trans('admin.zone.head_registration_date') }}</th>
                                <th>{{ trans('admin.zone.head_expire_date') }}</th>
                                <th>{{ trans('admin.zone.head_total_dns') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($userDomains as $domain)
                                <tr>
                                    <td>{{ $domain->complete_domain_name }}</td>
                                    <td>{{ $domain->created_at->format('D, d F y') }}</td>
                                    <td>{{ $domain->expired_at->format('D, d F y') }}
                                    <td>{{ $domain->dnsRecords->count() }}</td>
                                    <td>
                                        @include('admin.partials.action_button', ['action' => 's', 'route' => ['user.domain', [$user->id, $domain->id]]])
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $userDomains])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection