<!DOCTYPE html>
<html lang="en" class="gr__rn53themes_net">
<head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <title> <?php echo PROJECT_NAME;?> ..:: <?php echo ucfirst($this->router->fetch_class());?> </title>
    <!--== META TAGS ==-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--== FAV ICON ==-->
    <link rel="shortcut icon" href="">

    <!-- GOOGLE FONTS -->
<link href="<?php echo CSS;?>css.css" rel="stylesheet">

    <!-- FONT-AWESOME ICON CSS -->
    <link rel="stylesheet" href="<?php echo CSS;?>font-awesome.min.css">

    <!--== ALL CSS FILES ==-->
    <link rel="stylesheet" href="<?php echo CSS;?>style.css">
    <link rel="stylesheet" href="<?php echo CSS;?>mob.css">
    <link rel="stylesheet" href="<?php echo CSS;?>bootstrap.css">
    <link rel="stylesheet" href="<?php echo CSS;?>materialize.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo JS;?>html5shiv.js"></script>
    <script src="<?php echo JS;?>respond.min.js"></script>
    <![endif]-->
</head>

<body data-gr-c-s-loaded="true">
    <div class="blog-login">
        <div class="blog-login-in">

          <br clear="all" />

            <?php echo validation_errors('<div class="alert alert-warning text-center"> <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>', '</div>'); ?>
            
            <?php echo ($error_msg!='')?'<div class="alert alert-danger text-center"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'.$error_msg.'</div>':''; ?>

            <form id="login" name="login" method="post">
                <img src="<?php echo IMAGES;?>logo.png" alt="">
                <div class="row">
                    <div class="input-field col s12">
                     <input type="text" name="username" required="" class="validate" value="<?php echo set_value('username'); ?>"  id="first_name1" />

                        
                        <label for="username">Username</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                     <input type="password" class="validate" required="" name="password" value="<?php echo set_value('password'); ?>"  id="last_name" />

                       
                        <label for="password">Password</label>
                    </div>
                </div>
                <div class="row">
                    <div class="input-field col s12">
                     <button class="waves-effect waves-light btn-large btn-log-in">Login</button>
                     <!--  <a class="waves-effect waves-light btn-large btn-log-in" href="http://rn53themes.net/themes/demo/lava-admin/index.html">Login</a> -->
                    </div>
                </div>
                <a href="<?php echo base_url('login/forgotpassword');?>" class="for-pass">Forgot Password?</a>
            </form>
        </div>
    </div>

    <!--======== SCRIPT FILES =========-->
    <script src="<?php echo JS;?>jquery.min.js"></script>
    <script src="<?php echo JS;?>bootstrap.min.js"></script>
    <script src="<?php echo JS;?>materialize.min.js"></script>
    <script src="<?php echo JS;?>custom.js"></script>

<script type="text/javascript" src="<?php echo JS;?>jquery.validate.min.js"></script>
    <script type="text/javascript" src="<?php echo JS;?>validation.js"></script>
<div class="hiddendiv common"></div></body><autoscroll></autoscroll></html>




















                
                


            
       