@extends('layouts.login')
@section('title','Inicio de Session')
@section('content') 
<div class="login-box">
    <div class="card card-outline card-primary">          
        <div class="card-header text-center">
            <a class="h1"><img src="{{asset('img/LOGO DG AZULYMAGENTA.png')}}" alt="DirectaGroupLogo Logo" width="210"></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Conectate con nuestra plataforma</p>

            <form action="{{ route('loginin') }}" method="post">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="username" id="username" class="form-control @error('username') is-invalid @enderror" value="{{old('username')}}" placeholder="Usuario">
                    <div class="input-group-append">
                        <div class="input-group-text"> 
                            <span class="fas fa-user"></span>
                        </div>                
                    </div>
                    @error('username')
                    <span>{{$message}}</span>
                    @enderror
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control @error('password') is-invalid @enderror"  value="{{old('password')}}" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>                
                    </div>
                    @error('password')
                    <span>{{$message}}</span>
                    @enderror
                </div>
                <div class="row float-right">            
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Conectar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>               
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <img class="" src="{{asset('img/LOGO DG AZULYMAGENTA.png')}}" alt="DirectaGroupLogo Logo" width="210">
                    </div>
                    <form action="{{route('password.email')}}" method="post">
                        @csrf
                        <div class="modal-body">
                            <p class="login-box-msg">Recuperar Contraseña</p>
                            <div class="input-group mb-3">
                                <input type="email" name="email" id="email" class="form-control @error('email') is-invalid @enderror"  value="{{old('email')}}" placeholder="xxxx@directagroup.net">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="far fa-envelope" aria-hidden="true"></span>                    
                                    </div>                
                                </div>
                                @error('email')
                                <span>{{$message}}</span>
                                @enderror
                            </div>
                            <p class="text-center">Para Restaurar tu contraseña de acceso, ingresa por favor tu dirección de correo electronico.</p>                                                        
                            <p class="text-center">Recuperación vía E-mail <b style="color:red;">NO DISPONIBLE </b>, Contacte al Administrador.</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" disabled>Procesar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>
@endsection