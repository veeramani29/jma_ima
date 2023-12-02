@extends('templates.default')
@section('content')
<script type="text/javascript" language="javascript">
$(document).ready(function() {
  $(".First_name,.Last_name").hide();
});
</script>
<?php
$emailCategory = isset($result['emailAlert_category'])?$result['emailAlert_category']:'';


$defultAlertValue = implode(",",$result['defaultEmailAlert']);

$user_details = $result['userdetails'];


if(($user_details['want_to_email_alert'] != "" && $user_details['want_to_email_alert'] != "0" ) && $user_details['breaking_News_Alert']=="Y")
{
	$valueOfhidden = "3";
	$alertType = "Y";
}
else if(($user_details['want_to_email_alert'] != "" && $user_details['want_to_email_alert'] != "0" ) && $user_details['breaking_News_Alert']=="N")
{
	$valueOfhidden = "4";
	$alertType = "N";
}
else if(($user_details['want_to_email_alert'] == "0" || $user_details['want_to_email_alert'] == "") && $user_details['breaking_News_Alert']=="Y")
{
	$valueOfhidden = "2";
	$alertType = "Y";
}
else if(($user_details['want_to_email_alert'] == "0" || $user_details['want_to_email_alert'] == "") && $user_details['breaking_News_Alert']=="N")
{
	$valueOfhidden = "1";
	$alertType = "N";
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

if(Session::has('data')){
   $upgrade_msg=Session::get('data');

}
?>
<div class="col-xs-12">
  <p class="text-center" <?php if(isset($result['status']) && $result['status']==1) { ?> style="display: none"
    <?php } ?>><?php echo isset($result['message'])?$result['message']:''; ?>
  </p>

  <?php if(isset($upgrade_msg['msg'])) { ?>
    <p class="text-center text-danger"><?php echo isset($upgrade_msg['msg'])?$upgrade_msg['msg']:''; ?>
    </p>
 <?php } ?>
  <div class="tabs myacc_tabs">
    <ul class="nav nav-tabs">
      <li class="<?php echo $result['tabname'] == 'profile' ? 'active' : '';?>">
        <a href="#profile" data-toggle="tab">
          <i class="fa fa-pencil" ></i> Profile
        </a>
      </li>
      <?php if($user_details['linkedin_enabled'] == 'N' && $user_details['oauth_uid'] == ''){ ?>
      <li class="<?php echo $result['tabname'] == 'changepassword' ? 'active' : '';?>">
        <a href="#change_pswd" data-toggle="tab">
          <i class="fa fa-refresh" ></i> Change Password
        </a>
      </li>
      <?php } ?>
      <li class="<?php echo $result['tabname'] == 'subscription' ? 'active' : '';?>">
        <a href="#subscription" data-toggle="tab">
          <i class="fa fa-usd" ></i> Manage Subscription
        </a>
      </li>
      <li class="<?php echo $result['tabname'] == 'email-alert' ? 'active' : '';?>">
        <a href="#email-alert" data-toggle="tab">
          <i class="fa fa-envelope" ></i> Manage E-mail Alerts
        </a>
      </li>
    </ul>
    <div class="tab-content">
      <div class="tab-pane fade in <?php echo $result['tabname'] == 'profile' ? 'active' : '';?>" id="profile">
        <?php if(isset($_SESSION['message']) && $_SESSION['message'] != '') {?>
        <p id="Dv_flashMessage" class="text-center text-success">
          <?php //echo $flashMsg;?>
          <span class="close_btn"></span>
        </p>
        <?php }?>
        <div class="clearfix"></div>
        <form  id="Table_user_profile_show" class="form-horizontal">
          <div class="form-group">
            <label class="col-xs-12 col-sm-4"><b>Email</b></label>
            <div class="col-xs-12 col-sm-8 tups_email">
              <?php echo $user_details['email'];?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4"><b>Given name</b></label>
            <div class="col-xs-12 col-sm-8">
              <?php echo $user_details['fname'];?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4"><b>Surname</b></label>
            <div class="col-xs-12 col-sm-8">
              <?php echo $user_details['lname'];?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4"><b>Country</b></label>
            <div class="col-xs-12 col-sm-8">
              <?php echo $result['country_list'][$user_details['country_id']];?>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4"><b>Phone</b></label>
            <div class="col-xs-12 col-sm-8">
              <?php echo ($user_details['phone']!=null)?$user_details['phone']:'N/A';?>
            </div>
          </div>
          <div class="form-group ">
            <div class="col-xs-12 text-right">
              <a href="javascript:void(0)" onclick="JMA.User.showHideEditprofile();">Edit Profile</a>
            </div>
          </div>
        </form>
        <form class="cmxform signup_frm form-horizontal" name="Form_user_profile_edit" id="Table_user_profile_edit" method="post" action="<?php echo url('user/editprofile');?>" style="display: none;">
          <input type="hidden" name="user_id" value="<?php echo $user_details['id'];?>">
		  <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
          <div class="form-group">
            <label class="col-xs-12 col-sm-4">Email</label>
            <div class="col-xs-12 col-sm-8">
              <input type="text" name="title" value="<?php echo $user_details['email'];?>" class="form-control" disabled>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4">Given name</label>
            <div class="col-xs-12 col-sm-8">
              <input type="text" name="fname" id="reg_first_name" value="<?php echo $user_details['fname'];?>" class="form-control" data-rule-required="true" data-msg-required="Please enter First name" onkeypress="return IsCharacter(event);">
              <label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4">Surname</label>
            <div class="col-xs-12 col-sm-8">
              <input type="text" name="lname" id="reg_last_name" value="<?php echo $user_details['lname'];?>" class="form-control" data-rule-required="true" data-msg-required="Please enter Last name" onkeypress="return IsCharacter(event);">
              <label class="Last_name" id="Last_name" for="Last_name">Please Fill Only Text.</label>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4">Country</label>
            <div class="col-xs-12 col-sm-8">
              <select class="form-control" name="country_id" id="country_id">
                <option value="0">Select</option>
                <?php
                //echo $country_id;
                $res = $result['country_list1'];
                for($i=0;$i<count($res);$i++) {
                  $selected = '';
                  if($user_details['country_id'] == $res[$i]['country_id']){
                    $selected = ' selected="selected" ';
                  }
                  ?>
                  <option code="<?php echo $res[$i]['country_code'];?>" value="<?php echo $res[$i]['country_id'];?>"
                    <?php echo $selected;?>><?php echo $res[$i]['country_name'];?>
                  </option>
                  <?php
                } ?>
              </select>
            </div>
          </div>
          <div class="form-group">
            <label class="col-xs-12 col-sm-4">Phone</label>
            <div class="col-xs-12 col-sm-8">
              <input type="hidden"  name="isd_code" id="isd_code" value="<?php echo ((isset($_REQUEST['isd_code']))?$_REQUEST['isd_code']:(($user_details['country_code']!=null)?$user_details['country_code']:'+81'));?>"  class="card-isd-code" >
              <input type="text" size="10" placeholder="Phone number" data-rule-number="true" data-rule-minlength="6" name="phone" value="<?php echo (isset($_REQUEST['phone']))?$_REQUEST['phone']:$user_details['phone'];?>" class="card-phone-number form-control" onkeypress='return IsPhoneNumber(event);' />
            </div>
          </div>
          <div class="form-group pull-right">
            <div class="col-xs-12">
              Mandatory field (email) cannot be changed. <br>
              If you want to change the email then contact <a href="<?php echo url('helpdesk/post');?>">Help Desk.</a>
            </div>
          </div>
          <div class="form-group text-center">
            <div class="col-xs-12">
              <button type="submit"  id="form_submit_btn" class="btn btn-primary">Save</button>
              <button type="button" onclick="JMA.User.showHideEditprofile();"   class="btn btn-primary">Cancel</button>
            </div>
          </div>
        </form>
        <div class="clearfix"></div>
      </div>
      <?php if($userDetails['loginViaLinkedIn'] = 'no'){ ?>
      <div class="tab-pane fade in <?php echo $result['tabname'] == 'changepassword' ? 'active' : '';?>" id="change_pswd">
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-xs-12 col-md-10 col-md-offset-1">
            <form name="Form_user_profile_changepassword" id="Form_user_profile_changepassword" class="form-horizontal" method="post" action="<?php echo url('user/changepassword');?>">
			 <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <p id="alertMsg" class="text-center"></p>
              <div class="form-group">
                <label class="col-xs-12 col-sm-4">Current Password</label>
                <div class="col-xs-12 col-sm-8">
                  <input type="hidden" value="<?php echo $user_details['password']; ?>" name="old_password" id="old_password" />
                  <input type="password"  required="" name="currentpassword" id="currentpassword" class="form-control">
                  <input type="hidden" name="user_id" value="<?php echo $user_details['id'];?>">
                </div>
              </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-4">New Password</label>
                <div class="col-xs-12 col-sm-8">
                  <input type="password"  required="" style="width: 100%;" name="newpassword" id="newpassword" class="form-control">
                </div>
              </div>
              <div class="form-group">
                <label class="col-xs-12 col-sm-4">Confirm New Password</label>
                <div class="col-xs-12 col-sm-8">
                  <input type="password" required=""  style="width: 100%;" name="confirm_newpassword" id="confirm_newpassword" class="form-control">
                </div>
              </div>
              <div class="form-group text-center">
                <div class="col-xs-12">
                  <button type="submit"  id="form_submit_btn" class="btn btn-primary"> Save</button>
                  <button type="button" onclick="window.location='<?php echo url('user/myaccount');?>';"   class="btn btn-primary">Cancel</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
      <?php } ?>
      <div class="tab-pane fade in <?php echo $result['tabname'] == 'subscription' ? 'active' : '';?>" id="subscription">
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-xs-12">
            <?php
            switch ($user_details['user_status']) {
              case 'inactive':
			  include(SERVER_ROOT.'/resources/views/user/myaccount_user_inactive.php');
              break;
              case 'blocked':
              include(SERVER_ROOT.'/resources/views/user/myaccount_user_blocked.php');
              break;
              case 'active': ?>
               @if($user_details['user_type_id'] ==2)
                @include('user.myaccount_user_trial')
               @else
                 @include('user.myaccount_user_active')
               @endif
              <?php break;
              case 'expired':
              include(SERVER_ROOT.'/resources/views/user/myaccount_user_expired.php');
              break;
              case 'trial':
              include(SERVER_ROOT.'/resources/views/user/myaccount_user_trial.php');
              break;
              case 'unpaid':
              include(SERVER_ROOT.'/resources/views/user/myaccount_user_unpaid.php');
              break;
				}
				?>
          </div>
        </div>
      </div>
      <div class="tab-pane fade in <?php echo $result['tabname'] == 'email-alert' ? 'active' : '';?> <?php echo $result['tabname'] == 'update' ? 'active' : '';?>" id="email-alert">
		 <?php
          $userChoice = isset($result['emailAlert_choiceofUsers'][0]['want_to_email_alert'])?$result['emailAlert_choiceofUsers'][0]['want_to_email_alert']:'';
          if($userChoice != 0)
          {
           $defaultemail = (!empty($userChoice))?explode(",",$userChoice):'';
         }
         else
         {
           $defaultemail = array();
         }
         
         ?>  
        <div class="clearfix"></div>
        <div class="row">
          <div class="col-xs-12">
		  <form name="frmEmailAlert" id="frmEmailAlert" method="post" action="<?php echo url('user/mailAlertUpdate');?>">
			<input type="hidden" name="alert_type" id="alert_type" value="3" />
			<input type="hidden" name="alert_value" id="alert_value" value="0" />
			<input type="hidden" name="is_thematic" id="is_thematic" value="<?php echo $alertType; ?>" />
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
		   
		   <h6 class="text-center text-success" id="update_success">
		   <?php echo $result['tabname'] == 'update' ? 'Updated successfully' : '';?>
		   </h6>    
           <div class="sub-title">
                <h5>You can choose to receive</h5>
                <div class="sttl-line"></div>
            </div>
           
            <div class="collapse in" id="email-custom" >
              <div class="well">
                <div class="main-title">
                  <h1>Please select topics and indicators for which you like to receive our commentary</h1>
                  <div class="mttl-line"></div>
                </div>
				 <?php 
					$defaultemail = (array_unique($defaultemail));
					$categoryId = array();
					foreach($emailCategory as $key=>$val)
					{
						foreach($val as $k => $v)
						{
							$categoryId[] = $k;
						}
						
					}
					$allemailCategory = implode(',',$categoryId);
				  ?>
                <ul class="list-inline email_cusalert">
                   <li>
                      <div class="full-widthf">
                        <label class="control control--checkbox">All
                          <input type="checkbox" value="All" name="checkAllemailAlert" id="checkAllemailAlert" onclick="return selectallEmail('reports and indicator');" <?php echo  (count($categoryId)===count($defaultemail)  && $user_details['breaking_News_Alert'] == "Y")?'checked':'' ?>>
                          <span class="control__indicator"></span>
                        </label>
                      </div>
                    </li>
				   <li>
                      <div class="full-widthf">
                        <label class="control control--checkbox">Default selection
                          <input type="checkbox" value="All" name="checkAllemailAlert" id="checkDefaultemailAlert" onclick="return selectdefaultEmail('<?php echo $defultAlertValue; ?>','reports and indicator');" <?php echo ($user_details['want_to_email_alert'] == $defultAlertValue && $user_details['breaking_News_Alert'] == "Y") ? 'checked' : '';?>>
                          <span class="control__indicator"></span>
                        </label>
                      </div>
                    </li>
					 <li>
						<div class="full-widthf" >
						   <label class="control control--checkbox"> No email alerts
							<input type="checkbox" value="y" name="remove_box" id="remove_box" onclick="return removeallEmail();" <?php echo $result['firstParam'] == '1' ? 'checked' : '';?> <?php echo (($user_details['want_to_email_alert'] == "" || $user_details['want_to_email_alert']== "0" ) && $user_details['breaking_News_Alert']=="N")?'checked':''; ?>>
							<span class="control__indicator"></span>
						   </label>
						</div>
					  </li>
                </ul>
               <div class="sub-title">
					<h5>Topics</h5>
					<div class="sttl-line"></div>
				  </div>
                <ul class="list-inline email_cusalert">
					 <li>
					<div class="full-widthf">
					  <label class="control control--checkbox">Thematic reports
						<input type="checkbox" value="" name="thematic_report" id="thematic_report" class="email_alert" onclick="return issetThematicReports('<?php echo $defultAlertValue; ?>','<?php echo $allemailCategory; ?>');" <?php echo $user_details['breaking_News_Alert'] == "Y" ? 'checked' : '';?>>
						<span class="control__indicator"></span>
					  </label>
					</div>
				  </li>
                </ul>
                <div class="sub-title">
                  <h5>Indicators</h5>
                  <div class="sttl-line"></div>
                </div>
               <ul class="list-inline email_cusalert">
                    <?php

                    if(empty($defaultemail))
                    {
                      //$defaultemail = array(88,89,90,92,98,112,100,104);
                    }
                    foreach($emailCategory as $key => $val)
                    {
                      
                        foreach($val as $k => $v) { ?>
                        <li>
                          <div class="full-widthf">
                            <label class="control control--checkbox"><?php echo $v; ?>
                              <input type="checkbox" value="<?php echo $k; ?>" name="emailAlert[]" id="emailAlert_indicators_<?php echo  $k; ?>" <?php if(in_array($k,$defaultemail)) { echo "checked"; } ?> class="email_alert" onclick="return checkDefaultRemove('<?php echo $defultAlertValue; ?>','<?php echo $allemailCategory; ?>','reports and indicator');">
                              <span class="control__indicator"></span>
                            </label>
                          </div>
                        </li>
                        <?php }
                     
                    }?>
                  </ul>
              </div>
            </div>
            <div class="col-xs-12 text-center">
			  <p class="text-danger" id="errEmailAlert"></p>
              <button class="btn btn-primary btn-long" onclick="return mailAlertUpdate();"> Save</button>
            </div>
			</form>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
$(function() {
  /* $('[name="phone"]').intlTelInput({
    allowDropdown: true,
    autoHideDialCode: true,
    autoPlaceholder: true,
      //dropdownContainer: "body",
      geoIpLookup: function(callback) {
        $.get("//ipinfo.io", function() {}, "jsonp").always(function(resp) {
          var countryCode = (resp && resp.country) ? resp.country : "";
          callback(countryCode);
        });
      },
      initialCountry: "auto",
      nationalMode: true,
      numberType: "MOBILE",
      preferredCountries: ['jp', 'us', 'in'],
      separateDialCode: true,
      utilsScript: 'assets/js/utils.js',
    });
  $('ul.country-list li.country').on('click', function() {
    var option1 = $(this).data('dial-code');
    $('#isd_code').val("+"+option1);
  });
  $('#country_id').on('change', function() {
    var option = $('option:selected', this).attr('code').toLowerCase();
    var country_code = $('ul.country-list li.country.active').data('country-code');
    var country_name = $('ul.country-list li.country.active span.country-name').text();
    var dial_code = $('ul.country-list li.country.active').data('dial-code');
    $('div.selected-flag div.iti-flag').removeClass(country_code).addClass(option);
    $('ul.country-list li.country').removeClass('active');
    $('ul.country-list li.country[data-country-code="'+option+'"]').addClass('active');
    var sel_country_name =$('ul.country-list li.country[data-country-code="'+option+'"] span.country-name').text();
    var sel_dial_code =$('ul.country-list li.country[data-country-code="'+option+'"]').data('dial-code');
    $('div.selected-flag').attr("title",(sel_country_name+': '+"+"+sel_dial_code));
    $('#isd_code').val("+"+sel_dial_code);
  }); */
});
<?php if($user_details['country_code']!=null){ ?>
  $(function() {
    /* var edit_option = $('#isd_code').val().replace(new RegExp("\\+","g"),' ');
    $('ul.country-list li.country').removeClass('active');
    var oldclass=$('div.selected-flag div.iti-flag').attr('class');
    $( "ul.country-list li.country" ).each(function( index ) {
      if($( this ).data('dial-code')==edit_option){
        $( this ).addClass('active');
        $('div.selected-flag div.iti-flag').removeClass(oldclass.substr(-2)).addClass($( this ).data('country-code'));
      }
    }); */
  });
  <?php } ?>
 /*  $('.signup_request_select').on('click',function(event){
    var jq_id = this.id;
    var jqO = $(this);
    if(!$(this).hasClass('disabled')){
//alert($(this).attr('class'));
if(jq_id=='corporate'){
  if($('#'+jq_id).hasClass('activepro')){
    $('#'+jq_id+', #premium').removeClass( "activepro" );
    $('#'+jq_id+', #premium').find("i.fa-check").hide();
  }else{
    $('#'+jq_id).addClass( "activepro" );
    $('#'+jq_id).find("i.fa-check").show();
    $('#premium').removeClass( "activepro" );
    $('#premium').find("i.fa-check").hide();
  }
}
if(jq_id=='premium'){
  if($('#'+jq_id).hasClass('activepro')){
    $('#'+jq_id+', #corporate').removeClass( "activepro" );
    $('#'+jq_id+', #corporate').find("i.fa-check").hide();
  }else{
    $('#'+jq_id).find("i.fa-check").show();
    $('#'+jq_id).addClass( "activepro" );
    $('#corporate').removeClass( "activepro" );
    $('#corporate').find("i.fa-check").hide();
  }
}
}
}); */
  $('#dosubscripe_btt_submit').click(function(){
    if($('.signup_request_select.activepro').length >0){
      var corp_url='<?php echo url('user/user_request_info/');?>';
      var pay_url='<?php echo url('user/user_type_upgrade/');?>';
      if($('.signup_request_select.activepro').attr('id')=='premium'){
        $('#form_submit_subscription_request').attr('action',pay_url)
      }else{
        $('#form_submit_subscription_request').attr('action',corp_url);
      }
      $('.payloder').show();
      $('html, body').animate({scrollTop : 0},800);
      $('#form_submit_subscription_request').submit();
    }
  })
  $('.Alanee_tabset_tab.inactive').live("click",function(){
    var jqobj = $(this);
    var contentdiv = jqobj.attr('contentdiv');
    $('.Alanee_tabset_tab').removeClass('active').addClass('inactive');
    jqobj.removeClass('inactive').addClass('active');
    $('.Alanee_tabset_contentdiv').hide();
    $('.Alanee_tabset_contentarea').find(contentdiv).show();
  });
  $(function() {
/* // Validation..
$("#Table_user_profile_edit").validate({
  submitHandler: function(form) {
    $('.payloder').show();
    $('html, body').animate({scrollTop : 0},800);
    form.submit();
  }
});
$('.Alanee_tabset_tab ').on('click',function() {
  $('#alertMsg').html('');
  $('#Form_user_profile_changepassword')[0].reset();
  $('#Form_user_profile_changepassword :input').removeClass('error');
  $('#Form_user_profile_changepassword label').remove();
});
$("#Form_user_profile_changepassword").validate({
  rules: {
    currentpassword:{
      equalTo: "#old_password"
    }  ,
    confirm_newpassword:{
      equalTo: "#newpassword"
    }
  },
  messages: {
    currentpassword :" Please enter current password",
    confirm_newpassword :" Enter confirm password same as new password"
  },
  submitHandler: function(form) {
    $.ajax({
      type: 'POST',
      url: $('#Form_user_profile_changepassword').attr('action'),
      async: true,
      dataType: 'json',
      beforeSend: function() {
        //$('.payloder').show();
        $('html, body').animate({scrollTop : 0},800);
      },
      data: $('#Form_user_profile_changepassword').serializeArray(),
      success: function(data) {
        //$('.payloder').hide();
        $('#Form_user_profile_changepassword')[0].reset();
        if(data.success!=null){
          $('#alertMsg').addClass('text-success');
          $('#alertMsg').html(data.success);
        }else{
          $('#alertMsg').addClass('text-danger');
          $('#alertMsg').html(data.success);
        }
      }
    });
    return false;
//form.submit();
}
});
//$( "#Table_user_profile_edit" ).validate();
function FirstName() {
  var str = $("#reg_first_name").val();
  if((/^[a-zA-Z0-9- ]*$/.test(str) == false) || ($.isNumeric(str))) {
    $(".First_name").show();
    $("#reg_first_name").addClass("errors");
    JMA.flags=false;
  }if((/^[a-zA-Z0-9- ]*$/.test(str) == true)&& (!$.isNumeric(str))) {
    $(".First_name").hide();
    $("#reg_first_name").removeClass("errors");
    JMA.flags=true;
  }
}
function LastName() {
  var str = $("#reg_last_name").val();
  if((/^[a-zA-Z0-9- ]*$/.test(str) == false) || ($.isNumeric(str))){
    $(".Last_name").show();
    $("#reg_last_name").addClass("errors");
    JMA.flag=false;
  }if((/^[a-zA-Z0-9- ]*$/.test(str) == true)&& (!$.isNumeric(str))) {
    $(".Last_name").hide();
    $("#reg_last_name").removeClass("errors");
    JMA.flag=true;
  }
}
$("#reg_first_name").keyup(function() {
  FirstName();
});
$("#reg_last_name").keyup(function() {
  LastName();
});
$('#Table_user_profile_edit').on('submit', function() {
  FirstName();
  LastName();
  if (JMA.flag == true && JMA.flags == true) {
    return true;
  } if (JMA.flags == false) {
    $( "#reg_first_name" ).focus();
    return false;
  } else if (JMA.flag == false) {
    $( "#reg_last_name" ).focus();
    return false;
  }
}); */
});
</script>
@stop