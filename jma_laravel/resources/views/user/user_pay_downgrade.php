@extends('templates.default')
@section('content')
<?php
$user_details = $result['userdetails'];
?>
<div class="col-md-9">
	<div class="panel panel-default full-width user_panel"> 
		<div class="panel-heading"><h4 class="mar0">User Downgrade</h4></div>
		<div class="panel-body panel_downgrade">
			<p>Dear  <?php echo ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']);?>,</p>
			<p>We have not received payment from you for Standard account activation. Please click on Pay Now button below to proceed to payment page.</p>
			<p>If you want to downgrade to <strong>"FREE"</strong> user, click on downgrade to free user button.</p>
		</div>
		<div class="panel-footer text-center">
			<button  type="button" onclick="location.href='<?php echo url('user/dopayment/');?>'" value="individual" class="form_submit_btn btn btn-primary btn-long">Proceed to payment details</button>
			<div class="spacerv10"></div>
			<button type="submit" value="free" class="form_submit_btn btn btn-primary btn-long" name="submit" >Downgrade to FREE user</button>
		</div>
	</div>
	<!-- <div class="panel-body panel_downgrade">
			<p>Hi  <?php echo ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']);?>,</p>
			<p>We are genuinely bummed. What went wrong? We’d really like to know why you downgraded.</p>
			<p>We’ve learned that it takes about 8 meetings to really fall in love with Amy and Andrew. And we also know that some of their skills are not so obvious (we’re working on that!).</p>
			<p>Could you, would you take this <a href="#">3 minute survey</a> to let us know why you’re downgrading? If you can spare a few minutes, it would help us make Amy and Andrew smarter, faster, better—and maybe help you too. </p>
			<p><b>Looking forward to hearing from you soon! </b></p>
		</div> -->
	<!-- <div class="content_midsection">
		<div class="mid_content">
			<div class="login_box_outer">
				<div class="login_box_inner">
					<div style="padding:12px">
						<form onsubmit="return confirm('Are you sure?');"  method="post">
							<?php if(($flashMsg = getFlashMessage()) != null) {?>
							<div id="Dv_flashMessage" class="fullwidth"><div class="flash_msg activemsg"><?php echo $flashMsg;?></div><div class="close_btn"></div></div>
							<?php }?>
							<div class="pad20">
								<?php if($user_details['user_type']=='individual'){ ?>
								<p>* We have not received payment from you for premium account activation. Please click on Pay Now button below to proceed to payment page. </p>
								<p>* If you want to downgrade to "FREE" user, click on downgrade to free user button.</p>
								<div align="center" >
									<button  type="button" onclick="location.href='<?php echo url('user/dopayment/');?>'" value="individual" class="form_submit_btn">Pay Now</button>
									<button type="submit" value="free" class="form_submit_btn" name="submit" >Downgrade to FREE user</button>
								</div>
								<?php } ?>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div> -->
</div>
@stop
