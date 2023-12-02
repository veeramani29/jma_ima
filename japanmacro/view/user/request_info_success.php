<?php 
$user_details = $this->resultSet['result']['user_details'];
$Subscription=$user_details['user_type_id'];
$Subscription_Status='';
if($Subscription==1)
  $Subscription_Status="You have selected Free subscription";
else if($Subscription==2)
  $Subscription_Status="You have selected Individual subscription and enjoy a full-featured free trail account for 30 days.";
else if($Subscription==3)
  $Subscription_Status="You have selected Corporate subscription and enjoy a active account for 90 days.";
?>
<div>
  <div class="col-md-9">
    <div class="panel panel-default full-width"> 
      <div class="panel-heading"><strong>Welcome to Japan Macro Advisors <?php echo ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']);?></strong></div>
      <div class="panel-body">
        <?php 
        $trial_expiry_date = date('d, M Y',$user_details['expiry_on']);
        ?>
        <p>Dear  <?php echo ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']);?>,</p>
        <p>Thank you for your interest in Japan Macro Advisors, source of the most timely and comprehensive economic data.</p>
        <p>We have received your request for corporate subscription. One of our account representative will contact you in one or two business days with further instructions on using your corporate account. If you have any further inquiries, please feel free to contact us at <strong><a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a></strong>.</p>
      </div>
      <div class="panel-footer text-right">
        <div class="default-padding">
          Sincerely,<br> JMA Team
        </div>
      </div>
    </div>
  </div>
</div>