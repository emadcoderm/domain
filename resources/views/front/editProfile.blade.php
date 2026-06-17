@extends('front.layouts.layout')

@section('title')
{{ trans('front.profile.title') }} -
@endsection

@section('main_content')
<header class="page-header">
    <h1 class="page-title">{{ trans('front.profile.header') }}</h1>
</header>
@include('front.partials.alert')
{!! form_start($form) !!}
    {!! form_row($form->full_name) !!}
    {!! form_row($form->email) !!}
    <hr/>
    {!! form_row($form->new_password) !!}
    {!! form_row($form->new_password_confirmation) !!}
{!! form_end($form) !!}
@endsection