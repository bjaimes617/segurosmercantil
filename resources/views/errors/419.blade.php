@extends('errors::layout')
@section('title', __('Page Expired'))
@section('image')
<img width="45%" src="{{asset('img/419 ERROR-07.png')}}">
@endsection
@section('code', '419')
@section('message')
<br>
<a href="{{route('home')}}" class="btn btn-primary">Regresar</a>
@endsection
