
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


<form onsubmit="return confirm('Are you sure?');"  method="post">
	
		 <?php if(($flashMsg = $this->getFlashMessage()) != null) {?>
		<div id="Dv_flashMessage" class="fullwidth"><div class="flash_msg activemsg"><?php echo $flashMsg;?></div><div class="close_btn"></div></div>
		<?php }?>
		
		
		<div class="pad20">
		<?php if($user_details['user_type']=='individual'){ ?>
		<p>* We have not received payment from you for premium account activation. Please click on Pay Now button below to proceed to payment page. </p>
		<p>* If you want to downgrade to "FREE" user, click on downgrade to free user button.</p>
		<div align="center" >
		<button  type="button" onclick="location.href='<?php echo $this->url('user/dopayment/');?>'" value="individual" class="form_submit_btn">Pay Now</button>
		<button type="submit" value="free" class="form_submit_btn" name="submit" >Downgrade to FREE user</button>
		</div>
		<?php } ?>
		
		</div>
 
		</form>
	</div>	

	</div>
	
	
</div>
</div>
</div>
