@extends('errors::layout')
@section('title', __('Too Many Requests'))
@section('image')
<img width="45%" src="{{asset('img/429 ERROR-06.png')}}">
@endsection
@section('code', '429')
@section('message')
<p>{{__('Intento de Sesión bloqueado, debe esperar 2 minutos.')}}</p>
<br>
<a href="{{route('home')}}" class="btn btn-primary">Regresar</a>
@endsection