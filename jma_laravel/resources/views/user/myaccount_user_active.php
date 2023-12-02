<?php
if(Session::has('signup_ts'))
{
	$signup_ts  = Session::get('signup_ts');
}
if(empty($signup_ts))
{
	$signup_ts  = time();
	Session::put('signup_ts',$signup_ts);
} ?>
<?php if($user_details['user_type'] == 'free'){ ?>
<p>You have been our registered user since <?php echo ($user_details['registered_on']!=null)?date('Y M d',$user_details['registered_on']):'N/A';?>.</p>
<?php } else { ?>
<p>You have been our registered user since <?php echo ($user_details['registered_on']!=null)?date('Y M d',$user_details['registered_on']):'N/A';?>.</p>
<?php } ?>
<?php if($user_details['user_type']== 'free') { ?>
<h5 class="myacc_fresubttl">Subscription type :
	<i class="fa fa-user fa-lg"></i>
	<?php echo ''.ucfirst($user_details['user_type']); ?>

	<?php if($user_details['user_upgrade_status'] == 'RC') { ?>
					<h3 class="text-center">"Request for corporate Subscription Sent."</h3>
					<?php } ?>
</h5>
<?php } elseif ($user_details['user_type']== 'corporate') { ?>
<h5 class="myacc_fresubttl">Subscription type :
	<i style="color:#255a8e;" class="fa fa-building fa-lg"></i>
	<?php echo ucfirst($user_details['user_type']); ?>
</h5>
<?php } ?>
<?php if ($user_details['user_type']!='corporate'){ ?>
<!--<form id="form_submit_subscription_request" class="form-horizontal well box myacc_subform"  method="post" action="<?php //echo url('user/myaccount/subscription');?>">
	<input type="hidden" value="<?php //echo $signup_ts; ?>" name="signup_ts" />
	<input type="hidden" name="_token" value="<?php //echo csrf_token(); ?>">
	<div class="col-xs-12 upgradetext pad0">
		<h4>Upgrade your subscription to Standard Free Trial</h4>
		<ul class="list-unstyled">
      <li class=""><i class="fa fa-check-square-o" aria-hidden="true"></i> Costs USD 100/month.</li>
      <li class=""><i class="fa fa-check-square-o" aria-hidden="true"></i> Start with free 1-month trial.</li>
      <li class=""><i class="fa fa-check-square-o" aria-hidden="true"></i> Monthly payments start after the trial period ends.</li>
    </ul>
	</div>
	<!-- <div class="col-md-8 pad0">
		<?php
		if($user_details['user_type']=='individual' || $user_details['user_type']=='free'){ ?>
		<div class="col-xs-12">
			<div class="signup_request_select <?php //echo ($user_details['user_upgrade_status'] == 'RC')?"disabled":"";?>"  id="corporate">
				<i class="fa fa-building fa-lg" ></i>
				<b>Corporate</b>
				<i class="fa fa-check"></i>
			</div>
			<b class="masf_prince">USD 1000 / month</b>
		</div>
		<div class="spacer10f"></div>
		<?php } ?>
		<?php
		if($user_details['user_type']=='free'){ ?>
		<div class="col-xs-12">
			<div class="signup_request_select" id="premium">
				<i class="fa fa-check pull-right"></i>
				<i class="fa fa-user fa-lg" ></i>
				<sup><i  class="fa fa-star fa-fw"></i></sup> 
				<b>Premium</b>
			</div>
			<b class="masf_prince">USD 30 / month (one month free trial)</b>
		</div>
		<?php } ?>
	</div> -->
	<!--<div class="col-sm-12 masf_upgbtn">-->
		<!-- <button type="button" id="dosubscripe_btt_submit" value="Submit" class="btn btn-long btn-primary">Proceed to Trial</button> -->
		 <!--<a class="btn btn-long btn-primary" href="<?php //echo url('products');?>">
              
             Proceed to Trial
            </a>
	</div>
</form>-->
	<br>
	<!--<p>For more information, please see our <a href="<?php //echo url('products');?>">product page</a></p>-->
<?php } ?>
<?php if(Session::has('user')) {
	if($user_details['user_status']=='active' && $user_details['user_type']!='individual'){ ?>
	<p class="myacc_cansubs">If you would like to cancel your <?php echo ucfirst($user_details['user_type']); ?> subscription, contact <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a></p>
	<?php } 
} ?>
