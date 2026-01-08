@extends('layouts.main')
@section('title', 'Buscador de tipificaciones')
@section('menu_gestion','menu-open')
@section('gestion','active')
@section('buscador.index','active')
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
                        <li class="breadcrumb-item active">Buscador</li>
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
                            <h3 class="card-title">Buscador de tipificaciones</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">  
                            {!! Form::token() !!}
                            <div class="row"> 
                            <div class='col-md-4'>
                                    <div class="form-group">
                                        {!! Form::label('rango_fecha', 'Rango de Fechas', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                                                                                             
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            {{ Form::text('rango_fecha',null, ['class' => 'form-control calendar','id' => 'rango_fecha','placeholder'=>'DD/MM/YYYY','data-parsley-required-message' => 'Este campo es obligatorio', 'required']) }}                                                                   
                                        </div>
                                    </div>
                                </div> 
                                <div class='col-md-4'>
                                    <div class="form-group">
                                        {!! Form::label('n_cedula', 'Cédula', ['class' => 'col-form-label']) !!}                                                                                                                            
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-id-card"></i></span>
                                            </div>
                                            {{ Form::number('n_cedula',null, ['class' => 'form-control','id' => 'n_cedula']) }}                                                                   
                                        </div>
                                    </div>
                                </div>
                                    <div class='col-md-4'>
                                    <div class="form-group">
                                        {!! Form::label('telefono', 'Teléfono', ['class' => 'col-form-label']) !!}                                                                                                                            
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-phone"></i></span>
                                            </div>
                                            {{ Form::number('telefono',null, ['class' => 'form-control','id' => 'telefono']) }}                                                                   
                                            <span class="input-group-append">
                                                <button type="button" id="tipificacionSearch" data-href="{{route('tipificacion.show')}}" class="btn btn-primary btn-block"><i class="fas fa-search"></i> Buscar</button>
                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12"  id="displaytable_tipificacion" style="display: none;">
                                    <h6> Estos resultados son extraidos de forma integra desde la Base de Datos.</h6>    
                                    <div class="ln_solid"></div>
                                    <table id="datatable-tipificaciones" class="table text-sm compact table-sm text-sm table-bordered table-striped text-center">
                                        <thead>
                                            <tr>
                                                <th>Fecha del Registro</th>
                                                <th>Cédula</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Fecha de Nacimiento</th>
                                                <th>Email</th>
                                                <th>Teléfonos</th>
                                                <th>Operador</th>   
                                                <th>T.C | Cuenta</th>   
                                                <th>S.A | Monto</th>   
                                                <th>Tipificación 1</th>
                                                <th>Tipificación 2</th>
                                                <th>Tipificación 3</th>
                                                <th>Observaciones</th>
                                            </tr>
                                        </thead> 
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
{!! Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css')!!}
{!! Html::style('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')!!}    
@endpush

@push('scripts')   
<!-- DataTables  & Plugins -->
{!! Html::script('plugins/moment/moment.min.js') !!}
{!! Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js')!!}    
{!! Html::script('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')!!}
{!!Html::script('plugins/datatables/jquery.dataTables.js')!!}
{!!Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-responsive/js/dataTables.responsive.js')!!}
{!!Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')!!}
{!! Html::script('js/SegurosMercantil/gestion.js') !!}
@endpush