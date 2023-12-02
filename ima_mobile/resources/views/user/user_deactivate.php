<?php 
//echo '<pre>';
//print_r($this->resultSet['result']['userdetails']);
//exit;

$user_details = $this->resultSet['result']['userdetails'];

?>



	<div class="content_midsection">
    <div class="mid_content">
        <div class="login_box_outer">
        	<div class="login_box_inner">
	            <div style="padding:12px">

	<form onsubmit="return confirm('Are you sure?');" action="<?php echo $this->url('user/user_deactivate');?>" method="post">
	
		 <?php if(($flashMsg = $this->getFlashMessage()) != null) {?>
		<div id="Dv_flashMessage" class="fullwidth"><div class="flash_msg activemsg"><?php echo $flashMsg;?></div><div class="close_btn"></div></div>
		<?php }?>
		
		
		<div class="pad20">
		<?php if($user_details['user_type']=='individual'){ ?>
		<p>Your are about to cancel your Premium account subscription, Please be aware that you will no longer be able to access your Premium contents. Once you choose confirm, your account type will change to Free Account.</p>
		<div align="center" >
		<button type="button" class="form_submit_btn" onclick="location.href='<?php echo $this->url('user/myaccount/subscription');?>'" >Cancel</button>
		
		<button name="submit" type="submit" value="individual" class="form_submit_btn">Confirm</button>
		</div>
		<?php } ?>

		<?php if($user_details['user_type']=='corporate'){ ?>
		<p>Your are about to cancel your Corporate account subscription, Please be aware that you will no longer be able to access your Corporate contents. Once you choose confirm, your account type will change to Free Account.</p>
		<div align="center" >
		<button type="button" class="form_submit_btn" onclick="location.href='<?php echo $this->url('user/myaccount/subscription');?>'" >Cancel</button>
		
		<button name="submit" type="submit" value="corporate" class="form_submit_btn">Confirm</button>
		</div>
		<?php } ?>

		<?php if($user_details['user_type']=='free'){ ?>
			<p>If you want to deactivate your account permanently ,  click on Permanently  Delete Account</p>
			<div align="center" ><button type="button" class="form_submit_btn" onclick="location.href='<?php echo $this->url('user/myaccount/subscription');?>'" >Cancel</button>
			<button name="submit"   type="submit" value="free" class="form_submit_btn">Permanently Delete Account</button></p>
		<?php } ?>
		</div>
 
		</form>

	</div>	

	</div>
	
	
</div>
</div>
</div>
