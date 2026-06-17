@extends('layouts.front')

@section('title')
{{ trans('front.sign_up.title') }} -
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 maincontent">
            <div style="margin-top: 30px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">{{ trans('front.sign_up.header') }}</h3>
                        <hr>
                        @include('front.partials.alert')
                        {{-- Forms\RegisterForm --}}
                        {!! form_start($form) !!}
                        {!! form_row($form->full_name) !!}
                        {!! form_row($form->email) !!}
                        <div class="row top-margin">
                            <div class="col-sm-6">
                                {!! form_row($form->password) !!}
                            </div>
                            <div class="col-sm-6">
                                {!! form_row($form->password_confirmation) !!}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-8">
                                @if (true === Setting::get('captcha_on_register'))
                                @include('front.partials.nocaptcha')
                                @endif
                            </div>
                            <div class="col-md-4 text-right">
                                {!! form_widget($form->register, ['attr' => ['class' => 'btn btn-action']]) !!}
                            </div>
                        </div>
                        {!! form_end($form) !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection