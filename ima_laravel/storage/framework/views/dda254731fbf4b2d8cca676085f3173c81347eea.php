<?php $__env->startSection('content'); ?>
<div class="col-md-7">
  <div class="error_404">
    <h1 class="err_404">404</h1>
    <h4>Page Not Found...!</h4>
    <p>We are really very sorry but the page you requested can not be found.</p>
    <a href="">Home</a>
  </div> 
</div>
 <?php echo $__env->make('templates.rightside', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>