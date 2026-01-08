@extends('layouts.main')
@section('title', 'Añadir Permisos del Sistema')
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
                        <li class="breadcrumb-item">Permisos</li>
                        <li class="breadcrumb-item active">Añadir</li>
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
                            <h3 class="card-title">Añadir Nuevo permiso al sistema </h3>
                        </div>
                        {!! Form::open(['route' => 'permissions.store','method' => 'post','id' => 'create-permission','class' => 'form-horizontal  form-label-left','data-parsley-validate']) !!}
                        {!! Form::token() !!}
                        <!-- /.card-header -->
                        <div class="card-body text-right">
                            <div class="form-group row">    
                                    {!! Form::label('name', 'Nombre', ['class' => 'col-sm-4 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-5">
                                    {!!Form::text('name',null,['class'=>'form-control','id'=>'name','required'=>'required','placeholder'=>'Name'])!!}                      
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                 {!! Form::label('slug', 'Slug', ['class' => 'col-sm-4 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-5">
                                    {!!Form::text('slug',null,['class'=>'form-control','id'=>'slug','required'=>'required','placeholder'=>'Slug'])!!}                                                                        
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                {!! Form::label('descripcion', 'Descripci&oacute;n', ['class' => 'col-sm-4 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-5">
                                    {!!Form::text('descripcion',null,['class'=>'form-control','id'=>'descripcion','required'=>'required','placeholder'=>'Detalle el permiso'])!!}                                    
                                </div>                                
                            </div>                            
                        </div>
                        <div class="card-footer text-center">
                            <button type="submit" class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-save"></i></button>
                            </div>
                        {!! Form::close() !!}
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
@endsection
@push('styles')

@endpush

@push('scripts')
{!!Html::script('plugins/jquery-validation/jquery.validate.min.js')!!}
{!!Html::script('plugins/jquery-validation/additional-methods.min.js')!!}
{!!Html::script('js/permissions/permisos.js')!!}
@endpush
