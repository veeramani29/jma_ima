@extends('templates.default')
@section('content')
<?php
$email = $_SESSION['user']['email'];
?>
<div class="col-xs-12 col-md-7">
  <div class="main-title">
    <h1>Update your card details</h1>
    <div class="mttl-line"></div>
  </div>
  <p <?php if(isset($result['status']) && $result['status']==4444) { ?> style="display: block" <?php } ?> class="text-center text-danger"><?php echo isset($result['message'])?$result['message']:''; ?></p>
  <form class="form-horizontal cmxform signup_frm" id="payment-form"  action="<?php echo url('user/updateCard');?>" method="POST" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">  
	  <div class="form-group">
    <div class="col-xs-12">
      <input type="text" class="form-control" placeholder="Email  *" readonly name="email" id="reg_email" value="<?php echo $email; ?>"  />
    </div>
  </div>
          <div class="col-xs-12 col-lg-6">
          <div class="form-group">
            <input type="text" onkeypress="return IsPhoneNumber(event);" name="card-number" id="card_number" placeholder="1234 5678 9012 3456" value="<?php echo (isset($_REQUEST['card-number']))?$_REQUEST['card-number']:'';?>" autocomplete="off" class="form-control card-number stripe-sensitive required" style="" />
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="form-group">
            <input type="text" size="2" onkeypress="return IsPhoneNumber(event);"  maxlength="2" placeholder="MM *" name="card-expiry-month" value="<?php echo (isset($_REQUEST['card-expiry-month']))?$_REQUEST['card-expiry-month']:'';?>" class="form-control card-expiry-month" />
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="form-group">
            <input type="text" size="4" maxlength="4" onkeypress="return IsPhoneNumber(event);" placeholder="YYYY *" name="card-expiry-year" value="<?php //echo (isset($_REQUEST['card-expiry-year']))?$_REQUEST['card-expiry-year']:'';?>" class="form-control card-expiry-year" autocomplete="off" />
          </div>
        </div>
        <div class="col-lg-4 col-xs-12">
          <div class="form-group">
            <input type="password" size="4" onkeypress="return IsPhoneNumber(event);" placeholder="Card code *" maxlength="4" autocomplete="new-password" class="form-control card-cvc"  />
          </div>
        </div>
  <div class="form-group">
    <div class="col-xs-12">
      <p><small class="text-danger" >*</small> Required fields</p>
    </div>
  </div>
  <div class="form-group">
    <div class="col-xs-12">
      <button type="submit" name="signup_btn" class="btn btn-primary pull-right"> Update </button>
    </div>
  </div>
</form>
</div>
@include('templates.rightside') 
@stop