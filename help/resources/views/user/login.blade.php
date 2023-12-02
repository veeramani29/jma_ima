@extends('templates.default')
@section('content')
<?php
if(isset($result['status']) && $result['status'] == 3333) {
  $login_msg = $result['message'];
} else {
  $login_msg =(Session::has('message'))?Session::get('message'):'';
}
$register_msg = '';
?>
<div class="col-md-10 col-xs-12 loginpage_con">
  <?php if(thisMethod()=='premium_login'){ ?>
  <div class="alert  <?php echo (thisMethod()=='premium_login')?'text-center':'';?>" role="alert">
    
      
      <h4 class="modal-title"> <!--<strong><i class="fa fa-warning"></i></strong>Sorry! --> This feature is restricted to our Standard / Corporate subscribers. </h4>
      <br>
      
            <p><a target="_balnk" class="btn btn-success" href="<?php echo url('products');?>">Start a subscription with 30-days free trial</a></a></p>
 @if(!Session::has('user'))  @endif
             <p><b> If you are a JMA Standard / Corporate subscriber, please login from below.</b> </p>
            
             @if(Session::has('user') && Session::get('user.id') > 0)   @endif
            <p><b> If you are a Free account user registered before Jan 2018, please upgrade your subscription status from <a href="<?php echo url('user/myaccount/subscription');?>">here</a></b>. </p>

           <!-- <p>We welcome any feedback you like to share with us at <a href="mailto:info@japanmacroadvisors.com">info@japanmacroadvisors.com</a>. </p> -->
  </div>
  <?php } ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="<?php echo (thisMethod()=='premium_login')?'col-md-12 col-lg-12 col-xs-12':'col-md-7 col-lg-6 col-xs-12 li_licon';?> padl0 ">
        <div class="default-padding">
          <div class="main-title">
            <h1>Login</h1>
            <div class="mttl-line"></div>
          </div>
          <?php if(isset($login_msg) && $login_msg != '') { ?>
          <p class="text-center text-danger"><?php echo $login_msg; ?></p>
          <?php }?>
          <form name="login_frm" id="login_frm" action="<?php echo url('user/login');?>" class="form-horizontal"  method="post" role="form" >
            <?php if(thisMethod()=='premium_login'){ ?>
            <input type="hidden" name="premium_login" value="Yes">
            <?php } ?>
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" value="<?php echo (isset($login_ts) && $login_ts!=null)?$login_ts:''; ?>" name="login_ts" />
			<div class="form-group">
              <div class="text-center">
                <a  title="Linkedin Signin" class="text-center" href="<?php echo url('user/linkedinProcess');?>"><img  alt="Linkedin Signin" src="<?php echo images_path('sign-in-with-linkedin.png');?>" /></a>
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
 <?php if(thisMethod()=='login'){ ?>
      <div class="col-lg-6 col-md-5 col-xs-12 padr0 pad-md0">
        <div class="default-padding">
          <div class="main-title">
            <h1>Register</h1>
            <div class="mttl-line"></div>
          </div>
          <?php if($register_msg != '') { ?>
          <p class="text-center text-danger"><?php echo $register_msg; ?></p>
          <?php }?>
          <form class="form-horizontal" name="register_pre_frm" id="register_pre_frm"  action="<?php echo url('/user/signup');?>" method="post" role="form">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" value="<?php echo (isset($login_ts) && $login_ts!=null)?$login_ts:''; ?>" name="login_ts" />
<div class="form-group text-center">


          <!--   <a class="btn btn-success " href="<?php echo url('products');?>">
              <i class="fa fa-hand-o-right"></i>
              Register for 30-days free trial
            </a> -->
            </div>

           <div class="form-group">
              <label class="control-label col-lg-2 col-xs-12" for="email">Email:</label>
              <div class="col-lg-10 col-xs-12">
                <input type="email" class="form-control required"  name="register_email" id="register_email" placeholder="Enter email">
              </div>
            </div>
           <!--  <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                Sign up for Standard account (*30-days free trial).  
              </div>
            </div> -->
            <div class="form-group">
              <div class="col-xs-12 col-md-offset-2 col-md-10">
                <button type="submit" name="login_btn" class="btn btn-primary">Continue</button>
              </div>
            </div>
          </form>
        </div>
      </div>
      <?php } ?>
    </div>
  </div>
</div>
@stop