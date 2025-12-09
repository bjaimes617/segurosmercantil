<?php $__env->startSection('title','Inicio de Session'); ?>
<?php $__env->startSection('content'); ?> 

<div class="card card-outline card-primary">          
    <div class="card-header text-center">
        <a href="" class="h1"><img src="<?php echo e(asset('img/LOGO DG AZULYMAGENTA.png')); ?>" alt="DirectaGroupLogo Logo"  height="55" width="210" style="opacity: .8"></a>
    </div>
    <div class="card-body">
        <div class="text-center"><b><?php if(Session::has('password')): ?><?php echo e(Session::get('password')); ?><?php endif; ?>.</b> <br> Por politicas de seguridad es necesario que ingrese una nueva contrase&ntilde;a,<br> la misma debe contener una letra mayuscula, un n&uacute;mero y como m&iacute;nimo 12 caracteres de longitud.</div>

        <?php echo Form::open(['route' => 'users.password.update','method' => 'post','id' => 'form_update_password','class' => 'form-horizontal  form-label-left','data-parsley-validate']); ?>

        <?php echo csrf_field(); ?>
        <br>
        <div class="input-group mb-3">
            <input type="password" name="newpassword" id="newpassword" class="form-control <?php $__errorArgs = ['newpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" data-check="<?php echo e(route('users.checknewpassword')); ?>" value="<?php echo e(old('newpassword')); ?>" placeholder="Nueva Contraseña">
            <div class="input-group-append">
                <div class="input-group-text"> 
                    <span class="fas fa-key"></span>
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
        <div class="input-group mb-3">
            <input type="password" name="confirmpassword" id="confirmpassword" class="form-control <?php $__errorArgs = ['confirmpassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"  value="<?php echo e(old('confirmpassword')); ?>" placeholder="Confirme la Contraseña">
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>                
            </div>
            <?php $__errorArgs = ['confirmpassword'];
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

        <!-- /.social-auth-links -->

    </div>
    <div class="card-footer ">            
        <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block" onclick="waith()">Conectar</button>
        </div>
        <!-- /.col -->
    </div>
</form> 
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('styles'); ?>
<!--Custom Style-->

<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<?php echo Html::script("js/user/password.js"); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/source/resources/views/users/changepassword.blade.php ENDPATH**/ ?>