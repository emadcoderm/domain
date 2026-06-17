@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.setting.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-info">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.setting.box_form') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body">
                        {!! form_start($form) !!}
                        <div style="margin-bottom: 10px">
                            {!! form_row($form->save) !!} @include('admin.partials.button', ['action' => 'c', 'route' => ['setting', []]])
                        </div>
                        <div class="nav-tabs-custom">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#tab_1" data-toggle="tab">{{ trans('admin.setting.tab_website') }}</a></li>
                                <li><a href="#tab_2" data-toggle="tab">{{ trans('admin.setting.tab_homepage') }}</a></li>
                                <li><a href="#tab_3" data-toggle="tab">{{ trans('admin.setting.tab_domain') }}</a></li>
                                <li><a href="#tab_4" data-toggle="tab">{{ trans('admin.setting.tab_security') }}</a></li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab_1">
                                    {!! form_row($form->keyword) !!}
                                    {!! form_row($form->description) !!}
                                    {!! form_row($form->page_title) !!}
                                    {!! form_row($form->lead_text) !!}
                                    {!! form_row($form->google_analytics) !!}
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! form_row($form->middle_title) !!}
                                            {!! form_row($form->footer_left_title) !!}
                                            {!! form_row($form->footer_left_body) !!}

                                            {!! form_row($form->footer_social_title) !!}
                                            {!! form_row($form->footer_social_facebook) !!}
                                            {!! form_row($form->footer_social_twitter) !!}
                                            {!! form_row($form->footer_social_googleplus) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! form_row($form->middle_body) !!}
                                            {!! form_row($form->footer_right_title) !!}
                                            {!! form_row($form->footer_right_body) !!}

                                            {!! form_row($form->footer_social_pinterest) !!}
                                            {!! form_row($form->footer_social_linkedin) !!}
                                            {!! form_row($form->footer_social_instagram) !!}
                                            {!! form_row($form->footer_social_youtube) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    {!! form_row($form->domain_min_chars) !!}
                                    {!! form_row($form->domain_max_chars) !!}
                                    {!! form_row($form->domain_registration_year) !!}
                                    {!! form_row($form->domains_per_user) !!}
                                    {!! form_row($form->dns_per_domain) !!}
                                </div>
                                <div class="tab-pane" id="tab_4">
                                    {!! form_row($form->captcha_on_register, ['checked' => $settings->captcha_on_register]) !!}
                                    {!! form_row($form->captcha_on_login, ['checked' => $settings->captcha_on_login]) !!}
                                </div>
                            </div>
                        </div>
                        {!! form_end($form, false) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('styles')
@parent
{!! Html::style('css/bootstrap3-wysihtml5.min.css') !!}
@endsection

@section('scripts')
@parent
{!! Html::script('js/bootstrap3-wysihtml5.all.min.js') !!}
<script>
    $(function () {
        $("textarea.whtml5").wysihtml5();
    });
</script>
@endsection