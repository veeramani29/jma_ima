<style>
<?php include("calendar/CalendarControl.php");?>
</style>
<script src="calendar/CalendarControl.js" language="javascript"></script>
<?php include('header.php');?>

<?php 
$userId = $_REQUEST['id'];
if($userId == ''){
    header('Location:listUser.php');
}
$form_validate = true;
$userDetails = $userObj->getUserDetails($userId);
$userTypes = $userObj->getAllUserTypes();
$userCompanies = $userObj->getAllUserCompanies();
$userStatuses = $userObj->getAllUserStatus();
$userCountries = $userObj->getAllUserCountries();

// srinivasan 07/09/16 change option for subscription upgrade statuses while error id : jma 193
/* $subscription_upgrade_statuses = array(
	'NU'=>'No Upgrade',
	'RP'=>'Requested for Premium',
	'RC'=>'Requested for Corporate', 
	'RB'=>'Requested for both Premium and Corporate',
	'AP'=>'Premium request is aproved by JMA',
	'AC'=>'Corporate request is aproved by JMA', 
	'JP'=>'Premium request is rejected by JMA',
	'JC'=>'Corporate request is rejected by JMA', 
	'JB'=>'Corporate and Premium requests are rejected by JMA',
	'XP'=>'User is activated Premium (Paid)',
	'XC'=>'User is activated Corporate (Paid)'	
); */



$subscription_upgrade_statuses = array(
  'NU'=>'No Upgrade',
  'RC'=>'Requested for Corporate',
	'AC'=>'Corporate request is aproved by JMA',
	'JC'=>'Corporate request is rejected by JMA',
	'XC'=>'User is activated Corporate (Paid)'
);

//echo '<pre>';
//print_r($userDetails); exit;

$id = $userDetails[0]['id'];
$company_id = $userDetails[0]['company_id'];
$user_title       = $userDetails[0]['user_title'];
$fname   = $userDetails[0]['fname'];
$lname    = $userDetails[0]['lname'];
$email   = $userDetails[0]['email'];
$password   = $userDetails[0]['password'];
$country_id = $userDetails[0]['country_id'];
$phone = $userDetails[0]['phone'];
$user_type_id = $userDetails[0]['user_type_id'];
$user_status_id = $userDetails[0]['user_status_id'];
$expiry_date = date('Y-m-d',$userDetails[0]['expiry_on']);
$email_verification = $userDetails[0]['email_verification'];
$user_post_alert = $userDetails[0]['user_post_alert'];
$user_upgrade_status = $userDetails[0]['user_upgrade_status'];
$linkedin_enabled = $userDetails[0]['linkedin_enabled'];

