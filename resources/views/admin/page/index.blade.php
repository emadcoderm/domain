@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.page.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.page.box_index') }}</h3>
                    </div>
                    <div class="box-body">
                        @include('admin.partials.button', ['action' => 'a', 'route' => ['page', '']])
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.page.head_title') }}</th>
                                <th>{{ trans('admin.page.head_created_at') }}</th>
                                <th>{{ trans('admin.page.head_last_updated') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($pages as $page)
                            <tr>
                                <td>{{ $page->title }}</td>
                                <td>{{ $page->created_at->format('D, d F y H:i:s') }}</td>
                                <td>{{ $page->updated_at->format('D, d F y H:i:s') }}</td>
                                <td style="text-align:right">
                                    @include('admin.partials.action_button', ['action' => 'sed', 'route' => ['page', $page->id]])
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $pages])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection