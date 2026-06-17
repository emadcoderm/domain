@extends('layouts.front')

@section('title')
{{ trans('front.contact.title') }} -
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 maincontent">
            <div style="margin-top: 30px" class="col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">{{ trans('front.contact.header') }}</h3>
                        <p class="text-center text-muted">
                            {{ trans('front.contact.description') }}
                        </p>
                        <hr>
                        @include('front.partials.alert')
                        {!! form_start($form) !!}
                        {!! form_row($form->name) !!}
                        {!! form_row($form->email) !!}
                        {!! form_row($form->message) !!}
                        <hr/>
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                {!! form_widget($form->send) !!}
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