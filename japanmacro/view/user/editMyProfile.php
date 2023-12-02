<?php
$user_details = $this->resultSet['result']['userdetails'];
//print_r($user_details);
$user_position = $user_details['user_position_id'];
$user_industry = $user_details['user_industry_id'];
$fname = $user_details['fname'];
$lname = $user_details['lname'];
$email = $user_details['email'];
$country_id = $user_details['country_id'];
//echo $country_id;
$phone = $user_details['phone'];
$request_info = array(
						'premium' => false,
						'corporate' =>false
				);

if($user_details['user_upgrade_status'] == 'RP'){
	$request_info['premium'] = true;
}
if($user_details['user_upgrade_status'] == 'RC'){
	$request_info['corporate'] = true;
}
if(!isset($_POST['request_info'])){
	$_POST['request_info'] = $user_details['user_upgrade_status'];
}
$this->renderResultSet['result']['request_info'] = $request_info;
if(isset($_SESSION['signup_ts']))
{
	$signup_ts	= $_SESSION['signup_ts'];
}
if(empty($signup_ts))
{
	$signup_ts	= time();
	$_SESSION['signup_ts'] = $signup_ts;
}

?>
<script type="text/javascript" language="javascript">
$(document).ready(function() {
  <?php if($this->resultSet['status']!=1) { ?> 
  var reg_temp_class = $('<?php echo $signup_error_id; ?>').attr('class');
  $('<?php echo $signup_error_id; ?>').focus().removeClass(reg_temp_class).addClass(reg_temp_class+' error');
  <?php } ?>
  $(".First_name,.Last_name").hide();
});

