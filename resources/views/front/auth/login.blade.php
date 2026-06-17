@extends('layouts.front')

@section('title')
{{ trans('front.log_in.title') }} -
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 maincontent">
            <div style="margin-top: 30px;" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">{{ trans('front.log_in.header') }}</h3>
                        <hr>
                        @include('front.partials.alert')
                        {{-- Forms/LoginForm --}}
                        {!! form_start($form) !!}
                        {!! form_row($form->email) !!}
                        {!! form_row($form->password) !!}
                        {!! form_row($form->remember) !!}
                        <br/>
                        <b><a href="{{ url('/password/email') }}">{{ trans('front.log_in.forgot_password') }}</a></b>
                        <hr/>
                        <div class="row">
                            <div class="col-lg-8">
                                @if (true === Setting::get('captcha_on_login'))
                                @include('front.partials.nocaptcha')
                                @endif
                            </div>
                            <div class="col-lg-4 text-right">
                                {!! form_widget($form->login, ['attr' => ['class' => 'btn btn-action']]) !!}
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