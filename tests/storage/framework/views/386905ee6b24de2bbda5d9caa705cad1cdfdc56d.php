

<?php $__env->startSection('title', __('Forbidden')); ?>
<?php $__env->startSection('image'); ?>
<img width="45%" src="<?php echo e(asset('img/403 ERROR-04.png')); ?>">
<div class="mid_center">
    <?php if(auth()->guard()->check()): ?>
    <a class="btn btn-primary" href="<?php echo e(route('home')); ?>">Regresar</a>
    <?php else: ?>
    <a class="btn btn-primary" href="<?php echo e(route('login')); ?>">Login</a>
    <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('message', __($exception->getMessage() ?: '')); ?>
<?php $__env->startSection('code', '403'); ?>
<?php echo $__env->make('errors::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/source/resources/views/errors/403.blade.php ENDPATH**/ ?>