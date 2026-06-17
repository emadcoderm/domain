@extends('front.layouts.layout')

@section('title')
{{ trans('front.domain.title') }} -
@endsection

@section('main_content')
<header class="page-header">
    <h1 class="page-title">{{ trans('front.domain.header') }}</h1>
</header>
@include('front.partials.alert')
<a href="{{ route('user.domain.create') }}" class="pull-right btn btn-primary" style="margin-bottom: 15px;"><i class="fa fa-plus"></i> {{ trans('button.add') }}</a>
<table class="table table-hover">
    <tr>
        <th>{{ trans('front.domain.head_domain') }}</th>
        <th>{{ trans('front.domain.head_registration_date') }}</th>
        <th>{{ trans('front.domain.head_expire_date') }}</th>
        <th></th>
    </tr>
    @foreach ($domains as $domain)
    <tr>
        <td>{{ $domain->complete_domain_name }}</td>
        <td>{{ $domain->created_at->format('D, d F y') }}</td>
        <td>{{ $domain->expired_at->format('D, d F y') }}
        <td style="text-align:right">
            <a class="btn btn-default btn-normal" href="{{ route('user.domain.manage', ['domainName' => $domain->complete_domain_name]) }}">{{ trans('front.domain.button_manage') }} <i class="fa fa-gear"></i></a>
        </td>
    </tr>
    @endforeach
</table>

@endsection