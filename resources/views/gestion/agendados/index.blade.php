@extends('layouts.main')
@section('title', 'Registros Agendados')
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
                        <li class="breadcrumb-item active">Agendados</li>
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
                            <h3 class="card-title">Buscar Clientes Agendados</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">  
                            {!! Form::token() !!}
                            <div class="row">                     
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('fecha', 'Fecha Agendamiento', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                                                                                             
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            {{ Form::text('fecha',null, ['class' => 'form-control calendarfecha','id' => 'fecha','placeholder'=>'DD/MM/YYYY','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        {!! Form::label('searchAgendados', '&nbsp;', ['class' => 'col-form-label']) !!} 
                                        <div class="input-group mb-3">                                              
                                            <button type="button" class="btn btn-primary" data-href="{{route('gestion.agendados.search')}}" id="searchAgendados"><i class="fas fa-search"></i></button>
                                        </div>
                                    </div>
                                    
                                </div>
                                <div class="col-md-12"  id="displaytable" style="display: none;">
                                    <h6>  Estos resultados son extraidos de forma integra desde la Base de Datos.</h6>    
                                    <div class="ln_solid"></div>

                                    <table id="datatables" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cedula</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Fecha de Nacimiento</th>    
                                                <th>Ultimo Comentario</th>   
                                                <th>Acciones</th>
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