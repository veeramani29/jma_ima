<div class="content_midsection">
    <div class="mid_content">
    	<div style="height:40px;font-size:20px;font-weight:bold;color:#393939">Profile</div>
        <div id="dv_placeholder_view_profile" class="login_box_outer" style="<?php if($this->resultSet['status'] == 3331 || $this->resultSet['status'] == 3332) { echo 'display:none'; }?>">
        	<div class="profile_box_inner">
				<div style="width:530px;height:30px;float:left;">
					<div class="boldTitle" style="float:left;width:430"><?php echo $_SESSION['user']['clients_accounts_fname'].' '.$_SESSION['user']['clients_accounts_lname']; ?></div>
					<div style="float:right;width:80px;text-align:right" class="linkTxt"><a href="javascript:void(0)" onclick="JMA.UserProfile.showEdit()">Edit</a></div>
				</div>
				<div style="width:530px;height:20px;float:left;" class="normalTxt"><?php echo $_SESSION['user']['clients_accounts_email'];?></div>
				<div style="width:530px;height:20px;float:left;" class="normalTxt"><?php echo $_SESSION['user']['clients_accounts_jobtitle'];?></div>
				<div style="width:530px;height:20px;float:left;margin-top:20px" class="normalTxt">Address:</div>
				<div style="width:530px;float:left;margin-top:5px" class="normalTxt"><?php echo nl2br($_SESSION['user']['clients_accounts_address']);?></div>
				<div style="width:530px;height:20px;float:left;margin-top:5px" class="normalTxt">Telephone: <?php echo $_SESSION['user']['clients_accounts_phone'];?></div>
				<div style="width:530px;height:20px;float:left;margin-top:5px" class="normalTxt">Fax: <?php echo $_SESSION['user']['clients_accounts_fax'];?></div>
            </div>
        </div>
        <div id="dv_placeholder_edit_profile" style="<?php if($this->resultSet['status']!= 3331 && $this->resultSet['status']!= 3332) { echo 'display:none'; }?>" class="login_box_outer">
        	<form action="<?php echo $this->url('/user/editprofile');?>" method="post">
	        	<div class="profile_box_inner">
	        		<?php if($this->resultSet['status'] == 3332) {?>
        			<div style="width:530px;height:45px;float:left;margin-top:10px;color:#ff0000"><?php echo $this->resultSet['message'];?></div>
        			<?php }?>
					<div style="width:530px;height:31px;float:left">
						<div style="float:left;width:430">
							<input type="hidden" name="clients_accounts_id" value="<?php echo $_SESSION['user']['clients_accounts_id'];?>">
							<input type="text" name="clients_accounts_fname" value="<?php echo $_SESSION['user']['clients_accounts_fname'];?>" class="form_textfield_profile" disabled readonly>
						</div>
						<div style="float:right;width:80px;text-align:right" class="linkTxt">
							<a href="javascript:void(0)" onclick="JMA.UserProfile.closeEdit()">Close</a>
						</div>
					</div>
					<div style="width:530px;height:31px;float:left;margin-top:10px">
						<input type="text" name="clients_accounts_lname" value="<?php echo $_SESSION['user']['clients_accounts_lname'];?>" class="form_textfield_profile" disabled readonly>
					</div>	
					<div style="width:530px;height:31px;float:left;margin-top:10px">
						<input type="text" name="clients_accounts_email" value="<?php echo $_SESSION['user']['clients_accounts_email'];?>" class="form_textfield_profile" disabled readonly>
					</div>
					<div style="width:530px;height:31px;float:left;margin-top:10px">
						<input type="text" name="clients_accounts_jobtitle" value="<?php echo $_SESSION['user']['clients_accounts_jobtitle'];?>" class="form_textfield_profile">
					</div>
					<div style="width:530px;height:77px;float:left;margin-top:10px">
						<textarea name="clients_accounts_address" class="form_textarea_profile"><?php echo $_SESSION['user']['clients_accounts_address'];?></textarea>
					</div>
					<div style="width:530px;height:31px;float:left;margin-top:10px">
						<input type="text" name="clients_accounts_phone" value="<?php echo $_SESSION['user']['clients_accounts_phone'];?>" class="form_textfield_profile">
					</div>
					<div style="width:530px;height:31px;float:left;margin-top:10px">
						<input type="text" name="clients_accounts_fax" value="<?php echo $_SESSION['user']['clients_accounts_fax'];?>" class="form_textfield_profile">
					</div>
					<div style="width:530px;height:31px;float:left;margin-top:20px">
						<input type="submit" style="width:125px;height: 36px" value="Update Profile" name="profile_changepassword_submitbtn" class="form_submit_btn">
					</div>
	            </div>
	        </form>
        </div>
        <div id="dv_placeholder_change_password" style="width:530px;height:300px;color:#393939;margin-top:20px;">
        	<form name="frm_profile_changepassword" action="<?php echo $this->url('/user/changepassword');?>" method="post">
        		<input type="hidden" name="clients_accounts_id" value="<?php echo $_SESSION['user']['clients_accounts_id'];?>">
        		<div style="width:530px;height:20px;float:left;margin-top:20px">Change Password</div>
        		<?php if($this->resultSet['status'] == 3330) {?>
        			<div style="width:530px;height:20px;float:left;margin-top:10px;color:#ff0000"><?php echo $this->resultSet['message'];?></div>
        		<?php }?>
        		<div style="width:530px;height:25px;float:left;margin-top:10px"><input type="password" name="profile_changepassword_oldpassword" placeholder="Old password" class="form_textfield"></div>
        		<div style="width:530px;height:25px;float:left;margin-top:10px"><input type="password" name="profile_changepassword_newpassword" placeholder="New password" class="form_textfield"></div>
        		<div style="width:530px;height:25px;float:left;margin-top:10px"><input type="password" name="profile_changepassword_oldpassword_re" placeholder="Retype new password" class="form_textfield"></div>
        		<div style="width:530px;height:25px;float:left;margin-top:10px">
					<input type="submit" style="height: 36px" value="Submit" name="profile_changepassword_submitbtn" class="form_submit_btn">
				</div>
        	</form>
        </div>
    </div>
</div>
<?php 
 include('view/templates/rightside.php');
?>