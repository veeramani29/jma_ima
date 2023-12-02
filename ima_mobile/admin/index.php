<?php 
error_reporting(E_ALL & ~E_NOTICE);

include('header_login.php');?>

<script language="javascript">
    $(document).ready(function() {
        $('#admin_login').submit(function() {
            var ret = true;
            $('#user_error').html('');
            $('#pass_error').html('');
            var user  =   $('#username').val();
            var pass =   $('#password').val();
            
            if(user == ''){
                $('#user_error').html('Please enter username.');
                ret =  false;
            }
            if(pass == ''){
               
                $('#pass_error').html('Please enter password');
                ret =  false;
            }
            return ret;
     });
    });
</script>


<?php
$errorMsg ='';
if(isset($_POST['login'])){
	if($_POST['login']){
		$userName = $_POST['username'];
		$password = $_POST['password'];
		
		$userName = cleanInputField($userName);
		$password = cleanInputField($password);
		if($userName == '' || $password == ''){
			$errorMsg ='Please enter a valid user name and password';
		}else {	
			$result = $adminObj->isLogginDetailsCurrect($userName,$password);	
			print_r($result);
			if(isset($result['code'])){
                            //   $catObj->updateIcondisp();
				header('location:listPost.php');
			}else{
				$errorMsg =$result['msg'];
			}
		}
	}
}

?>


<!-- Start: login-holder -->
<div id="login-holder">

	<!-- start logo -->
	<div id="logo-login">
		<!--<a href="index.html"><img src="images/shared/logo.png" width="156" height="40" alt="" /></a>-->
	</div>
	<!-- end logo -->
	
	<div class="clear"></div>
	
	<!--  start loginbox ................................................................................. -->
	<div id="loginbox">
	
	<!--  start login-inner -->
	<div id="login-inner">
              <form action="" name="admin_login" id="admin_login" method="post">
                  <?php if($errorMsg !='') { ?>
				<div class="error_sent_notification"><?php echo $errorMsg;?></div>
	          <?php } ?>
                    <table border="0" cellpadding="0" cellspacing="0">
                    <tr>
                            <th>Username</th>
                            <td>
                                <input type="text" name="username" id="username"  class="login-inp" />
                                <label for="username" class="error" id="user_error"></label>
                            </td>
                    </tr>
                    <tr>
                            <th>Password</th>
                            <td>
                                <input type="password" name="password" id="password" value=""   class="login-inp" />
                                <label for="password" class="error" id="pass_error"></label>
                            </td>
                    </tr>
                    <tr>
                            <th></th>
                            <td valign="top"><input type="checkbox" class="checkbox-size" id="login-check" /><label for="login-check">Remember me</label></td>
                    </tr>
                    <tr>
                            <th></th>
                            <td><input type="submit" class="submit-login" name="login" /></td>
                    </tr>
                    </table>
              </form>
	</div>
 	<!--  end login-inner -->
	<div class="clear"></div>
	<!--<a href="" class="forgot-pwd">Forgot Password?</a>-->
 </div>
 <!--  end loginbox -->
 
	<!--  start forgotbox ................................................................................... -->
	<div id="forgotbox">
		<div id="forgotbox-text">Please send us your email and we'll reset your password.</div>
		<!--  start forgot-inner -->
		<div id="forgot-inner">
		<table border="0" cellpadding="0" cellspacing="0">
		<tr>
			<th>Email address:</th>
			<td><input type="text" value=""   class="login-inp" /></td>
		</tr>
		<tr>
			<th> </th>
			<td><input type="submit" name="forgotPass" class="submit-login"  /></td>
		</tr>
		</table>
		</div>
		<!--  end forgot-inner -->
		<div class="clear"></div>
		<a href="" class="back-login">Back to login</a>
	</div>
	<!--  end forgotbox -->

</div>
<?php include('footer_login.php');?>