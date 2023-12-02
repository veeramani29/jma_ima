<?php include('header.php');?>

<script language="javascript">
    $(document).ready(function() {
        $('#add_copywriter').submit(function() {
            var ret = true;
            $('#user_error').html('');$('#pass_error').html(''); $('#repass_error').html('');$('#email_error').html('');
            
            var user    =   $('#username').val();
            var pass    =   $('#password').val();
            var repass  =   $('#repassword').val();
            var email   =   $('#email').val();
            
            if(user == ''){
                $('#user_error').html('Please enter username.');
                ret =  false;
            }
             
            if(pass == ''){
              
                $('#pass_error').html('Please enter password.');
                ret =  false;
            }
            if(pass != ''&& repass == ''){
               
                $('#repass_error').html('Please repete password.');
                ret =  false;
            }
            if(pass != ''&& repass != '' && pass != repass){
               
                $('#repass_error').html('Please enter same password.');
                ret =  false;
            }
            if(email ==''){
                 $('#email_error').html('Please enter email.');
                ret =  false;
            }
             if(email !='' && validEmail(email) == false){
                 $('#email_error').html('Please enter valid email.');
                ret =  false;
            }
            return ret;
     });
    });
    
    function validEmail(email) {
     var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
    return emailReg.test(email);
   }
</script>

<?php
$errorMsg = '';
 $insertArray = array();
  if(isset($_POST['copywriteAdd'])){
      
	if($_POST['copywriteAdd']){
		$today  = date('Y-m-d');
                $status = 'Y';
		$username	= $_POST['username'];
                $email          = $_POST['email'];
                $password       = $_POST['password'];
                
                $insertArray['copywriter_user']          = $username;
                $insertArray['copywriter_password']      = md5($password);
                $insertArray['copywriter_email']         = $email;
                $insertArray['copywriter_date_created']  = $today;
                $insertArray['copywriter_status']        = $status ;
                $insertArray                             = cleanInputArray($insertArray);
			
		if($username == '' || $email == '' || $password == ''){
			$errorMsg ='Please enter all mandatory field<br/>';
		}
                else if(check_email(cleanInputField($email)) == false) {
                  $errorMsg = 'Please enter a valid email.';
                 } 
                else if($copywriterObj->uniqueUserCheck(cleanInputField($username)) == 1){
                    $errorMsg ='User name already exists.';
                }
                 else{           
                    
		        $copywriterObj->addWriter($insertArray);
			$successMsg = "User details added successfully.";
                        $insertArray = array(); 
                        header('Location:copywriter.php');
		}	
		
		
	}
}
?>

<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Add Copy writer</h1></div>


<table border="0" width="100%" cellpadding="0" cellspacing="0" id="content-table">
<tr>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowleft.jpg" width="20" height="300" alt="" /></th>
	<th class="topleft"></th>
	<td id="tbl-border-top">&nbsp;</td>
	<th class="topright"></th>
	<th rowspan="3" class="sized"><img src="<?php echo $adminThemeLink?>themes/theme1/images/shared/side_shadowright.jpg" width="20" height="300" alt="" /></th>
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
                 <form action="" name="add_copywriter" id="add_copywriter" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                    <tr>
                            <th valign="top"> User name:</th>
                            <td>
                                <input type="text"  name="username" id="username" class="inp-form" <?php if (isset($insertArray['copywriter_user'])) { ?>value="<?php echo $insertArray['copywriter_user']; ?>"<?php } ?> />
                                 <label for="username" class="error" id="user_error"></label>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top"> Password:</th>
                            <td>
                                <input type="password" name="password" id="password" class="inp-form" />
                                <label for="password" class="error" id="pass_error"></label>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top">Password again:</th>
                            <td>
                                <input type="password" id="repassword" name="repassword" class="inp-form" />
                                 <label for="password" class="error" id="repass_error"></label>
                            </td>
                            <td></td>
                    </tr>

                    <tr>
                            <th valign="top">Email:</th>
                            <td>
                                <input type="text" name="email" id="email" class="inp-form" <?php if (isset($insertArray['copywriter_email'])) { ?>value="<?php echo $insertArray['copywriter_email']; ?>"<?php } ?> />
                                <label for="email" class="error" id="email_error"></label>
                            </td>
                            <td></td>
                    </tr>


                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="copywriteAdd" class="form-submit" />

                    </td>
                    <td></td>
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