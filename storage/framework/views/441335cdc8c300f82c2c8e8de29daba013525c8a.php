<?php $__env->startSection('title', 'Usuarios del Sistema'); ?>
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
                        <li class="breadcrumb-item active">Usuarios</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Listado de usuarios</h3>
                            <div class="btn-group  float-right">
                                <button type='button' class="btn btn-info" data-toggle="modal" data-toggle="tooltip" data-target="#modal-default"  data-placement="top" 
                                        title="Crear Llave de Acceso"><i class="fa fa-key"></i></button>
                                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-primary" id="add" data-toggle="tooltip" data-placement="top" title="Añadir"><i class="fa fa-plus-circle"></i></a>
                            </div>
                        </div>
                        <input type="hidden" id="searchPermissionsUsers" value="<?php echo e(route('users.permissions.search')); ?>">
                        <input type="hidden" id="searchTokensUsers" value="<?php echo e(route('users.tokens.show')); ?>">
                        
                        <!-- /.card-header  modal-tokens-->
                        <div class="card-body">
                            <p><small><?php echo e(trans('mensajeTabla')); ?></small></p>
                            <table id="usuarios_table" class="table compact table-sm table-bordered table-striped text-center">
                                <thead>
                                    <tr>
                                        <th>Nombre y Apellido</th>
                                        <th>Usuario</th>
                                        <th>Email</th>
                                        <th>Estatus</th>
                                        <th>Creado</th>     
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($user->name); ?></td>
                                        <td><?php echo e($user->username); ?></td>
                                        <td><?php echo e($user->email); ?></td>
                                        <td> <?php switch( $user->estatus_id):
                                            case ("Nuevo"): ?>
                                            <span class="badge badge-primary"><?php echo e(strtoupper($user->estatus_id)); ?></span>
                                            <?php break; ?>
                                            <?php case ("Inactivo"): ?>
                                            <span class="badge badge-danger"><?php echo e(strtoupper($user->estatus_id)); ?></span>
                                            <?php break; ?>
                                            <?php default: ?>
                                            <span class="badge badge-success"><?php echo e(strtoupper($user->estatus_id)); ?></span>
                                            <?php break; ?>
                                            <?php endswitch; ?>
                                        </td>
                                        <td><?php echo e(date('d/m/Y',strtotime($user->created_at))); ?></td>                                         
                                        <td>                                             
                                            <?php if (Auth::check() && Auth::user()->hasPermission('edit.users | remove.users')): ?>
                                            <div class="btn-group">
                                                <button type='button'
                                                        class='btn btn-success btn-sm' 
                                                        onclick="ModalPermissions(<?php echo e($user->id); ?>);" 
                                                        ><i class="fas fa-eye"></i></button>
                                                
                                                <button type='button' <?php echo e(!$user->tokens()->exists() ? 'disabled': ''); ?> 
                                                class='btn btn-info btn-sm' data-placement="top" 
                                                title="Listado de tokens" 
                                                onclick="ModelTokens(<?php echo e($user->id); ?>);"><i class="fas fa-key"></i></button>

                                                <?php if (Auth::check() && Auth::user()->hasPermission('edit.users')): ?>
                                                <a href="<?php echo e(route('users.edit',$user->id)); ?>" target="_blank" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i>
                                                </a> 
                                                <?php endif; ?>
                                                <?php if (Auth::check() && Auth::user()->hasPermission('remove.users')): ?>
                                                <button type="button" onclick="Destroy(<?php echo e($user->id); ?>);" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i>
                                                </button>                        
                                                <?php endif; ?>
                                            </div>
                                            <?php endif; ?>
                                            <form  action="<?php echo e(route('users.remove',$user->id)); ?>" method="POST" id="eliminar<?php echo e($user->id); ?>">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                            </form>
                                        </td>                                                                              
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <!-- MODAL DE PERMISOS-->
                            <div class="modal fade" id="modal-permisos">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Permisologia adicional al rol principal</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12"><h4> Rol Principal del usuario: <b><span id="RolPrincipal" style="color:red;"></span></b></h4></div>
                                                <br>
                                                <hr>
                                                <div class="col-md-12">                                                  
                                                    <table id="PermissionsUsers" class="table table-sm compact table-bordered table-striped text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre del permiso</th>
                                                                <th>Slug</th>                                                                                                                                                                                     
                                                            </tr>
                                                        </thead>
                                                        <tbody>                                                       
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                                          
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- MODAL AGREGAR TOKENS--> 
                            <div class="modal fade" id="modal-default">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Creacion de Tokens de Acceso</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <form action="<?php echo e(route('users.tokens.store')); ?>" method="post" id="form-tokens" >
                                            <?php echo csrf_field(); ?>   
                                            <div class="modal-body">
                                                <div class="row mb-3">
                                                    <div class="col-md-12">
                                                        <div class="form-group">
                                                            <label class="col-form-label" for="nombre">Nombre del Token <span style="color:red">*</span></label>                                 
                                                            <div  class="input-group ">
                                                                <input type="text" name="nombre" id="nombre" required class="form-control"  value="<?php echo e(old('nombre')); ?>" placeholder="Nombre del Token">                                           
                                                            </div>
                                                        </div>  
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">                                   
                                                            <label class="col-form-label" for="usuario">Usuario del Sistema <span style="color:red">*</span></label>                               
                                                            <div  class="input-group">
                                                                <select name="usuario" id="usuario" required data-allow-clear="true" multiple class="form-control select2" style="width: 100%;" >                                                   
                                                                    <option value="">[Seleccione]</option>                                                              
                                                                    <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $keys => $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($user->id); ?>"><?php echo e($user->name); ?> : <?php echo e($user->username); ?></option>                                           
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <div class="form-group">                                   
                                                            <label class="col-form-label" for="permisos">Permisos/Habilidades del Acceso</label>                                 
                                                            <div  class="input-group">
                                                                <select name="permisos[]" id="permisos" data-allow-clear="true" required multiple class="form-control select2" style="width: 100%;" >                                                   
                                                                    <option value="">[Seleccione]</option>
                                                                    <option value="*">Sin Restricciones</option>
                                                                    <?php $__currentLoopData = $permissions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $permisos): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                    <option value="<?php echo e($permisos->slug); ?>"><?php echo e($permisos->name); ?></option>                                           
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="displaytoken" class="col-md-12 text-center" style="display:none;">
                                                        <h5>Token De Acceso</h5>
                                                        <p id="newtoken"></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer justify-content-between">
                                                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                                                <button type="submit" class="btn btn-primary">Registrar</button>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
                            <!-- MODAL ELIMINAR TOKENS-->
                            <div class="modal fade" id="modal-tokens-list">
                                <div class="modal-dialog modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title">Listado de Tokens Asignados al Usuario</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">                                                
                                                <hr>
                                                <div class="col-md-12">                                                  
                                                    <table id="TokenListUser" class="table table-sm compact table-bordered table-striped text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>Nombre del Token</th>
                                                                <th>Token</th>                                                                                                                                                                                    
                                                                <th>Acciones</th>                                                                                                                                                                                     
                                                            </tr>
                                                        </thead>                                                        
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer justify-content-between">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>                                          
                                        </div>
                                    </div>
                                    <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->
                            </div>
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
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')); ?>">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css')); ?>">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css')); ?>">
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/select2/css/select2.css')); ?>">  
<link media="all" type="text/css" rel="stylesheet" href="<?php echo e(asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script src="<?php echo e(asset('plugins/datatables/jquery.dataTables.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/datatables-responsive/js/dataTables.responsive.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/datatables-responsive/js/responsive.bootstrap4.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('plugins/select2/js/select2.js')); ?>"></script>
<script src="<?php echo e(asset('js/user/users.js')); ?>" type="text/javascript"></script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil8/resources/views/users/index.blade.php ENDPATH**/ ?>