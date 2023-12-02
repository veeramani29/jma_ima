<div class="row">
<div class="col-md-12">
       
	            	<?php 
	            		$user_details = $_SESSION['user'];
	            		$trial_expiry_date = date('d, M Y',$user_details['expiry_on']);
        			?>
        			<p>
        				Hi, <strong><?php echo $user_details['fname'].' '.$user_details['lname'];?></strong>, <br>Your payment has been cancelled.<br><br>
	           		</p>

	         
    </div>
</div>