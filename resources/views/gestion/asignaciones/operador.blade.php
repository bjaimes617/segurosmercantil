@extends('layouts.main')
@section('title', 'Carga de Registros')
@section('menu_gestion','menu-open')
@section('gestion','active')
@section('gestion.'.$type,'active')
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
                        <li class="breadcrumb-item">Gestion</li>
                        <li class="breadcrumb-item active">Asignados</li>
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
                            <h3 class="card-title">Listado de Clientes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">                           
                            <div class="row">                     

                                <div class="col-md-12">
                                    <h6>  Estos resultados son extraidos de forma integra desde la Base de Datos.</h6>    
                                    <div class="ln_solid"></div>
                                    <table id="datatables" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>   
                                                <th>#</th>
                                                <th>Nacionalidad</th>
                                                <th>Cedula</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Fecha de Nacimiento</th>                                                
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tboody>
                                            @foreach($clientes as $key =>$client)
                                            <tr>
                                                <td>{{$key+1}}</td>
                                                <td>{{$client->nacionalidad_cliente}}</td>
                                                <td>{{$client->n_cedula}}</td>
                                                <td>{{$client->nomb1}} {{$client->nomb2}} {{$client->ape1ld1}} {{$client->apelld2}}</td>
                                                <td>{{date('d/m/Y', strtotime($client->fecha_de_nacimiento))}}</td>
                                               <td><a class="btn btn-primary btn-sm" data-toggle="tooltip" 
                                                      data-placement="top" title="Gestionar Cliente"
                                                      href="{{route('gestion.show',[$client->id,$type])}}"><i class="fas fa-edit"></i></a></td>
                                            </tr>
                                            @endforeach
                                        </tboody>
                                    </table> 
                                </div>

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
{!! Html::script('js/SegurosMercantil/gestion.js') !!}
@endpush