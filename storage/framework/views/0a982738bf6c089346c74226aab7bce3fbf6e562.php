<?php $__env->startSection('title', 'Añadir Usuario al Sistema'); ?>
<?php $__env->startSection('content'); ?>
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6"></div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Seguridad</a></li>
                        <li class="breadcrumb-item">Usuarios</li>
                        <li class="breadcrumb-item active">Añadir</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Añadir un nuevo usuario al sistema </h3>
                        </div>
                        <form action="<?php echo e(route('users.store')); ?>" method="POST" id="users" class="form-horizontal form-label-left" data-parsley-validate >                                                
                            <?php echo csrf_field(); ?>                        
                            <!-- /.card-header -->
                            <div class="card-body text-right">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="name">Nombre Y Apellido <span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="text" name="name" id="name" required class="form-control"  value="<?php echo e(old('name')); ?>" placeholder="Nombre y Apellido">                                           
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="cedula">Cedula de Identidad<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="number" name="cedula" id="cedula" required class="form-control"  value="<?php echo e(old('cedula')); ?>" placeholder="Cedula de identidad">                                           
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="username">Usuario de Acceso<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="text" name="username" id="username" required class="form-control"  value="<?php echo e(old('username')); ?>" placeholder="Usuario">                                           
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="email">Correo Electronico<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="email" name="email" id="email" required class="form-control"  value="<?php echo e(old('email')); ?>" placeholder="XX@directagroup.net">                                           
                                    </div>
                                </div>                                 
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="roles">Asignación de Rol<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <select name="roles" id="roles" required class="form-control select2 custom-select" data-href="<?php echo e(route('users.permissions.add')); ?>">         
                                            <option value="">SELECCIONE</option>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                            <option value="<?php echo e($rol->id); ?>"><?php echo e($rol->name); ?></option>                                        
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div> 
                                <hr>
                                <p class="text-center">Podra Asignar Permisos adicionales al usuario que no se encuentren asociados al rol Seleccionado.</p>
                                <div class="form-group row">                                   
                                    <label class="col-sm-3 col-form-label" for="permisos">Permisos Adicionales</label>                                 
                                    <div  class="input-group col-md-6">
                                        <select name="permisos[]" id="permisos" data-allow-clear="true" disabled multiple class="form-control select2 custom-select">                                                   
                                            <option value="">[Seleccione]</option>
                                            <?php $__currentLoopData = $modelos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opgroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <optgroup label="<?php echo e($opgroup); ?>"> 
                                                <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                <?php if($permisos->model === $opgroup): ?>
                                                <option value="<?php echo e($permisos->id); ?>"><?php echo e($permisos->name); ?></option> 
                                                <?php endif; ?>                                            
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                            <optgroup label="Sin Categoria"> 
                                                <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                <?php if($permisos->model === null): ?>
                                                <option value="<?php echo e($permisos->id); ?>"><?php echo e($permisos->name); ?></option> 
                                                <?php endif; ?>                                            
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-center"><span style="color:red;"><b>Atención:</b></span> Para Seleccionar mas permisos en simultaneo, presiones la tecla <b>CONTROL+CLIC</b></p>
                                <hr>
                               
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary btn-block" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/select2/css/select2.css')); ?>">  
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/select2/js/select2.js')); ?>"></script>
<script src="<?php echo e(asset('js/user/users.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/users/create.blade.php ENDPATH**/ ?>