<div class="user-panel mt-3 pb-3 mb-3 d-flex">
    <div class="image">
        <img src="<?php echo e(asset('img/user.png')); ?>" class="img-circle elevation-2" alt="User Image">
    </div>
    <div class="info">
        <a href="#" class="d-block"><?php echo e(\Auth::user()->name); ?></a>
    </div>
</div>
<nav class="mt-2">    
    <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">              
        <?php if (Auth::check() && Auth::user()->hasPermission('gestion.module|consolidados.ventas')): ?>
        <li class="nav-item <?php echo $__env->yieldContent('menu_gestion'); ?>">
            <a href="#" class="nav-link <?php echo $__env->yieldContent('gestion'); ?>">
                <i class="nav-icon fas fa-folder-open"></i>
                <p>Gestión <i class="right fas fa-angle-left"></i></p>
            </a>
            <?php if (Auth::check() && Auth::user()->hasPermission('gestion.asignarclientes|gestion.submodulos')): ?>
            <ul class="nav nav-treeview"> 
                 <li class="nav-item">
                    <a href="<?php echo e(route('gestion.manual')); ?>" class="nav-link <?php echo $__env->yieldContent('gestion.manual'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Manual</p>
                    </a>
                </li>
                <?php if (Auth::check() && Auth::user()->hasPermission('gestion.asignarclientes')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('gestion.asignar')); ?>" class="nav-link <?php echo $__env->yieldContent('gestion.asignar'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Asignar</p>
                    </a>
                </li>
                <?php endif; ?>
                <?php if (Auth::check() && Auth::user()->hasPermission('gestion.submodulos')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('gestion.index')); ?>" class="nav-link <?php echo $__env->yieldContent('gestion.index'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Asignados</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('gestion.agendados')); ?>" class="nav-link <?php echo $__env->yieldContent('gestion.agendados'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Agendados</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('gestion.nocontactos')); ?>" class="nav-link <?php echo $__env->yieldContent('gestion.nocontacto'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>No Contactado</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo e(route('gestion.ventas')); ?>" class="nav-link <?php echo $__env->yieldContent('gestion.ventas'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Ventas</p>
                    </a>
                </li>
                <?php endif; ?>               
            </ul>
            <ul class="nav nav-treeview">
                <?php if (Auth::check() && Auth::user()->hasPermission('consolidados.ventas')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('consolidado.index')); ?>" class="nav-link <?php echo $__env->yieldContent('consolidado.index'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Consolidado Ventas</p>
                    </a>
                </li>
                 <?php endif; ?>
                 <?php if (Auth::check() && Auth::user()->hasPermission('buscador')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('buscador.index')); ?>" class="nav-link <?php echo $__env->yieldContent('buscador.index'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Buscador</p>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
            <?php endif; ?>
        </li> 
        <?php endif; ?>
        <?php if (Auth::check() && Auth::user()->hasPermission('reportes.module')): ?>
        <li class="nav-item <?php echo $__env->yieldContent('menu_reportes'); ?>">
            <a href="#" class="nav-link <?php echo $__env->yieldContent('reportes'); ?>">
                <i class="nav-icon fas fa-file"></i>
                <p>Reportes <i class="right fas fa-angle-left"></i></p>
            </a>
            <ul class="nav nav-treeview"> 
                <?php if (Auth::check() && Auth::user()->hasPermission('reporte.general')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('reportes.index')); ?>" class="nav-link <?php echo $__env->yieldContent('reportes.index'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>General</p>
                    </a>
                </li>         
                <?php endif; ?>
                <?php if (Auth::check() && Auth::user()->hasPermission('reporte.txt')): ?>
                <!---<li class="nav-item">
                    <a href="<?php echo e(route('reportes.txt')); ?>" class="nav-link <?php echo $__env->yieldContent('reportes.txt'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>TXT por Planes</p>
                    </a>
                </li>-->
                <li class="nav-item">
                    <a href="<?php echo e(route('reportes.csv')); ?>" class="nav-link <?php echo $__env->yieldContent('reportes.csv'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>CSV Ventas</p>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
        </li> 
        <?php endif; ?>
        <?php if (Auth::check() && Auth::user()->hasPermission('administrador.module')): ?>
        <li class="nav-item <?php echo $__env->yieldContent('menu_administracion'); ?>">
            <a href="#" class="nav-link <?php echo $__env->yieldContent('administracion'); ?>">
                <i class="nav-icon fas fa-cog"></i>
                <p>Administración <i class="right fas fa-angle-left"></i></p>
            </a>
            <?php if (Auth::check() && Auth::user()->hasPermission('administrador.upload|administrador.deleted')): ?>
            <ul class="nav nav-treeview">   
                <?php if (Auth::check() && Auth::user()->hasPermission('administrador.upload')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('administration.index')); ?>" class="nav-link <?php echo $__env->yieldContent('administracion.index'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Cargar</p>
                    </a>
                </li>
                 <?php endif; ?>
                <?php if (Auth::check() && Auth::user()->hasPermission('administrador.deleted')): ?>
                <li class="nav-item">
                    <a href="<?php echo e(route('administration.deleted')); ?>" class="nav-link <?php echo $__env->yieldContent('administracion.deleted'); ?>">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Eliminar</p>
                    </a>
                </li>
                <?php endif; ?>
            </ul>
             <?php endif; ?>
        </li> 
        <?php endif; ?>
    </ul>  
</nav><?php /**PATH /var/www/html/SISTEMAS_ACTUALIZADOS 8.2/segurosmercantil8/resources/views/partials/menu.blade.php ENDPATH**/ ?>