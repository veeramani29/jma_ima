@extends('templates.default')
@section('content')
<?php $user_details = $result['userdetails']; ?>
<div class="col-xs-12 col-md-10">
	<form class="cancel_subscription" method="post">
	   <input type="hidden" name="_token" value="{{ csrf_token() }}">
		<?php if(($flashMsg = Session::get('message')) != null) {?>
		<p id="Dv_flashMessage" class="text-center text-success"><div class="flash_msg activemsg"><?php echo $flashMsg;?></div><div class="close_btn"></div></p>
		<?php }?>
		<?php if(isset($result['cancelSubscriptionError']) && $result['cancelSubscriptionError']!= null) {?>
		<div id="Dv_flashMessage" style="color:red;" class="fullwidth"><div  class="flash_msg"><?php echo $result['cancelSubscriptionError'];?></div><div class="close_btn"></div></div>
		<?php }?>
		<?php if($user_details['user_type']=='individual'){ ?>
		<div class="sec-title">
			<h1>Downgrading your account to Free </h1>
			<div class="sttl-line"></div>
		</div>
		<p>We hope you enjoyed the timely updates on Japanese economy and the use of My Charts functions.</p>
		<p>Below are details on what would happen to Standard contents you have used when you revert to Free account user.</p>
		<div class="sec-title">
			<h1>What would happen to My Charts?</h1>
			<div class="sttl-line"></div>
		</div>
		<p>Even when you cancel your Standard account, you will continue to have access to all the My Charts functions. But you can only use one folder and up to 1 page. We will keep the default folder in the first position in the My Charts menu. Please note that deletion of other folders are permanent. All other folders you did not delete but not in the first position will become inaccessible but you can re-access them if you become our Standard account user again.</p>
		<div class="sec-title">
			<h1>What would happen when I upgrade back?</h1>
			<div class="sttl-line"></div>
		</div>
		<p>All the Standard contents will be waiting for you when need them. When you re-upgrade to a paid-plan, you will regain access to all the contents you lost access to when you became a Free account user. </p>
		<div class="sec-title">
			<h1>What would happen to my billing?</h1>
			<div class="sttl-line"></div>
		</div>
		<p>Once you downgrade to Free, your account will immediately change to a Free account and you will not be charged afterward while you remain a Free account user.</p>
		<div class="full-widthf">
			<label class="control control--checkbox">I read everything above and I would like to downgrade my account to Free.
				<input type="checkbox" value="y" name="login_rememberMe" id="agreetofree">
				<div class="control__indicator"></div>
			</label>
		</div>
		<!-- <p class="cursor"> <input type="checkbox" id="agreetofree" /> <label for="agreetofree" >.</label></p> -->
		<div class="text-center cansub_btns" >
			<button  type="button" onclick="location.href='<?php echo url('user/myaccount/');?>'" class="btn btn-primary">Cancel</button>
			<button type="submit" id="submit" value="free" disabled="" class="btn btn-primary" name="submit" > Downgrade to FREE user</button>
		</div>
		<?php } ?>       
	</form> 
</div>
<script type="text/javascript">
$('#agreetofree').on('click',function(){
	if($('#agreetofree').is(":checked")){
		$('#submit').prop("disabled",false);
	}else{
		$('#submit').prop("disabled",true);
	}
});
</script>
@stop