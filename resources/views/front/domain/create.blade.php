@extends('front.layouts.layout')

@section('title')
{{ trans('front.domain.title_add') }} -
@endsection

@section('main_content')
<header class="page-header">
    <h1 class="page-title">{{ trans('front.domain.header_add') }}</h1>
</header>
@include('front.partials.alert')
<div class="row">
    <div class="col-md-12">
        {!! form_start($form, ['class' => 'form-inline']) !!}
        <div class="input-group input-group-lg">
            {!! form_widget($form->name, ['default_value' => $request->domain]) !!}
            <div class="input-group-btn input-group-lg">
                {!! form_widget($form->zone_id, ['selected' => $request->zone]) !!}
            </div>
        </div>
        {!! form_end($form) !!}
    </div>
</div>
@endsection

@section('styles')
@parent
<style>
.input-group > .input-group-btn:last-child > .selectpicker {
    border-top-right-radius: 5px;
    border-bottom-right-radius: 5px;
}

.input-group > .input-group-btn:first-child > .selectpicker {
    border-top-left-radius: 5px;
    border-bottom-left-radius: 5px;
}
</style>
@endsection