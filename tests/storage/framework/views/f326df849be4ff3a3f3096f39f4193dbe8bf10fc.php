
<?php $__env->startSection('title', __('Page Expired')); ?>
<?php $__env->startSection('image'); ?>
<img width="45%" src="<?php echo e(asset('img/419 ERROR-07.png')); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('code', '419'); ?>
<?php $__env->startSection('message'); ?>
<br>
<a href="<?php echo e(route('home')); ?>" class="btn btn-primary">Regresar</a>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('errors::layout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/html/segurosmercantil/source/resources/views/errors/419.blade.php ENDPATH**/ ?>