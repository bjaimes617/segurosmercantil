<?php $__env->startSection('title', 'Usuarios del Sistema|Eliminados'); ?>
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
                        <li class="breadcrumb-item">Seguridad</li>
                        <li class="breadcrumb-item ">Usuarios</li>
                        <li class="breadcrumb-item active">Eliminados</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Listado de usuarios eliminados</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <p><small><?php echo e(trans('mensajeTabla')); ?></small></p>                        
                            <table id="usuarios_table" class="table table-sm compact table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre y Apellido</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Estatus</th>
                                        <th>Creado</th>                                      
                                        <th>Removido</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->username); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td><?php echo e($user->estatus_id); ?></td>
                                        <td><?php echo e(date('d/m/Y',strtotime($user->created_at))); ?></td>      
                                        <td><?php echo e(date('d/m/Y',strtotime($user->deleted_at))); ?></td>          
                                        <td> 
                                            <?php if (Auth::check() && Auth::user()->hasPermission('restore.users | delete.users')): ?>
                                            <div class="btn-group">
                                                <?php if (Auth::check() && Auth::user()->hasPermission('restore.users')): ?>
                                                <form  action="<?php echo e(route('users.restore',$user->id)); ?>" method="POST">
                                                    <button type="submit" class="btn btn-warning btn-sm"><i class="fas fa-recycle"></i></button>                        
                                                    <?php echo csrf_field(); ?>
                                                    <?php echo method_field('PUT'); ?>
                                                </form>                                                        
                                                <?php endif; ?>
                                                <?php if (Auth::check() && Auth::user()->hasPermission('delete.users')): ?>
                                                <button type="button" onclick="Destroy(<?php echo e($user->id); ?>);" class="btn btn-danger btn-sm"><i class="fas fa-minus-circle"></i></button>                        
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <form  action="<?php echo e(route('users.destroy',$user->id)); ?>" method="POST" id="eliminar<?php echo e($user->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        </td> 
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <!-- /.card-body -->
            </div>          
            <!-- /.row -->
        </div>
        <!-- /.container-fluid -->
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/datatables-responsive/js/dataTables.responsive.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/datatables-responsive/js/responsive.bootstrap4.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('js/user/users.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/users/remove.blade.php ENDPATH**/ ?>