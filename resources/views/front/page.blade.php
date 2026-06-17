@extends('layouts.front')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 maincontent">
            <header class="page-header">
                <h1 class="page-title">{!! $page->title !!}</h1>
            </header>
            {!! $page->content !!}
        </div>
    </div>
</div>
@endsection