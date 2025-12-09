@extends('layouts.main')
@section('title', 'Eliminar Registros')
@section('menu_administracion','menu-open')
@section('administracion','active')
@section('administracion.deleted','active')
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
                        <li class="breadcrumb-item active">Eliminar</li>
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
                            <h3 class="card-title">Eliminar Registros Cargados</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            {!! Form::open(['route' => 'administration.deleted','method' => 'post','id' => 'DeletedFiles','class' => 'form-horizontal  form-label-left','data-parsley-validate','enctype' => 'multipart/form-data']) !!}
                            {!! Form::token() !!}
                            <div class="row"> 
                                <div class="col-md-12">
                                    <h6>  Estos resultados son extraidos de forma integra desde la Base de Datos.</h6>    
                                    <div class="ln_solid"></div>
                                    <table id="datatables" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>   
                                                <th><input type="checkbox" id="select_all"></th>
                                                <th>ID</th>
                                                <th>Nombre Lote</th>
                                                <th>Cantidad</th>
                                                <th>Cargado por</th>
                                                <th>Cargado el</th> 
                                            </tr>
                                        </thead>
                                        <tboody>
                                            @foreach($lote as $key =>$client)
                                                @if($client->conteos != 0)
                                                <tr>
                                                    <td><input name="check[]" class="check" type="checkbox" value="{{$client->lote_id}}" id="check"></td>
                                                    <td>{{$client->lote_id}}</td>
                                                    <td>{{$client->RelationLotes != null ? $client->RelationLotes->archivo : null}}</td>
                                                    <td>{{$client->conteos }}</td>
                                                    <td>{{$client->RelationLotes != null ? date('d/m/Y',strtotime($client->RelationLotes->created_at)) : null }}</td>
                                                    <td>{{$client->RelationLotes != null ? $client->RelationLotes->RelationUsers->username : null}}</td>
                                                </tr>
                                                @endif
                                            @endforeach
                                        </tboody>
                                    </table> 
                                </div> 
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-trash"></i> Eliminar</button>
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
