<?php
if(isset($_SESSION['signup_ts']))
{
	$signup_ts	= $_SESSION['signup_ts'];
}
if(empty($signup_ts))
{
	$signup_ts	= time();
	$_SESSION['signup_ts'] = $signup_ts;
}
?>
<?php if($user_details['user_type'] == 'free'){?>
<p>You have been our registered user since <?php echo date('M d, Y',$user_details['registered_on'])?>.</p>
<?php }else{ ?>
<p>You have been our registered user since <?php echo date('M d, Y',$user_details['registered_on'])?>.</p>
<?php } ?>
<?php if($user_details['user_type']== 'free'){?>
<h5 class="myacc_fresubttl">Subscription type :
	<i class="fa fa-user fa-lg"></i>
	<?php echo ''.ucfirst($user_details['user_type']); ?>
</h5>
<?php }elseif ($user_details['user_type']== 'corporate') { ?>
<h5 class="myacc_fresubttl">Subscription type :
	<i style="color:#255a8e;" class="fa fa-building fa-lg"></i>
	<?php echo ucfirst($user_details['user_type']); ?>
</h5>
<?php }?>
<?php if ($user_details['user_type']!='corporate'){
	?>
	


	<form id="form_submit_subscription_request" class="form-horizontal well box myacc_subform"  method="post" action="<?php echo $this->url('user/myaccount/subscription');?>">
		<input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
		<div class="col-md-4 upgradetext pad0">
			<h5>Upgrade your subscription to</h5>
		</div>
		<?php
		if($user_details['user_type']=='individual' || $user_details['user_type']=='free'){ ?>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="signup_request_select <?php echo ($user_details['user_upgrade_status'] == 'RC')?"disabled":"";?>"  id="corporate">
				<i class="fa fa-building fa-lg" ></i>
				<b>Corporate</b>
				<i class="fa fa-check"></i>
			</div>
		</div>
		<?php } ?>
		<?php
		if($user_details['user_type']=='free'){ ?>
		<div class="col-xs-12 col-sm-6 col-md-3">
			<div class="signup_request_select" id="premium">
				<i class="fa fa-check pull-right"></i>
				<i class="fa fa-user fa-lg" ></i>
				<sup><i  class="fa fa-star fa-fw"></i></sup> 
				<b>Premium</b>
			</div>
		</div>
		<?php } ?>
		<div class="col-sm-12 masf_upgbtn">
		<button type="button" id="dosubscripe_btt_submit" value="Submit" class="btn btn-primary">Upgrade</button>
		</div>
	</form>
	<?php }?>
	<?php if(isset($_SESSION['user'])){
		if($user_details['user_status']=='active' && $user_details['user_type']!='individual'){ ?>
		<br>
		<p class="myacc_cansubs">If you would like to cancel your <?php echo ucfirst($user_details['user_type']); ?> subscription, contact <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a> or submit your query to <a href="<?php  echo $this->url('helpdesk/post');?>">Help Desk.</a></p>
		<?php } } ?>
