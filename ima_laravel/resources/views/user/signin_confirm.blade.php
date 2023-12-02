@extends('templates.default')
@section('content')
<?php
$user_details = $result['user_details'];
$competition_user = isset($result['competition'])?$result['competition']:'';
$Subscription=$user_details['user_type_id'];
$Subscription_Status='';
if($Subscription==1)
  $Subscription_Status="You have selected Free subscription";
else if($Subscription==2)
  $Subscription_Status="You have selected Individual subscription and enjoy a full-featured free trail account for 30 days.";
else if($Subscription==3)
  $Subscription_Status="You have selected Corporate subscription and enjoy a active account for 90 days.";
?>
<div class="col-md-10 col-xs-12">
  <div class="main-title">
    <h1>Registration Successful</h1> 
    <div class="mttl-line"></div>
  </div>
  <?php
  $trial_expiry_date = date('d, M Y',$user_details['expiry_on']);
  ?>
  <p>Dear  <strong><?php echo $user_details['fname'].' '.$user_details['lname'];?></strong>,</p>
  <?php if($user_details['user_type_id']==1 && $user_details['user_upgrade_status']=='NU'){ ?>
  <?php if($competition_user=='yes'){ ?>
  <p>Thank you for signing up to India Macro Advisors. You have been successfully registered for the IMA Idea Pitch Competition. You will receive a validation email on your registered email address.</p>
  <?php }else if($competition_user=='no'){ ?>
  <p>You have successfully registered for the IMA Idea Pitch Competition</p>
  <?php }else{ ?>
  <p class="un-justify">Thank you for signing up with India Macro Advisors. A validation message was sent to your email address, <i><?php echo $user_details['email'];?></i>. If you do not receive it in the next 10 minutes, please email <strong><a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com</a></strong>. </p>
  <?php }}else{ ?>
  <p class="un-justify">Thank you for your interest in India Macro Advisors, source of the most timely and comprehensive economic data.</p>
  <p class="un-justify">We have received your request for corporate subscription. One of our account representative will contact you in one or two business days with further instructions on using your corporate account. If you have any further inquiries, please feel free to contact us at <strong><a href="mailto:support@indiamacroadvisors.com">support@indiamacroadvisors.com.</a></strong>.</p>
  <br>
  <p class="text-left">
    Sincerely,<br> IMA Team
  </p>
  <?php } ?>
  <table class="table table-bordered">
    <tr>
      <td>Given name</td><td><?php echo $user_details['fname'];?></td>
    </tr>
    <tr>
      <td>Surname</td><td><?php echo $user_details['lname'];?></td>
    </tr>
    <tr>
      <td>Email</td><td><?php echo $user_details['email'];?></td>
    </tr>
    <tr>
      <td>Account type</td>
      <td>
        Free Account
        <?php if($user_details['user_upgrade_status']=='RC'){
          echo $corp="( You'r Requested Corporate Account )";
        } ?>
      </td>
    </tr>
    <tr>
      <td>Account status</td><td>Inactive</td>
    </tr>
    <tr>
      <td>Account expiry date</td><td> NA</td>
    </tr>
    <tr>
      <td>Subscription amount</td><td>NA</td>
    </tr>
  </table>
</div>
@stop