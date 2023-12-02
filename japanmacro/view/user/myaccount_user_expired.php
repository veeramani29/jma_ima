<?php if($user_details['expiry_on']>=time()) {?>
<p clas="text-center">
	 Your current subscription expires on <font color="#ba1f33"><?php echo date('d M Y',$user_details['expiry_on'])?></font>. <br> Your subscription will not be auto-renewed, as you have cancelled your subscription.
	</p>

<?php } else {?>
<p>
	
	 Your subscription is expired on <font color="#ba1f33"><?php echo date('d M Y',$user_details['expiry_on'])?></font>

</p>

<?php }?>