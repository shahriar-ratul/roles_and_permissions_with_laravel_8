@extends('errors.layout')
@section('title', __('Unauthorized'))
@section('content')
<div id="notfound">
    <div class="notfound">
        <div class="notfound-404">
            <h1>403</h1>
        </div>
        <h2>We are sorry,Access to this resource on the server is denied</h2>
        <h3>{{ $exception->getMessage() }}.</h3>
        <a href="{{route('home')}}">Back To Homepage</a>
    </div>
</div>

@endsection
