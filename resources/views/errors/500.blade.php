@extends('errors::layout')
@section('title', __('Server Error'))
@section('image')
<img width="45%" src="{{asset('img/500 ERROR-01.png')}}">
<div class="mid_center">
    @auth
    <a class="btn btn-primary" href="{{route('home')}}">Regresar</a>
    @else
    <a class="btn btn-primary" href="{{route('login')}}">Login</a>
    @endauth
</div>
@endsection
@section('message', __($exception->getMessage() ?: ''))
@section('code', '500')
