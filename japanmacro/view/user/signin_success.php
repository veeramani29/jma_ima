<div class="row">
    <div class="col-md-12">
        
        	<?php if($this->resultSet['status'] != 1) { ?>
	            <p class="text-danger" >
	                <?php echo $this->resultSet['message']; ?>
	            </p>
	            <?php } else {
	            ?>
	            <p style="padding:12px">
	            	<?php echo $this->resultSet['message'];
        			?>
	            </p>
	            <?php 
	            }?>
         
    </div>
</div>