@extends('errors.layout')
@section('title', __('Page Not Found'))
@section('content')
<div id="notfound">
    <div class="notfound">
        <div class="notfound-404" >
            <h1>404</h1>
        </div>
        <h2>We are sorry,404 Page not found!</h2>
        <p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
        <a href="{{route('home')}}">Back To Homepage</a>
    </div>
</div>

@endsection
