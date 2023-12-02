<?php 
if($this->resultSet['status'] != 1) {
	$err_msg = $this->resultSet['message'];
} else {
	$err_msg = '';
}

?>

 <div class="col-xs-12 col-md-10">
<div class="row">
    <div class="col-md-12">
<div class="main-title">
      <h1>Forgot Password</h1>
      <div class="mttl-line"></div>
    </div>

    <div class="panel-group">
    <div class="panel panel-default">
      <!-- <div class="panel-heading">Forgot Password</div> -->
      <div class="panel-body">

      <div class="sub-title">
 <h5 >Please enter your email address to retrieve your password.</h5>
<div class="sttl-line"></div>
    </div>

     
    <?php if($err_msg!='') {?><p class="text-danger text-center"><?php echo $err_msg;?></p><?php }?>
    <form name="forgotpasswd_frm" id="forgotpasswd_frm" role="form" class="form-horizontal" action="<?php echo $this->url('/user/forgotpassword');?>" method="post" >
       
        
          
                  
<div class="form-group">
<label class="col-md-2">Email :</label>
<div class="col-md-10">
<input type="email" name="forgotpasswd_email" placeholder="Enter email" id="forgotpasswd_email" class="form-control required" /> 

</div>
</div>

<div class="form-group">

<div class="col-md-12 text-center">

<button type="submit" class="btn btn-primary" name="forgotpasswd_btn" value="Submit" ><i class="fa fa-angle-double-right" ></i> Submit </button>
</div>
</div>
        </form>
      </div>
    </div>
    </div>

 
    </div>
</div>
</div>
<?php 
 //include('view/templates/rightside.php');
?>