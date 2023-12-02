@extends('templates.default')
@section('content')
<?php
$user_details = $result['user_details'];
$Subscription=$user_details['user_type_id'];
$Subscription_Status='';
if($Subscription==1)
  $Subscription_Status="You have selected Free subscription";
else if($Subscription==2)
  $Subscription_Status="You have selected Individual subscription and enjoy a full-featured free trail account for 30 days.";
else if($Subscription==3)
  $Subscription_Status="You have selected Corporate subscription and enjoy a active account for 90 days.";
?>
<div class="row">
  <div class="col-md-12">
    <?php
    $trial_expiry_date = date('d, M Y',$user_details['expiry_on']);
    ?>
    <p>Dear  <strong><?php echo ucfirst($user_details['fname']).' '.ucfirst($user_details['lname']);?></strong>,</p>
    <br><br><p>Thank you for your interest in India Macro Advisors, source of the most timely and comprehensive economic data.</p>
    <br><br>
    <p>We have received your request for corporate subscription. One of our account representative will contact you in one or two business days with further instructions on using your corporate account. If you have any further inquiries, please feel free to contact us at <strong><a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a></strong>.</p>
    <br><br>
    <p class="text-left">
      Sincerely,<br> JMA Team
    </p>
  </div>
</div>
@stop