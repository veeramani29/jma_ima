<div class="row">
<div class="col-md-12">
	            	<?php 
	            		$user_details = $_SESSION['user'];
	            		$trial_expiry_date = date('d, M Y',$user_details['expiry_on']);
        			?>
        			<p >
        				Dear, <strong><?php echo $user_details['fname'].' '.$user_details['lname'];?></strong>, <br>Thank you for your payment. Your account has been upgraded to Premium.<br><br>
	           		</p>

	            
    </div>
</div>