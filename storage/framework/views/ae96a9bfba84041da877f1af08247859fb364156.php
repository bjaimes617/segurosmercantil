<?php $__env->startSection('title', 'Inicio de Session'); ?>
<?php $__env->startSection('content'); ?>
    <div class="card card-outline card-primary">
        <div class="card-header text-center">
            <a href="" class="h1"><img src="<?php echo e(asset('img/LOGO DG AZULYMAGENTA.png')); ?>" alt="DirectaGroupLogo Logo"
                    height="55" width="210" style="opacity: .8"></a>
        </div>
        <form
            <?php if(auth()->guard()->check()): ?>
action="<?php echo e(route('users.password.update')); ?>"
             <?php else: ?> 
             action="<?php echo e(route('password.request')); ?>" <?php endif; ?>
            method="POST" id="form_update_password">
            <?php echo csrf_field(); ?>
            <div class="card-body">
                <?php if(auth()->guard()->guest()): ?>
                    <input type="hidden" name="email" value="<?php echo e($email); ?>">
                    <input type="hidden" name="token" value="<?php echo e($token); ?>">
                <?php endif; ?>
                <div class="text-center"><b>
                        <?php if(Session::has('password')): ?>
                            <?php echo e(Session::get('password')); ?>

                        <?php endif; ?>.
                    </b> <br> Por politicas de seguridad es necesario que ingrese una nueva contraseña, <br> la misma debe
                    contener una letra mayuscula, un número y como mínimo 8 caracteres de longitud.</div>
                <br>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="newpassword" id="newpassword" required
                            <?php if(auth()->guard()->check()): ?>
data-check="<?php echo e(route('users.checknewpassword')); ?>"
                           <?php else: ?> 
                           data-check="<?php echo e(route('guest.checknewpassword', $email)); ?>" <?php endif; ?>
                            class="form-control" value="<?php echo e(old('newpassword')); ?>" placeholder="Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-key"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <div class="input-group">
                        <input type="password" name="confirmpassword" id="confirmpassword" required class="form-control"
                            value="<?php echo e(old('confirmpassword')); ?>" placeholder="Confirme su Contraseña">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary btn-block">Conectar</button>
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
    <script src="<?php echo e(asset('js/user/password.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/users/changepassword.blade.php ENDPATH**/ ?>