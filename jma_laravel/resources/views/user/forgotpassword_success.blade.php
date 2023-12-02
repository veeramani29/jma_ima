@extends('templates.default')
@section('content')
<?php 
if(isset($result['status']) && $result['status'] != 1) {
	$err_msg = $result['message'];
} else {
	$err_msg = '';
}
?>
    <div class="col-md-7">
<div class="row">
    <div class="col-md-12">
     

     <div class="main-title">
      <h1>Thank you for requesting forgot password</h1>
      <div class="mttl-line"></div>
    </div>

     

            <?php if($err_msg!='') {?><p class="text-center text-danger"><?php echo $err_msg;?></p><?php }?>
            <p class="text-success">
            	<?php echo $result['message'];?>
            </p>
        
    </div>
</div>
</div>
 @include('templates.rightside') 
@stop