if($_POST && isset($_POST['Submit'])){
	try{
		$id = $_POST['userid'];
		$company_id = $_POST['company_id'];
		$user_title = trim($_POST['user_title']);
		//if(empty($user_title)) throw new Exception("Title cannot be empty.", 9999);
		$fname = trim($_POST['fname']);
		if(empty($fname)) throw new Exception("Firstname cannot be empty", 9999);
		$lname = trim($_POST['lname']);
		if(empty($lname)) throw new Exception("Lastname cannot be empty", 9999);
		$email = trim($_POST['email']);
		if(empty($email)) throw new Exception("Email cannot be empty", 9999);
		$password = trim($_POST['password']);
		//if(empty($password)) throw new Exception("Password cannot be empty", 9999);
		$country_id = $_POST['country_id'];
		$phone = trim($_POST['phone']);
		$user_type_id = $_POST['user_type_id'];
		$user_status_id = $_POST['user_status_id'];
		$expiry_on = strtotime($_POST['expiry_on']);
		$email_verification = $_POST['email_verification'];
		$user_post_alert = $_POST['user_post_alert'];
		$user_upgrade_status = $_POST['user_upgrade_status'];
		if($userObj->isEmailRegistered($email, $id)==true){
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
			'expiry_on' => $expiry_on,
			'email_verification' => $email_verification,
			'user_post_alert' => $user_post_alert,
			'user_upgrade_status' => $user_upgrade_status
		);
		$userObj->updateUserProfile($postVars,$id);
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


<div id="page-heading"><h1>Edit User</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="slider images" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="slider images" /></th>
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
                 <form name="edit_user" id="edit_user" method="POST">
                     
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form" width="100%">
                    <tr>
                    	<td colspan="2"><font color="#ff0000"><?php echo $form_validate == false ? $form_validate_message : '';?></font></td>
                    </tr>

                    <tr>
                            <th valign="top"> User Id:</th>
                            <td>
                            	<input type="hidden" class="inp-form" name="userid" value="<?php echo $id;?>">
                                <?php  echo $id?>
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Company (For corporate users):</th>
                            <td>
                               <select name="company_id" class="">
                               		<option value="">NA</option>
                               		<?php foreach ($userCompanies as $company) {?>
                               		<option value="<?php echo $company['id']?>" <?php echo $company['id'] == $company_id ? 'selected' : '';?>><?php echo $company['company_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>                   
                    
                     <tr>
                            <th valign="top">User Title</th>
                            <td>
                                <input type="text" class="inp-form" name="user_title" value="<?php echo $user_title;?>">
                            </td>
                    </tr>

                    <tr>
                            <th valign="top">First Name:</th>
                            <td>
                               <input type="text" class="inp-form" name="fname" value="<?php echo $fname;?>">
                            </td>
                    </tr>
                    
                    
                    <tr>
                            <th valign="top">Last Name:</th>
                            <td>
                               <input type="text" class="inp-form" name="lname" value="<?php echo $lname;?>">
                            </td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Email:</th>
                            <td>
                               <input type="text" class="inp-form" name="email" value="<?php echo $email;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Password:</th>
                            <td>
                               <input type="text" class="inp-form" name="password" value="<?php echo $password;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">Country:</th>
                            <td>
                               <select name="country_id" class="">
                               		<?php foreach ($userCountries as $cont) {?>
                               		<option value="<?php echo $cont['country_id']?>" <?php echo $cont['country_id'] == $country_id ? 'selected' : '';?>><?php echo $cont['country_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Phone:</th>
                            <td>
                               <input type="text" class="inp-form" name="phone" value="<?php echo $phone;?>">
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Type:</th>
                            <td>
                               <select name="user_type_id" class="">
                               		<?php foreach ($userTypes as $ut) {?>
                               		<option value="<?php echo $ut['id']?>" <?php echo $ut['id'] == $user_type_id ? 'selected' : '';?>><?php echo $ut['type_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>
                    
                     <tr>
                            <th valign="top">User Status:</th>
                            <td>
                               <select name="user_status_id" class="">
                               		<?php foreach ($userStatuses as $ust) {?>
                               		<option value="<?php echo $ust['id']?>" <?php echo $ust['id'] == $user_status_id ? 'selected' : '';?>><?php echo $ust['status_name']?></option>
                               		<?php }?>
                               </select>
                            </td>
                    </tr>
                    
                    
                     <tr>
                            <th valign="top">Expiry On:</th>
                            <td>
                            	<input type="hidden" name="txt_expiry_on" id="txt_expiry_on" value="" />
                               <input name="expiry_on" type="text"  class="textBox_style2 inp-form" id="expiry_on" value="<?php echo $expiry_date;?>" readonly="readonly" />
                      <a onclick="showCalendarControl(edit_user.expiry_on,'edit_user.txt_expiry_on');"><img src="calendar/calendar.gif"  border="0" alt="calender image" /></a> 
                            </td>
                    </tr>
                    
                      <tr>
                            <th valign="top">New post alert:</th>
                            <td>
                               <select name="user_post_alert" class="">
                               		<option value="Y" <?php echo $user_post_alert == 'Y' ? 'selected' : '';?>>YES</option>
                               		<option value="N" <?php echo $user_post_alert == 'N' ? 'selected' : '';?>>NO</option>
                               </select>
                            </td>
                    </tr>   
                    
                      <tr>
                            <th valign="top">User email verified ?: </th>
                            <td>
                               <select name="email_verification" class="">
                               		<option value="Y" <?php echo $email_verification == 'Y' ? 'selected' : '';?>>YES</option>
                               		<option value="N" <?php echo $email_verification == 'N' ? 'selected' : '';?>>NO</option>
                               </select>
                            </td>
                    </tr>     
                       <tr>
                            <th valign="top">LinkedIn Enabled ?: </th>
                            <td>
								<?php echo $linkedin_enabled =='Y' ? 'Yes' : 'No';?>
                            </td>
                    </tr>                     
                      <tr>
                            <th valign="top">Subscription Upgrade Status: </th>
                            <td>
                               <select name="user_upgrade_status" class="">
                               		<?php foreach ($subscription_upgrade_statuses as $ky => $status) {?>
                               		<option value="<?php echo $ky;?>" <?php echo $ky == $user_upgrade_status ? 'selected style="color:#ff0000;"' : '';?>><?php echo $status;?></option>
                               		<?php }?>
                               </select>
                               <br><br>
                               Payment URL : http://japanmacroadvisors.com/user/myaccount/subscription
                            </td>
                    </tr>                    
                    
                                                   
                     <tr>
                            <th valign="top"></th>
                            <td>
                               <input type="Submit" name="Submit" value="Save Profile" class="form-submit">&nbsp;&nbsp;&nbsp;
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