</script>
<div class="content_midsection">
    <div class="mid_content">
	<div class="Alanee_tabset_contentarea">
    	<form  name="edit_frm" id="edit_frm" class="signup_frm" action="<?php echo $this->url('user/updateMyProfile');?>" method="post" autocomplete="off">
		<input type="hidden" value="<?php echo $signup_ts; ?>" name="signup_ts" />
		<input type="hidden" name="user_id" value="<?php echo $user_details['id'];?>">
			<div style="width: 532px;margin-bottom:8px; float: left">
				<div id="Dv_register_wrapper_register_title">Profile</div>	
			</div>
			<div class="register_errorcon" <?php if($this->resultSet['status']==1) { ?> style="display: none" <?php } ?>><?php echo $this->resultSet['message']; ?></div>
			<?php if(($flashMsg = $this->getFlashMessage()) != null) {?>
				<div id="Dv_flashMessage" class="fullwidth"><div class="flash_msg"><?php echo $flashMsg;?></div><div class="close_btn"></div></div>
			<?php }?>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Sector (pick one)</div>
				<div class="register_box_input">
					<select class="form_selectfield" name="user_industry" id="user_industry" style="margin-top: 5px;width: 100%;">
						<option value="0">Select</option>
						<?php
						$res = $this->resultSet['result']['user_industry'];
						for($i=0;$i<count($res);$i++) {
							$selected = '';
							if($user_industry == $res[$i]['user_industry_id']){
								$selected = ' selected="selected" ';
							}
							?>
						<option value="<?php echo $res[$i]['user_industry_id'];?>"
						<?php echo $selected;?>><?php echo $res[$i]['user_industry_value'];?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Job Function (pick one)</div>
				<div class="register_box_input">
					<select class="form_selectfield" name="user_position" id="user_position" style="margin-top: 5px;width: 100%;">
						<option value="0">Select</option>
						<?php
						$res = $this->resultSet['result']['user_position'];
						for($i=0;$i<count($res);$i++) {
							$selected = '';
							if($user_position == $res[$i]['user_position_id']){
								$selected = ' selected="selected" ';
							}
							?>
						<option value="<?php echo $res[$i]['user_position_id'];?>"
						<?php echo $selected;?>><?php echo $res[$i]['user_position_value'];?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">First Name</div>
				<div class="register_box_input">
					<input type="text" class="form_textfield" name="fname" id="reg_first_name" value="<?php echo $fname; ?>" style="margin-top: 5px;width: 100%;" data-rule-required="true" data-msg-required="Please enter first name" />
					<label class="First_name" id="First_name" for="First_name">Please Fill Only Text.</label>
					</div>
			</div>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Last Name</div>
				<div class="register_box_input">
					<input type="text" class="form_textfield" name="lname" id="reg_last_name" value="<?php echo $lname; ?>" style="margin-top: 5px;width: 100%;" data-rule-required="true" data-msg-required="Please enter last name"/>
					<label class="Last_name" id="Last_name" for="Last_name">Please Fill Only Text.</label>
				</div>
			</div>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Email</div>
				<div class="register_box_input">
					<input type="text" disabled="" class="form_textfield" name="email" id="reg_email" value="<?php echo $email; ?>" style="margin-top: 5px;width: 100%;" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address"/>
				</div>
			</div>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Country</div>
				<div class="register_box_input">
					<select class="required" name="country_id" id="reg_country" style="margin-top: 5px;width: 100%;">
						<option value="">Select</option>
						<?php
						$res = $this->resultSet['result']['country_list'];
						for($i=0;$i<count($res);$i++) {
							$selected = '';
							if($country_id == $res[$i]['country_id']){
								$selected = ' selected="selected" ';
							}
							?>
						<option value="<?php echo $res[$i]['country_id'];?>"
						<?php echo $selected;?>><?php echo $res[$i]['country_name'];?></option>
						<?php
						}
						?>
					</select>
				</div>
			</div>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Phone</div>
				<div class="register_box_input">
					<input type="text" class="form_textfield" name="phone" id="reg_phone" value="<?php echo $phone; ?>" style="margin-top: 5px;width:180px" />
				</div>
			</div>
			<?php
				if($user_details['user_upgrade_status'] == 'NU') {
			?>
			<div class="register_form_singleouter fontsize12">
				<div class="register_box_label">Request Info</div>
				<div class="register_box_input">
					<div>Please select to request information</div>
					<div style="padding-top:16px;float:left;">
						<div class="signup_request_select <?php echo $this->resultSet['result']['request_info']['premium'] == true ? 'selected': '';?>" id="signup_request_select_premium">
							<i class="fa fa-user fa-lg" style="font-size:20px; margin: 0 0 0 0;"></i>&nbsp;Premium&nbsp;<input type="checkbox" class="signup_request_select_request_info" name="request_info[]" id="request_info_premium" value="premium" <?php echo $this->resultSet['result']['request_info']['premium'] == true ? 'checked': '';?>> 
						</div>
						<div class="signup_request_select <?php echo $this->resultSet['result']['request_info']['corporate'] == true ? 'selected': '';?>" id="signup_request_select_corporate">
							<i class="fa fa-building fa-lg" style="font-size:18px"></i>&nbsp;Corporate&nbsp;<input type="checkbox" class="signup_request_select_request_info" name="request_info[]" id="request_info_corporate" value="corporate" <?php echo $this->resultSet['result']['request_info']['corporate'] == true ? 'checked': '';?>>
						</div>
					</div>
				</div>
			</div>
			<?php } ?>
			<div class="register_form_singleouter fontsize12" style="margin-top: 20px; margin-bottom: 20px">
				<div class="register_box_label"></div>
				<div class="register_box_input">
					<input type="submit" class="form_submit_btn" name="signup_btn" value="&nbsp;Update&nbsp;" style="height: 36px" />&nbsp;&nbsp;&nbsp;
				</div>
			</div>
<!--register section end here-->
		</form> 
	</div>		
    </div>
</div>
<script type="text/javascript">
$('.signup_request_select').on('click',function(event){
	var jqO = $(this);
	var target = $(event.target);
	 if (target.is('input:checkbox')){
		if(jqO.find('.signup_request_select_request_info').is(":checked")){
			jqO.addClass('selected');
		}else{
			jqO.removeClass('selected');
		}
	
	 }else{
		if(jqO.find('.signup_request_select_request_info').is(":checked")){
			jqO.removeClass('selected');
			jqO.find('.signup_request_select_request_info').prop('checked',false);
		}else{
			jqO.addClass('selected');
			jqO.find('.signup_request_select_request_info').prop('checked',true);
		}
	 }

});

$(function() { 
  	if ($('#user_title_id').val() == "Other") {
		 $("#other").show();
      }else{$("#other").hide();}
    $('#user_title_id').change(function(){
       if ($(this).val() == "Other") {
		  // alert("1");
       $("#other").show();
      }else if ($(this).val() != "Other") {
		 // alert("2");
       $("#other").hide();
      }
	//alert($('#user_title_id').val());
    });

	// Validation..

    $( "#edit_frm" ).validate();
	
	$("#reg_first_name").keyup(function() {
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
	 });
	$("#reg_last_name").keyup(function() {
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
	   });
	
	 $('#edit_frm').on('submit', function() {
	   if (JMA.flag == true && JMA.flags == true) {
		    return true;
		} if (JMA.flags == false) {
			$( "#reg_first_name" ).focus();
		    return false;
		} else if (JMA.flag == false) {
			$( "#reg_last_name" ).focus();
			return false;
		} 
	});

    

});
</script>
