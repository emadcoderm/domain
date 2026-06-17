@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.blacklist_domain.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.blacklist_domain.box_index') }}</h3>
                    </div>
                    <div class="box-body">
                        @include('admin.partials.button', ['action' => 'a', 'route' => ['blacklist-domain', '']])
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.blacklist_domain.head_domain_name') }}</th>
                                <th>{{ trans('admin.blacklist_domain.head_zone') }}</th>
                                <th>{{ trans('admin.blacklist_domain.head_created_at') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($blacklistDomains as $blacklistDomain)
                            <tr>
                                <td>{{ $blacklistDomain->name }}</td>
                                <td>
                                @if($blacklistDomain->zone_id)
                                {{ $blacklistDomain->zone->name }}
                                @else
                                {{ trans('admin.blacklist_domain.global') }}
                                @endif
                                </td>
                                <td>{{ $blacklistDomain->created_at->format('D, d F y H:i:s')  }}</td>
                                <td style="text-align:right">
                                    @include('admin.partials.action_button', ['action' => 'sed', 'route' => ['blacklist-domain', $blacklistDomain->id]])
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $blacklistDomains])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection