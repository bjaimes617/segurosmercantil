@extends('errors::layout')

@section('title', __('Forbidden'))
@section('image')
<img width="45%" src="{{asset('img/403 ERROR-04.png')}}">
<div class="mid_center">
    @auth
    <a class="btn btn-primary" href="{{route('home')}}">Regresar</a>
    @else
    <a class="btn btn-primary" href="{{route('login')}}">Login</a>
    @endauth
</div>
@endsection
@section('message', __($exception->getMessage() ?: ''))
@section('code', '403')