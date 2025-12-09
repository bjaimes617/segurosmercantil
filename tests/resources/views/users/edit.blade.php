@extends('layouts.main')
@section('title', 'Editar Usuario al Sistema')
@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Seguridad</a></li>
                        <li class="breadcrumb-item">Usuarios</li>
                        <li class="breadcrumb-item active">Editar</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">

                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Editando ficha del usuario</h3>
                        </div>
                        {!! Form::open(['route' => ['users.update',$user->id],'method' => 'PUT','id' => 'create-permission','class' => 'form-horizontal  form-label-left','data-parsley-validate']) !!}
                        {!! Form::token() !!}
                        <!-- /.card-header -->
                        <div class="card-body text-right">
                            <div class="form-group row">    
                                {!! Form::label('name', 'Nombre y Apelido', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-6">
                                    {{Form::text('name',$user->name,['class'=>'form-control','id'=>'name','required'=>'required','placeholder'=>'Nombre y Apellido'])}}
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                {!! Form::label('username', 'Cedula', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-6">
                                    {{Form::text('cedula',$user->cedula,['class'=>'form-control','id'=>'cedula','required'=>'required','placeholder'=>'Cedula de Identidad'])}}
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                {!! Form::label('username', 'Usuario', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-6">
                                    {{Form::text('username',$user->username,['class'=>'form-control','disabled','id'=>'username','required'=>'required','placeholder'=>'Nombre de usuario'])}}
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                {!! Form::label('email', 'Correo Electronico', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-6">
                                    {{Form::email('email',$user->email,['class'=>'form-control','id'=>'email','required'=>'required','placeholder'=>'xxxxxx@directagroup.net'])}}                                    
                                </div>                                
                            </div>
                            <div class="form-group row">  
                                {!! Form::label('estatus', 'Estatus', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-6">
                                    {{ Form::select('estatus',['1'=>'Activo','2'=>'Inactivo'],$user->getoriginal('estatus_id'),['class' => 'form-control','id' => 'estatus','required','data-parsley-required-message' => 'Este campo es obligatorio','placeholder' => '[Seleccione]']) }}
                                </div>
                            </div> 
                            <div class="form-group row">  
                                {!! Form::label('roles', 'Rol de Usuario', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-6">
                                    {{ Form::select('roles',$roles,$roleuser,['class' => 'form-control','id' => 'roles','required','data-parsley-required-message' => 'Este campo es obligatorio','placeholder' => '[Seleccione]']) }}
                                </div>
                            </div>  
                            
                            <div class="form-group row">  
                                {!! Form::label('resetpassword', 'Resetear Contraseña', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red"></span>                       
                                <div class="col-sm-6">
                                    <div class="icheck-primary d-inline float-left">
                                        <input type="checkbox" id="resetpassword" name="resetpassword" value="1" data-parsley-required-message='Este campo es obligatorio'>
                                        <label for="resetpassword">
                                        </label>
                                    </div>
                                </div>
                            </div>  
                        </div>  
                        @permission('update.users')
                    <div class="card-footer text-center">
                        <button type="submit"class="btn btn-lg btn-primary" data-toggle="tooltip" data-placement="top" title="Guardar"> <i class=" fa fa-save"></i></button>   
                    </div>
                        @endpermission
                    {!! Form::close() !!}
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
        </section>
</div>
<!-- /.container-fluid -->

@endsection
@push('styles')
{!!Html::style('plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')!!}

@endpush

@push('scripts')
{!!Html::script('plugins/jquery-validation/jquery.validate.min.js')!!}
{!!Html::script('plugins/jquery-validation/additional-methods.min.js')!!}
{!!Html::script('plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')!!}
{!!Html::script('js/roles/roles.js')!!}
@endpush
