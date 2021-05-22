@extends('errors.layout')
@section('title', __('Page Expired'))
@section('content')
<div id="notfound">
    <div class="notfound">
        <div class="notfound-404" >
            <h1>419</h1>
        </div>
        <h2>We are sorry,Page Expired</h2>
        <a href="{{route('login')}}">Back To Login</a>
    </div>
</div>

@endsection
