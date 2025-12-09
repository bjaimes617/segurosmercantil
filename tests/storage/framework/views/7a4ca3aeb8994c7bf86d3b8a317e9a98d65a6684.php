<?php $__env->startSection('title', 'Carga de Registros'); ?>
<?php $__env->startSection('menu_administracion','menu-open'); ?>
<?php $__env->startSection('administracion','active'); ?>
<?php $__env->startSection('administracion.index','active'); ?>
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
                        <li class="breadcrumb-item">Administracion</li>
                        <li class="breadcrumb-item active">Cargar</li>
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
                            <h3 class="card-title">Carga de Clientes al Sistema</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">
                            <?php echo Form::open(['route' => 'administration.store','method' => 'post','id' => 'uploadFile','class' => 'form-horizontal  form-label-left','data-parsley-validate','enctype' => 'multipart/form-data']); ?>

                            <?php echo Form::token(); ?>

                            <div class="row">                        

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="archivo">Archivo de Cargar de Clientes</label><span class="required">*</span>
                                        <div class="input-group">
                                            <div class="custom-file">
                                                <input type="file" class="custom-file-input" required id="archivo" name="archivo">
                                                <label class="custom-file-label" for="exampleInputFile">Buscar Archivo en...</label>
                                            </div>
                                            <div class="input-group-append">
                                                <button type="submit" class="btn btn-primary cargamasiva"><i class="fa fa-save"></i> upload</button>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                                <div class='col-md-12'>
                                <h5 Style="color: red;"> Recomendaciones a considerar al momento de subir el archivo:</h5>
                                <p>Utilice el formato suministrado para cargar los registros. Si no lo tienes Descarga <a href="<?php echo e(asset('/source/storage/app/public/formato_mercantil.csv')); ?>">Aqui</a></p>
                                <p>No realice ninguna modificación en las cabeceras de las columnas </p>
                                <p>Revisar que la <b>Fecha de Nacimiento</b> se encuentre como Y-M-D </p>
                                <p>Cargar el <b>Numero de Cuenta</b> con una comilla al inicio, para que mantenga la longitud correspondiente </p>
                                <p>al guardar, abrir el archivo con block de notas, y verificar la separacion de valores con Punto y coma <b>;</b> y que los valores anteriores se encuentre correctos.</p>
                                
                            </div> 
                            </div>
                            <?php echo Form::close(); ?>  
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
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>

<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<!-- DataTables  & Plugins -->
<?php echo Html::script('plugins/bs-custom-file-input/bs-custom-file-input.min.js'); ?>

<?php echo Html::script('js/administration/validate.init.js'); ?>    
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/source/resources/views/administration/index.blade.php ENDPATH**/ ?>