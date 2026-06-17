@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.apikey.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.apikey.box_index') }}</h3>
                    </div>
                    <div class="box-body">
                        @include('admin.partials.button', ['action' => 'a', 'route' => ['apikey', '']])
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.apikey.head_email') }}</th>
                                <th>{{ trans('admin.apikey.head_created_at') }}</th>
                                <th>{{ trans('admin.apikey.head_total_zone') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($apikeys as $apikey)
                            <tr>
                                <td>{{ $apikey->email }}</td>
                                <td>{{ $apikey->created_at->format('D, d F y H:i:s') }}</td>
                                <td>{{ $apikey->zones->count() }}</td>
                                <td style="text-align:right">
                                    @include('admin.partials.action_button', ['action' => 'ed', 'route' => ['apikey', $apikey->id]])
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $apikeys])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection