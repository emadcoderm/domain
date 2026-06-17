@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.blacklist_domain.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.blacklist_domain.box_show') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body">
                        {!! form_start($form) !!}
                        {!! form_row($form->name, ['attr' => ['disabled' => 'disabled']]) !!}
                        {!! form_row($form->zone_name) !!}
                        {!! form_row($form->reason, ['attr' => ['disabled' => 'disabled']]) !!}
                        @include('admin.partials.button', ['action' => 'b'])
                        {!! form_end($form, false) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection