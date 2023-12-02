<?php $__env->startSection('content'); ?>
<?php
?>
<div class="col-md-10">
  <div class="main-title">
    <h1>Payment Successful</h1>
    <div class="mttl-line"></div>
  </div>
  <h4>Dear <?php echo ucfirst($_SESSION['user']['fname']).' '.ucfirst($_SESSION['user']['lname']);?></h4>
  <?php if($_SESSION['message']=='Upgarde'){?>
  <p>Our records show that you had signed up for our 1-month Premium trial before.Your subscription has been upgraded to Premium. You can continue to access your saved charts and other premium content. Your account subscription will renew automatically every month.</p>
  <p>If you face any difficulties, please contact <a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a></p>
  <?php }else {?>
  <p>Thank you for choosing India Macro Advisors. Your Premium subscription has been successful and your Premium account is now active.
    <?php if(isset($_SESSION['user_type_upgrade']) && $_SESSION['user_type_upgrade']!=1){ ?>
    Check your mail inbox for your login credentials sent to <?php echo (isset($_SESSION['user']['email']))?$_SESSION['user']['email']:'N/A';?>.
    <?php } ?>
  </p>
  <p>Please mail <a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a> with any problems.</p>
  <?php } ?>
  <p>Thank you, <br>India Macro Advisors</p>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>