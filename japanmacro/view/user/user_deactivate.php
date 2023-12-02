<?php 
//echo '<pre>';
//print_r($this->resultSet['result']['userdetails']);
//exit;

$user_details = $this->resultSet['result']['userdetails'];

?>
<div class="col-xs-12 col-sm-10">
	<div class="panel panel-default full-width"> 
		<div class="panel-heading"><strong>Hi <?php echo ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']);?></strong></div>
		<div class="panel-body">
			<form onsubmit="return confirm('Are you sure?');" action="<?php echo $this->url('user/user_deactivate');?>" method="post">
				<?php if(($flashMsg = $this->getFlashMessage()) != null) { ?>
				<div id="Dv_flashMessage" class="fullwidth">
					<div class="flash_msg activemsg"><?php echo $flashMsg;?></div>
					<div class="close_btn"></div>
				</div>
				<?php } ?>
				<?php if($user_details['user_type']=='individual'){ ?>
				<p>Your are about to cancel your Premium account subscription, Please be aware that you will no longer be able to access your Premium contents. Once you choose confirm, your account type will change to Free Account.</p>
				<?php } ?>
				<?php if($user_details['user_type']=='corporate'){ ?>
				<p>Your are about to cancel your Corporate account subscription, Please be aware that you will no longer be able to access your Corporate contents. Once you choose confirm, your account type will change to Free Account.</p>
				<?php } ?>
				<?php if($user_details['user_type']=='free'){ ?>
				<p>If you want to deactivate your account permanently ,  click on Permanently  Delete Account</p>
				<?php } ?>
			</form>
		</div>
		<div class="panel-footer text-center">
			<?php if($user_details['user_type']=='individual'){ ?>				
			<button type="button" class="form_submit_btn btn btn-primary btn-long" onclick="location.href='<?php echo $this->url('user/myaccount/subscription');?>'" >Cancel</button>
			<div class="spacerv10"></div>
			<button name="submit" type="submit" value="individual" class="form_submit_btn btn btn-primary btn-long">Confirm</button>
			<?php } ?>
			<?php if($user_details['user_type']=='corporate'){ ?>
			<button type="button" class="form_submit_btn btn btn-primary btn-long" onclick="location.href='<?php echo $this->url('user/myaccount/subscription');?>'" >Cancel</button>
			<div class="spacerv10"></div>
			<button name="submit" type="submit" value="corporate" class="form_submit_btn btn btn-primary btn-long">Confirm</button>
			<?php } ?>
			<?php if($user_details['user_type']=='free'){ ?>
			<button type="button" class="form_submit_btn btn btn-primary btn-long" onclick="location.href='<?php echo $this->url('user/myaccount/subscription');?>'" >Cancel</button>
			<div class="spacerv10"></div>
			<button name="submit"   type="submit" value="free" class="form_submit_btn btn btn-primary btn-long">Permanently Delete Account</button>
			<?php } ?>
		</div>
	</div>
</div>
