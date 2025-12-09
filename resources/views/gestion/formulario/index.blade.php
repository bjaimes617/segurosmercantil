@extends('layouts.main')
@section('title', 'Gestionando Cliente')
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
                        <li class="breadcrumb-item">Gestion de Ventas</li>
                        <li class="breadcrumb-item active">Generar Venta</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Visualizando informacion de: <b>{{$client->nomb1}} {{$client->nomb2}} {{$client->apelld1}} {{$client->apelld2}}</b>  </h3>
                            <p class="float-right">                                
                                <button type="button" 
                                        class="btn btn-md btn-warning"
                                        data-toggle="modal" 
                                        data-target="#modal-incidencias" 
                                        onclick="Incidencias();"
                                        ><i class="fas fa-exclamation-circle"></i> Incidencia</button>
                            </p>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">                           
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card card-primary card-tabs">
                                        <div class="card-header p-0 pt-1">
                                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Información del Ciente</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Selección de Polizas</a>
                                                </li>                  
                                            </ul>
                                        </div>
                                        {!! Form::open(['route' => ['gestion.store',$client->id],'method' => 'post','id' => 'venta-polizas','class' => 'text-sm form-horizontal  form-label-left','data-parsley-validate']) !!}
                                        <div class="card-body">
                                            {!! Form::token() !!}
                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <div class="row">
                                                        <div class="col-md-6"> 
                                                            <div class="row">
                                                                <div class="col-md-12">                                            
                                                                    <div class="form-group">
                                                                        {!! Form::label('n_cedula', 'Cedula de Identidad', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">   
                                                                            <div class="input-group-prepend">
                                                                                {{ Form::select('nacionalidad',config('app.nacionalidad'),$client->nacionalidad, ['class' => 'form-control','id' => 'nacionalidad','required','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                            </div> 
                                                                            {{ Form::text('n_cedula',$client->n_cedula,['class' => 'form-control input-number','readonly','id' =>'n_cedula' ,'minlength'=>'6','maxlength'=>'13','required','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <!--- <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        {!! Form::label('fechavencedula', 'Fecha Vencimiento Cedula', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">
                                                                            {{ Form::text('fechavencedula',$client->fe_vencimiento_documento != null ? date('m-Y',strtotime($client->fe_vencimiento_documento)) : null,['class' => 'form-control','id' =>'fechavencedula','required','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                        </div> 
                                                                    </div>
                                                                </div>--->
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        {!! Form::label('nomb1', 'Primer Nombre', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">   
                                                                            {{ Form::text('nomb1',$client->nomb1,['class' => 'form-control input-text','id' =>'nomb1','required','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        {!! Form::label('nomb2', 'Segundo Nombre', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::text('nomb2',$client->nomb2,['class' => 'form-control input-text','id' =>'nomb2','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        {!! Form::label('apelld1', 'Primer  Apellido', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::text('apelld1',$client->apelld1,['class' => 'form-control input-text','id' =>'apelld1' ,'required','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        {!! Form::label('apelld2', 'Segundo Apellido', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::text('apelld2',$client->apelld2,['class' => 'form-control input-text','id' =>'apelld2','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                        </div> 
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="row">
                                                                <div class="col-md-12">                                                                     
                                                                    <div class="form-group">
                                                                        {!! Form::label('fecha_de_nacimiento', 'Fecha de Nacimiento y Edad', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::text('fecha_de_nacimiento',date('d/m/Y',strtotime($client->fecha_de_nacimiento)),['class' => 'form-control','required','Onblur'=>'CalcularEdad();','id' =>'fecha_de_nacimiento','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                            <div class="input-group-prepend">                                                                               
                                                                                {{ Form::text('edad',null,['class' => 'form-control','readonly','id' =>'edad']) }}
                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">                                                                     
                                                                    <div class="form-group">
                                                                        {!! Form::label('email_persol_tomador', 'Correo Electronico Personal', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::text('email_persol_tomador',$client->email_persol_tomador,['class' => 'form-control','id' =>'email_persol_tomador','required','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                          
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">                                                                     
                                                                    <div class="form-group">
                                                                        {!! Form::label('email_trabajo_u_ofici_tomador', 'Correo Electronico Alternativo', ['class' => 'col-form-label']) !!}                                                              
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::text('email_trabajo_u_ofici_tomador',$client->email_trabajo_u_ofici_tomador,['class' => 'form-control','id' =>'email_trabajo_u_ofici_tomador','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                          
                                                                        </div> 
                                                                    </div>
                                                                </div>                                                                                                                          
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4">                                            
                                                            <div class="form-group">
                                                                {!! Form::label('apellcasada', 'Apellido Casada', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::text('apellcasada',$client->apellcasada,['class' => 'form-control',$client->cd_edo_civil !=  "C" ? 'readonly': '','id' =>'apellcasada','data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">                                            
                                                            <div class="form-group">
                                                                {!! Form::label('sexo', 'Sexo', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::select('sexo',config('app.sexo'),$client->cd_sexo, ['class' => 'form-control','id' => 'sexo','required','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                    </div> 
                                                            </div>
                                                        </div>                                                              
                                                        <div class="col-md-4">                                            
                                                            <div class="form-group">
                                                                {!! Form::label('cd_edo_civil', 'Estado Civil', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::select('cd_edo_civil',config('app.cd_edo_civil'),$client->cd_edo_civil, ['class' => 'form-control','id' => 'cd_edo_civil','required','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                </div> 
                                                            </div>
                                                        </div> 
                                                        <small class="col-md-12"><i class="fa fa-phone"></i> Información De Contacto</Small>
                                                        <div class="col-md-12">                                                                     
                                                            <div class="form-group">
                                                                <label for='estado' class='col-form-label'> Estado <span class="required" style="color:red;"> * </span>        </label>                                                                
                                                                <div class="input-group mb-3">  
                                                                    <select name="estado" id="estado" required class="form-control">
                                                                        <option value="">[SELECCIONE]</option>
                                                                       @foreach($estado as $estados)
                                                                       <option value="{{$estados->id}}">{{$estados->estado}}</option>
                                                                       @endforeach
                                                                    </select> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                {!! Form::label('num_telefono_hab_tomador', 'Telefono de Habitación', ['class' => 'col-form-label']) !!}                                                              
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::select('cd_area_num_telefono_habitacion_tomador',$cod,$client->cd_area_num_telefono_habitacion_tomador, ['class' => 'form-control','id' => 'cd_area_num_telefono_habitacion_tomador','placeholder'=>'[Seleccione]','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                    <div class="input-group-prepend">
                                                                        {{ Form::text('num_telefono_hab_tomador',$client->num_telefono_hab_tomador, ['class' => 'form-control input-number','minlength'=>'7','maxlength'=>'7','id' => 'num_telefono_hab_tomador','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                {!! Form::label('num_telefono_trab_ofic_tomador', 'Telefono de Oficina', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group mb-3">  
                                                                        {{ Form::select('cd_area_num_telefono_trab_ofic_tomador',$cod,$client->cd_area_num_telefono_trab_ofic_tomador, ['class' => 'form-control','id' => 'cd_area_num_telefono_trab_ofic_tomador','placeholder'=>'[Seleccione]','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                    <div class="input-group-prepend">
                                                                        {{ Form::text('num_telefono_trab_ofic_tomador',$client->num_telefono_trab_ofic_tomador, ['class' => 'form-control input-number','minlength'=>'7','maxlength'=>'7','id' => 'num_telefono_trab_ofic_tomador','data-parsley-required-message' => 'Este campo es obligatorio']) }} 
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                {!! Form::label('num_celular_pers_tomador', 'Telefono Movil ', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::text('num_celular_pers_tomador',$client->num_celular_pers_tomador, ['class' => 'form-control input-number','id' => 'num_celular_pers_tomador','minlength'=>'10','maxlength'=>'10','required','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                {!! Form::label('num_celular_trab_tomador', 'Telefono Movil Trabajo', ['class' => 'col-form-label']) !!}                                                               
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::text('num_celular_trab_tomador',$client->num_celular_trab_tomador, ['class' => 'form-control input-number','id' => 'num_celular_trab_tomador','minlength'=>'10','maxlength'=>'10','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                                    <div class="row">
                                                        <div class="col-md-12"> 
                                                            <table id="tableproductos" class="table table-sm table-bordered text-center">
                                                                <thead>
                                                                <th>Producto</th>
                                                                <th>Suma Aseg.</th>
                                                                <th>Tipo de Pago</th>
                                                                <th>Prima</th>
                                                                <th>Banco Domicilio</th>
                                                                <th>Instr. de Cobro</th>
                                                                <th>Modificar</th>
                                                                <th>Activar</th>
                                                                </thead>
                                                                <tbody>                                                                  
                                                                    @foreach($planes as $plan)                                                                      
                                                                    <tr>
                                                                        <td>
                                                                            {{ Form::text('plan'.$plan->id,$plan->nombre,['class' => 'form-control input-number','disabled','id' =>'plan'.$plan->id ,'required']) }}
                                                                        </td>
                                                                        <td>
                                                                            {{ Form::select('suma_asegurada'.$plan->id,$plan->RelationSumasSeguradas()->where('active',1)->pluck('nombre','id'),null,['class' => 'form-control','onChange'=>'ChangePrimas('.$plan->id.')','id' =>'suma_asegurada'.$plan->id ,'required']) }}
                                                                        </td>                                                                       
                                                                        <td>                                                                       
                                                                            {{ Form::select('tipo_de_pago'.$plan->id,$frecuencias,'M',['class' => 'form-control','onChange'=>'ChangePrimas('.$plan->id.')','id' =>'tipo_de_pago'.$plan->id ,'required']) }}
                                                                        </td>
                                                                        <td>
                                                                            {{ Form::number('prima'.$plan->id, null,
                                                                                        ['class'    => 'form-control PrimasAll readonly',
                                                                                        'data-plan' => $plan->id, 
                                                                                        'data-href' => route('gestion.search.prima'),
                                                                                        'oninput'   => 'CalculoPrimas(this)',
                                                                                        'disabled',
                                                                                        'id'        =>'prima'.$plan->id,
                                                                                        'required']) }}
                                                                        </td>
                                                                        <td>
                                                                            <select id="banco{{$plan->id}}" name="banco{{$plan->id}}" disabled class="form-control readonly">
                                                                                @foreach($banco as $ban)
                                                                                <option value='{{$ban->id}}' @if($ban->codigo == substr($client->num_cuenta_asociar_inst_bancario_sinencriptar, 0,4))
                                                                                    selected 
                                                                                    @endif >{{$ban->banco}}</option>
                                                                                @endforeach
                                                                            </select>
                                                                        </td>
                                                                        <td><!--$client->num_cuenta_asociar_inst_bancario_sinencriptar,10,20)--->
                                                                            {{ Form::hidden('instrumento'.$plan->id,$client->num_cuenta_asociar_inst_bancario_sinencriptar,
                                                                                ['class'    => 'form-control confidential',
                                                                                'data-plan' => $plan->id, 
                                                                                'data-cuenta'=> $client->num_cuenta_asociar_inst_bancario_sinencriptar,
                                                                                'oninput'   => 'maskInput(this)',
                                                                                'maxlength' => '20',
                                                                                'id'        =>'instrumento'.$plan->id]) }} 

                                                                            {{ Form::hidden('tipocuenta'.$plan->id, $client->tipo_cuenta_domiciliar,
                                                                                ['class'    => 'form-control',
                                                                                'data-plan' => $plan->id,                                                                                
                                                                                'id'        =>'tipocuenta'.$plan->id ]) }} 

                                                                            <p style="margin:0px;" id="texttipocuenta{{$plan->id}}">{{$client->tipo_cuenta_domiciliar}}</p>
                                                                            <p style="margin:0px;"id="textdisplay{{$plan->id}}"></p>                                                                              
                                                                        </td>
                                                                        <td>
                                                                            <button type="button" 
                                                                                    class="btn btn-sm btn-primary"
                                                                                    data-toggle="modal" 
                                                                                    data-target="#modal-default" 
                                                                                    onclick="EditDomicilio({{$plan->id}});"><i class="fa fa-edit"></i></button>   
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <div class="form-check">
                                                                                    <input id="activarplan{{$plan->id}}" name="activarplan{{$plan->id}}" class="check form-check-input" data-plan="{{$plan->id}}" onclick="SelectActivePlan(this);" type="checkbox">
                                                                                    <label class="form-check-label"></label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-12">                                                            
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        {!! Form::label('monto_mensual', 'Monto Mensual', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::number('monto_mensual','0', ['class' => 'form-control','id' => 'monto_mensual','disabled']) }}                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        {!! Form::label('monto_trimestral', 'Monto Trimestral', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::number('monto_trimestral','0', ['class' => 'form-control','id' => 'monto_trimestral','disabled']) }}                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        {!! Form::label('monto_semestral', 'Monto Semestral', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::number('monto_semestral','0', ['class' => 'form-control','id' => 'monto_semestral','disabled']) }}                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        {!! Form::label('monto_anual', 'Monto Anual', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group mb-3">  
                                                                            {{ Form::number('monto_anual','0', ['class' => 'form-control','id' => 'monto_anual','disabled']) }}                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">                                                            
                                                            <div class="form-group">
                                                                {!! Form::label('monto_total', 'Monto a Domicilar por Todos los planes', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::number('monto_total','0', ['class' => 'form-control','id' => 'monto_total','disabled']) }}                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12"> 
                                                            <div class="form-group">
                                                                {!! Form::label('identificador_llamada_prin', 'Identificador de Llamada', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                              
                                                                <div class="input-group mb-3">  
                                                                    {{ Form::text('identificador_llamada_prin',$callid, ['class' => 'form-control','required','id' => 'identificador_llamada_prin','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                                               
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class='row'>
                                                <div class='col-md-12'> 
                                                    <button type="submit"class="btn btn-lg btn-block btn-primary" disabled id="FinishVenta" data-toggle="tooltip" data-placement="top" title="Finalizar Venta"> <i class=" fa fa-save"></i></button>     
                                                </div>
                                            </div>
                                        </div>
                                        {!! Form::close() !!}
                                        <!-- /.card -->
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
                <div class="modal fade" id="modal-default">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="nombredelplanmodal">Domicilación de pagos para el Plan: </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body text-center">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            {!! Form::label('domicilioadoa', 'Instrumento de Domicilio', ['class' => 'col-form-label']) !!}                                                               
                                            <select id="domicilioadoa" name="domicilioadoa" class="form-control">
                                                <option value=''>[SELECCIONE]</option>      
                                                <option value='1'> CUENTA BANCARIA</option>
                                                <option value='2'> TARJETA DE CREDITO</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('newbanco', 'Institución Bancaria', ['class' => 'col-form-label']) !!}                                                               
                                            <select id="newbanco" name="newbanco"  class="form-control">
                                                <option value=''>[SELECCIONE]</option>                                            
                                                @foreach($banco as $ban)
                                                <option value='{{$ban->id}}'>{{$ban->banco}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('tipoinstrumentonew', 'Tipo de Instrumento', ['class' => 'col-form-label']) !!}                                                               
                                            <div class="input-group mb-3">  
                                                {{ Form::select('tipoinstrumentonew',[],null, ['class' => 'form-control','id' => 'tipoinstrumentonew','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('instrumentonew', 'Instrumento para Domiciliar', ['class' => 'col-form-label']) !!}                                                               
                                            <div class="input-group mb-3">  
                                                {{ Form::text('instrumentonew',null, ['class' => 'form-control input-number','maxlength' => '20','id' => 'instrumentonew','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                            </div> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="button" class="btn btn-primary" id="buttonModalConfirm">Cambiar Domicilación</button>
                            </div>
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>

                <div class="modal fade" id="modal-incidencias">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title" id="nombredelplanmodal">Tipificación de Incidencia </h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            {!! Form::open(['route' => ['gestion.store.incidencias',$client->id],'method' => 'post','id' => 'incidencias','class' => 'text-sm form-horizontal  form-label-left','data-parsley-validate']) !!}
                            {!! Form::token() !!}
                            <div class="modal-body text-center">
                                <div class="row">
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('tipificacion1', 'Tipificación 1', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                                                                                             
                                            <div class="input-group mb-3">  
                                                {{ Form::select('tipificacion1', $tipificacion1,null, ['class' => 'form-control','required','id' => 'tipificacion1','placeholder'=>'[SELECCIONE]','data-href'=>route('gestion.tipificaciones.search'),'data-parsley-required-message' => 'Este campo es obligatorio']) }}
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('tipificacion2', 'Tipificación 2', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                                                                                             
                                            <div class="input-group mb-3">  
                                                {{ Form::select('tipificacion2', [],null, ['class' => 'form-control','id' => 'tipificacion2','required','placeholder'=>'[SELECCIONE TIPIFICACION 1]','data-parsley-required-message' => 'Este campo es obligatorio', 'data-href' =>  route('mercantil.tipificacion3')]) }}                                                                   
                                            </div> 
                                        </div>
                                    </div>
                                       <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('tipificacion3', 'Tipificación 3', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                                                                                             
                                            <div class="input-group mb-3">  
                                                {{ Form::select('tipificacion3', [],null, ['class' => 'form-control','id' => 'tipificacion3','required','placeholder'=>'[SELECCIONE TIPIFICACION 2]','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6"> 
                                        <div class="form-group">
                                            {!! Form::label('identificador_llamada', 'Identificador de Llamada', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                              
                                            <div class="input-group mb-3">  
                                                {{ Form::text('identificador_llamada',null, ['class' => 'form-control','required','id' => 'identificador_llamada','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                            </div> 
                                        </div>
                                    </div>
                                    <div class="col-md-6" id="displayagendamiento" style="display: none;"> 
                                        <div class="form-group">
                                            {!! Form::label('agendamiento', 'Fecha Agendamiento', ['class' => 'col-form-label']) !!} <span class="required" style="color:red;"> * </span>                                                                                                                             
                                            <div class="input-group mb-3">  
                                                <div class="input-group-prepend">  
                                                    <span class="input-group-text" id="basic-addon11"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                {{ Form::text('agendamiento',null, ['class' => 'form-control','id' => 'agendamiento','placeholder'=>'DD/MM/YYYY','data-parsley-required-message' => 'Este campo es obligatorio']) }}                                                                   
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-12"> 
                                        <div class="form-group">
                                            <label class="control-label"  for="comentario">Comentarios | Observaciones <span style="color:red;">*</span></label>
                                            <div class="input-group mb-3">  
                                                {!! Form::text('comentario',null,
                                                ['class' => 'form-control',
                                                'style'=>'resize:none;',
                                                'id' =>'comentario',
                                                'required',
                                                'data-parsley-required-message' => 'Este campo es obligatorio'
                                                ]) !!} 
                                            </div> 
                                        </div>
                                    </div>                                   
                                </div>
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                <button type="submit" class="btn btn-primary" id="buttonModalConfirm">Procesar</button>
                            </div>
                            {!! Form::close() !!}
                        </div>
                        <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
</div>

@endsection
@push('styles')
{!!Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')!!}
{!!Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')!!}
{!!Html::style('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')!!}

<!-- bootstrap-datetimepicker -->
{!! Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css')!!}
{!! Html::style('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css')!!}    
@endpush

@push('scripts')   
{!! Html::script('plugins/moment/moment.min.js') !!}
{!! Html::script('plugins/inputmask/jquery.inputmask.min.js') !!}
{!! Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js')!!}    
{!! Html::script('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js')!!}

<!-- DataTables  & Plugins -->
{!!Html::script('plugins/datatables/jquery.dataTables.js')!!}
{!!Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-responsive/js/dataTables.responsive.js')!!}
{!!Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js')!!}
{!!Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js')!!}
{!!Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js')!!}
{!! Html::script('js/SegurosMercantil/Validate.init.js') !!}
{!! Html::script('js/SegurosMercantil/gestion.js') !!}
@endpush