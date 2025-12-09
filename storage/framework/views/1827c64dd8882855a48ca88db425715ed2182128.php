<?php $__env->startSection('title', 'Reporteria CSV'); ?>
<?php $__env->startSection('menu_reportes','menu-open'); ?>
<?php $__env->startSection('reportes','active'); ?>
<?php $__env->startSection('reportes.csv','active'); ?>
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
                        <li class="breadcrumb-item">Reportes</li>
                        <li class="breadcrumb-item active">General</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Generación de CSV de Clientes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">   
                            <?php echo Form::open(['route' => 'reportes.store.clientes.csv','method' => 'post','id' => 'DescargarReportes','class' => 'form-horizontal  form-label-left','data-parsley-validate','enctype' => 'multipart/form-data']); ?>

                            <?php echo Form::token(); ?>

                            <div class="row">
                                <div class="col-md-6">                                                                     
                                    <div class="form-group">
                                        <?php echo Form::label('rango_fecha', 'Rango de Fechas', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                                                                                             
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <?php echo e(Form::text('rango_fecha',null, ['class' => 'form-control calendartxt','id' => 'rango_fecha','placeholder'=>'DD/MM/YYYY','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                                                     
                                    <div class="form-group">
                                        <?php echo Form::label('tiporeporte', 'Tipo de Reporte', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                                                                                             
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-filter"></i></span>
                                            </div>
                                            <select name='tipo_reporte' required class="form-control" id="tipo_reporte">
                                                 <option value="">[SELECCIONE]</option>
                                                <option value="CARGAPN2">CSV de Clientes SIN Dirección - CARGAPN2</option>
                                                    <option value="CARGAPNDOMI">CSV de Clientes CON Dirección - CARGAPNDOMI</option>                                                
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-download"></i> Generar Clientes</button>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>  
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->
                  <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Generación de CSV por Planes</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">   
                            <?php echo Form::open(['route' => 'reportes.store.csv','method' => 'post','id' => 'DescargarReportes','class' => 'form-horizontal  form-label-left','data-parsley-validate','enctype' => 'multipart/form-data']); ?>

                            <?php echo Form::token(); ?>

                            <div class="row">
                                <div class="col-md-6">                                                                     
                                    <div class="form-group">
                                        <?php echo Form::label('rango_fecha', 'Rango de Fechas', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                                                                                             
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-calendar"></i></span>
                                            </div>
                                            <?php echo e(Form::text('rango_fecha',null, ['class' => 'form-control calendartxt','id' => 'rango_fecha','placeholder'=>'DD/MM/YYYY','data-parsley-required-message' => 'Este campo es obligatorio'])); ?>                                                                   
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">                                                                     
                                    <div class="form-group">
                                        <?php echo Form::label('tiporeporte', 'CSV Por Planes', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                                                                                             
                                        <div class="input-group mb-3">  
                                            <div class="input-group-prepend">  
                                                <span class="input-group-text" id="basic-addon11"><i class="fa fa-filter"></i></span>
                                            </div>
                                            <select name='tipo_reporte' required class="form-control" id="tipo_reporte">
                                                <option value="">[SELECCIONE]</option>
                                                <?php $__currentLoopData = $planes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($plan->id); ?>"><?php echo e($plan->nombre); ?> - <?php echo e($plan->nombre_archivo); ?></option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                 <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block"><i class="fas fa-download"></i> Generar por Plan</button>
                                </div>
                            </div>
                            <?php echo Form::close(); ?>  
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <!-- /.col -->
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

<?php echo Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>   
<!-- DataTables  & Plugins -->
<?php echo Html::script('plugins/moment/moment.min.js'); ?>

<?php echo Html::script('plugins/inputmask/jquery.inputmask.min.js'); ?>

<?php echo Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>    
<?php echo Html::script('js/SegurosMercantil/gestion.js'); ?>

<?php echo Html::script('js/SegurosMercantil/Validate.init.js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/reportes/generateCSV.blade.php ENDPATH**/ ?>