@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.zone.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.zone.box_show') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body">
                        {!! form_start($form) !!}
                        {!! form_row($form->name) !!}
                        {!! form_row($form->api_key_id) !!}
                        <b>{{ trans('admin.zone.please_change_ns')}}</b>
                        {!! form_row($form->ns1) !!}
                        {!! form_row($form->ns2) !!}
                        {!! form_row($form->totalDomains) !!}
                        @include('admin.partials.button', ['action' => 'b'])
                        {!! form_end($form, false) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.zone.box_domain_list') }}</h3>
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
                            @foreach ($zone->userDomains as $domain)
                                <tr>
                                    <td>{{ $domain->complete_domain_name }}</td>
                                    <td>{{ $domain->created_at->format('D, d F y') }}</td>
                                    <td>{{ $domain->expired_at->format('D, d F y') }}
                                    <td>{{ $domain->dnsRecords->count() }}</td>
                                    <td>
                                        @include('admin.partials.action_button', ['action' => 's', 'route' => ['user.domain', [$domain->user->id, $domain->id]]])
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