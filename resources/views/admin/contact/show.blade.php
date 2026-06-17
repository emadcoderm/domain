@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.contact.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.contact.box_show') }}</h3>
                    </div>
                    <div class="box-body">
                        {!! form($form) !!}
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection