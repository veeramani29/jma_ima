<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');?>

<?php 
$form_validate = true;
$userTypes = $userObj->getAllUserTypes();
$userCompanies = $userObj->getAllUserCompanies();
$userStatuses = $userObj->getAllUserStatus();
$userCountries = $userObj->getAllUserCountries();

$company_id = '';
$user_title = '';
$fname = '';
$lname = '';
$email = '';
$password = '';
$country_id = 0;
$phone = '';
$user_type_id = 1;
$user_status_id = 1;
$expiry_on = '';
$expiry_date = '';
$email_verification = '';
$user_post_alert = '';

if($_POST && isset($_POST['Submit'])){
	try{
		$company_id = $_POST['company_id'];
		$user_title = trim($_POST['user_title']);
		if(empty($user_title)) throw new Exception("Title cannot be empty.", 9999);
		$fname = trim($_POST['fname']);
		if(empty($fname)) throw new Exception("Firstname cannot be empty", 9999);
		$lname = trim($_POST['lname']);
		if(empty($lname)) throw new Exception("Lastname cannot be empty", 9999);
		$email = trim($_POST['email']);
		if(empty($email)) throw new Exception("Email cannot be empty", 9999);
		$password = trim($_POST['password']);
		if(empty($password)) throw new Exception("Password cannot be empty", 9999);
		$country_id = $_POST['country_id'];
		$phone = trim($_POST['phone']);
		$user_type_id = $_POST['user_type_id'];
		$user_status_id = $_POST['user_status_id'];
		$expiry_on = strtotime($_POST['expiry_on']);
		$expiry_date = $_POST['expiry_on'];
		$email_verification = $_POST['email_verification'];
		$user_post_alert = $_POST['user_post_alert'];
		$registered_on = time();
		if($userObj->isEmailRegistered($email, 0)==true){
			throw new Exception("Entered email is already registered.", 9999);
		}
		$postVars = array(
			'company_id' => $company_id,
			'user_title' => $user_title,
			'fname' => $fname,
			'lname' => $lname,
			'email' => $email,
			'password' => $password,
			'country_id' => $country_id,
			'phone' => $phone,
			'user_type_id' => $user_type_id,
			'user_status_id' => $user_status_id,
			'registered_on' => $registered_on,
			'expiry_on' => $expiry_on,
			'email_verification' => $email_verification,
			'user_post_alert' => $user_post_alert
		);
		if($company_id >0){
			$postVars['company_id'] = $company_id;
		}
		$userObj->addNewUserProfile($postVars);
		header('Location:listUser.php');
	}catch (Exception $ex){
		$form_validate = false;
		$form_validate_message = $ex->getMessage();
	}

}


?>

