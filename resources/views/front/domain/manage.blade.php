@extends('front.layouts.layout')

@section('title')
{{ trans('front.dns.title') }} -
@endsection

@section('main_content')
<header class="page-header">
    <h1 class="page-title">{{ trans('front.dns.header') }} <b>{{ $domainName }}</b></h1>
</header>
@include('front.partials.alert')
{!! form_start($form, ['class' => 'navbar-form']) !!}
<div class="form-group" style="display:inline;">
    <div class="input-group center-block">
        {!! form_widget($form->type) !!}
    </div>
</div>
<div class="form-group" style="display:inline;">
    <div class="input-group center-block">
        {!! form_widget($form->name) !!}
    </div>
</div>
<div class="form-group" style="display:inline;">
    <div class="input-group center-block  col-sm-4 col-xs-12">
        {!! form_widget($form->content) !!}
    </div>
</div>
<div class="form-group" style="display:inline;">
    <div class="input-group center-block">
        {!! form_widget($form->ttl) !!}
    </div>
</div>
<div class="form-group" style="display:inline;">
    <div class="input-group center-block">
        {!! form_widget($form->priority) !!}
    </div>
</div>
<div class="form-group" style="display:inline;">
    <div class="input-group center-block">
        {!! form_widget($form->save) !!}
    </div>
</div>
<p>{{ trans('front.dns.at_for_root_domain') }}</p>
{!! form_end($form) !!}
<table class="table table-hover table-striped" border="0">
    <tbody id="dns-table">
        <tr>
            <th>{{ trans('front.dns.head_type') }}</th>
            <th>{{ trans('front.dns.head_name') }}</th>
            <th>{{ trans('front.dns.head_value') }}</th>
            <th>{{ trans('front.dns.head_ttl') }}</th>
            <th>{{ trans('front.dns.head_priority') }}</th>
            <th></th>
        </tr>
        @foreach ($dnsystems as $dns)
        <tr class="dns-row">
            <td>{{ $dns->type }}</td>
            <td>{{ $dns->name }}</td>
            <td>{{ $dns->content }}</td>
            <td>{{ trans('domain.dns_ttl.'.$dns->ttl) }}</td>
            <td>
                @if($dns->priority)
                    {{ $dns->priority }}
                @else
                    -
                @endif
            </td>
            <td style="text-align:right">
                <a class="btn btn-info btn-normal edit-dns" title="{{ trans('button.edit') }}"><i class="fa fa-edit"></i></a>
            </td>
        </tr>
        <tr class="edit-dns-toggle">
            <td colspan="100%">
                <div class="row">
                    <div class="col-md-11">
                        @set($editForm = $dns->getFormEdit())
                        {!! form_start($editForm, ['class' => 'navbar-form']) !!}
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($editForm->type) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($editForm->name) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block col-sm-3 col-xs-12">
                                {!! form_widget($editForm->content) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($editForm->ttl) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($editForm->priority) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($editForm->save) !!}
                            </div>
                        </div>
                        {!! form_end($editForm) !!}
                        </div>
                        <div class="col-md-1">

                        {!! Form::open([
                            'class' => 'navbar-form',
                            'method' => 'DELETE',
                            'url' => route('user.domain.dns.delete', ['domainName' => $domainName, 'id' => $dns->id])
                        ]) !!}
                            <button type="submit" class="btn btn-danger btn-normal confirm-delete"><i title="{{ trans('button.delete') }}" class="fa fa-close"></i></button>
                        {!! Form::close() !!}
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
<hr/>
<div class="col-md-12" id="domain-advanced">
    <div class="row">
        <button id="domain-advanced-button" class="pull-right btn btn-warning">{{ trans('front.dns.button_advanced') }}</button>
    </div>
    <div id="domain-advanced-box" class="row" style="border: 1px solid #000; padding-bottom: 30px">
        <div class="col-md-9">
            <h2>{!! trans('front.dns.advanced_title') !!}</h2>
            {!! trans('front.dns.advanced_description') !!}
        </div>
        <div class="col-md-3 center-block pull-down">
            {!! Form::open([
                'class' => 'navbar-form',
                'method' => 'DELETE',
                'url' => route('user.domain.delete', ['domainName' => $domainName])
            ]) !!}
                <button type="submit" class="btn btn-danger btn-normal confirm-delete"><i title="{{ trans('button.delete') }}" class="fa fa-close"></i> {{trans('front.dns.button_delete_domain') }} </button>
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function () {
    // edit dns
    var dnsTable = $('tbody#dns-table');
    dnsTable.children('tr.edit-dns-toggle').hide();
    dnsTable.find('a.edit-dns').on('click', function () {
        var next = $(this).parent().parent().next('tr.edit-dns-toggle');
        if (next.is(':hidden')) {
            dnsTable.children('tr.edit-dns-toggle').not(':hidden').hide();
        }
        next.slideToggle();
    });

    // dns type
    var dnsForm = $('form.navbar-form');
    dnsForm.find('select.dns-type').on('change', function () {
        var priority = $(this).parents('form.navbar-form').find('input.dns-priority');
        if ('MX' == $(this).val()) {
            priority.prop('disabled', false);;
        } else {
            priority.val('');
            priority.prop('disabled', true);;
        }
    });

    dnsForm.find('select.dns-type').each(function () {
        var priority = $(this).parents('form.navbar-form').find('input.dns-priority');
        if ('MX' == $(this).val()) {
            priority.prop('disabled', false);;
        } else {
            priority.val('');
            priority.prop('disabled', true);;
        }
    })

    $('.pull-down').each(function() {
        $(this).css('margin-top', $(this).parent().height()-$(this).height())
    });

    var domainAdvanced = $('div#domain-advanced');
    domainAdvanced.find('div#domain-advanced-box').slideUp('fast');
    domainAdvanced.find('button#domain-advanced-button').on('click', function () {
        domainAdvanced.find('div#domain-advanced-box').slideToggle();
    });
});
</script>
@endsection