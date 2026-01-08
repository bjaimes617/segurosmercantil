<?php echo Html::script('plugins/sweetalert2/sweetalert2.min.js'); ?>      
<?php echo Html::script('plugins/toastr/toastr.min.js'); ?> 
<script>
function main() {
    return Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 10000
    });
};

function mainconfirms() {
    return Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: true,
      confirmButtonText: "OK",
      //timer: 10000
    });
};
</script>

<?php if(Session('success')): ?>
<script>   
    var Toastr = main();  
    $(function () {
        Toastr.fire({
            icon: 'success',
            title: "&nbsp;<?php echo e(Session::get('success')); ?>",
        }); 
    });
</script>
<?php endif; ?>
<?php if(Session('error')): ?>
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'error',
        title: "&nbsp; <?php echo e(Session::get('error')); ?>",
      });
</script>
<?php endif; ?>
<?php if(Session('info')): ?>
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'info',
        title: "&nbsp; <?php echo e(Session::get('info')); ?>",
      });
</script>
<?php endif; ?>
<?php if(Session('warning')): ?>
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'warning',
        title: "&nbsp; <?php echo e(Session::get('warning')); ?>",
      });
</script>
<?php endif; ?>
<?php if(Session('question')): ?>
<script>
    var Toastr = main();    
        Toastr.fire({
        icon: 'question',
        title: "&nbsp; <?php echo e(Session::get('question')); ?>",
      });
</script>
<?php endif; ?>

<?php if(count($errors) > 0): ?>
<script>
    var msg = ""; 
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        msg += "&nbsp; <?php echo $error; ?> <br />"
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
 

    var Toastr = main();    
        Toastr.fire({
        icon: 'error',
        title: msg,
      });
</script>
<?php endif; ?>
<?php if(Session('uploadserror')): ?>
<script>   
    var Toastr = mainconfirms();  
    $(function () {
        Toastr.fire({
            icon: 'error',
            title: "&nbsp;<?php echo e(Session::get('uploadserror')); ?>",
        }); 
    });
</script>
<?php endif; ?><?php /**PATH /var/www/html/segurosmercantil/resources/views/notifications/index.blade.php ENDPATH**/ ?>