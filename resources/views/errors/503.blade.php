@extends('errors::layout')
@section('title', __('Service Unavailable'))
@section('image')
<img width="45%" src="{{asset('img/503 ERROR -08.png')}}">
<div class="mid_center">
    {{__($exception->getMessage() ?: 'La plataforma se encuentra en Mantenimiento.')}}
</div>
@endsection
@section('message', __($exception->getMessage() ?: ''))
@section('code', '503')