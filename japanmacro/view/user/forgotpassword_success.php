<?php 
if($this->resultSet['status'] != 1) {
	$err_msg = $this->resultSet['message'];
} else {
	$err_msg = '';
}
?>
    <div class="col-md-7">
<div class="row">
    <div class="col-md-12">
     
     <div class="main-title">
      <h4>Thank you for requesting forgot password</h4>
      <div class="mttl-line"></div>
    </div>

            <?php if($err_msg!='') {?><p class="text-center text-danger"><?php echo $err_msg;?></p><?php }?>
            <p class="text-success">
            	<?php echo $this->resultSet['message'];?>
            </p>
        
    </div>
</div>
</div>
<?php 
 include('view/templates/rightside.php');
?>