@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            {{ trans('admin.page.header') }}
        </h1>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">{{ trans('admin.page.box_form') }}</h3>
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

@section('styles')
@parent
{!! Html::style('css/bootstrap3-wysihtml5.min.css') !!}
@endsection

@section('scripts')
@parent
{!! Html::script('js/bootstrap3-wysihtml5.all.min.js') !!}
<script>
    $(function () {
        $("textarea.whtml5").wysihtml5();
    });
</script>
@endsection