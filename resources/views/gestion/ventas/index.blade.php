@extends('layouts.main')
@section('title', 'Registros De Clientes Con Ventas')
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
                        <li class="breadcrumb-item active">Ventas</li>
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
                            <h3 class="card-title">Buscar Clientes con Ventas Generadas</h3>
                        </div>   
                        <script>
                        var esOperador = @json(!$isOperador); 
                        </script>                          
                        <div class="card-body">                             
                            <div class="row">  
                                <form id="buscar-cliente-ventas" action="{{ route('gestion.obtener.ventas') }}" method="POST" class="text-sm form-horizontal  form-label-left" data-parsley-validate>
                                    @csrf
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <span for="cedula_cliente" style="color:red;"> <i class="fas fa-info-circle"></i> Ingrese la cedula de cliente para verificar si tiene ventas generadas</span>
                                        <div class="input-group">  
                                            <input type="text" name="cedula_cliente" required class="form-control input-number" id="cedula_cliente" placeholder="123456...">
                                           <div class="input-group-append">
                                            <button type="submit" id="buscar_cliente" class="btn btn-primary"><i class="fas fa-search"></i> Buscar</button>
                                           </div>
                                        </div> 
                                    </div>
                                </div>
                            </form>
                                <div class="col-md-12"  id="displaytable" style="display:none;">
                                    <h6> Se muestran los resultados de las concidencias encontradas.</h6>    
                                    <div class="ln_solid"></div>
                                    <table id="datatablesVentasGenerate" class="table table-sm table-bordered table-hover text-center" width="100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cedula</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Fecha de Nacimiento</th> 
                                                <th>Fecha Emisión</th>    
                                                <th>Total Productos</th>                        
                                                @if(!$isOperador) 
                                                <th>Usuario</th>    
                                                <th>Acciones</th>    
                                                @endif
                                            </tr>
                                        </thead> 
                                        
                                    </table>                                          

                                </div>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="modal fade" id="modal-deleted">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Eliminar Ventas Generadas</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                     <form id="deleted-form" action='' method="POST" class="text-sm form-horizontal  form-label-lef">
                                        <div class="modal-body">   
                                            <div class="row">
                                            @METHOD('DELETE')      
                                            @csrf                                        
                                            <div class="col-md-12">                                            
                                                <div class="form-group">
                                                    {!! Form::label('razones', 'Ingrese el motivo de Eliminacion de este cliente', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                    <div class="input-group mb-3">  
                                                        <input id="razones" name="razones" required class="form-control input-text" placeholder="No interesado?">                                                    
                                                    </div> 
                                                </div>
                                            </div>                                       
                                            </div>                                       
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-danger"><i class="fas fa-check-circle"></i> Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

                        <div class="modal fade" id="modal-update-data">
                            <div class="modal-dialog modal-xl">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Cliente: <span id="nombre_cliente"></span></h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                     <form id="update-data" action='' method="POST" class="text-sm form-horizontal  form-label-lef">
                                        <div class="modal-body">   
                                            <div class="row">
                                                @METHOD('put')      
                                                @csrf         
                                                <input type="hidden" name="fecha_emision" id="fecha_emision">                               
                                                <div class="col-md-6">                                            
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="cd_edo_civil">Estado Civil</label>                                                   
                                                        <div class="input-group">  
                                                            <select name="cd_edo_civil" id="cd_edo_civil" class="form-control">
                                                                @foreach(config('app.cd_edo_civil') as $key => $value)
                                                                    <option value="{{ $key }}">{{ $value }}</option>
                                                                @endforeach
                                                            </select>                                                      
                                                        </div> 
                                                    </div>
                                                </div> 
                                                <div class="col-md-6">                                                                     
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="email_persol_tomador">Correo Electronico Personal</label> <span class="required" style="color:red;"> * </span>                                                               
                                                        <div class="input-group">  
                                                            <input type="email" name="email_persol_tomador" id="email_persol_tomador" class="form-control" required>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">                                                                     
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="email_trabajo_u_ofici_tomador">Correo Electronico Trabajo</label> <span class="required" style="color:red;"> * </span>                                                               
                                                        <div class="input-group">  
                                                            <input type="email" name="email_trabajo_u_ofici_tomador" id="email_trabajo_u_ofici_tomador" class="form-control" required>
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="direccion">Dirección</label> <span class="required" style="color:red;"> * </span>                                                               
                                                        <div class="input-group">  
                                                            <input type="text" name="direccion" id="direccion" class="form-control" required maxlength="190">
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="domicilioadomanual">Instrumento de Domicilio</label> <span class="required" style="color:red;"> * </span>                                                             
                                                        <select id="domicilioadomanual" name="domicilioadomanual" required class="form-control">
                                                            <option value=''>[SELECCIONE]</option>      
                                                            <option value='1'> CUENTA BANCARIA</option>
                                                            <option value='2'> TARJETA DE CREDITO</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="bancoselect">Institución Bancaria</label> <span class="required" style="color:red;"> * </span>                                                              
                                                        <select id="bancoselect" name="bancoselect" required class="form-control">
                                                            <option value=''>[SELECCIONE]</option>
                                                            @foreach($banco as $ban)
                                                            <option value='{{$ban->id}}'>{{$ban->banco}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="tipoinstrumentonewmanual">Tipo de Instrumento</label> <span class="required" style="color:red;"> * </span>                                                              
                                                        <div class="input-group">  
                                                            <select name="tipoinstrumentonewmanual" id="tipoinstrumentonewmanual" class="form-control" required>
                                                                <option value=''>[SELECCIONE]</option>                                                                        
                                                            </select>                                                                   
                                                        </div> 
                                                    </div>
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="form-group">
                                                        <label class="col-form-label" for="instrumentonewmanual">Instrumento para Domiciliar</label> <span class="required" style="color:red;"> * </span>                                                               
                                                        <div class="input-group">  
                                                            <input type="text" name="instrumentonewmanual" id="instrumentonewmanual" class="form-control input-number" required maxlength="20">
                                                        </div> 
                                                    </div>
                                                </div>                                                      
                                            </div>                                       
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                            <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle"></i> Confirmar</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
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
<link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css') }}"></script>    
@endpush

@push('scripts')   
<!-- DataTables  & Plugins -->
<script type="text/javascript" src="{{ asset('plugins/moment/moment.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-daterangepicker/daterangepicker.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/SegurosMercantil/Validate.init.js') }}"></script>
<script type="text/javascript" src="{{ asset('js/SegurosMercantil/gestion.js') }}"></script>
@endpush