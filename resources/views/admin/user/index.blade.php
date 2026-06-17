@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.user.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.user.box_index') }}</h3>
                    </div>
                    <div class="box-body">
                        @include('admin.partials.button', ['action' => 'a', 'route' => ['user', '']])
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.user.head_full_name') }}</th>
                                <th>{{ trans('admin.user.head_email') }}</th>
                                <th>{{ trans('admin.user.head_registered_at') }}</th>
                                <th>{{ trans('admin.user.head_enabled') }}</th>
                                <th>{{ trans('admin.user.head_total_domain') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->full_name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->format('D, d F y H:i:s')  }}</td>
                                <td>
                                    @if($user->enabled)
                                        {{ trans('admin.true') }}
                                    @else
                                        {{ trans('admin.false') }}
                                    @endif
                                </td>
                                <td>{{ $user->userDomains->count() }}</td>
                                <td style="text-align:right">
                                    @include('admin.partials.action_button', ['action' => 'se', 'route' => ['user', $user->id]])
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $users])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection