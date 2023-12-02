<?php
 $mychartsFolder =  isset($menu_items['folderList'])?json_encode($menu_items['folderList']):json_encode(array());
 $folderDels = json_decode($mychartsFolder, true);
 ?>
<div class="menu-wrap">
	<div class="icon-list">
	    <?php if(isset($_SESSION['user'])) {?> 
		<?php if(isset($folderDels[0]['folder_id'])){ ?>
		<a href="<?php echo url('mycharts/#').$folderDels[0]['folder_id'];?>" ><i class="fa fa-fw fa-bar-chart"></i></a>
		<?php } ?>
		<?php } else {?>
		<a data-toggle="modal" data-target="#Dv_modal_login"><i class="fa fa-fw fa-bar-chart"></i></a>
		<?php }?>
		<?php if(isset($_SESSION['user'])) {?>
		<a href="<?php echo url('user/logout');?>"><i class="fa fa-fw fa-sign-out"></i></a>
		<?php } else {?>
		<a href="<?php echo url('/user/login');?>"><i class="fa fa-fw fa-sign-in"></i></a>
		<?php }?>
		<a href="<?php echo url('/');?>"><i class="fa fa-fw fa-home"></i></a>
	</div>
	<nav id="ml-menu" class="menu ">
		<div class="menu__wrap"><ul data-menu="main" class="menu__level" tabindex="-4" role="menu" aria-label="All">
			<?php if(isset($menu_items['Normal_left_menu'])) {
				echo $menu_items['Normal_left_menu']; 
			} ?>
		</div>
	</nav>
</div>		