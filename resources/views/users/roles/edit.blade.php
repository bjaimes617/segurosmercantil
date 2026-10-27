@extends('layouts.main')
@section('title', 'Editar Roles de usuario al Sistema')
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
                        <li class="breadcrumb-item">Roles</li>
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
                            <h3 class="card-title">Añadir Nuevo rol de usuario al sistema </h3>
                        </div>
                        {!! Form::open(['route' => ['roles.update',$role->id],'method' => 'PUT','id' => 'create-permission','class' => 'form-horizontal  form-label-left','data-parsley-validate']) !!}
                        {!! Form::token() !!}
                        <!-- /.card-header -->
                        <div class="card-body text-right">
                            <div class="form-group row">    
                                {!! Form::label('name', 'Nombre', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-6">
                                    {{Form::text('name',$role->name,['class'=>'form-control','id'=>'name','required'=>'required','placeholder'=>'Name'])}}                      
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                {!! Form::label('slug', 'Slug', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                         
                                <div class="col-sm-6">
                                    {{Form::text('slug',$role->slug,['class'=>'form-control','id'=>'slug','required'=>'required','placeholder'=>'Slug'])}} 
                                </div>                                
                            </div>
                            <div class="form-group row">                                
                                {!! Form::label('descripcion', 'Descripci&oacute;n', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-6">
                                    {{Form::text('descripcion',$role->description,['class'=>'form-control','id'=>'descripcion','required'=>'required','placeholder'=>'Detalle el permiso'])}}                                    
                                </div>                                
                            </div>
                             <div class="form-group row">                                
                                {!! Form::label('level', 'Level', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-6">
                                   {{ Form::select('level',['1'=>'1','2'=>'2','3'=>'3','4'=>'4','5'=>'5'],$role->level,['class' => 'form-control','id' => 'level','required','data-parsley-required-message' => 'Este campo es obligatorio','placeholder' => '[Seleccione]']) }}
                                </div>                                
                            </div>
                            <div class="form-group row">  
                                {!! Form::label('permisos', 'Permisos', ['class' => 'col-sm-3 col-form-label']) !!} <span style="color:red">*</span>                       
                                <div class="col-sm-6">                                    
                                    <select class="duallistbox" id="permisos" name='permisos[]' required="required" multiple="multiple">
                                        @foreach($permission as $permissions)
                                        <option value="{{$permissions->id}}" <?php if(in_array($permissions->id,$idpermission)) echo "Selected";?>>{{$permissions->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                                
                        </div>  
                    <div class="card-footer text-center">
                       <button type="submit"class="btn btn-lg btn-primary" data-toggle="tooltip" data-placement="top" title="Guardar"> <i class=" fa fa-save"></i></button>   
                    </div>
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
