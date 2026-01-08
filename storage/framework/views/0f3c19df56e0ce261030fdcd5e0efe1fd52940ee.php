<?php $__env->startSection('title', 'Registros De Clientes Con Ventas'); ?>
<?php $__env->startSection('menu_gestion','menu-open'); ?>
<?php $__env->startSection('gestion','active'); ?>
<?php $__env->startSection('gestion.'.$type,'active'); ?>
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
                            <h3 class="card-title">Buscar Clientes con Ventas Generadas</h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body">                             
                            <div class="row">    
                                <div class="col-md-12"  id="displaytable">
                                    <h6>  Estos resultados son extraidos de forma integra desde la Base de Datos.</h6>    
                                    <div class="ln_solid"></div>
                                    <table id="datatables" class="table table-bordered table-hover text-center">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Cedula</th>
                                                <th>Nombres y Apellidos</th>
                                                <th>Fecha de Nacimiento</th>    
                                                <th>Planes Activados</th>
                                                <?php if(!\Auth::user()->hasRole(["operador"])): ?>                                                
                                                <th>Usuario</th>    
                                                <th>Acciones</th>    
                                                <?php endif; ?>
                                                <th>Fecha Emisión</th>
                                            </tr>
                                        </thead> 
                                        <tbody>                                          
                                            <?php $__currentLoopData = $client; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $datos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                                <?php if($datos->RelationGestionados()->where('estatus_id',5)->exists()): ?>
                                                <tr>
                                                <td><?php echo e($key + 1); ?></td>
                                                <td><?php echo e($datos->n_cedula); ?></td>
                                                <td><?php echo e($datos->nomb1); ?> <?php echo e($datos->nomb2); ?> <?php echo e($datos->ape1ld1); ?> <?php echo e($datos->apelld2); ?></td>
                                                <td><?php echo e(date('d/m/Y', strtotime($datos->fecha_de_nacimiento))); ?></td>
                                                <td><?php echo e($datos->RelationGestionados()->where('estatus_id',5)->count()); ?></td>
                                                <?php if(!\Auth::user()->hasRole(["operador"])): ?>                                            
                                                <td><?php echo e($datos->RelationGestionados()->where('estatus_id',5)->first()->user_id); ?></td>                                                
                                               
                                                    <?php if(\Auth::user()->haspermission('eliminar.ventas')): ?>
                                                   <td>                                                           
                                                        <input type="hidden" id="ruta<?php echo e($datos->id); ?>" value="<?php echo e(route('gestion.ventas.eliminar',$datos->id)); ?>">
                                                        <button class='btn btn-danger btn-sm' onclick="deletedVentas(<?php echo e($datos->id); ?>);"><i class="fas fa-trash-alt"></i></button>                                                    
                                                    </td>
                                                    <?php else: ?>
                                                    <td> - </td>
                                                    <?php endif; ?>
                                                <?php endif; ?>
                                                 <td><?php echo e(date('d/m/Y', strtotime($datos->RelationGestionados()->where('estatus_id',5)->first()->created_at))); ?></td>
                                                </tr>
                                                <?php endif; ?>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                           
                                        </tbody>
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
                                     <form id="deleted" action='' method="POST" class="text-sm form-horizontal  form-label-lef">
                                        <div class="modal-body">   
                                            <div class="row">
                                            <?php echo method_field('delete'); ?>      
                                            <?php echo csrf_field(); ?>                                        
                                            <div class="col-md-12">                                            
                                                <div class="form-group">
                                                    <?php echo Form::label('razones', 'Ingrese el motivo de Eliminacion de este cliente', ['class' => 'col-form-label']); ?> <span class="required" style="color:red;"> * </span>                                                               
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
<?php echo Html::style('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css'); ?>

<?php echo Html::style('plugins/datatables-responsive/css/responsive.bootstrap4.min.css'); ?>

<?php echo Html::style('plugins/datatables-buttons/css/buttons.bootstrap4.min.css'); ?>

<?php echo Html::style('plugins/bootstrap-daterangepicker/daterangepicker.css'); ?>

<?php echo Html::style('plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.css'); ?>    
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>   
<!-- DataTables  & Plugins -->
<?php echo Html::script('plugins/moment/moment.min.js'); ?>

<?php echo Html::script('plugins/bootstrap-daterangepicker/daterangepicker.js'); ?>    
<?php echo Html::script('plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js'); ?>

<?php echo Html::script('plugins/datatables/jquery.dataTables.js'); ?>

<?php echo Html::script('plugins/datatables-bs4/js/dataTables.bootstrap4.js'); ?>

<?php echo Html::script('plugins/datatables-responsive/js/dataTables.responsive.js'); ?>

<?php echo Html::script('plugins/datatables-responsive/js/responsive.bootstrap4.js'); ?>

<?php echo Html::script('plugins/datatables-buttons/js/dataTables.buttons.min.js'); ?>

<?php echo Html::script('plugins/datatables-buttons/js/buttons.bootstrap4.min.js'); ?>

<?php echo Html::script('js/SegurosMercantil/gestion.js'); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/SISTEMAS_ACTUALIZADOS 8.2/segurosmercantil8/resources/views/gestion/ventas/index.blade.php ENDPATH**/ ?>