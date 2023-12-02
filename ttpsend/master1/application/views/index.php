<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
   <title> <?php echo PROJECT_NAME;?> ..:: <?php echo ucfirst($this->router->fetch_class());?> </title>
  <meta name="description" content="Admin, Dashboard, Bootstrap, Bootstrap 4, Angular, AngularJS" />
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimal-ui" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <!-- for ios 7 style, multi-resolution icon of 152x152 -->
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-barstyle" content="black-translucent">
  <link rel="apple-touch-icon" href="<?php echo IMAGES;?>logo.png">
  <meta name="apple-mobile-web-app-title" content="Flatkit">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="<?php echo IMAGES;?>logo.png">
  
  <!-- style -->
  <link rel="stylesheet" href="<?php echo CSS;?>animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>material-design-icons/material-design-icons.css" type="text/css" />

  <link rel="stylesheet" href="<?php echo CSS;?>bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <!-- build:css <?php echo CSS;?>styles/app.min.css -->
  <link rel="stylesheet" href="<?php echo CSS;?>styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="<?php echo CSS;?>styles/font.css" type="text/css" />
</head>
<body>
  <div class="app" id="app">

<!-- ############ LAYOUT START-->
  <div class="center-block w-xxl w-auto-xs p-y-md">
    <div class="navbar">
      <div class="pull-center">
        <a class="navbar-brand">
    <div ui-include="'<?php echo IMAGES;?>logo.svg'"></div>
    <img src="<?php echo IMAGES;?>logo.png" alt="." class="hide">
    <span class="hidden-folded inline"><?php echo PROJECT_NAME;?></span>
</a>

    
      </div>
    </div>
    <div class="p-a-md box-color r box-shadow-z1 text-color m-a">
      <div class="m-b text-sm">
        Sign in with your <?php echo PROJECT_NAME;?> Account
      </div>
        <br clear="all" />

            <?php echo validation_errors('<div class="alert alert-warning text-center"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            
            <?php echo ($error_msg!='')?'<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$error_msg.'</div>':''; ?>
      <form name="form" id="login" name="login" method="post">
        <div class="md-form-group float-label">
              <input type="email" name="user_email" required="" class="md-input" value="<?php echo set_value('username'); ?>"  id="user_email" />

         
          <label>Email</label>
        </div>
        <div class="md-form-group float-label">
       <input type="password" class="md-input" required="" name="password" value="<?php echo set_value('password'); ?>"  id="last_name" />
          <label>Password</label>
        </div>      
        <div class="m-b-md">        
          <label class="md-check">
            <input name="login_rememberMe" id="login_rememberMe" value="y" type="checkbox"><i class="primary"></i> Keep me signed in
          </label>
        </div>
        <button type="submit" class="btn primary btn-block p-x-md">Sign in</button>
      </form>
    </div>

    <div class="p-v-lg text-center">
      <div class="m-b"><a  href="<?php echo base_url('login/forgotpassword');?>" class="text-primary _600">Forgot password?</a></div>
   <!--    <div>Do not have an account? <a ui-sref="access.signup" href="signup.html" class="text-primary _600">Sign up</a></div> -->
    </div>
  </div>

<!-- ############ LAYOUT END-->

  </div>
<!-- build:js <?php echo SCRIPTS;?>/app.html.js -->
<!-- jQuery -->
  <script src="<?php echo JS;?>jquery/jquery/dist/jquery.js"></script>
<!-- Bootstrap -->
  <script src="<?php echo JS;?>jquery/tether/dist/js/tether.min.js"></script>
  <script src="<?php echo JS;?>jquery/bootstrap/dist/js/bootstrap.js"></script>
<!-- core -->
  <script src="<?php echo JS;?>jquery/underscore/underscore-min.js"></script>
  <script src="<?php echo JS;?>jquery/jQuery-Storage-API/jquery.storageapi.min.js"></script>
  <script src="<?php echo JS;?>jquery/PACE/pace.min.js"></script>

  <script src="<?php echo SCRIPTS;?>config.lazyload.js"></script>

  <script src="<?php echo SCRIPTS;?>palette.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-load.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-jp.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-include.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-device.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-form.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-nav.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-screenfull.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-scroll-to.js"></script>
  <script src="<?php echo SCRIPTS;?>ui-toggle-class.js"></script>

  <script src="<?php echo SCRIPTS;?>app.js"></script>

  <!-- ajax -->
  <script src="<?php echo JS;?>jquery/jquery-pjax/jquery.pjax.js"></script>

<!-- endbuild -->
</body>
</html>





















                
                


            
       