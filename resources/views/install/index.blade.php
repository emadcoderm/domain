<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Installation</title>
    <link rel="shortcut icon" href="favicon.ico">
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="{{ url( elixir('css/front.css') ) }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="home">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 maincontent">
                <div style="margin-top: 30px;" class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <h3 class="thin text-center">1-Click Installation</h3>
                            <hr>
                            @include('front.partials.alert')
                            {!! Form::model(null, ['route' => 'install_change', 'class' => 'form-horizontal']) !!}
                                <b>Database</b>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Host</label>
                                    <div class="col-md-9">
                                        {!! Form::text('host', null, ['class' => 'form-control input-md', 'placeholder' => 'Database Host']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Username</label>
                                    <div class="col-md-9">
                                        {!! Form::text('username', null, ['class' => 'form-control input-md', 'placeholder' => 'Database Username']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        {!! Form::text('password', null, ['class' => 'form-control input-md', 'placeholder' => 'Database Password']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Name</label>
                                    <div class="col-md-9">
                                        {!! Form::text('name', null, ['class' => 'form-control input-md', 'placeholder' => 'Database Name']) !!}
                                    </div>
                                </div>
                                <hr/>
                                <b>Administrator</b>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Full Name</label>
                                    <div class="col-md-9">
                                        {!! Form::text('admin_full_name', null, ['class' => 'form-control input-md', 'placeholder' => 'Administrator Full Name']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Email</label>
                                    <div class="col-md-9">
                                        {!! Form::email('admin_email', null, ['class' => 'form-control input-md', 'placeholder' => 'Administrator Email']) !!}
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label">Password</label>
                                    <div class="col-md-9">
                                        {!! Form::text('admin_password', null, ['class' => 'form-control input-md', 'placeholder' => 'Administrator Password']) !!}
                                    </div>
                                </div>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <b><a href="http://studionesia.com" target="_blank">www.studionesia.com</a></b>
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <button class="btn btn-action" type="submit">PROCESS</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ url( elixir('js/front.js') ) }}" type="text/javascript"></script>
</body>
</html>