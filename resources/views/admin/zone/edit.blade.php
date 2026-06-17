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
                        <h3 class="box-title">{{ trans('admin.zone.box_edit') }}</h3>
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
                        {!! form_row($form->enabled, ['checked' => $zone->enabled]) !!}
                        {!! form_end($form) !!}
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.zone.dns') }}</h3>
                    </div>
                    <div class="box-body table-responsive no-padding">
                        {!! form_start($formDns, ['class' => 'navbar-form']) !!}
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($formDns->type) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($formDns->name) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block  col-sm-4 col-xs-12">
                                {!! form_widget($formDns->content) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($formDns->ttl) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($formDns->priority) !!}
                            </div>
                        </div>
                        <div class="form-group" style="display:inline;">
                            <div class="input-group center-block">
                                {!! form_widget($formDns->save) !!}
                            </div>
                        </div>
                        <p>{{ trans('front.dns.at_for_root_domain') }}</p>
                        {!! form_end($formDns) !!}
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
                                        <button class="btn btn-info btn-normal edit-dns"><i class="fa fa-edit"></i></button>
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
                                                    'url' => route('admin.zone.destroy_dns', ['zone' => $zone->id, 'zonedns' => $dns->id])
                                                ]) !!}
                                                    <button type="submit" class="btn btn-danger btn-normal  confirm-delete"><i title="{{ trans('button.delete') }}" class="fa fa-close"></i></button>
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
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

@section('scripts')
@parent
<script type="text/javascript">
$(document).ready(function () {
    // edit dns
    var dnsTable = $('tbody#dns-table');
    dnsTable.children('tr.edit-dns-toggle').hide();
    dnsTable.find('button.edit-dns').on('click', function () {
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