@extends('layouts.main')
@section('title', 'Usuarios del Sistema|Perfil de Usuario')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item">Seguridad</li>
                        <li class="breadcrumb-item">Usuarios</li>
                        <li class="breadcrumb-item active">Perfil</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="card">                        
                        <div class="card-body">  
                            <div class="text-center">La nueva contraseña debe contener una letra mayuscula, un n&uacute;mero y como m&iacute;nimo 12 caracteres de longitud.</div>
                            {!! Form::open(['route' => 'users.password.update','method' => 'post','id' => 'form_update_password','class' => 'form-label-left','data-parsley-validate']) !!}
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
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-block">Conectar</button>
                            </div>
                        </div>
                        </form> 
                    </div>                                               
                </div>
            </div>
            <!-- /.card -->

        </div>
    </section>
</div>
@endsection
@push('scripts')
{!! Html::script('plugins/jquery-validation/jquery.validate.js') !!}
{!! Html::script("js/user/password.js") !!}
@endpush
