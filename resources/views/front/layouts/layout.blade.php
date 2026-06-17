@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row">
        <aside class="col-md-2 sidebar sidebar-left">
            <div class="profile-sidebar">
                <div class="profile-usermenu">
                    <ul class="nav">
                        @include('front.partials.dashboard_sidebar')
                    </ul>
                </div>
            </div>
        </aside>
        <div class="col-md-10 maincontent">
            @yield('main_content')
        </div>
    </div>
</div>
@endsection

@section('style')
@parent
@endsection

@section('scripts')
@parent
@endsection
