<?php 
if($this->resultSet['status'] != 1) {
	$err_msg = $this->resultSet['message'];
} else {
	$err_msg = '';
}
?>
<div class="row">
    <div class="col-md-12">
     
            <?php if($err_msg!='') {?><p class="text-center text-danger" ><?php echo $err_msg;?></p><?php }?>
            <p class="text-center text-danger">
            	<?php echo $this->resultSet['message'];?>
            	<br><br>
            	<a class="btn btn-primary" href="<?php echo $this->url('/user/profile');?>">Back</a>
            </p>
        
    </div>
</div>
<?php 
 include('view/templates/rightside.php');
?>