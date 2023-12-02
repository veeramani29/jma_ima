<?php $__env->startSection('content'); ?>
<?php
if(isset($result['status']) && $result['status'] == 3333) {
  $login_msg = $result['message'];
} else {
  //($login_msg = $this->getFlashMessage()) == null ? '' : $login_msg;
  $login_msg =isset($_SESSION['alanee_flashmessage']) ? $_SESSION['alanee_flashmessage'] : '';
}
$register_msg = '';
?>
<div class="col-xs-12 loginpage_con">
  <?php if(thisMethod()=='premium_login'){ ?> 
  <div class="alert alert-warning" role="alert">  
    <p><b> <strong><i class="fa fa-warning"></i></strong>
      Sorry..! You do not have a permission to view premium contents. Please review your subscription status 
      <a href="<?php echo url('user/myaccount');?>">Account details</a> . </b> 
    </p>
    <p>This content is restricted <b>for paying users only.</b> If you are a PREMIUM / CORPORATE account user, please log-in.</p>
   <p class="un-justify"><br>Thank you again for being a IMA user and we welcome any feedback you like to share with us at <a href="mailto:info@indiamacroadvisors.com">info@indiamacroadvisors.com</a>. </p>
  </div>
  <?php } ?>
  <div class="panel panel-default">
    <div class="panel-body">      
      <div class="col-md-7 col-xs-12 padl0 li_licon">
        <div class="default-padding">
          <div class="main-title">
            <h1>Login</h1>
            <div class="mttl-line"></div>
          </div>
          <?php if($login_msg != '') { ?>
          <p class="text-center text-danger"><?php echo $login_msg; ?></p>
          <?php }?>
          <form name="login_frm" id="login_frm" class="form-horizontal" action="<?php echo url('/user/login');?>" method="post" role="form" >
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <input type="hidden" value="<?php echo (isset($login_ts) && $login_ts!=null)?$login_ts:''; ?>" name="login_ts" />
            <div class="form-group text-center">
              <a class="reg_fb btn btn-fbsu" onclick="window.open(this.href, '_blank','width=600,height=600,scrollbars=yes,status=yes,resizable=yes,screenx='+((parseInt(screen.width) - 600)/2)+',screeny='+((parseInt(screen.height) - 600)/2)+'');return false;" href="<?php echo url('auth/login/facebook',isset($product)? $product : 'free');?>"> 
                <i class="fa fa-facebook"></i> Sign in
              </a>
              <a href="<?php echo url('user/linkedinProcess');?>" class="btn btn-lisu">
                <i class="fa fa-linkedin"></i> Sign in
              </a>
            </div>
            <div class="form-group">
              <div class="sinup_orcon">
                <p class="">OR</p>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2 col-xs-12" for="email">Email:</label>
              <div class="col-sm-10 col-xs-12">
                <input type="email" class="form-control required" value="<?php echo (isset($_REQUEST['login_email']))?$_REQUEST['login_email']:'';?>" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address" name="login_email" id="login_email" placeholder="Enter email">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-sm-2 col-xs-12" for="pwd">Password:</label>
              <div class="col-sm-10 col-xs-12">
                <input type="password" class="form-control" name="login_password" data-rule-required="true" data-msg-required="Please enter password" id="login_password" placeholder="Enter password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <div class="checkbox">
                  <label class="control control--checkbox">Keep me signed in
                    <input type="checkbox" value="y" id="login_rememberMe" name="login_rememberMe"/>
                    <div class="control__indicator"></div>
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <a href="<?php echo url('user/forgotpassword');?>">Forgot your password?</a>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <button type="submit" name="login_btn" class="btn btn-primary">Submit</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-5 col-xs-12 padr0 pad-md0">
        <div class="default-padding">
          <div class="main-title">
            <h1>Register</h1>
            <div class="mttl-line"></div>
          </div>
          <!-- <div class="form-group text-center">
            <a class="reg_fb btn btn-fbsu" onclick="window.open(this.href, '_blank','width=600,height=600,scrollbars=yes,status=yes,resizable=yes,screenx='+((parseInt(screen.width) - 600)/2)+',screeny='+((parseInt(screen.height) - 600)/2)+'');return false;" href="<?php echo url('auth/login/facebook',isset($product)? $product : 'free');?>"> 
              <i class="fa fa-facebook"></i> Sign up
            </a>
            <a href="<?php echo url('user/linkedinProcess');?>" class="btn btn-lisu">
              <i class="fa fa-linkedin"></i> Sign up
            </a>
          </div>
          <div class="form-group">
            <div class="sinup_orcon">
              <p class="">OR</p>
            </div>
          </div> -->
          <?php if($register_msg != '') { ?>
          <p class="text-center text-danger"><?php echo $register_msg; ?></p>
          <?php }?>
          <form name="register_pre_frm" id="register_pre_frm"  action="<?php echo url('/user/signup');?>" method="post" role="form">
            <input type="hidden" value="<?php echo (isset($login_ts) && $login_ts!=null)?$login_ts:''; ?>" name="login_ts" />
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">
            <div class="form-group">
              <label class="control-label" for="email">Email:</label>
              <input type="email" class="form-control required"  name="register_email" id="register_email" placeholder="Enter email">
            </div>
            <div class="form-group">
              Sign up for a free account.
            </div>
            <div class="form-group text-center">
              <button type="submit" name="login_btn" class="btn btn-primary">Continue</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
/* $("#login_frm").validate({
  submitHandler: function(form) {
    $('.payloder').show();
    $('html, body').animate({scrollTop : 0},800);
    form.submit();
  }
});
$("#register_pre_frm").validate({
  submitHandler: function(form) {
    $('.payloder').show();
    $('html, body').animate({scrollTop : 0},800);
    form.submit();
  }
}); */
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('templates.default', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>