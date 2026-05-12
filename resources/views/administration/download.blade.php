@extends('layouts.main')
@section('title', 'Eliminar Registros')
@section('menu_administracion','menu-open')
@section('administracion','active')
@section('administracion.download','active')
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
                        <li class="breadcrumb-item active">Descargar Datos</li>
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
                            <h3 class="card-title">Descargar Lote de Datos</h3>
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
                                                <th>Nombre Lote</th>
                                                <th>Cantidad</th>                                               
                                                <th>Cargado el</th> 
                                                <th>Cargado por</th> 
                                                <th>Acciones</th> 
                                            </tr>
                                        </thead>
                                        <tboody>
                                           @foreach($lote as $key =>$client)                                              
                                                <tr>       
                                                    <td>{{$client->archivo}}</td>
                                                    <td>{{$client->RelationClientes()->count() }}</td>
                                                    <td>{{date('d/m/Y',strtotime($client->created_at))}}</td>
                                                    <td>{{$client->RelationUsers->username}}</td>
                                                    <td>
                                                        <form action="{{ route('administration.descargar.get',$client->id) }}" target="_blank" method="POST">
                                                            @csrf                                                            
                                                            <div class="btn-group">                                                           
                                                                <button type="submit" name="type" value="processed" 
                                                                    class="btn btn-warning btn-sm" data-toggle="tooltip" 
                                                                    data-placement="top" title="Descargar Registros Procesados"><i class="fa fa-download"></i></button>                                                      
                                                                <button type="submit" name="type" value="origin" {{ $client->identificacion_storage === null ?  'disabled' : '' }}
                                                                    class="btn btn-danger btn-sm" data-toggle="tooltip"  
                                                                    data-placement="top" title="Descargar Archivo Original"><i class="fas fa-file-csv"></i></button>
                                                            </div>
                                                        </form>
                                                    </td>
                                                </tr>
                                             
                                            @endforeach
                                        </tboody>
                                    </table> 
                                </div>                                 
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
{!! Html::script('plugins/bs-custom-file-input/bs-custom-file-input.min.js') !!}
{!!Html::script('plugins/datatables/jquery.dataTables.js')!!}
{!!Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-responsive/js/dataTables.responsive.js')!!}
{!!Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')!!}

{!! Html::script('js/administration/validate.init.js') !!}    
@endpush
