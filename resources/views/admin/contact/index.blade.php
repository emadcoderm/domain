@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.contact.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.contact.box_index') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body table-responsive no-padding">
                        <table class="table table-hover">
                            <tr>
                                <th>{{ trans('admin.contact.head_from') }}</th>
                                <th>{{ trans('admin.contact.head_email') }}</th>
                                <th>{{ trans('admin.contact.head_date') }}</th>
                                <th>{{ trans('admin.contact.head_status') }}</th>
                                <th></th>
                            </tr>
                            @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ $contact->created_at->format('D, d F y H:i:s')  }}</td>
                                <td>
                                    @if ($contact->seen)
                                        <span title="{{ trans('admin.contact.status_read') }}"><i class="fa fa-folder-open"></i></span>
                                    @else
                                        <span title="{{ trans('admin.contact.status_unread') }}"><i class="fa fa-folder"></i></span>
                                    @endif
                                </td>
                                <td style="text-align:right">
                                    @include('admin.partials.action_button', ['action' => 'sd', 'route' => ['contact', $contact->id]])
                                </td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                    <div class="box-footer clearfix">
                        @include('admin.partials.pagination', ['model' => $contacts])
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection