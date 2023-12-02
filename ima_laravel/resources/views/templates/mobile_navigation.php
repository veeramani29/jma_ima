<div class="navbar-header nav-mobile">
	<a class="navbar-brand" href="<?php echo url('/');?>">
		<img alt="Indian GDP Economy" src="<?php echo images_path("/product/logo.png");?>" >
	</a>
</div>
<?php
	$mychartsFolder =  isset($menu_items['folderList'])?json_encode($menu_items['folderList']):json_encode(array());
	$folderDels = json_decode($mychartsFolder, true);
?>
<button class="action" aria-label="Open Menu" id="open-button"><i class="fa fa-fw fa-bars"></i></button>
<div class="menu-wrap">
	<div class="icon-list">
		<?php //if(isset($_SESSION['user'])) { ?>
		<?php //if(isset($folderDels[0]['folder_id'])){ ?>
		<!-- <a href="<?php //echo url('mycharts/#').$folderDels[0]['folder_id'];?>" ><i class="fa fa-fw fa-bar-chart"></i></a> -->
		<?php //} ?>
		<?php //} else {?>
		<!-- <a data-toggle="modal" data-target="#Dv_modal_login"><i class="fa fa-fw fa-bar-chart"></i></a> -->
		<?php // }?>
		<?php if(isset($_SESSION['user'])) { ?>
		<a href="<?php echo url('user/logout');?>"><i class="fa fa-fw fa-sign-out"></i></a>
		<?php } else { ?>
		<a href="<?php echo url('/user/login');?>"><i class="fa fa-fw fa-sign-in"></i></a>
		<?php } ?>
		<a href="<?php echo url('/');?>"><i class="fa fa-fw fa-home"></i></a>
	</div>
	<nav id="ml-menu" class="menu ">
		<div class="menu__wrap">
			<ul data-menu="main" class="menu__level" tabindex="-4" role="menu" aria-label="All">
				<?php if(isset($menu_items['Responsive_left_menu'])) {
					echo $menu_items['Responsive_left_menu']; 
				} ?>
			</ul>
		</div>
	</nav>
</div>
<?php if(isset($_SESSION['user'])) {?>
<button class="action act-user" id="user-login"><i class="fa fa-fw fa-user"></i></button>
<div class="user_dropdown">
	<ul class="list-unstyled">
		<!-- <li> -->
			<?php //if(isset($_SESSION['user'])) {?>
			<?php //if(isset($folderDels[0]['folder_id'])){ ?>
			<!-- <a href="<?php echo url('mycharts/#').$folderDels[0]['folder_id'];?>" ><i class="fa fa-fw fa-bar-chart"></i> My Charts</a> -->
			<?php //} ?>
			<?php //} else {?>
			<!-- <a data-toggle="modal" data-target="#Dv_modal_login"><i class="fa fa-fw fa-bar-chart"></i> My Charts</a> -->
			<?php //}?>
		<!-- </li> -->
		<li><a href="<?php echo url('user/myaccount/subscription');?>"><i class="fa fa-user"></i> My Account</a></li>
		<li><a href="<?php echo url('user/logout');?>"><i class="fa fa-sign-out"></i> Logout</a></li>
	</ul>
</div>
<?php } ?>