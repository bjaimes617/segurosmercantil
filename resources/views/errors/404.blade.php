@extends('errors::layout')
@section('title', __('Not Found'))
@section('code', '404')
@section('image')
<img width="45%" src="{{asset('img/404 ERROR-02.png')}}">
<br>
<a href="{{route('home')}}" class="btn btn-primary">Regresar</a>
@endsection
@section('message', __($exception->getMessage() ?: 'No encontrado'))

