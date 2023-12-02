@extends('templates.default')
@section('content')
<div class="col-xs-12 col-md-10">
  <div class="main-title">
    <h1>Payment Successful</h1>
    <div class="mttl-line"></div>
  </div>
  <h4>Dear <?php echo ucfirst(Session::get('user.fname')).' '.ucfirst(Session::get('user.lname'));?></h4>
  <?php if(Session::get('message') == 'Upgarde') {?>
  <p>Our records show that you had signed up for our 1-month Standard trial before.Your subscription has been upgraded to Standard. You can continue to access your saved charts and other Standard content. Your account subscription will renew automatically every month.</p>
  <p>If you face any difficulties, please contact <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a></p>
  <?php }else {?>
  <p>
    Thank you for choosing Japan Macro Advisors. Your Standard account at Japan Macro Advisors is now active.
    <?php if(!Session::has('user_type_upgrade')) {?>
    Check your mail inbox for your login credentials sent to <?php echo (Session::has('user.email'))?Session::get('user.email'):'N/A';?>.
    <?php } ?>
  </p>
  <p>Please mail <a href="mailto:support@japanmacroadvisors.com">support@japanmacroadvisors.com</a> with any problems.</p>
  <?php } ?>
  <p>Thank you, <br>Japan Macro Advisors</p>
</div>
@stop