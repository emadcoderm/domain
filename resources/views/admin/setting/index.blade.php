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
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.setting.box_index') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body">
                        <div style="margin-bottom: 10px">
                            @include('admin.partials.button', ['action' => 'e', 'route' => ['setting', $settings->id]])
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
                                    {!! form_row($form->keyword, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->description, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->page_title, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->lead_text, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->google_analytics, ['attr' => ['readonly' => 'readonly']]) !!}
                                </div>
                                <div class="tab-pane" id="tab_2">
                                    <div class="row">
                                        <div class="col-md-6">
                                            {!! form_row($form->middle_title, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_left_title, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_left_body, ['attr' => ['readonly' => 'readonly']]) !!}

                                            {!! form_row($form->footer_social_title, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_social_facebook, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_social_twitter, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_social_googleplus, ['attr' => ['readonly' => 'readonly']]) !!}
                                        </div>
                                        <div class="col-md-6">
                                            {!! form_row($form->middle_body, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_right_title, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_right_body, ['attr' => ['readonly' => 'readonly']]) !!}

                                            {!! form_row($form->footer_social_pinterest, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_social_linkedin, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_social_instagram, ['attr' => ['readonly' => 'readonly']]) !!}
                                            {!! form_row($form->footer_social_youtube, ['attr' => ['readonly' => 'readonly']]) !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab_3">
                                    {!! form_row($form->domain_min_chars, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->domain_max_chars, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->domain_registration_year, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->domains_per_user, ['attr' => ['readonly' => 'readonly']]) !!}
                                    {!! form_row($form->dns_per_domain, ['attr' => ['readonly' => 'readonly']]) !!}
                                </div>
                                <div class="tab-pane" id="tab_4">
                                    {!! form_row($form->captcha_on_register, ['checked' => $settings->captcha_on_register, 'attr' => ['disabled' => 'disabled']]) !!}
                                    {!! form_row($form->captcha_on_login, ['checked' => $settings->captcha_on_login, 'attr' => ['disabled' => 'disabled']]) !!}
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