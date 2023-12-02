<div class="row">
<div class="col-md-12">
	<?php if($this->resultSet['status'] == 1) {?>
    <p>
		<b>Successfully unsubscribed from </b>alerts for new reports.
	</p>
	<?php } else {?>
	<p class="text-danger">
		<?php echo $this->resultSet['message'];?>
	</p>
	<?php }?>
</div>
</div>
<?php 
 include('view/templates/rightside.php');
?>