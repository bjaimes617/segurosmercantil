<?php $__env->startSection('title', 'Editar Usuario al Sistema'); ?>
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
                        <li class="breadcrumb-item active">Editar</li>
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
                            <h3 class="card-title">Editando Credenciales del Usuario</h3>
                        </div>                        
                        <form action="<?php echo e(route('users.update',$user->id)); ?>" method="POST" id="users" class="form-horizontal form-label-left" data-parsley-validate >                                                
                            <?php echo method_field('PUT'); ?>
                            <?php echo csrf_field(); ?>                        
                            <!-- /.card-header -->
                            <div class="card-body text-right">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="name">Nombre Y Apellido <span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="text" name="name" id="name" value="<?php echo e($user->name); ?>" required class="form-control"  value="<?php echo e(old('name')); ?>" placeholder="Nombre y Apellido">                                           
                                    </div>
                                </div> 
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="cedula">Cedula de Identidad<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="number" name="cedula" id="cedula" value="<?php echo e($user->cedula); ?>" required class="form-control"  value="<?php echo e(old('cedula')); ?>" placeholder="Cedula de identidad">                                           
                                    </div>
                                </div>                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="username">Usuario de Acceso<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="text" name="username" id="username" disabled value="<?php echo e($user->username); ?>" required class="form-control"  value="<?php echo e(old('username')); ?>" placeholder="Usuario">                                           
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="email">Correo Electronico<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <input type="email" name="email" id="email" required value="<?php echo e($user->email); ?>" class="form-control"  value="<?php echo e(old('email')); ?>" placeholder="XX@directagroup.net">                                           
                                    </div>
                                </div> 
                                    <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="estatus">Estatus<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <select name="estatus" id="estatus" required class="form-control">         
                                            <option value="">SELECCIONE</option>
                                            <?php $__currentLoopData = ['1'=>'Activo','2'=>'Inactivo','3'=>"Nuevo"]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $estatus): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                            <option value="<?php echo e($key); ?>" <?php if($key === $user->getRaworiginal('estatus_id')): ?> selected <?php endif; ?> ><?php echo e($estatus); ?></option>                                        
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>                                 
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="roles">Asignación de Rol<span style="color:red">*</span></label>                                 
                                    <div  class="input-group col-md-6">
                                        <select name="roles" id="roles" required class="form-control select2" data-href="<?php echo e(route('users.permissions.add')); ?>">         
                                            <option value="">SELECCIONE</option>
                                            <?php $__currentLoopData = $roles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $rol): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                            <option value="<?php echo e($rol->id); ?>" <?php if(in_array($rol->id, $roleuser)): ?> selected <?php endif; ?> ><?php echo e($rol->name); ?></option>                                        
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div> 
                                <p class="text-center">Podra Asignar Permisos adicionales al usuario que no se encuentren asociados al rol Seleccionado.</p>
                                <div class="form-group row">                                   
                                    <label class="col-sm-3 col-form-label" for="permisos">Permisos Adicionales</label>                                 
                                    <div  class="input-group col-md-6">
                                        <select name="permisos[]" id="permisos" data-allow-clear="true" <?php if(empty($permisosadicionales)): ?> disabled <?php endif; ?> multiple class="form-control select2">                                                   
                                            <option value="">[Seleccione]</option>
                                            <?php $__currentLoopData = $modelos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opgroup): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <optgroup label="<?php echo e($opgroup); ?>"> 
                                                <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                <?php if($permisos->model === $opgroup): ?>
                                                <option value="<?php echo e($permisos->id); ?>" 
                                                        <?php if(in_array($permisos->id, $permisosadicionales)): ?> selected <?php endif; ?> 
                                                    <?php if(in_array($permisos->id, $permisosrol)): ?> disabled <?php endif; ?> 
                                                    ><?php echo e($permisos->name); ?></option> 
                                                <?php endif; ?>                                            
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> 
                                            <optgroup label="Sin Categoria"> 
                                                <?php $__currentLoopData = $permission; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                <?php if($permisos->model === null): ?>
                                                <option value="<?php echo e($permisos->id); ?>" 
                                                        <?php if(in_array($permisos->id, $permisosadicionales)): ?> selected <?php endif; ?> 
                                                    <?php if(in_array($permisos->id, $permisosrol)): ?> disabled <?php endif; ?> 
                                                    ><?php echo e($permisos->name); ?></option> 
                                                <?php endif; ?>                                            
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </optgroup>
                                        </select>
                                    </div>
                                </div>
                                <p class="text-center"><span style="color:red;"><b>Atención:</b></span> Para Seleccionar mas permisos en simultaneo, presiones la tecla <b>CONTROL+CLIC</b></p>
                                <hr>
                                
                                <div class="row ">
                                    <div class="col-md-6 d-flex justify-content-center align-items-center">
                                        <div class="form-group row"> 
                                            <div class="col-sm-12 float-center">
                                                <div class="icheck-primary d-inline float-left">
                                                    <input type="checkbox" id="resetpassword" name="resetpassword" data-parsley-required-message='Este campo es obligatorio'>
                                                    <label for="resetpassword">
                                                        Reinicio de Contraseña
                                                    </label>
                                                </div>
                                            </div>

                                        </div> 
                                    </div>                                      
                                </div>
                                <hr>                                
                                <?php if (Auth::check() && Auth::user()->hasPermission('update.users')): ?>
                                <div class="card-footer text-center">
                                    <div class="row">
                                        <button type="submit" class="btn btn-primary btn-block" data-toggle="tooltip" data-placement="top" title="Guardar"><i class="fas fa-save"></i></button>
                                    </div>
                                </div>
                                <?php endif; ?>
                        </form>
                        <!-- /.card-body -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
</div>
<!-- /.container-fluid -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/select2/css/select2.css')); ?>">  
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/select2/js/select2.js')); ?>"></script>
<script src="<?php echo e(asset('js/user/users.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/users/edit.blade.php ENDPATH**/ ?>