@extends('templates.default')
@section('content')
<?php

/* echo "<pre>";
print_r($status); exit; */

$group_type = '';
$no_of_numbers = '';
$group_name = '';
$college_name = '';     	 
$user_title = '';
$fname = '';
$lname = '';
$email = (isset($_POST['register_email']))?$_POST['register_email']:'';
$phone = '';
$OtherTitle ='';
if(isset($status) && $status!=1) { 
  $signup_error_id = $result['signup_error_id'];
  $group_type = $result['postdata']['user_group'];
  $no_of_numbers = isset($result['postdata']['No_of_group'])?$result['postdata']['No_of_group']:'';
  $group_name = $result['postdata']['groupname'];
  $college_name = $result['postdata']['Collegename']; 
  $user_title = $result['postdata']['user_title'];
  $OtherTitle = $result['postdata']['OtherTitle'];
  $fname = $result['postdata']['fname'];
  $lname = $result['postdata']['lname'];
  $email = $result['postdata']['email'];
  $phone = isset($result['postdata']['phone'])?$result['postdata']['phone']:'';
}
if(isset($_SESSION['signup_ts']))
{
  $signup_ts  = $_SESSION['signup_ts'];
}
if(empty($signup_ts))
{
  $signup_ts  = time();
  $_SESSION['signup_ts'] = $signup_ts;
}
?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
  <?php if(isset($status) && $status!=1) 
  { ?>
    var reg_temp_class = $('<?php echo $signup_error_id; ?>').attr('class');
    $('<?php echo $signup_error_id; ?>').focus().removeClass(reg_temp_class).addClass(reg_temp_class+' error');
    <?php 
  } ?>
  $(".First_name,.Last_name").hide();
});
function compitation_group(groupVal)
{
  if(groupVal == 1)
  {
    document.getElementById("comp_no_group").style.display = "block";
  }
  else
  {
   document.getElementById("comp_no_group").style.display = "none";
 }
}
</script>
<!--Register section starts here-->
<div class="col-xs-12 col-md-7 comreg_con">
  <div class="main-title">
    <h1>Registration Page</h1>
    <div class="mttl-line"></div>
  </div>
  <div class="crc_back">Back to competition <a href="<?php echo url('page/ideapitchcompetition');?>">page</a></div>
  <p <?php if(isset($status) && $status!=1) { ?> style="display: block" <?php } ?> class="text-center text-danger"><?php echo isset($message)?$message:''; ?></p>
  <form class="form-horizontal cmxform signup_frm" name="competition_frm" id="competition_frm"  method="post" autocomplete="off">
    <input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h4>Competition Registration</h4>
    <div class="spacer10f"></div>
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <select class="form-control" name="user_group" id="user_group" onchange="return compitation_group(this.value);">
            <option value="">Please select your group</option>
            <option value="0" <?php echo $group_type == '0' ? 'selected' : ''?>>Individual</option>
            <option value="1" <?php echo $group_type == '1' ? 'selected' : ''?>>Group</option>
          </select>
        </div>
      </div>
      <?php if($no_of_numbers !="") { ?>
      <div class="col-xs-12 col-md-6" >
        <div class="form-group" class="comp_no_group" id="comp_no_group">
          <select class="form-control" name="No_of_group" id="No_of_group">
            <option value="0">No. of people in group</option>
            <option value="2" <?php echo $no_of_numbers == '2' ? 'selected' : ''?>>2</option>
            <option value="3" <?php echo $no_of_numbers == '3' ? 'selected' : ''?>>3</option>
          </select>
        </div>
      </div>
      <?php  } else { ?>
      <div class="col-xs-12 col-md-6" >
        <div class="form-group" class="comp_no_group" id="comp_no_group" style="display:none;">
          <select class="form-control" name="No_of_group" id="No_of_group">
            <option value="0">No. of people in group</option>
            <option value="2" <?php echo $no_of_numbers == '2' ? 'selected' : ''?>>2</option>
            <option value="3" <?php echo $no_of_numbers == '3' ? 'selected' : ''?>>3</option>
          </select>
        </div>
      </div>   
      <?php } ?>
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <input type="text" placeholder="Name Of The Group/Individual *" class="form-control" name="groupname" id="groupname" value="<?php echo $group_name; ?>" onkeypress="return IsCharacter(event);" />
          <label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
        </div>
      </div>
      <div class="col-xs-12  col-md-6">
        <div class="form-group">
          <input type="text" placeholder="College Name *" class="form-control" name="Collegename" id="Collegename" value="<?php echo $college_name; ?>" onkeypress="return IsCharacter(event);" />
          <label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
        </div>
      </div>
    </div>
    <div class="tooltip left" role="tooltip"> <div class="tooltip-arrow"></div> <div class="tooltip-inner"> Tooltip on the left </div> </div>
    <hr class="full-width">
    <h4>IMA Registration</h4>
    <div class="spacer10f"></div>
    <div class="row">
      <div class="form-group">
        <div class="col-xs-12">
          <select class="form-control" name="user_title" id="user_title_id">
            <option value="">Title</option>
            <option value="Mr" <?php echo $user_title == 'Mr' ? 'selected' : ''?>>Mr</option>
            <option value="Mrs" <?php echo $user_title == 'Mrs' ? 'selected' : ''?>>Mrs</option>
            <option value="Miss" <?php echo $user_title == 'Miss' ? 'selected' : ''?>>Miss</option>
            <option value="Ms" <?php echo $user_title == 'Ms' ? 'selected' : ''?>>Ms</option>
            <option value="Dr" <?php echo $user_title == 'Dr' ? 'selected' : ''?>>Dr</option>
            <option value="Prof" <?php echo $user_title == 'Prof' ? 'selected' : ''?>>Prof</option>
            <option value="Sir" <?php echo $user_title == 'Prof' ? 'selected' : ''?>>Sir</option>
			<!--<option value="Other" <?php echo $user_title == 'Other' ? 'selected' : ''?>>Other</option> -->
          </select>
        </div>
      </div>
      <div class="form-group" id="other">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Other Title " name="OtherTitle" id="" value="<?php echo $OtherTitle; ?>"  />
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <input type="text" placeholder="Given name *" class="form-control" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" onkeypress="return IsCharacter(event);" />
          <label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
        </div>
      </div>
      <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Surname *" name="lname" id="reg_last_name" value="<?php echo $lname; ?>" onkeypress="return IsCharacter(event);"/>
          <label class="Last_name" id="Last_name" for="Last_name">Please Fill Only Text.</label>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12">
          <input type="text" class="form-control" placeholder="Email  *" name="email" id="reg_email" value="<?php echo $email; ?>"  />
        </div>
      </div> 
     
      <div class="form-group">
        <div class="col-xs-12">
		  <input type="hidden"   value="+91" name="country_code"   id="country_code"   />
          <input type="text" class="phonecls form-control"  value="<?php echo $phone;?>" name="phone"  data-rule-number="true" data-rule-minlength="6" id="reg_phone_number"  onkeypress='return IsPhoneNumber(event);' />
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12 suf_tercon">
          <button type="button" id="terms-conditions" class="btn btn-primary" data-toggle="modal" data-target=".tercon-modal"> Agree with the terms and conditions <i class="fa fa-check" id="check" aria-hidden="true"></i></button>
          <div class="full-width">
            <input type="hidden" name="agree" id="agree" />
          </div>
        </div>
      </div>
     
      <div class="form-group">
        <div class="col-xs-12">
          <p><small class="text-danger" >*</small> Required fields</p>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12">
          <button type="submit" name="signup_btn" class="btn btn-primary pull-right"> Continue </button>
        </div>
      </div>
    </div>
  </form>
</div>
@include('templates.rightside') 
@stop