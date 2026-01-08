<?php $__env->startSection('title', 'Usuarios del Sistema|Perfil de Usuario'); ?>
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
                        <li class="breadcrumb-item">Usuarios</li>
                        <li class="breadcrumb-item active">Perfil</li>
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
                        <div class="card-body">  

                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">
                                    <div class="text-center">
                                        <img class="profile-user-img img-fluid img-circle"
                                             src="<?php echo e(Auth()->user()->RelationToPersonal != null ? \Storage::disk('personal')->url(\Auth()->user()->RelationToPersonal->image) : asset('img/user.png')); ?>"
                                             alt="User profile picture">
                                    </div>
                                    <h3 class="profile-username text-center"><?php echo e(Auth::User()->name); ?></h3>
                                    <p class="text-muted text-center"><?php echo e(Auth::User()->roles()->first()->name); ?></p>
                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">                                         
                                            <b>Token Autenticación Externa: </b> <a class="float-right"> <?php echo Auth::User()->tokens()->first() != null ? $tokens : ""; ?></a>
                                        </li>                                    
                                        
                                        <li class="list-group-item">
                                            <b>Ultima Actualización de Contraseña: </b> <a class="float-right"><?php echo e(Auth::User()->password_updated_at != null ? date('d/m/Y',strtotime(Auth::User()->password_updated_at)) : "-"); ?></a>
                                        </li>                                        
                                    </ul>
                                    <div class="text-center"><h3> Credenciales de Usuario</h3></div>
                                    <br>
                                    <div class="text-center"><h6><?php if(Session::has('password')): ?><?php echo e(Session::get('password')); ?><?php endif; ?>. <br> <?php echo e(trans('passwords.password.text')); ?></h6> </div>
                                    <form action="<?php echo e(route('users.password.update')); ?>" method="POST" id="form_update_password" >                                    
                                        <?php echo csrf_field(); ?>
                                        <br>
                                        <div class="form-group">
                                            <div  class="input-group">
                                                <input type="password" name="password" id="password" required                                                       
                                                       data-check="<?php echo e(route('users.checknewpassword')); ?>"                                                             
                                                       class="form-control"  value="<?php echo e(old('password')); ?>" placeholder="Contraseña">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-key"></span>
                                                    </div>                
                                                </div>        
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div  class="input-group">
                                                <input type="password" name="confirmpassword" id="confirmpassword" required                                       
                                                       class="form-control"  value="<?php echo e(old('confirmpassword')); ?>" placeholder="Confirme su Contraseña">
                                                <div class="input-group-append">
                                                    <div class="input-group-text">
                                                        <span class="fas fa-lock"></span>
                                                    </div>                
                                                </div>        
                                            </div>
                                        </div> 
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary btn-block">Actualizar</button>
                                        </div>
                                    </form> 
                                </div>                                
                            </div> 

                        </div>

                        <!-- /.card-body -->
                    </div>
                </div>
            </div>
            <!-- /.card -->

        </div>
    </section>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('js/user/password.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/users/profile.blade.php ENDPATH**/ ?>