<!-- start content -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add New User</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slide images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slide images" /></th>
</tr>
<tr>
	<td id="tbl-border-left"></td>
	<td>
	<!--  start content-table-inner -->
	<div id="content-table-inner">
	
	<table border="0" width="100%" cellpadding="0" cellspacing="0">
	<tr valign="top">
	<td>
	
	
		<!-- start id-form -->
                 <form name="add_user" id="add_user" method="POST">
                     
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" id="id-form">
                    <tr>
                    	<td colspan="3"><font color="#ff0000"><?php echo $form_validate == false ? $form_validate_message : '';?></font></td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Company (For corporate users):</th>
                            <td valign="top">
                               <select name="company_id" class="styledselect_form_1">
                               		<option value="">NA</option>
                               		<?php foreach ($userCompanies as $company) {?>
                               		<option value="<?php echo $company['id']?>" <?php echo $company['id'] == $company_id ? 'selected' : '';?>><?php echo $company['company_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>                   
                    
                     <tr>
                            <th valign="top">User Title</th>
                            <td valign="top">
                                <input type="text" class="inp-form" name="user_title" value="<?php echo $user_title;?>">
                            </td>
                    </tr>

                    <tr>
                            <th valign="top">First Name:</th>
                            <td valign="top">
                               <input type="text" class="inp-form" name="fname" value="<?php echo $fname;?>">
                            </td>
                    </tr>
                    
                    
                    <tr>
                            <th valign="top">Last Name:</th>
                            <td valign="top">
                               <input type="text" class="inp-form" name="lname" value="<?php echo $lname;?>">
                            </td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Email:</th>
                            <td valign="top">
                               <input type="text" class="inp-form" name="email" value="<?php echo $email;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Password:</th>
                            <td valign="top">
                               <input type="text" class="inp-form" name="password" value="<?php echo $password;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Country:</th>
                            <td valign="top">
                               <select name="country_id" class="styledselect_form_1">
                               		<?php foreach ($userCountries as $cont) {?>
                               		<option value="<?php echo $cont['country_id']?>" <?php echo $cont['country_id'] == $country_id ? 'selected' : '';?>><?php echo $cont['country_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Phone:</th>
                            <td valign="top">
                               <input type="text" class="inp-form" name="phone" value="<?php echo $phone;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Type:</th>
                            <td valign="top">
                               <select name="user_type_id" class="styledselect_form_1">
                               		<?php foreach ($userTypes as $ut) {?>
                               		<option value="<?php echo $ut['id']?>" <?php echo $ut['id'] == $user_type_id ? 'selected' : '';?>><?php echo $ut['type_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Status:</th>
                            <td valign="top">
                               <select name="user_status_id" class="styledselect_form_1">
                               		<?php foreach ($userStatuses as $ust) {?>
                               		<option value="<?php echo $ust['id']?>" <?php echo $ust['id'] == $user_status_id ? 'selected' : '';?>><?php echo $ust['status_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Expiry On:</th>
                            <td valign="top">
                            	<input type="hidden" name="txt_expiry_on" id="txt_expiry_on" value="<?php echo $expiry_date;?>" />
                               <input name="expiry_on" type="text"  class="textBox_style2 inp-form" id="expiry_on" value="<?php echo $expiry_date;?>" readonly="readonly" />
                      <a onclick="showCalendarControl(add_user.expiry_on,'add_user.txt_expiry_on');"><img src="calendar/calendar.gif"  border="0" alt="calender images" /></a> 
                            </td>
                    </tr>
                    
                      <tr>
                            <th valign="top">New post alert:</th>
                            <td valign="top">
                               <select name="user_post_alert" class="styledselect_form_1">
                               		<option value="Y" <?php echo $user_post_alert == 'Y' ? 'selected' : '';?>>YES</option>
                               		<option value="N" <?php echo $user_post_alert == 'N' ? 'selected' : '';?>>NO</option>
                               </select>
                            </td>
                    </tr>   
                    
                      <tr>
                            <th valign="top">User email verified ?:</th>
                            <td valign="top">
                               <select name="email_verification" class="styledselect_form_1">
                               		<option value="Y" <?php echo $email_verification == 'Y' ? 'selected' : '';?>>YES</option>
                               		<option value="N" <?php echo $email_verification == 'N' ? 'selected' : '';?>>NO</option>
                               </select>
                            </td>
                    </tr>                                     
                     <tr>
                            <th valign="top"></th>
                            <td valign="top">
                               <input type="Submit" name="Submit" class="form-submit" value="Save Profile">&nbsp;&nbsp;&nbsp;
                               <a href="listUser.php"class="form-cancel">Cancel</a>
                            </td>
	                    </tr>                   

                </table>
          </form>
	<!-- end id-form  -->

	</td>
	<td>


</td>
</tr>

</table>
 
<div class="clear"></div>
 

</div>
<!--  end content-table-inner  -->
</td>
<td id="tbl-border-right"></td>
</tr>
<tr>
	<th class="sized bottomleft"></th>
	<td id="tbl-border-bottom">&nbsp;</td>
	<th class="sized bottomright"></th>
</tr>
</table>



<div class="clear">&nbsp;</div>

</div>
<!--  end content -->
<div class="clear">&nbsp;</div>
</div>


<?php include('footer.php');?>