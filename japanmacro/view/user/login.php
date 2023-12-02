<?php
if($this->resultSet['status'] == 3333) {
  $login_msg = $this->resultSet['message'];
} else {
  ($login_msg = $this->getFlashMessage()) == null ? '' : $login_msg;
}
$register_msg = '';
?>

<div class="col-md-10 col-xs-12 loginpage_con">
<?php if($this->actionname=='premium_login'){ ?> 

<div class="alert alert-warning" role="alert">  
<p><b> <strong><i class="fa fa-warning"></i></strong>
                  Sorry..! you do not have permission to view premium ontents. Please review your subscription status 
                  <a href="<?php echo $this->url('user/myaccount');?>">Account details</a> . </b> </p>
<p>This content is restricted <b>for paying users only.</b> If you are a PREMIUM / CORPORATE account user, please log-in.</p>
                 <p><br>Thank you again for being a JMA user and we welcome any feedback you like to share with us at 
                <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. 
              </p>
 </div>
<?php } ?>

  <div class="panel panel-default">
    <div class="panel-body">      
      <div class="col-md-7 col-lg-6 col-xs-12 padl0 li_licon">
        <div class="default-padding">
          <div class="main-title">
            <h1>Login</h1>
            <div class="mttl-line"></div>
          </div>
          <?php if($login_msg != '') { ?>
          <p class="text-center text-danger"><?php echo $login_msg; ?></p>
          <?php }?>
          <form name="login_frm" id="login_frm" class="form-horizontal" action="<?php echo $this->url('/user/login');?>" method="post" role="form" >
            <input type="hidden" value="<?php echo (isset($login_ts) && $login_ts!=null)?$login_ts:''; ?>" name="login_ts" />
            <div class="form-group">
              <div class="text-center">
                <a  title="Linkedin Signin" class="text-center" href="<?php echo $this->url('user/linkedinProcess');?>"><img  alt="Linkedin Signin" src="<?php echo $this->images;?>sign-in-with-linkedin.png" /></a>
              </div>

            </div>
            <div class="form-group">
              <div class="sinup_orcon">
                <p class="">OR</p>
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2 col-xs-12" for="email">Email:</label>
              <div class="col-md-10 col-xs-12">
                <input type="email" class="form-control required" value="<?php echo (isset($_REQUEST['login_email']))?$_REQUEST['login_email']:'';?>" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address" name="login_email" id="login_email" placeholder="Enter email">
              </div>
            </div>
            <div class="form-group">
              <label class="control-label col-md-2 col-xs-12" for="pwd">Password:</label>
              <div class="col-md-10 col-xs-12">
                <input type="password" class="form-control" name="login_password" data-rule-required="true" data-msg-required="Please enter password" id="login_password" placeholder="Enter password">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <div class="checkbox">
                  <label class="control control--checkbox">Keep me signed in
                    <input type="checkbox" value="y" id="login_rememberMe" name="login_rememberMe" checked/>
                    <div class="control__indicator"></div>
                  </label>
                </div>
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <a href="<?php echo $this->url('user/forgotpassword');?>">Forgot your password?</a>
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
      <div class="col-lg-6 col-md-5 col-xs-12 padr0 pad-md0">
        <div class="default-padding">
          <div class="main-title">
            <h1>Register</h1>
            <div class="mttl-line"></div>
          </div>
          <?php if($register_msg != '') { ?>
          <p class="text-center text-danger"><?php echo $register_msg; ?></p>
          <?php }?>
          <form class="form-horizontal" name="register_pre_frm" id="register_pre_frm"  action="<?php echo $this->url('/user/signup');?>" method="post" role="form">
            <input type="hidden" value="<?php echo (isset($login_ts) && $login_ts!=null)?$login_ts:''; ?>" name="login_ts" />
            <div class="form-group">
              <label class="control-label col-lg-2 col-xs-12" for="email">Email:</label>
              <div class="col-lg-10 col-xs-12">
                <input type="email" class="form-control required"  name="register_email" id="register_email" placeholder="Enter email">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                Sign up for a free account.
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <button type="submit" name="login_btn" class="btn btn-primary">Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
