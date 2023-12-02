@extends('templates.default')
@section('content')
<?php

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
  <?php if(isset($status) && $status!=1) { ?>
    var reg_temp_class = $('<?php echo $signup_error_id; ?>').attr('class');
    $('<?php echo $signup_error_id; ?>').focus().removeClass(reg_temp_class).addClass(reg_temp_class+' error');
    <?php } ?>
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

<div class="col-xs-12 col-md-7">
  <div class="main-title">
    <h1>Registration Page</h1>
    <div class="mttl-line"></div>
  </div>
  <form class="form-horizontal cmxform signup_frm" name="competition_frm_login" id="competition_frm_login"  method="post" autocomplete="off">
    <input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    <h4>Competition Registration</h4>
  <div class="spacer10f"></div>
    <div class="row">
	
	<div class="col-xs-12 col-md-6">
        <div class="form-group">
          <select class="form-control" name="user_group" id="user_group" onchange="return compitation_group(this.value);">
            <option value="">Please select your group</option>
            <option value="0">Indiviual</option>
            <option value="1">Group</option>
          </select>
        </div>
      </div>
	  
      <div class="col-xs-12 col-md-6" >
        <div class="form-group" class="comp_no_group" id="comp_no_group" style="display:none;">
          <select class="form-control" name="No_of_group" id="No_of_group">
            <option value="0">No. of people in group</option>
            <option value="2">2</option>
            <option value="3">3</option>
          </select>
        </div>
      </div>
	  
	  <div class="col-xs-12 col-md-6">
        <div class="form-group">
          <input type="text" placeholder="Name Of The Group/Individual *" class="form-control" name="groupname" id="groupname" value="" onkeypress="return IsCharacter(event);" />
          <label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
        </div>
      </div>
      <div class="col-xs-12  col-md-6">
        <div class="form-group">
          <input type="text" placeholder="College Name *" class="form-control" name="Collegename" id="Collegename" value="" onkeypress="return IsCharacter(event);" />
          <label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="form-group">
        <div class="col-xs-12">
          <p><small class="text-danger" >*</small> Required fields</p>
        </div>
      </div>
      <div class="form-group">
        <div class="col-xs-12">
          <button type="submit" name="competition_login_btn" class="btn btn-primary pull-right"> Continue </button>
        </div>
      </div>
    </div>
  </form>
</div>
@include('templates.rightside') 
@stop