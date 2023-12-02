<?php  $CONF_CURRENCY = Config::read('subscription.currency');
$CONF_AMOUNT = Config::read('subscription.amount'); if(isset($_SESSION['user'])){
	if(($user_details['user_type']=='individual') && ($user_details['user_status']=='active' || $user_details['user_status']=='trial')){ ?>
	<div class="sub-title sub-title2">
		<div class="ttl_sec2">You have been our registered user since <?php echo date('M d, Y',$user_details['registered_on'])?>.</div>
		<h5>Your Subscription Information</h5>
		<div class="sttl-line"></div>
	</div>

	<table class="table table-striped table-bordered">
		<tr>
			<th>Subscription Type</th>
			<th>Amount</th>
			<th>Expiration </th>
			<th>Status</th>
		</tr>
		<?php
		$payment_History=$this->resultSet['result']['payment_history'];
		$total_payment_History=count($payment_History);
		if($total_payment_History>0){ ?>
		<tr>
			<td >
				<i class="fa fa-user fa-lg" style="color: #22558F;"></i><sup><i style="color: #22558F;" class="fa fa-star fa-fw"></i></sup> <b><?php echo ($user_details['user_type']=='individual')?'Premium':ucfirst($user_details['user_type']); ?></b>
			</td>
			<td><b><?php echo $CONF_CURRENCY.' '.$CONF_AMOUNT;?></b></td>
			<td><b><?php echo date('Y M d',$user_details['expiry_on']);?> </b></td>
			<td><b><?php echo ucfirst($user_details['user_status']);?></b></td>
		</tr>
		<?php }else{ ?>
		<tr class="subs_recnotfou">
			<td colspan="4" class="text-center">
				<small class="text-danger">No more records found</small>
			</td>
		</tr>
		<?php } ?>
	</table>
	<?php if($user_details['user_status']=='trial'){?>
	<p > <b>NOTE:</b>  Your monthly premium subscription is on trial period.
		<br>And you will be charged <?php echo $CONF_CURRENCY.' '.$CONF_AMOUNT;?> each month after your trial expires on <?php echo date('M d, Y',$user_details['expiry_on']);?>.</p>
		<?php }else{?>
		<p>Your account will auto-renew on <?php echo date('M d, Y',strtotime('+1 day',$user_details['expiry_on']));?>.</p>
		<?php } ?>
		<?php if ($user_details['user_type']!='corporate'){ ?>
		<form id="form_submit_subscription_request" class="form-horizontal well box myacc_subform" method="post" action="<?php echo $this->url('user/myaccount/subscription');?>">
			<input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
			<div class="form-group">
				<div class="col-xs-12">
					<?php
					if($user_details['user_type']=='individual' || $user_details['user_type']=='free'){ ?>
					<?php if($user_details['user_upgrade_status'] == 'RC') { ?>
					<h3 class="text-center">"Request for corporate Subscription Sent."</h3>
					<?php }else{ ?>
					<h5 class="text-center">To Upgrade Your Subscription to corporate. Please click the button Below.</h5>
					<div class="form-group">
						<div class="col-md-12 text-center">
							<button type="button"  id="dosubscripe_btt_submit" value="Submit" <?php echo ($user_details['user_upgrade_status'] == 'RC')?"disabled":"";?> class="btn btn-primary">Request Info</button>
						</div>
					</div>
					<?php	} ?>
					<?php } ?>
				</div>
			</div>
		</form>
		<?php } ?>
		<?php if($user_details['recurrent_profile_id'] != ''){ ?>
		<p>For cancelling subscription, contact <a href="<?php  echo $this->url('helpdesk/post');?>">Help Desk.</a></p>
		<?php } else { ?>
		<p>If you would like to cancel your Premium subscription, please click <a  href="<?php  echo $this->url('user/cancelSubscription');?>">revert to free account.</a></p>
		<?php } ?>
		<p>For any assistance, feel free to contact us at <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a> or submit your query to <a href="<?php  echo $this->url('helpdesk/post');?>">Help Desk.</a></p>
		<?php } } ?>
