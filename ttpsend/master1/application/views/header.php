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
  <meta name="apple-mobile-web-app-title" content="BlueStar">
  <!-- for Chrome on Android, multi-resolution icon of 196x196 -->
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="shortcut icon" sizes="196x196" href="<?php echo IMAGES;?>logo.png">
  <!-- style -->
  <link rel="stylesheet" href="<?php echo CSS;?>animate.css/animate.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>glyphicons/glyphicons.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>font-awesome/css/font-awesome.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>material-design-icons/material-design-icons.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>bootstrap/dist/css/bootstrap.min.css" type="text/css" />
  <link rel="stylesheet" href="<?php echo CSS;?>jquery-ui/jquery-ui.css">
  <!-- build:css <?php echo CSS;?>styles/app.min.css -->
  <link rel="stylesheet" href="<?php echo CSS;?>styles/app.css" type="text/css" />
  <!-- endbuild -->
  <link rel="stylesheet" href="<?php echo CSS;?>styles/font.css" type="text/css" />
  <style type="text/css">
    ul.parsley-errors-list li,div.form-group small{
      color: red;
    }
  </style>
  <script type="text/javascript">
  WEB_URL="<?php  echo HOST_ADMIN;?>";
  HOST="<?php  echo HOST;?>";
  get_csrf_token_name="<?php  echo $this->security->get_csrf_token_name();?>"; 
get_csrf_hash="<?php  echo $this->security->get_csrf_hash();?>";
 WEB_CLASS="<?php  echo $this->router->fetch_class();?>";
 WEB_METHOD="<?php  echo $this->router->fetch_method();?>";

  </script>
</head>
<body>
  <div class="app" id="app">
    <!-- ############ LAYOUT START-->

 








