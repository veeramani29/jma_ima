@extends('templates.default')
@section('content')
<?php 
$user_details = $result['userdetails'];
?>
<div class="col-md-10">
<div class="row">
<div class="col-md-12">
       
	          


<form  method="post">
	
		 <?php if(isset($_SESSION['message']) && ( $_SESSION['message'] != null)) {?>
		<p id="Dv_flashMessage" class="text-center text-success"><div class="flash_msg activemsg"><?php echo isset($_SESSION['message'])?$_SESSION['message']:'';?></div><div class="close_btn"></div></p>
		<?php }?>

		<?php if(isset($result['cancelSubscriptionError']) && $result['cancelSubscriptionError']!= null) {?>
		<div id="Dv_flashMessage" style="color:red;" class="fullwidth"><div  class="flash_msg"><?php echo $result['cancelSubscriptionError'];?></div><div class="close_btn"></div></div>
		<?php }?>

		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		
	
		<?php if($user_details['user_type']=='individual'){ ?>
			<b>Downgrading your account to Free</b>
			<p>We hope you enjoyed the timely updates on Indian economy and the use of My Charts functions.</p>
			<p>Below are details on what would happen to premium contents you have used when you revert to Free account user.</p> 

			<b>What would happen to My Charts?</b>
		<p>Even when you cancel your Premium account, you will continue to have access to all the My Charts functions. But you can only use one folder and up to 1 page. We will keep the default folder in the first position in the My Charts menu. Please note that deletion of other folders are permanent. All other folders you did not delete but not in the first position will become inaccessible but you can re-access them if you become our Premium account user again.</p>
		<b>What would happen when I upgrade back?</b>
		<p>All the premium contents will be waiting for you when need them. When you re-upgrade to a paid-plan, you will regain access to all the contents you lost access to when you became a Free account user. </p>
		<b>What would happen to my billing?</b>
		<p>Once you downgrade to Free, your account will immediately change to a Free account and you will not be charged afterward while you remain a Free account user.</p>
<p class="cursor"> <input type="checkbox" id="agreetofree" /> <label for="agreetofree" >I read everything above and I would like to downgrade my account to Free.</label></p>

		<div align="center" >
		<button  type="button" onclick="location.href='<?php echo url('user/myaccount/');?>'" class="btn btn-primary">Cancel</button>
		<button type="submit" id="submit" value="free" disabled="" class="btn btn-primary" name="submit" ><i class="fa fa-angle-double-right"></i> Downgrade to FREE user</button>
		</div>
		
		<?php } ?>
	
 
		</form>
	
</div>
</div>
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