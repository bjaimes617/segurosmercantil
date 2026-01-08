
<?php $__env->startSection('title', 'Gestionando Cliente'); ?>
<?php $__env->startSection('menu_gestion','menu-open'); ?>
<?php $__env->startSection('gestion','active'); ?>
<?php $__env->startSection('gestion.manual','active'); ?>
<?php $__env->startSection('content'); ?>
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
                                        <?php echo Form::open(['route' => ['gestion.manual.store'],'method' => 'post','id' => 'venta-polizas-manual','class' => 'text-sm form-horizontal  form-label-left','data-parsley-validate']); ?>

                                        <div class="card-body">
                                            <?php echo Form::token(); ?>

                                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                                    <div class="row">
                                                        <div class="col-md-6"> 
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">                                            
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('n_cedula', 'Cedula de Identidad', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">   
                                                                            <div class="input-group-prepend">
                                                                                <?php echo e(Form::select('nacionalidad',config('app.nacionalidad'),null, ['class' => 'form-control','id' => 'nacionalidad','required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                            </div> 
                                                                            <?php echo e(Form::text('n_cedula_manual',null,['class' => 'form-control input-number','id' =>'n_cedula_manual' ,'minlength'=>'6','maxlength'=>'13','data-href'=>route('check.cedula.manual'),'required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                        </div> 
                                                                    </div>
                                                                </div>                                                               
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('nomb1', 'Primer Nombre', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">   
                                                                            <?php echo e(Form::text('nomb1',null,['class' => 'form-control input-text','id' =>'nomb1','required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('nomb2', 'Segundo Nombre', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::text('nomb2',null,['class' => 'form-control input-text','id' =>'nomb2','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('apelld1', 'Primer  Apellido', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::text('apelld1',null,['class' => 'form-control input-text','id' =>'apelld1' ,'required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">                                            
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('apelld2', 'Segundo Apellido', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::text('apelld2',null,['class' => 'form-control input-text','id' =>'apelld2','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                        </div> 
                                                                    </div>
                                                                </div>                                                                
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="row mb-3">
                                                                <div class="col-md-12">                                                                     
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('fecha_de_nacimiento', 'Fecha de Nacimiento y Edad', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::text('fecha_de_nacimiento',null,['class' => 'form-control','required','Onblur'=>'CalcularEdad();','id' =>'fecha_de_nacimiento','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                            <div class="input-group-prepend">                                                                               
                                                                                <?php echo e(Form::text('edad',null,['class' => 'form-control','readonly','required','id' =>'edad'])); ?>

                                                                            </div>
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">                                                                     
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('email_persol_tomador', 'Correo Electronico Personal', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::text('email_persol_tomador',null,['class' => 'form-control','id' =>'email_persol_tomador','required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                          
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-12">                                                                     
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('email_trabajo_u_ofici_tomador', 'Correo Electronico Alternativo', ['class' => 'col-form-label']); ?>                                                              
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::text('email_trabajo_u_ofici_tomador',null,['class' => 'form-control','id' =>'email_trabajo_u_ofici_tomador','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                          
                                                                        </div> 
                                                                    </div>
                                                                </div>                                                                                                                          
                                                            </div>
                                                        </div>    
                                                        <div class="col-md-4">                                            
                                                            <div class="form-group">
                                                                <?php echo Form::label('apellcasada', 'Apellido Casada', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::text('apellcasada',null,['class' => 'form-control', 'readonly','id' =>'apellcasada','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>

                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-4">                                            
                                                            <div class="form-group">
                                                                <?php echo Form::label('sexo', 'Sexo', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::select('sexo',config('app.sexo'),null, ['class' => 'form-control','id' => 'sexo','required','placeholder'=>'[Seleccione]','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                </div> 
                                                            </div>
                                                        </div>                                                              
                                                        <div class="col-md-4">                                            
                                                            <div class="form-group">
                                                                <?php echo Form::label('cd_edo_civil', 'Estado Civil', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::select('cd_edo_civil',config('app.cd_edo_civil'),null, ['class' => 'form-control','id' => 'cd_edo_civil','placeholder'=>'[Seleccione]','required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                </div> 
                                                            </div>
                                                        </div> 
                                                        <small class="col-md-12"><i class="fa fa-phone"></i> Información De Contacto</Small>
                                                        <div class="col-md-12">                                                                     
                                                            <div class="form-group">
                                                                <label for='estado' class='col-form-label'> Estado <span class="required" style="color:red;"> * </span></label>                                                                
                                                                <div class="input-group">  
                                                                    <select name="estado" id="estado" required class="form-control">
                                                                        <option value="">[SELECCIONE]</option>
                                                                        <?php $__currentLoopData = $estado; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $estados): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <option value="<?php echo e($estados->id); ?>"><?php echo e($estados->estado); ?></option>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </select> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                <?php echo Form::label('num_telefono_hab_tomador', 'Telefono de Habitación', ['class' => 'col-form-label']); ?>  <span class="required" style="color:red;"> * </span>                                                            
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::select('cd_area_num_telefono_habitacion_tomador',$cod, null,['class' => 'form-control input-number','required','id' => 'cd_area_num_telefono_habitacion_tomador','placeholder'=>'[Seleccione]','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                    <div class="input-group-prepend">
                                                                        <?php echo e(Form::text('num_telefono_hab_tomador',null, ['class' => 'form-control input-number','minlength'=>'7','required','maxlength'=>'7','id' => 'num_telefono_hab_tomador','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                <?php echo Form::label('num_telefono_trab_ofic_tomador', 'Telefono de Oficina', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">                                                                          
                                                                    <?php echo e(Form::select('cd_area_num_telefono_trab_ofic_tomador',$cod,null, ['class' => 'form-control','id' => 'cd_area_num_telefono_trab_ofic_tomador','required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                    <div class="input-group-prepend">
                                                                        <?php echo e(Form::text('num_telefono_trab_ofic_tomador',null, ['class' => 'form-control input-number','minlength'=>'7','maxlength'=>'7','id' => 'num_telefono_trab_ofic_tomador','data-parsley-required-message' => 'Este campo es obligatorio'])); ?> 
                                                                    </div> 
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                <?php echo Form::label('num_celular_pers_tomador', 'Telefono Movil ', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::text('num_celular_pers_tomador',null, ['class' => 'form-control input-number','required','id' => 'num_celular_pers_tomador','minlength'=>'10','maxlength'=>'10','required','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">                                                                     
                                                            <div class="form-group">
                                                                <?php echo Form::label('num_celular_trab_tomador', 'Telefono Movil Trabajo', ['class' => 'col-form-label']); ?>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::text('num_celular_trab_tomador',null, ['class' => 'form-control input-number','id' => 'num_celular_trab_tomador','minlength'=>'10','maxlength'=>'10','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <?php echo Form::label('domicilioadomanual', 'Instrumento de Domicilio', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                             
                                                                <select id="domicilioadomanual" name="domicilioadomanual" required class="form-control">
                                                                    <option value=''>[SELECCIONE]</option>      
                                                                    <option value='1'> CUENTA BANCARIA</option>
                                                                    <option value='2'> TARJETA DE CREDITO</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="form-group">
                                                                <?php echo Form::label('newbancomanual', 'Institución Bancaria', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                              
                                                                <select id="newbancomanual" name="newbancomanual" required class="form-control">
                                                                    <option value=''>[SELECCIONE]</option>                                            
                                                                    <?php $__currentLoopData = $banco; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ban): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value='<?php echo e($ban->id); ?>'><?php echo e($ban->banco); ?></option>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="form-group">
                                                                <?php echo Form::label('tipoinstrumentonewmanual', 'Tipo de Instrumento', ['class' => 'col-form-label']); ?>  <span class="required" style="color:red;"> * </span>                                                              
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::select('tipoinstrumentonewmanual',[],null, ['class' => 'form-control','required','id' => 'tipoinstrumentonewmanual','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6"> 
                                                            <div class="form-group">
                                                                <?php echo Form::label('instrumentonewmanual', 'Instrumento para Domiciliar', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::text('instrumentonewmanual',null, ['class' => 'form-control input-number','required','maxlength' => '20','id' => 'instrumentonewmanual','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
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
                                                                <th>Activar</th>
                                                                </thead>
                                                                <tbody>                                                                  
                                                                    <?php $__currentLoopData = $planes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>                                                                      
                                                                    <tr>
                                                                        <td>
                                                                            <?php echo e(Form::text('plan'.$plan->id,$plan->nombre,['class' => 'form-control input-number','disabled','id' =>'plan'.$plan->id ,'required'])); ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php echo e(Form::select('suma_asegurada'.$plan->id,$plan->RelationSumasSeguradas()->where('active',1)->pluck('nombre','id'),null,['class' => 'form-control','onChange'=>'ChangePrimas('.$plan->id.')','id' =>'suma_asegurada'.$plan->id ,'required'])); ?>

                                                                        </td>                                                                       
                                                                        <td>                                                                       
                                                                            <?php echo e(Form::select('tipo_de_pago'.$plan->id,$frecuencias,'M',['class' => 'form-control','onChange'=>'ChangePrimas('.$plan->id.')','id' =>'tipo_de_pago'.$plan->id ,'required'])); ?>

                                                                        </td>
                                                                        <td>
                                                                            <?php echo e(Form::number('prima'.$plan->id, null,
                                                                                        ['class'    => 'form-control PrimasAll readonly',
                                                                                        'data-plan' => $plan->id, 
                                                                                        'data-href' => route('gestion.search.prima'),
                                                                                        'oninput'   => 'CalculoPrimas(this)',
                                                                                        'disabled',
                                                                                        'id'        =>'prima'.$plan->id,
                                                                                        'required'])); ?>

                                                                        </td>
                                                                        <td>
                                                                            <select id="banco<?php echo e($plan->id); ?>" name="banco<?php echo e($plan->id); ?>" disabled class="form-control readonly nuevosbancos">
                                                                                <option value=''>[SELECCIONE]</option>
                                                                                <?php $__currentLoopData = $banco; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ban): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <option value='<?php echo e($ban->id); ?>' ><?php echo e($ban->banco); ?></option>
                                                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                            </select>
                                                                        </td>
                                                                        <td><!--$client->num_cuenta_asociar_inst_bancario_sinencriptar,10,20)--->                                                                           

                                                                            <p style="margin:0px;" class="texttipocuenta">N/D</p>
                                                                            <p style="margin:0px;"class="textdisplay"></p>                                                                              
                                                                        </td>                                                                        
                                                                        <td>
                                                                            <div class="form-group">
                                                                                <div class="form-check">
                                                                                    <input id="activarplan<?php echo e($plan->id); ?>" name="activarplan<?php echo e($plan->id); ?>" class="check form-check-input" data-plan="<?php echo e($plan->id); ?>" onclick="SelectActivePlan(this);" type="checkbox">
                                                                                    <label class="form-check-label"></label>
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                        <br>
                                                        <div class="col-md-12">                                                            
                                                            <div class='row'>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('monto_mensual', 'Monto Mensual', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::number('monto_mensual','0', ['class' => 'form-control','id' => 'monto_mensual','disabled'])); ?>                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('monto_trimestral', 'Monto Trimestral', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::number('monto_trimestral','0', ['class' => 'form-control','id' => 'monto_trimestral','disabled'])); ?>                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('monto_semestral', 'Monto Semestral', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::number('monto_semestral','0', ['class' => 'form-control','id' => 'monto_semestral','disabled'])); ?>                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                                <div class='col-md-3'>
                                                                    <div class="form-group">
                                                                        <?php echo Form::label('monto_anual', 'Monto Anual', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                        <div class="input-group">  
                                                                            <?php echo e(Form::number('monto_anual','0', ['class' => 'form-control','id' => 'monto_anual','disabled'])); ?>                                                                   
                                                                        </div> 
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">                                                            
                                                            <div class="form-group">
                                                                <?php echo Form::label('monto_total', 'Monto a Domicilar por Todos los planes', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::number('monto_total','0', ['class' => 'form-control','id' => 'monto_total','disabled'])); ?>                                                                   
                                                                </div> 
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12"> 
                                                            <div class="form-group">
                                                                <?php echo Form::label('identificador_llamada_prin', 'Identificador de Llamada', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                              
                                                                <div class="input-group">  
                                                                    <?php echo e(Form::text('identificador_llamada_prin',$callid, ['class' => 'form-control','required','id' => 'identificador_llamada_prin','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
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
                                                    <button type="submit" class="btn btn-lg btn-block btn-primary" id="FinishVenta" 
                                                            data-toggle="tooltip" data-placement="top" title="Finalizar Venta" disabled="disabled">
                                                        <i class=" fa fa-save"></i>
                                                </button>     
                                                </div>
                                            </div>
                                        </div>
                                        <?php echo Form::close(); ?>

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



            </div>

        </div>
        <!-- /.container-fluid -->
    </section>
</div>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<?php echo Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>

<?php echo Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>

<?php echo Html::style('plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>


<!-- bootstrap-datetimepicker -->
<?php echo Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

<?php echo Html::style('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'); ?>    
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>   
<?php echo Html::script('plugins/moment/moment.min.js'); ?>

<?php echo Html::script('plugins/inputmask/jquery.inputmask.min.js'); ?>

<?php echo Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>    
<?php echo Html::script('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>


<!-- DataTables  & Plugins -->
<?php echo Html::script('plugins/datatables/jquery.dataTables.js'); ?>

<?php echo Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js'); ?>

<?php echo Html::script('plugins/datatables-responsive/js/dataTables.responsive.js'); ?>

<?php echo Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js'); ?>

<?php echo Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>

<?php echo Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>

<?php echo Html::script('js/SegurosMercantil/Validate.init.js'); ?>

<?php echo Html::script('js/SegurosMercantil/gestion.js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/SISTEMAS_ACTUALIZADOS 8.2/segurosmercantil8/resources/views/gestion/formulario/manual.blade.php ENDPATH**/ ?>