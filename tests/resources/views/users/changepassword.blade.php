@extends('layouts.login')
@section('title','Inicio de Session')
@section('content') 

<div class="card card-outline card-primary">          
    <div class="card-header text-center">
        <a href="" class="h1"><img src="{{asset('img/LOGO DG AZULYMAGENTA.png')}}" alt="DirectaGroupLogo Logo"  height="55" width="210" style="opacity: .8"></a>
    </div>
    <div class="card-body">
        <div class="text-center"><b>@if(Session::has('password')){{Session::get('password')}}@endif.</b> <br> Por politicas de seguridad es necesario que ingrese una nueva contrase&ntilde;a,<br> la misma debe contener una letra mayuscula, un n&uacute;mero y como m&iacute;nimo 12 caracteres de longitud.</div>

        {!! Form::open(['route' => 'users.password.update','method' => 'post','id' => 'form_update_password','class' => 'form-horizontal  form-label-left','data-parsley-validate']) !!}
        @csrf
        <br>
        <div class="input-group mb-3">
            <input type="password" name="newpassword" id="newpassword" class="form-control @error('newpassword') is-invalid @enderror" data-check="{{route('users.checknewpassword')}}" value="{{old('newpassword')}}" placeholder="Nueva Contraseña">
            <div class="input-group-append">
                <div class="input-group-text"> 
                    <span class="fas fa-key"></span>
                </div>                
            </div>
            @error('password')
            <span>{{$message}}</span>
            @enderror
        </div>
        <div class="input-group mb-3">
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control @error('confirmpassword') is-invalid @enderror"  value="{{old('confirmpassword')}}" placeholder="Confirme la Contraseña">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>                
            </div>
            @error('confirmpassword')
            <span>{{$message}}</span>
            @enderror
        </div>

        <!-- /.social-auth-links -->

    </div>
    <div class="card-footer ">            
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" onclick="waith()">Conectar</button>
        </div>
        <!-- /.col -->
    </div>
</form> 
</div>
@endsection
@push('styles')
<!--Custom Style-->

@endpush
@push('scripts')
{!! Html::script("js/user/password.js") !!}
@endpush