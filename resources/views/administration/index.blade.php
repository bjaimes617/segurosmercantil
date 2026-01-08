@extends('layouts.main')
@section('title', 'Carga de Registros')
@section('menu_administracion','menu-open')
@section('administracion','active')
@section('administracion.index','active')
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
                        <li class="breadcrumb-item">Administracion</li>
                        <li class="breadcrumb-item active">Cargar</li>
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
                        <div class="card-header">
                            <h3 class="card-title">Carga de Clientes al Sistema</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! Form::open(['route' => 'administration.store','method' => 'post','id' => 'uploadFile','class' => 'form-horizontal  form-label-left','data-parsley-validate','enctype' => 'multipart/form-data']) !!}
                            {!! Form::token() !!}
                            <div class="row">                        

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="archivo">Archivo de Cargar de Clientes</label><span class="required">*</span>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" required id="archivo" name="archivo">
                                                <label class="custom-file-label" for="exampleInputFile">Buscar Archivo en...</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary cargamasiva"><i class="fa fa-save"></i> upload</button>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                <div class='col-md-12'>
                                <h5 Style="color: red;"> Recomendaciones a considerar al momento de subir el archivo:</h5>
                                <p>Utilice el formato suministrado para cargar los registros. Si no lo tienes Descarga <a href="{{asset('/source/storage/app/public/formato_mercantil.csv')}}">Aqui</a></p>
                                <p>No realice ninguna modificación en las cabeceras de las columnas </p>
                                <p>Revisar que la <b>Fecha de Nacimiento</b> se encuentre como Y-M-D </p>
                                <p>Revisar el <b>Numero de Cuenta</b> el cual la columna se encuentre configurada como Texto, para que se refleje los 20 Caracteres. </p>
                                <p>Al guardar, abrir el archivo con block de notas, y verificar la separacion de valores con Punto y coma <b>;</b> y que los valores anteriores se encuentre correctos.</p>
                                
                            </div> 
                            </div>
                            {!! Form::close() !!}  
                        </div>
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
<!-- DataTables  & Plugins -->
{!! Html::script('plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
{!! Html::script('js/administration/validate.init.js') !!}    
@endpush
