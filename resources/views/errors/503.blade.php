@extends('errors.layout')
@section('title', __('Service Unavailable'))
@section('content')
<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <h1>503</h1>
        </div>
        <h2>We are sorry,Service Unavailable</h2>
        <h3>{{ $exception->getMessage() }}.</h3>
        <a href="{{route('home')}}">Back To Homepage</a>
    </div>
</div>

@endsection
