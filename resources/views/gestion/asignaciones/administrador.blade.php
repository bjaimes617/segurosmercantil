@extends('layouts.main')
@section('title', 'Asignación de Registros')
@section('menu_gestion','menu-open')
@section('gestion','active')
@section('gestion.asignar','active')
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
                        <li class="breadcrumb-item">Gestión</li>
                        <li class="breadcrumb-item active">Asignar</li>
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
                            <h3 class="card-title">Asignar de Clientes al Sistema</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body"> 
                            {!! Form::open(['route' => 'gestion.asignar.store','method' => 'post','id' => 'AsignarClientes','class' => 'form-horizontal  form-label-left','data-parsley-validate','enctype' => 'multipart/form-data']) !!}
                            {!! Form::token() !!}
                            <div class="row">                     
                                <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">                                            
                                            <div class="form-group">
                                                {!! Form::label('user', 'Usuario de Operador', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                <div class="input-group mb-3">  
                                                    <select id="user" class="form-control" required name="user">
                                                        <option value="">[SELECCIONE]</option>
                                                        @foreach($users as $user)
                                                        <option value="{{$user->id}}">{{$user->name}}</option>
                                                        @endforeach                                                       
                                                    </select>

                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <h6>  Estos resultados son extraidos de forma integra desde la Base de Datos.</h6>    
                                    <div class="ln_solid"></div>
                                    <table id="datatables" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>   
                                                <th><input type="checkbox" id="select_all"></th>
                                                <th>Nacionalidad</th>
                                                <th>Cedula</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Fecha de Nacimiento</th>
                                            </tr>
                                        </thead>  
                                        <tbody>
                                            @foreach($clientes as $client)
                                            <tr>
                                                <td><input type="checkbox" name="cliente[]" class="check" type="cliente" value="{{$client->id}}" id="cliente"></td>
                                                <td>{{$client->nacionalidad_cliente}}</td>
                                                <td>{{$client->n_cedula}}</td>
                                                <td>{{$client->nomb1}} {{$client->nomb2}} {{$client->ape1ld1}} {{$client->apelld2}}</td>
                                                <td>{{date('d/m/Y', strtotime($client->fecha_de_nacimiento))}}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table> 
                                </div>                                
                                 <div class="col-md-12">
                                     <br>
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-exchange-alt"></i> Asignar</button>
                                </div>
                            </div>
                            {!! Form::close() !!}  
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
{!!Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
{!!Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
{!!Html::style('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')!!}
@endpush

@push('scripts')   
<!-- DataTables  & Plugins -->
{!!Html::script('plugins/datatables/jquery.dataTables.js')!!}
{!!Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-responsive/js/dataTables.responsive.js')!!}
{!!Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')!!}
{!! Html::script('js/SegurosMercantil/Validate.init.js') !!}
<script>$(function () {
    if ($('#datatables').length != 0) {
        $("#datatables").DataTable({
            "lengthMenu": [25,50,100,150,250,500,700],
            "responsive": true,
            "lengthChange": true,
            "autoWidth": false,
            "ordering": true,
            //"buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"]
        });
    }
        ///añadimos validaciones de los checkbox
    $('.check').rules('add', {
        alMenosUnoSeleccionado: true
    });
});
</script>
@endpush