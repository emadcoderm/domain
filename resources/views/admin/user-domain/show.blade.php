@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.user_domain.header') }} <b>{{ $userDomain->complete_domain_name }}</b>
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.user_domain.box_show') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-striped">
                            <tr>
                                <th>{{ trans('admin.user_domain.head_domain') }}</th>
                                <th>{{ trans('admin.user_domain.head_registration_date') }}</th>
                                <th>{{ trans('admin.user_domain.head_expire_date') }}</th>
                                <th>{{ trans('admin.user_domain.head_total_dns') }}</th>
                            </tr>
                            <tr>
                                <td>{{ $userDomain->complete_domain_name }}</td>
                                <td>{{ $userDomain->created_at->format('D, d F y') }}</td>
                                <td>{{ $userDomain->expired_at->format('D, d F y') }}</td>
                                <td>{{ $userDomain->dnsRecords->count() }}</td>
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
                        <h3 class="box-title">{{ trans('admin.user_domain.box_dns_list') }}</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('front.dns.head_type') }}</th>
                                <th>{{ trans('front.dns.head_name') }}</th>
                                <th>{{ trans('front.dns.head_value') }}</th>
                                <th>{{ trans('front.dns.head_ttl') }}</th>
                                <th>{{ trans('front.dns.head_priority') }}</th>
                            </tr>
                            @foreach ($dnsRecords as $dns)
                                <tr>
                                    <td>{{ $dns->type }}</td>
                                    <td>{{ $dns->name }}</td>
                                    <td>{{ $dns->content }}</td>
                                    <td>{{ trans('domain.dns_ttl.'.$dns->ttl) }}</td>
                                    <td>{{ $dns->priority }}</td>
                                </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $dnsRecords])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection