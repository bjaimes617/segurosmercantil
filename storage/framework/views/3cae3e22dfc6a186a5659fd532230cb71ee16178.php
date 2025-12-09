<?php $__env->startSection('title', 'Home'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">             
                        
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <!-- Default box -->
        <div class="card">            
            <div class="card-body">
                <div class="jumbotron" style="margin-top: 10px;">
                    <h4 class="display-4">Bienvenid@, <?php echo e(ucwords(Auth::user()->name)); ?></h4>
                    <p class="lead">Esto es la nueva plataforma <?php echo e(env('APP_NAME')); ?>... una integración con las diferentes tecnologias de Directa Group, facilitando la gestión del contact center y la gerencia administrativa de la organización</p>
                    <hr class="my-3"><img class="img-fluid float-md-right" src="<?php echo e(asset('img/logo directa.png')); ?>" width="200px"> 
                    <p style="font-size: 16px;">Desarrollado por la Gerencia Ingenier&iacute;a de Software 
                        &COPY;<?php echo e(date("Y")); ?></p>
                    
                </div> 
            </div>            
        </div>        
    </section>     
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/home/index.blade.php ENDPATH**/ ?>