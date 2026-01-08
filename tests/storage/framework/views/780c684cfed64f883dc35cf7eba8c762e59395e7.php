
<?php $__env->startSection('title', __('Not Found')); ?>
<?php $__env->startSection('code', '404'); ?>
<?php $__env->startSection('image'); ?>
<img width="45%" src="<?php echo e(asset('img/404 ERROR-02.png')); ?>">
<br>
<a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Regresar</a>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('message', __($exception->getMessage() ?: 'No encontrado')); ?>


<?php echo $__env->make('errors::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/source/resources/views/errors/404.blade.php ENDPATH**/ ?>