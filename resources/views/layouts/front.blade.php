<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{!! Setting::get('description') !!}">
    <meta name="keyword" content="{!! Setting::get('keyword') !!}">

    <title>@yield('title'){{ Setting::get('page_title') }}</title>

    <link rel="shortcut icon" href="{{ url('favicon.png') }}">
    <link rel="stylesheet" media="screen" href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <link rel="stylesheet" href="{{ url( elixir('css/front.css') ) }}">

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    @yield('styles')
</head>
<body class="home">
    <div class="navbar navbar-inverse navbar-fixed-top headroom" >
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse"><span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <a class="navbar-brand" href="{{ route('home') }}">
                    <img src="{{ url('build/images/logo.png') }}" alt="logo">
                </a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav pull-right">
                    @include('front.partials.menu')
                </ul>
            </div>
        </div>
    </div>

    <header id="head" class="secondary"></header>

    @yield('content')

    <footer id="footer" class="top-space">
        <div class="footer1">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 widget">
                        <h3 class="widget-title">{!! Setting::get('footer_left_title') !!}</h3>
                        <div class="widget-body">
                            {!! Setting::get('footer_left_body') !!}
                        </div>
                    </div>
                    <div class="col-md-3 widget">
                        <h3 class="widget-title">{!! Setting::get('footer_social_title') !!}</h3>
                        <div class="widget-body">
                            <p class="follow-me-icons">
                                @if(Setting::get('footer_social_facebook'))
                                <a href="{{ Setting::get('footer_social_facebook') }}" target="_blank"><i class="fa fa-facebook fa-2"></i></a>
                                @endif
                                @if(Setting::get('footer_social_twitter'))
                                <a href="{{ Setting::get('footer_social_twitter') }}" target="_blank"><i class="fa fa-twitter fa-2"></i></a>
                                @endif
                                @if(Setting::get('footer_social_googleplus'))
                                <a href="{{ Setting::get('footer_social_googleplus') }}" target="_blank"><i class="fa fa-google-plus fa-2"></i></a>
                                @endif
                                @if(Setting::get('footer_social_pinterest'))
                                <a href="{{ Setting::get('footer_social_pinterest') }}" target="_blank"><i class="fa fa-pinterest-p fa-2"></i></a>
                                @endif
                                @if(Setting::get('footer_social_linkedin'))
                                <a href="{{ Setting::get('footer_social_linkedin') }}" target="_blank"><i class="fa fa-linkedin fa-2"></i></a>
                                @endif
                                @if(Setting::get('footer_social_instagram'))
                                <a href="{{ Setting::get('footer_social_instagram') }}" target="_blank"><i class="fa fa-instagram fa-2"></i></a>
                                @endif
                                @if(Setting::get('footer_social_youtube'))
                                <a href="{{ Setting::get('footer_social_youtube') }}" target="_blank"><i class="fa fa-youtube fa-2"></i></a>
                                @endif
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 widget">
                        <h3 class="widget-title">{!! Setting::get('footer_right_title') !!}</h3>
                        <div class="widget-body">
                            {!! Setting::get('footer_right_body') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="footer2">
            <div class="container">
                <div class="row">

                    <div class="col-md-6 widget">
                        <div class="widget-body">
                            <p class="simplenav">
                                powered by <a href="http://studionesia.com" target="_blank">www.studionesia.com</a>
                            </p>
                        </div>
                    </div>

                    <div class="col-md-6 widget">
                        <div class="widget-body">
                            <p class="text-right">
                                Copyright &copy; 2015</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="{{ url( elixir('js/front.js') ) }}" type="text/javascript"></script>
    @yield('scripts')
    @set($ga = Setting::get('google_analytics'))
    @if (!empty($ga))
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', '{{ $ga }}', 'auto');
      ga('send', 'pageview');
    </script>
    @endif
</body>
</html>