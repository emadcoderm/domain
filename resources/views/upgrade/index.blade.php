<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Upgrade</title>
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
                            <h3 class="thin text-center">Upgrading</h3>
                            <hr>
                            @include('front.partials.alert')
                            {!! Form::open(['route' => 'upgrade_process']) !!}
                                <p>Before installing the update, it is recommended that you have a backup of your <b>files</b> and <b>database</b> </p>
                                <p>If you sure to upgrade the script, click <b>UPGRADE</b> button below.</p>
                                <hr/>
                                <div class="row">
                                    <div class="col-lg-8">
                                        <b><a href="http://studionesia.com" target="_blank">www.studionesia.com</a></b>
                                    </div>
                                    <div class="col-lg-4 text-right">
                                        <button class="btn btn-action" type="submit">UPGRADE</button>
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