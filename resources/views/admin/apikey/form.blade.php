@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.apikey.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.apikey.box_form') }}</h3>
                    </div>
                    @include('admin.partials.alert')
                    <div class="box-body">
                        {!! form($form) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection