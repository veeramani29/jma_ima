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
<div class="col-xs-12 col-md-7">
  <div class="main-title">
    <h1>Registration Successful</h1>
    <div class="mttl-line"></div>
  </div>
  <?php $trial_expiry_date = date('d, M Y',$user_details['expiry_on']); ?>
  <p>Dear  <strong><?php echo $user_details['fname'].' '.$user_details['lname'];?></strong>,</p>
  <?php if($user_details['user_type_id']==1 && $user_details['user_upgrade_status']=='NU'){ ?>
  <p>Thank you for signing up with Japan Macro Advisors. A validation message was sent to your email address, <i><?php echo $user_details['email'];?></i>. If you do not receive it in the next 10 minutes, please email <strong><a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a></strong>.</p>
  <?php } else { ?>
  <p>Thank you for your interest in Japan Macro Advisors, source of the most timely and comprehensive economic data.</p>
  <p>We have received your request for corporate subscription. One of our account representative will contact you in one or two business days with further instructions on using your corporate account. If you have any further inquiries, please feel free to contact us at <strong><a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com.</a></strong>.</p>
  <br>
  <p class="text-left">
    Sincerely,<br> <b>JMA Team</b>
  </p>
  <br>
  <?php } ?>
  <table class="table table-bordered table-striped">
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
        }
        ?>
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
<div class="col-md-3 col-xs-12">
  <div class="sec-title">
    <h1>With Free Account</h1>
    <div class="sttl-line"></div>
  </div>
  <ul class="list-group comregsuc_list">
    <li class="list-group-item"><i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;You can save chart data with CSV format.</li>
    <li class="list-group-item"><i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp;You can save up to 4 charts into your personal My Charts Folder.</li>
  </ul>
  <div class="right_vidcon">
    <div class="rv_banner effect2">
      <h3>My Chart</h3>
      <h5>Enabling instant creations of chartbooks</h5>
      <a class="btn btn-primary btn-sm" target="_blank" href="<?php echo $this->url('products/offerings/offerings#2');?>">
        <i class="fa fa-tag" aria-hidden="true"></i> Try Free
      </a>
    </div>
  </div>
</div>