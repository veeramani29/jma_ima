
<!DOCTYPE html>
<html lang="en">

<head>
 <title><?php echo PROJECT_NAME;?> ..:: <?php echo ucfirst($this->router->fetch_class());?></title>
   
    <!--== META TAGS ==-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <!--== FAV ICON ==-->
    <link rel="shortcut icon" href="<?php echo IMAGES;?>fav.ico">

    <!-- GOOGLE FONTS -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600|Quicksand:300,400,500" rel="stylesheet">

    <!-- FONT-AWESOME ICON CSS -->
    <link rel="stylesheet" href="<?php echo CSS;?>font-awesome.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
    <!--== ALL CSS FILES ==-->
    <link rel="stylesheet" href="<?php echo CSS;?>style.css">
    <link rel="stylesheet" href="<?php echo CSS;?>mob.css">
    <link rel="stylesheet" href="<?php echo CSS;?>bootstrap.css">
    <link rel="stylesheet" href="<?php echo CSS;?>materialize.css" />
 <script src="<?php echo JS;?>jquery.min.js"></script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="<?php echo JS;?>html5shiv.js"></script>
    <script src="<?php echo JS;?>respond.min.js"></script>
    <![endif]-->




<script type="text/javascript">
  WEB_URL="<?php  echo HOST_ADMIN;?>";
  HOST="<?php  echo HOST;?>";
  get_csrf_token_name="<?php  echo $this->security->get_csrf_token_name();?>"; 
get_csrf_hash="<?php  echo $this->security->get_csrf_hash();?>";
  </script>

  

<style type="text/css">
label.error{
     color: red;
     font-size: 10px;
}
.form-control.error{
    border: 1px solid red;
}



.green{
        color: green;
}

.red,.error{
 color: red;
}

.fleft{
    float: left;
}
.marg10{
        margin-left: 10%;
            width: 50%;
}
.marg10 p,.marg10 h4{
        color: #666;
        margin-top: 10px;
}
.orange,.revoke{
        color: #fb9337;
}


 

.hide{
    display: none;
}
.show{
    display: block;
}



</style>
</head>

<body>
    <!--== MAIN CONTRAINER ==-->
    <div class="container-fluid sb1">
        <div class="row">
            <!--== LOGO ==-->
            <div class="col-md-2 col-sm-3 col-xs-6 sb1-1">
                <a href="#" class="btn-close-menu"><i class="fa fa-times" aria-hidden="true"></i></a>
                <a href="#" class="atab-menu"><i class="fa fa-bars tab-menu" aria-hidden="true"></i></a>
                <a href="<?php echo base_url('dashboard');?>" class="logo"><img src="<?php echo IMAGES;?>logo1.png" alt="Admin Logo" />
                </a>
            </div>
           
          
            <!--== MY ACCCOUNT ==-->
            <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                <!-- Dropdown Trigger -->
                <a class='waves-effect dropdown-button top-user-pro' href='#' data-activates='top-menu'><img src="<?php echo IMAGES;?>6.png" alt="" />My Account <i class="fa fa-angle-down" aria-hidden="true"></i>
                </a>

                <!-- Dropdown Structure -->
                <ul id='top-menu' class='dropdown-content top-menu-sty'>
                    <li><a href="<?php echo base_url('admin/edit');?>" class="waves-effect"><i class="fa fa-cogs" aria-hidden="true"></i>Admin Setting</a>
                    </li>

                    <li><a href="<?php echo base_url('admin/changepassword');?>" class="waves-effect"><i class="fa fa-cogs" aria-hidden="true"></i>Change Password</a>
                    </li>
                  <!--   <li><a href="listing-all.html" class="waves-effect"><i class="fa fa-list-ul" aria-hidden="true"></i> Listings</a>
                    </li>
                    <li><a href="hotel-all.html" class="waves-effect"><i class="fa fa-building-o" aria-hidden="true"></i> Hotels</a>
                    </li> -->
                    <li><a href="<?php echo base_url('tourpack');?>" class="waves-effect"><i class="fa fa-umbrella" aria-hidden="true"></i> Tour Packages</a>
                    </li>
                   <!--  <li><a href="event-all.html" class="waves-effect"><i class="fa fa-flag-checkered" aria-hidden="true"></i> Events</a>
                    </li>
                    <li><a href="offers.html" class="waves-effect"><i class="fa fa-tags" aria-hidden="true"></i> Offers</a>
                    </li>
                    <li><a href="user-add.html" class="waves-effect"><i class="fa fa-user-plus" aria-hidden="true"></i> Add New User</a>
                    </li>
                    <li><a href="#" class="waves-effect"><i class="fa fa-undo" aria-hidden="true"></i> Backup Data</a>
                    </li>
                    <li class="divider"></li> -->
                    <li><a href="<?php echo base_url('login/signout');?>" class="ho-dr-con-last waves-effect"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>







