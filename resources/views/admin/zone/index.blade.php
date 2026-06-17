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
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.zone.box_index') }}</h3>
                    </div>
                    <div class="box-body">
                        @include('admin.partials.button', ['action' => 'a', 'route' => ['zone', '']])
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.zone.head_name') }}</th>
                                <th>{{ trans('admin.zone.head_api_key') }}</th>
                                <th>{{ trans('admin.zone.head_enabled') }}</th>
                                <th>{{ trans('admin.zone.head_total_domain') }}</th>
                                <th>{{ trans('admin.zone.head_created_at') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($zones as $zone)
                            <tr>
                                <td>{{ $zone->name }}</td>
                                <td>{{ $zone->apiKey->email }}</td>
                                <td>
                                    @if($zone->enabled)
                                        {{ trans('admin.true') }}
                                    @else
                                        {{ trans('admin.false') }}
                                    @endif
                                </td>
                                <td>{{ $zone->userDomains->count() }}</td>
                                <td>{{ $zone->created_at->format('D, d F y H:i:s')  }}</td>
                                <td style="text-align:right">
                                    @include('admin.partials.action_button', ['action' => 'sed', 'route' => ['zone', $zone->id]])
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $zones])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection