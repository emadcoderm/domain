@extends('layouts.front')

@section('title')
{{ trans('front.home.title') }}
@endsection

@section('content')
<header id="head">
    <div class="container">
        <div class="row">
            <h1 class="lead">{!! Setting::get('lead_text') !!}</h1>
        </div>
        <div class="row">
            {!! form_start($form, ['class' => 'form-inline']) !!}
                <div class="input-group input-group-lg">
                    {!! form_widget($form->name, ['attr' => ['class' => 'form-control col-md-4']]) !!}
                    <div class="input-group-btn input-group-lg">
                        {!! form_widget($form->zone_id, ['attr' => ['class' => 'selectpicker form-control']]) !!}
                    </div>
                </div>
                <div class="input-group input-group-lg">
                    {!! form_widget($form->submit, ['label' => trans('front.home.domain_check'), 'attr' => ['class' => 'btn btn-action btn-lg-normal form-control']]) !!}
                </div>
            {{-- </form> --}}
            {!! form_end($form, false) !!}
        </div>
        @if (Session::has('domain_status'))
            <div style="font-size: 18px">
                {!! Session::get('domain_status') !!}
            </div>
        @endif
    </div>
</header>
<!-- /Header -->

<!-- Intro -->
<div class="container text-center">
    <br> <br>
    <h2 class="thin">{!! Setting::get('middle_title') !!}</h2>
    <p class="text-muted">
        {!! Setting::get('middle_body') !!}
    </p>
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