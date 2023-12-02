@extends('templates.default')
@section('content')
<div class="row">
    <div class="col-md-8">
        
        	<?php if(isset($result['status']) && $result['status'] != 1) { ?>
	            <p class="text-danger" >
	                <?php echo $result['message']; ?>
	            </p>
	            <?php } else {
	            ?>
	            <p style="padding:12px">
	            	<?php echo $result['message'];
        			?>
	            </p>
	            <?php 
	            }?>
         
    </div>
</div>
@stop