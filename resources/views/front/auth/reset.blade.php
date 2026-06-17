@extends('layouts.front')

@section('title')
{{ trans('front.reset_password.title') }} -
@endsection

@section('content')
<div class="container">
    <div class="row">
        <div class="col-xs-12 maincontent">
            <div style="margin-top: 30px;" class="col-md-10 col-md-offset-1 col-sm-10 col-sm-offset-1">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <h3 class="thin text-center">{{ trans('front.reset_password.header') }}</h3>
                        <hr>
                    	@if (count($errors) > 0)
                    		<div class="alert alert-danger">
                    			<strong>Whoops!</strong> There were some problems with your input.<br><br>
                    			<ul>
                    				@foreach ($errors->all() as $error)
                    					<li>{{ $error }}</li>
                    				@endforeach
                    			</ul>
                    		</div>
                    	@endif

                    	<form class="form-horizontal" role="form" method="POST" action="{{ url('/password/reset') }}">
                    		<input type="hidden" name="_token" value="{{ csrf_token() }}">

                    		<div class="form-group">
                    			<label class="col-md-4 control-label">{{ trans('front.reset_password.field_email') }}</label>
                    			<div class="col-md-6">
                    				<input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    			</div>
                    		</div>

                    		<div class="form-group">
                    			<label class="col-md-4 control-label">{{ trans('front.reset_password.field_password') }}</label>
                    			<div class="col-md-6">
                    				<input type="password" class="form-control" name="password">
                    			</div>
                    		</div>

                    		<div class="form-group">
                    			<label class="col-md-4 control-label">{{ trans('front.reset_password.field_password_confirmation') }}</label>
                    			<div class="col-md-6">
                    				<input type="password" class="form-control" name="password_confirmation">
                    			</div>
                    		</div>

                    		<div class="form-group">
                    			<div class="col-md-6 col-md-offset-4">
                    				<button type="submit" class="btn btn-primary">
                    					{{ trans('front.reset_password.button_reset') }}
                    				</button>
                    			</div>
                    		</div>
                    	</form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection