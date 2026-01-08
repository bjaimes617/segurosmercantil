<?php $__env->startSection('title','Inicio de Session'); ?>
<?php $__env->startSection('content'); ?> 
<div class="login-box">
    <div class="card card-outline card-primary">          
        <div class="card-header text-center">
            <a class="h1"><img src="<?php echo e(asset('img/LOGO DG AZULYMAGENTA.png')); ?>" alt="DirectaGroupLogo Logo" width="210"></a>
        </div>
        <div class="card-body">
            <p class="login-box-msg">Conectate con nuestra plataforma</p>

            <form action="<?php echo e(route('loginin')); ?>" method="post">
                <?php echo csrf_field(); ?>
                <div class="input-group mb-3">
                    <input type="text" name="username" id="username" class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('username')); ?>" placeholder="Usuario">
                    <div class="input-group-append">
                        <div class="input-group-text"> 
                            <span class="fas fa-user"></span>
                        </div>                
                    </div>
                    <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="input-group mb-3">
                    <input type="password" name="password" id="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  value="<?php echo e(old('password')); ?>" placeholder="Contraseña">
                    <div class="input-group-append">
                        <div class="input-group-text">
                            <span class="fas fa-lock"></span>
                        </div>                
                    </div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <span><?php echo e($message); ?></span>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>
                <div class="row float-right">            
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block">Conectar</button>
                    </div>
                    <!-- /.col -->
                </div>
            </form>               
        </div>

        <div class="modal fade" id="modal-default">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header text-center">
                        <img class="" src="<?php echo e(asset('img/LOGO DG AZULYMAGENTA.png')); ?>" alt="DirectaGroupLogo Logo" width="210">
                    </div>
                    <form action="<?php echo e(route('password.email')); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="modal-body">
                            <p class="login-box-msg">Recuperar Contraseña</p>
                            <div class="input-group mb-3">
                                <input type="email" name="email" id="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  value="<?php echo e(old('email')); ?>" placeholder="xxxx@directagroup.net">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="far fa-envelope" aria-hidden="true"></span>                    
                                    </div>                
                                </div>
                                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <span><?php echo e($message); ?></span>
                                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            </div>
                            <p class="text-center">Para Restaurar tu contraseña de acceso, ingresa por favor tu dirección de correo electronico.</p>                                                        
                            <p class="text-center">Recuperación vía E-mail <b style="color:red;">NO DISPONIBLE </b>, Contacte al Administrador.</p>
                        </div>
                        <div class="modal-footer justify-content-between">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                            <button type="submit" class="btn btn-primary" disabled>Procesar</button>
                        </div>
                    </form>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/SISTEMAS_ACTUALIZADOS 8.2/segurosmercantil8/resources/views/login/index.blade.php ENDPATH**/ ?>