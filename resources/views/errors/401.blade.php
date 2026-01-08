@extends('errors::layout')

@section('title', __('Unauthorized'))
@section('image')
<img width="45%" src="{{asset('img/401 ERROR-05.png')}}">
<br>
<a href="{{route('home')}}" class="btn btn-primary">Regresar</a>
@endsection
@section('code', '401')
