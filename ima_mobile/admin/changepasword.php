<?php include('header.php');?>



<script language="javascript">
    $(document).ready(function() {
        $('#change_pass').submit(function() {
            var ret = true;
            $('#oldpass_error').html('');$('#newpass_error').html('');$('#repass_error').html('');
             var oldPass     =   $('#oldpass').val();  
             var repass      =   $('#repass').val();
             var newpass     =   $('#newpass').val();
            
            if(oldPass == ''){
                $('#oldpass_error').html('Please enter old password.');
                ret =  false;
            }
            
            if(newpass == ''){
                $('#newpass_error').html('Please enter new password.');
                ret =  false;
            }
            
            if(repass == ''){
                $('#repass_error').html('Please repeate the same password.');
                ret =  false;
            }
            
             if(newpass != ''&& repass != '' && newpass != repass){
               
                $('#repass_error').html('Please enter same password.');
                ret =  false;
            }
             
            return ret;
     });
    });
    
    
</script>

<?php
$errorMsg = '';
$successMsg = '';
 $insertArray = array();
  if(isset($_POST['changePass'])){
      
	if($_POST['changePass']){
		
             $oldPass = $_POST['oldPass']; 
             $newPass = $_POST['newpass']; 
             $rePass = $_POST['repass']; 
             
             echo "return is :".$adminObj->isPasswordExist(md5($oldPass));
             
             if($oldPass == '' || $newPass == '' || $rePass == '' ){
                 $errorMsg = 'Please enter all mandatoory fields.';
             }
             else if($newPass != $rePass){
                 $errorMsg = 'Password not matching.';
             }
             else if($adminObj->isPasswordExist(md5($oldPass))== false){
                 $errorMsg = 'Please enter the correct old password.';
             }
             else{
                  $adminObj->updatePassword(md5($newPass));
                  $successMsg = 'Password updated successfully.';
             }
		
		
	}
}
?>

<!-- start content-outer -->
<div id="content-outer">
<!-- start content -->
<div id="content">


<div id="page-heading"><h1>Change password</h1></div>


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
                 <form action="" name="change_pass" id="change_pass" method="post">
                     <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	             <?php } ?>
                                
                      <?php if($successMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $successMsg;?></div>
	             <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0"  id="id-form">

                         
                    <tr>
                            <th valign="top"> Old Password:</th>
                            <td>
                                <input type="password" name="oldPass" id="oldpass" class="inp-form" />
                                <label for="oldPass" class="error" id="oldpass_error"></label>
                            </td>
                            <td></td>
                    </tr>
                 

                    <tr>
                            <th valign="top"> New Password:</th>
                            <td>
                                <input type="password" name="newpass" id="newpass" class="inp-form" />
                                <label for="newpass" class="error" id="newpass_error"></label>
                            </td>
                            <td></td>
                    </tr>
                    
                     <tr>
                            <th valign="top"> Repeat Password:</th>
                            <td>
                                <input type="password" name="repass" id="repass" class="inp-form" />
                                <label for="repass" class="error" id="repass_error"></label>
                            </td>
                            <td></td>
                    </tr>


                   

                <tr>
                    <th>&nbsp;</th>
                    <td valign="top">
                            <input type="submit" value="Submit" name="changePass" class="form-submit" />

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