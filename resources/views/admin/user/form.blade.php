@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.user.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.user.box_form') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body">
                        {!! form_start($form) !!}
                        {!! form_row($form->full_name) !!}
                        {!! form_row($form->email) !!}
                        {!! form_row($form->new_password) !!}
                        {!! form_row($form->new_password_confirmation) !!}
                        {!! form_row($form->enabled, ['checked' => $user->enabled]) !!}
                        {!! form_end($form) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection